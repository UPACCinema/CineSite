<?php
include_once("include/session.php");
include_once("TMDb.php");
include_once("../menubar.php");

if(!($session->isAdmin())){
  header("Location: main.php");
} else {

global $session, $form;

$tmdb = new TMDb('a1425b80993f31c6030c2af97272750b');

$user = "cinema";
$pass = "n@VSjEV4lG";
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

      $ftp_user = "cinema";
      $ftp_pass = "n@VSjEV4lG";
      $ftp_hostname = "ftp.union.rpi.edu";
      $ftp_connection = ftp_connect($ftp_hostname);
      $ftp_login_result = ftp_login($ftp_connection, $ftp_user, $ftp_pass);
	  ftp_pasv($ftp_connection, true);
	if ($ftp_connection == 0) die("ftp connect failed");
	if ($ftp_login_result == 0) die("ftp login result failed");
function string_to_filename($word) {
    $tmp = preg_replace('/[^a-zA-Z0-9\s]/', '', $word); // remove all non-alphanumeric chars
    $tmp = preg_replace('/\s+/', '_', $tmp); // compress internal whitespace and replace with _
    return strtolower(preg_replace('/[^0-9^a-z^A-Z^_]/', '', $tmp)); // remove all non-alphanumeric chars except _ and -
}

function create_file_type($type, $file) {
      switch ($type) {
            case IMAGETYPE_GIF:
                  $image = imagecreatefromgif($file);
                  return $image;
                  break;
            case IMAGETYPE_JPEG:
                  $image = imagecreatefromjpeg($file);
                  return $image;
                  break;
            case IMAGETYPE_PNG:
                  $image = imagecreatefrompng($file);
                  return $image;
                  break;
      }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">


<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
    <link rel="stylesheet" type="text/css" href="../newstyles.css">
    <link rel="stylesheet" type="text/css" href="jquery-ui-1.8.2.custom.css">
    <style type="text/css">
      input.text { margin-bottom:12px; width:95%; padding: .4em; }
      .ui-state-error { padding: 0.3em; }
      .validateTips { border: 1px solid transparent; padding: 0.3em; }
    </style>
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <style type="text/css">
      .jeip-mouseover {
        background-color: #ffff99;
      } 
    </style>
    <title>UPAC Cinema - Schedule Summary</title>
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
    
      
<?php
      if(isset($_GET['semester'])) {
            $semester = $_GET['semester'];
            
            echo '
            <h1>Schedule Editor</h1>
            <h2>Click a field to start editing it</h2>';
            
            if(isset($_SESSION['upload_fail'])) {
                  echo '<p class="notify_bad"><span>Image upload failed</span></p>';
                  unset($_SESSION['upload_fail']);
            } elseif(isset($_SESSION['upload_success'])) {
                  echo '<p class="notify_good"><span>' . $_SESSION['upload_success'] . ' uploaded successfully</span></p>';
                  unset($_SESSION['upload_success']);
            }
            
            $sql = "SELECT * FROM $sched_tbl WHERE semester = '$semester' ORDER BY date;";
            $result = mysql_query($sql);
            sqlerr($sql, __FILE__, __LINE__);
            set_time_limit(0);
            while ( $movie = mysql_fetch_assoc($result) ) {
                  if($movie['tmdb_id']) {
                        $tmdb_data = json_decode($tmdb->getMovie($movie['tmdb_id'],TMDb::TMDB,TMDb::JSON));
                        $moviedata = $tmdb_data[0];
                  } else {
                        if(isset($moviedata)) {
                              unset($moviedata);
                        }
                  }
?>
                  <div id="movie-display-<?php echo $movie['id'] ?>">
                  <p class="heading"><a href="gen_add.php?semester=<?php echo $semester ?>">Add more movies</a></p>
                  <p id="delete-error-<?php echo $movie['id'] ?>" class="notify_bad"></p>
                  <fieldset>
                  <legend class="scheduler_title"><?php echo stripslashes($movie['title']) . ' - '.date('l, M jS, Y', strtotime($movie['date'])) ?> <input class="deletethismovie" type="button" id="delete-<?php echo $movie['id'] ?>" value="Delete" /><span class="jeip-saving" style="display: none;" id="delete-save-<?php echo $movie['id'] ?>">Deleting</span></legend>
                  <div class="scheduler_movie">
<?php
                  $reload_image = '';
                  if(isset($_SESSION['changed_image'])) {
                        if($_SESSION['changed_image'] == $movie['id']) {
                              $reload_image = '?' . time();
                              unset($_SESSION['changed_image']);
                        }
                  }
                  echo '<div>
                        <fieldset style="text-align:center;">
                        <legend>Poster</legend>' . PHP_EOL;
                        
                  $poster_displayed = false;
                  if ($movie['image'] != "") {
                        echo '<img class="posterselect" id="poster-' . $movie['id'] . '" alt="'.$movie['title'].'" src="../images/'. $movie['image'] . $reload_image . '" />' . PHP_EOL;
                        $poster_displayed = true;
                  } elseif(isset($moviedata->posters) and count($moviedata->posters) > 0) {
                        foreach($moviedata->posters as $id=>$poster) {
                              if(isset($poster->image->size) and $poster->image->size == 'mid' and $poster_displayed == false) {
                                    $url_semester = str_replace(" ", "_", $semester);
                                    $url_image = $url_semester . '_' . string_to_filename($movie['title']) . '.' . pathinfo(parse_url($poster->image->url,PHP_URL_PATH),PATHINFO_EXTENSION);
                                    $terms[] = "image='" . $url_image . "'";
                                    $copy_url = '/public_html/images/' . $url_image;
                                    $image_url = $poster->image->url;
                                    $ftp_result = ftp_put($ftp_connection, $copy_url, $image_url, FTP_BINARY);
									echo '<img class="posterselect" id="poster-' . $movie['id'] . '" alt="'.$movie['title'].'" src="../images/'.$url_image. $reload_image . '" />' . PHP_EOL;
                                    $poster_displayed = true;
                              }
                        }
                  }
                  if ( $poster_displayed == false ) {
                        echo '<img class="posterselect" id="poster-' . $movie['id'] . '" alt="'.$movie['title'].'" src="../images/noposter.png' . $reload_image . '" />' . PHP_EOL;
                  }
                  echo '<br><a href="gen_images.php?imagetype=poster&amp;tmdbid=' . $movie['tmdb_id'] . '&amp;movieid=' . $movie['id'] . '&amp;semester=' . $semester . '">Change</a>';
                  echo '</fieldset>
                        </div>' . PHP_EOL;
                                    
                  echo '<div>
                        <fieldset style="width:303px; text-align:center;" >
                        <legend>Backdrop</legend>' . PHP_EOL;
                        
                  $backdrop_displayed = false;
                  if ($movie['backdrop'] != "") {
                        echo '<img class="summary_backdrop" id="backdrop-' . $movie['id'] . '" alt="'.$movie['title'].'" src="../images/'. $movie['backdrop'] . $reload_image . '" />' . PHP_EOL;
                        $backdrop_displayed = true;
                  } elseif(isset($moviedata->backdrops) and count($moviedata->backdrops) > 0) {
                        foreach($moviedata->backdrops as $id=>$backdrop) {
                              if(isset($backdrop->image->size) and $backdrop->image->size == 'original' and $backdrop_displayed == false) {
                                    $url_semester = str_replace(" ", "_", $semester);
                                    $url_image = $url_semester . '_' . string_to_filename($movie['title']) . '_backdrop.' . pathinfo(parse_url($backdrop->image->url,PHP_URL_PATH),PATHINFO_EXTENSION);
                                    $terms[] = "backdrop='" . $url_image . "'";
                                    $copy_url = '/public_html/images/' . $url_image;
                                    $image_url = $backdrop->image->url;
                                    $ftp_result = ftp_put($ftp_connection, $copy_url, $image_url, FTP_BINARY);
                                    list($width, $height, $type) = getimagesize('../images/' . $url_image);
                                    $full_image = create_file_type($type, '../images/' . $url_image);
                                    $small_image = '/home/cinema/files/publicity/' . $url_image;
                                    imagejpeg($full_image, $small_image, 50);
                                    imagedestroy($full_image);
                                    $ftp_result2 = ftp_put($ftp_connection, $copy_url, $small_image, FTP_BINARY);
                                    unlink($small_image);
                                    echo '<img class="summary_backdrop" id="backdrop-' . $movie['id'] . '" alt="'.$movie['title'].'" src="../images/'.$url_image. $reload_image . '" />' . PHP_EOL;
                                    $backdrop_displayed = true;
                              }
                        }
                  } 
                  if ($backdrop_displayed == false) {
                        echo '<img class="summary_backdrop" id="backdrop-' . $movie['id'] . '" alt="'.$movie['title'].'" src="../images/nobackdrop.jpg"' . $reload_image . '" />' . PHP_EOL;
                  }
                  echo '<br><a href="gen_images.php?imagetype=backdrop&amp;tmdbid=' . $movie['tmdb_id'] . '&amp;movieid=' . $movie['id'] . '&amp;semester=' . $semester . '">Change</a>';
                  echo '</fieldset>
                        </div>' . PHP_EOL;
                        
                  echo '<div>
                        <fieldset style="width:303px;">
                        <legend>Trailer</legend>' . PHP_EOL;
                  
                  if($movie['trailer'] != '') {
                        echo '<a id="youtube-'.$movie['id'].'" href="' . $movie['trailer'] . '">Click here to preview the trailer</a>
                              <br><br><span class="scheduler_title">Link <br>(http://www.youtube.com/watch?v=video-id): </span><br>
                              <span class="movie-trailer" id="trailer-'.$movie['id'].'">' . $movie['trailer'] . '</span>' . PHP_EOL;
                  } elseif(isset($moviedata->trailer) and $moviedata->trailer != '') {
                        $trailer = $moviedata->trailer;
                        $terms[] = "trailer='". addslashes($trailer) . "'";
                        echo '<a id="youtube-'.$movie['id'].'" href="' . $trailer . '">Click here to preview the trailer</a>
                              <br><br><span class="scheduler_title">Link <br>(http://www.youtube.com/watch?v=video-id): </span><br>
                              <span class="movie-trailer" id="trailer-'.$movie['id'].'">' . $trailer . '</span>' . PHP_EOL;
                  } else {
                        echo '<a id="youtube-'.$movie['id'].'" href="#">Click here to preview the trailer</a>
                              <br><br><span class="scheduler_title">Link <br>(http://www.youtube.com/watch?v=video-id): </span><br>
                              <span class="movie-trailer" id="trailer-'.$movie['id'].'">Add</span>' . PHP_EOL;
                  }
                  echo '</fieldset>
                        </div>
                        <div>
                        <fieldset style="width:320px;">
                        <legend>Show Data</legend>
                        <p>
                        <span class="scheduler_title">Title: </span>
                        <span class="movie-metadata" id="title-'.$movie['id'].'">'.stripslashes($movie['title']).'</span>
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
                        </p><p>                        
                        <span class="scheduler_title">Sponsor: </span>
                        <span class="movie-metadata" id="sponsor-'.$movie['id'].'">'; 
                        if($movie['sponsor'] != '') { echo stripslashes($movie['sponsor']); } else { echo 'Add'; }
                        
                        echo '</span>
                        </p>
                        <p>
                        <span class="scheduler_title">Other Attributes: </span><span class="movie-other" id="other-'.$movie['id'].'">' . PHP_EOL;
                        if ($movie['nrb'] == 1) { $otherattrib[] = 'NRB'; }
                        if ($movie['sneak'] == 1) { $otherattrib[] = 'Sneak Preview'; }
                        if (count($otherattrib) > 0) { echo join(", ", $otherattrib); } else { echo 'None'; }
                        echo '</span></p>
                        </fieldset>
                        </div>' . PHP_EOL;
                        unset($otherattrib);
                  
                  echo '<div>
                        <fieldset>
                        <legend>Movie Data</legend>
                        
                        <p class="scheduler_overview">
                        <span class="scheduler_title">Categories: </span>' . PHP_EOL;
                  
                  if ($movie['categories'] != '') {
                        echo '<span class="movie-metadata" id="categories-'.$movie['id'].'">' . stripslashes($movie['categories']) . '</span>' . PHP_EOL;
                  } elseif(isset($moviedata->genres) and count($moviedata->genres) > 0) {
                        foreach($moviedata->genres as $id=>$genre) {
                              if(isset($genre->name)) {
                                    $movie_genres[] = $genre->name;
                              }
                        }
                        $terms[] = "categories='" . addslashes(join(", ", $movie_genres)) . "'";
                        echo '<span class="movie-metadata" id="categories-'.$movie['id'].'">'.join(", ", $movie_genres).'</span>' . PHP_EOL;
                        unset($movie_genres);
                  } else {
                        echo '<span class="movie-metadata" id="categories-'.$movie['id'].'">Add</span>' . PHP_EOL;
                  }
                  echo '</p>' . PHP_EOL;
                  
                  
                  echo '<p class="scheduler_overview">
                        <span class="scheduler_title">Overview:</span>
                        <span class="movie-overview" id="overview-'.$movie['id'].'">';
                  
                  if($movie['overview'] != '') {
                        echo $movie['overview'];
                  } elseif(isset($moviedata->overview) and $moviedata->overview != '') {
                        $terms[] = "overview='" . addslashes($moviedata->overview) . "'";
                        echo $moviedata->overview;
                  } else {
                        echo 'Add';
                  }
                  echo '</span></p>' . PHP_EOL;
                  
                  echo '<p class="scheduler_overview">
                        <span class="scheduler_title">MPAA Rating:</span>
                        <span class="movie-rating" id="rating-'.$movie['id'].'">';
                  
                  if($movie['rating'] != '') {
                        echo $movie['rating'];
                  } elseif(isset($moviedata->certification) and $moviedata->certification != '') {
                        $terms[] = "rating='" . addslashes($moviedata->certification) . "'";
                        echo $moviedata->certification;
                  } else {
                        echo 'Add';
                  }
                  echo '</span>&nbsp; &nbsp;' . PHP_EOL;
                  
                  echo '<span class="scheduler_title">Runtime (minutes):</span>
                        <span class="movie-metadata" id="length-'.$movie['id'].'">';
                  
                  if($movie['length'] != 0) {
                        echo $movie['length'];
                  } elseif(isset($moviedata->runtime) and $moviedata->runtime != 0) {
                        $terms[] = "length='" . addslashes($moviedata->runtime) . "'";
                        echo $moviedata->runtime;
                  } else {
                        echo 'Add';
                  }
                  echo '</span></p>' . PHP_EOL;
                  
                  echo '<p>
                        <span class="scheduler_title">IMDB link (ex: http://www.imdb.com/title/tt1375666): </span><br>
                        <span class="movie-metadata" id="imdb-'.$movie['id'].'">';
                  
                  if($movie['imdb'] != '0') {
                        echo 'http://www.imdb.com/title/' . $movie['imdb'];
                  } elseif(isset($moviedata->imdb_id) and $moviedata->imdb_id != '') {
                        $terms[] = "imdb='" . addslashes($moviedata->imdb_id) . "'";
                        echo 'http://www.imdb.com/title/' . $moviedata->imdb_id;
                  } else {
                        echo 'Add';
                  }
                  echo '</span></p>' . PHP_EOL;
                  
                  echo '</fieldset>
                        </div>' . PHP_EOL;
?>
                  </div>
                  </fieldset>
                  </div>
                  <br>
<?php
                  if(isset($terms)) {
                        $sql = "UPDATE $sched_tbl SET " . join(", ", $terms) . " WHERE id=" . $movie['id'] . ";";
                        $update_result = mysql_query($sql);
                        sqlerr($sql, __FILE__, __LINE__);
                        unset($terms);
                  }
            }
            flush();
      } else {
            echo 'There was a problem processing your request. Please try again.';
      }
      
      if(isset($_SESSION['changed_image'])) {
            unset($_SESSION['changed_image']);
      }
?>
  
    &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div id="pagebottom">&nbsp;</div>

</div>
    <script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui-1.8.2.custom.min.js"></script>
    <script type="text/javascript" src="../js/jeip.js"></script>
    <script type="text/javascript">
      $(document).ready(function () {
            
            $( ".change-date" ).eip( "save.php" , {
                  editfield_class : "add-datepicker"
            });
            
            $( ".movie-metadata" ).eip( "save.php" );
            
            $( ".movie-overview" ).eip( "save.php", {
                  form_type: "textarea"
            });
            
            $( ".movie-trailer" ).eip( "save.php", {
                  youtube_trailer: true
            });
            
            $( ".movie-other" ).eip( "save.php", {
                  form_type: "select",
                  select_options: {
                        NRB      : "NRB",
                        Sneak    : "Sneak",
                        SneakNRB : "Sneak and NRB",
                        None     : "None"
                  }
            });
            
            $( ".movie-rating" ).eip( "save.php", {
                  form_type: "select",
                  select_options: {
                        G     : "G",
                        PG    : "PG",
                        PG13  : "PG-13",
                        R     : "R",
                        NR    : "NR",
                        NC17  : "NC-17"
                  }
            });
                        
            $( ".deletethismovie" ).deleteMovie( "delete.php" );
            
            $( ".add-datepicker" ).datepicker({showOtherMonths: true, selectOtherMonths: true, dateFormat: 'DD, M d, yy' });
      });
      
      
      
      
      $.fn.deleteMovie = function( delete_url ) {
            var opt = {
                  delete_url  : delete_url
            };
            
            
            this.each( function( ) {
                  var self = this;
                  
                  $( this ).bind( "click", function( e ) {
                        _deleteTheMovie( this );
                  });
            });
            
            var _deleteTheMovie = function( self ) {
                  
                  var element_id = self.id;
                  var delete_field_and_id = element_id.split("-");
                  var delete_id = delete_field_and_id[1];
                  $( "#delete-save-" + delete_id ).fadeIn( );
                  
                  var ajax_data = {
                              url		      : location.href,
                              id		      : self.id,
                              delete_value	: delete_id
                        }
                  
                  $.ajax( {
                        url	      : opt.delete_url,
                        type	      : "POST",
                        dataType    : "json",
                        data	      : ajax_data,
                        success	: function( data ) {
                              if( data.is_error == false ) {
                                    $( "#delete-save-" + delete_id ).fadeOut( "fast", function() {
                                          $( "#delete-save-" + delete_id ).remove( );
                                    });
                                    $( "#movie-display-" + delete_id ).slideUp( 400, function() {
                                          $( "#movie-display-" + delete_id ).remove( );
                                    });
                              }
                              else {
                                    $( "#delete-error-" + delete_id ).html( data.error_text );
                              }
                        } // success
                  }); // ajax
            };
      };
    </script>
</body>
</html>
<?php

      ftp_close($ftp_connection);
}
flush();
      if(isset($_SESSION['changed_image'])) {
            unset($_SESSION['changed_image']);
      }
?>