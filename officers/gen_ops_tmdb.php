<?php
include_once("include/session.php");
include_once("TMDb.php");
include_once("../menubar.php");


if(!($session->isAdmin())){
  header("Location: main.php");
} else {

   global $session, $form;
   $user = "cinema";
   $pass = "kkbpfo233";
   $dbname = "cinema_db";
   $link = mysql_connect("db.union.rpi.edu", $user, $pass);
   mysql_select_db($dbname);

   $sched_tbl = "sched_new";

   function sqlerr($sql, $file, $line){
      if ($err = mysql_error()){
        echo "ERROR: $err<br>\n";
        echo "SQL: $sql<br>\n";
        echo "In $file, at line # $line<br>\n";
        exit();
      }
   }

   $tmdb = new TMDb('a1425b80993f31c6030c2af97272750b');

   $sem = $_POST['semester'];
   $fields = array('title', 'date', 'special', 'times', 'cost', 'nrb', 'sneak', 'sponsor');
   $multiple_movie_results_found = false;
   foreach($_POST['title'] as $id=>$title){
      if($title){
            $json_tmdb_search[$title] = json_decode($tmdb->searchMovie($title));
            if(count($json_tmdb_search[$title]) > 1) {
                  $multiple_movie_results_found = true;
            }
      }
   }
   if($multiple_movie_results_found == true) {

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">


<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../newstyles.css">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <title>UPAC Cinema - Movie Picker</title>
  </head>
<body>

<div id="wrapper">

<?php
    echo "<!-- Top Menu (Navigation) -->
    <div id=\"globalnavbar\" style=\"background-color:#000000;\">
      <img class=\"logo\"src=\"../images/upac_logo.png\" alt=\"UPAC Cinema\" />
      <ul class=\"dropdown\">
        <li><a href=\"../index.php\">Schedule</a></li>
        <li><a href=\"../policies.php\">Policies</a></li>
        <li><a href=\"../bylaws.php\">Bylaws</a></li>
        <li><a href=\"../clubfilm.php\">Requests</a></li>
        <li><a href=\"../faq.php\">FAQ</a></li>
        <li><a href=\"../feedback.php\">Feedback</a></li>
        <li><a href=\"../officers.php\">Contact</a></li>";
        if($session->logged_in){
            echo "<li>
                        <a href=\"#\">";
                        if($session->isAdmin()) { echo "Admin"; } else { echo "Members"; } 
                        echo "</a>
                        <ul>
                              <li><a href=\"userinfo.php?user=$session->username\">Profile</a></li>
                              <li><a href=\"managefiles.php\">Files</a></li>";
                              if($session->isAdmin()) {
                                    echo "<li><a href=\"gen.php\">Schedule Generator</a></li>
                                          <li><a href=\"editstaff.php\">Change Officers</a></li>
                                          <li><a href=\"register.php\">Add Users</a></li>
                                          <li><a href=\"admin/admin.php\">Admin Center</a></li>";
                              }
                        echo "</ul>
                  </li>";
            echo "<li><a href=\"process.php\">Logout</a></li>";
        } else {
            echo "<li><a href=\"main.php\">Login</a></li>";
        }
    echo
     "</ul>
    </div>";
  ?>

  
  <div id="content">
    &nbsp;
   <h1>Please select the correct movie from each list</h1><br><br>
   <form id="commentForm" action="gen_select.php" method="post">
   <div><input type="hidden" name="semester" value="<?php echo $sem ?>" /></div>
<?php
   $_SESSION['multiple_movies_found'] = true;
   }
   foreach ($_POST['title'] as $id=>$title){
     if ($title){
       $day = date('l',strtotime($_POST['date'][$id]));
       $terms = array();
       
       if(count($json_tmdb_search[$title]) > 1) {
            echo '<div><input type="hidden" name="movie_title['.$id.']" value="'.$title.'"></div>';
?>
    <div class="generator">
    <fieldset>
    <legend class="scheduler_title"><?php echo $title ?></legend>
      <table cellpadding="10">
<?php
            echo '<tr>';
            foreach($json_tmdb_search[$title] as $search_id => $movie_result) {
                  echo '<td align="center">';
                  if(isset($movie_result->posters)) {
                        if(count($movie_result->posters) < 1) {
                              echo '<img style="margin:auto;" class="scheduler_thumb" alt="'.$movie_result->name.'" src="../images/noposter.png" />';
                        } else {
                              foreach($movie_result->posters as $image_id => $poster) {
                                    if(isset($movie_result->name) and isset($poster->image->size) and isset($poster->image->url) and $poster->image->size == 'thumb') {
                                          echo '<img style="margin:auto;" class="scheduler_thumb" alt="'.$movie_result->name.'" src="'.$poster->image->url.'" />';
                                    }
                              }
                        }
                  }
                  echo '</td>';
            }
            echo '<td align="center"><img style="margin:auto;" class="scheduler_thumb" alt="Movie Not Found" src="../images/noposter.png" /></td>
                  </tr>';
            echo '<tr>';
            foreach($json_tmdb_search[$title] as $search_id => $movie_result) {
                  echo '<td align="center">';
                  if(isset($movie_result->name)) {
                        echo $movie_result->name;
                  }
                  if(isset($movie_result->released)) {
                        echo ' ('.date('Y', strtotime($movie_result->released)).')';
                  }
                  echo '</td>';
            }
            echo '<td align="center">Other...</td>
                  </tr>';
            echo '<tr>';
            $first_radio_button = true;
            foreach($json_tmdb_search[$title] as $search_id => $movie_result) {
                  echo '<td align="center">';
                  if($first_radio_button) {
                        echo '<input type="radio" name="'.$title.'" value="'.$movie_result->id.'" checked />Select';
                        $first_radio_button = false;
                  } else {
                        echo '<input type="radio" name="'.$title.'" value="'.$movie_result->id.'" />Select';
                  }
                  echo '</td>';
            }
            echo '<td align="center"><input type="radio" name="'.$title.'" value="tmdb_movie_not_found" />Select</td>
                  </tr>';
?>
      </table>
    </fieldset>
    </div>
<?php
       }
       
       foreach ($fields as $field){
         if($_POST[$field]) {
	     if (array_key_exists($id, $_POST[$field])){
	       $terms[] = "$field='".addslashes($_POST["$field"][$id])."'";
	     }
         }
       }
       $terms[] = "day='$day'";
       $terms[] = "semester='$sem'";
       
       if(count($json_tmdb_search[$title]) == 1) {
            if(isset($json_tmdb_search[$title][0]->id)) {
                  $terms[] = "tmdb_id='".($json_tmdb_search[$title][0]->id)."'";
            }
            $sql = "INSERT INTO $sched_tbl SET " . join(", ", $terms);
            $result = mysql_query($sql);
            sqlerr($sql, __FILE__, __LINE__);
       } else {
            $_SESSION[$title] = $terms;
       }
     }
   }
   if($multiple_movie_results_found == true) {
?>
   <div><input type="submit" name="submit" value="Submit" /></div>
   </form>
            &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div id="pagebottom">&nbsp;</div>

</div>
</body>
</html>
<?php
   }
   if($multiple_movie_results_found == false) {
      header("Location: gen_summary.php?semester=" . $sem);
   }
}
?>	