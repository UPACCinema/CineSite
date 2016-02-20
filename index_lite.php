<?php
include_once("officers/include/session.php");
include_once("menubar.php");
include_once("TMDb.php");

$tmdb = new TMDb('a1425b80993f31c6030c2af97272750b');

$user = "cinema";
$pass = "n@VSjEV4lG";
$dbname = "cinema_db";
$link = mysql_connect("db.union.rpi.edu", $user, $pass);
mysql_select_db($dbname);

$sched_tbl = "sched_new";

function sqlerr($sql, $file='',$line=''){
  if ($err = mysql_error()){
    echo "ERROR: $err<br>\nSQL: $sql<br>\n";
    if ($file){
      echo "File: $file, line $line<br>\n";
    }
    exit();
  }
}

  //This function is used to put the days in the correct order, soonest occurring
  //movie will be first.
  function ordered ($a, $b){
    $today = date('w')*100 + 2;
    if ($a['n'] < $today and $b['n'] >= $today){
      return 1;
    } elseif ($b['n'] < $today and $a['n'] >= $today){
      return -1;
    } else {
      if ($a['n'] < $b['n']){
        return -1;
      } else {
        return 1;
      }
    }
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="newstyles.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>UPAC Cinema - Schedule</title>
  </head>

<body>

<div id="wrapper">
 
<?php
    echo "<!-- Top Menu (Navigation) -->
    <div id=\"globalnavbar\" style=\"background-color:#000000;\">
      <img class=\"logo\"src=\"images/upac_logo.png\" alt=\"UPAC Cinema\" />
      <a href=\"http://www.google.com/calendar/embed?src=do6de78tj36dvop1dari1qq92k%40group.calendar.google.com&ctz=America/New_York\"><img style=\"position:absolute; top:4px; right:4px;\" src=\"images/googlecal.gif\" alt=\"Google Calendar\" /></a>
      <ul class=\"dropdown\">
        <li><a href=\"index.php\">Schedule</a></li>
        <li><a href=\"policies.php\">Policies</a></li>
        <li><a href=\"bylaws.php\">Bylaws</a></li>
        <li><a href=\"clubfilm.php\">Requests</a></li>
        <li><a href=\"faq.php\">FAQ</a></li>
        <li><a href=\"feedback.php\">Feedback</a></li>
        <li><a href=\"officers.php\">Contact</a></li>";
        if($session->logged_in){
            echo "<li>
                        <a href=\"#\">";
                        if($session->isAdmin()) { echo "Admin"; } else { echo "Members"; } 
                        echo "</a>
                        <ul>
                              <li><a href=\"officers/userinfo.php?user=$session->username\">Profile</a></li>
                              <li><a href=\"officers/managefiles.php\">Files</a></li>";
                              if($session->isAdmin()) {
                                    echo "<li><a href=\"officers/gen.php\">Schedule Generator</a></li>
                                          <li><a href=\"officers/editstaff.php\">Change Officers</a></li>
                                          <li><a href=\"officers/register.php\">Add Users</a></li>
                                          <li><a href=\"officers/admin/admin.php\">Admin Center</a></li>";
                              }
                        echo "</ul>
                  </li>";
            echo "<li><a href=\"officers/process.php\">Logout</a></li>";
        } else {
            echo "<li><a href=\"officers/main.php\">Login</a></li>";
        }
    echo
     "</ul>
    </div>";
  ?>

  
  <div id="content">
      &nbsp;
<?php
//We want the posters to switch at 2am of the next day, rather than midnight
  if (date('G') < 2){
    $date = date('Y-m-d', strtotime('Yesterday'));
  } else { 
    $date = date('Y-m-d');
  }
  
  $sql = "SELECT * FROM $sched_tbl WHERE date >= '$date' ORDER BY date;";
  $result = mysql_query($sql);
  sqlerr($sql, __FILE__, __LINE__);

  unset($movie);
  
  while ($movie = mysql_fetch_assoc($result)) {
    $movies[]=$movie;
  }
  
  unset($movie);
  if(count($movies) > 0) {
?>
      <h1>Upcoming Shows</h1><br><br>
      
<?php
  for ($j=0;$j<count($movies);$j++) {
      $movie = $movies[$j];
?>
                  <div id="movie-display-<?php echo $movie['id'] ?>">
<?php 
                  $backdrop_displayed = false;
                  if ($movie['backdrop'] != '') {
                        echo '<div><img style="position:absolute; width:914px; z-index=-1;" src="images/' . $movie['backdrop'] . '" alt="backdrop" /></div>';
                        $backdrop_displayed = true;
                  } 
                  if ($backdrop_displayed == false) {
                        echo '<div><img style="position:absolute; width:914px; z-index=-1;" src="nobackdrop.jpg" alt="backdrop" /></div>';
                  } 
?>
                  <div style="position:relative; top:0px; left:0px; z-index=1;">
                  <fieldset>
                  <legend style="background-image:url('images/transparent_background.png'); background-repeat:repeat; color:white;" class="scheduler_title"><?php echo stripslashes($movie['title']) . ' - '.date('l, M jS, Y', strtotime($movie['date'])) ?></legend>
                  <div class="scheduler_movie">
<?php
                  
                  echo '<div style="float:left; padding:10px; background-image:url(\'images/transparent_background.png\'); background-repeat:repeat; color:white;">' . PHP_EOL;
                        
                  $poster_displayed = false;
                  if ($movie['image'] != "") {
                        echo '<img class="posterselect" id="poster-' . $movie['id'] . '" alt="'.$movie['title'].'" src="images/'. $movie['image'] . '" />' . PHP_EOL;
                        $poster_displayed = true;
                  }
                  if ( $poster_displayed == false ) {
                        echo '<img class="posterselect" id="poster-' . $movie['id'] . '" alt="'.$movie['title'].'" src="images/noposter.png" />' . PHP_EOL;
                  }
                  echo '</div>' . PHP_EOL;
                  
                  echo '<div style="float:right; background-image:url(\'images/transparent_background.png\'); background-repeat:repeat; color:white;">
                        <fieldset style="width:320px;">
                        <legend style="background-image:url(\'images/transparent_background.png\'); background-repeat:repeat; color:white;">Show Data</legend>
                        <p>
                        <span class="scheduler_title">Title: </span>
                        <span class="movie-metadata" id="title-'.$movie['id'].'">'. stripslashes($movie['title']) .'</span>
                        </p>
                        <p>
                        <span class="scheduler_title">Date: </span>
                        <span class="change-date" id="date-'.$movie['id'].'">' . date('l, M j, Y', strtotime($movie['date'])) . '</span>
                        </p>
                        <p>
                        <span class="scheduler_title">Times: </span>
                        <span class="movie-metadata" id="times-'.$movie['id'].'">'.$movie['times'].'</span>
                        </p>
                        <p>
                        <span class="scheduler_title">Cost: </span>
                        <span class="movie-metadata" id="cost-'.$movie['id'].'">'.$movie['cost'].'</span>
                        </p>'; 
                        if($movie['sponsor'] != '') { 
                              echo '<p>                        
                                    <span class="scheduler_title">Sponsor: </span>
                                    <span class="movie-metadata" id="sponsor-'.$movie['id'].'">' . stripslashes($movie['sponsor']) . '</span>
                                    </p>';
                        }
                        
                        
                        if ($movie['nrb'] == 1) { $otherattrib[] = 'NRB'; }
                        if ($movie['sneak'] == 1) { $otherattrib[] = 'Sneak Preview!'; }
                        if (count($otherattrib) > 0) { 
                           echo '<p>
                                 <span class="movie-other" id="other-'.$movie['id'].'">' . PHP_EOL;
                           echo join(", ", $otherattrib);
                           echo '</span></p>';
                        }
                        echo '</fieldset>
                        </div>' . PHP_EOL;
                        unset($otherattrib);
                  
                  echo '<div style="float:right; background-image:url(\'images/transparent_background.png\'); background-repeat:repeat; color:white;">
                        <fieldset>
                        <legend style="background-image:url(\'images/transparent_background.png\'); background-repeat:repeat; color:white;">Movie Data</legend>';
                        
                        
                  
                  if ($movie['categories'] != '') {
                        echo '<p class="scheduler_overview">
                              <span class="scheduler_title">Categories: </span>' . PHP_EOL;
                        echo '<span class="movie-metadata" id="categories-'.$movie['id'].'">' . $movie['categories'] . '</span>' . PHP_EOL;
                        echo '</p>' . PHP_EOL;
                  }
                                    
                  if($movie['overview'] != '') {
                        echo '<p class="scheduler_overview">
                              <span class="scheduler_title">Overview:</span>
                              <span class="movie-overview" id="overview-'.$movie['id'].'">';
                        echo stripslashes($movie['overview']);
                        echo '</span></p>' . PHP_EOL;
                  }
                  
                  
                  if($movie['rating'] != '') {
                        echo '<p class="scheduler_overview">
                              <span class="scheduler_title">MPAA Rating:</span>
                              <span class="movie-rating" id="rating-'.$movie['id'].'">';
                        echo $movie['rating'];
                        echo '</span>&nbsp; &nbsp;' . PHP_EOL;
                  }
                  
                  
                  if($movie['length'] != 0) {
                        echo '<span class="scheduler_title">Runtime:</span>
                              <span class="movie-metadata" id="length-'.$movie['id'].'">';
                        echo $movie['length'] . ' minutes';
                        echo '</span></p>' . PHP_EOL;
                  }
                                    
                  if($movie['imdb'] != '0') {
                        echo '<a href="http://www.imdb.com/title/' . $movie['imdb'] . '"><img style="vertical-align:top;" src="images/imdb-logo.png" alt="IMDb" /></a>';
                  }
                  
                  
                  if($movie['trailer'] != '') {
                        echo '<a href="' . $movie['trailer'] . '"><img src="images/youtube_logo.png" alt="YouTube" /></a>' . PHP_EOL;
                  }
                  echo '</fieldset>
                        </div>' . PHP_EOL;
?>
                  </div>
                  </fieldset>
                  </div>
                  </div>
<?php
  }
?>

<?php 
} else {
?>
      <h1>No movies are currently scheduled</h1>
      <h2>Check back soon!</h2>
<?php
}
?>
      &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div style="background-color:#CC0000;" id="pagebottom">&nbsp;</div>

</div>
</body>
</html>