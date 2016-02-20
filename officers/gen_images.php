<?php
include_once("include/session.php");
include_once("TMDb.php");
include_once("../menubar.php");

if(!($session->isAdmin())){
  header("Location: main.php");
} else {


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


function string_to_filename($word) {
      $tmp = preg_replace('/^\W+|\W+$/', '', $word); // remove all non-alphanumeric chars at begin & end of string
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


$tmdb = new TMDb('a1425b80993f31c6030c2af97272750b');

if(isset($_POST['image-id'])) {
      $image_id = $_POST['image-id'];
      $image_type = $_POST['image_type'];
      $tmdb_id = $_POST['tmdb_id'];
      $movie_id = $_POST['movie_id'];
      
      $sql = "SELECT * FROM " . $sched_tbl . " WHERE id = " . $movie_id . ";";
      $result = mysql_query($sql);
      while( $movie = mysql_fetch_assoc($result) ) {
            $semester = $movie['semester'];
            $title = $movie['title'];
      }
      
      $ftp_user = "cinema";
      $ftp_pass = "n@VSjEV4lG";
      $ftp_hostname = "cinema.union.rpi.edu";
      $ftp_connection = ftp_connect($ftp_hostname, 21);
      $ftp_login_result = ftp_login($ftp_connection, $ftp_user, $ftp_pass);
      
      if($image_id != 'upload_new') {
            $image_list = json_decode($tmdb->getImages($tmdb_id,TMDb::JSON));
            
            if($image_type == 'poster') {
                  if(isset($image_list[0]->posters)) {
                        foreach($image_list[0]->posters as $array_id => $poster) {
                              if(isset($poster->image->url) and $poster->image->id == $image_id and $poster->image->size == 'mid') {
                                    $url_semester = str_replace(" ", "_", $semester);
                                    $url_title = str_replace(" ", "_", $title);
                                    $url_image = $url_semester . '_' . string_to_filename($url_title) . '.' . pathinfo(parse_url($poster->image->url,PHP_URL_PATH),PATHINFO_EXTENSION);
                                    $copy_url = '/public_html/images/' . $url_image;
                                    $image_url = $poster->image->url;
                                    $ftp_result = ftp_put($ftp_connection, $copy_url, $image_url, FTP_BINARY);
                                    if($ftp_result) {
                                          $sql = "UPDATE " . $sched_tbl . " SET image='" . $url_image . "' WHERE id=" . $movie_id . ";";
                                          $result = mysql_query($sql);
                                          $_SESSION['upload_success'] = $url_image;
                                    }
                              }
                        }
                  }
            } elseif ($image_type == 'backdrop') {
                  if(isset($image_list[0]->backdrops)) {
                        foreach($image_list[0]->backdrops as $array_id => $poster) {
                              if(isset($poster->image->url) and $poster->image->id == $image_id and $poster->image->size == 'original') {
                                    $url_semester = str_replace(" ", "_", $semester);
                                    $url_title = str_replace(" ", "_", $title);
                                    $url_image = $url_semester . '_' . string_to_filename($url_title) . '_backdrop.' . pathinfo(parse_url($poster->image->url,PHP_URL_PATH),PATHINFO_EXTENSION);
                                    $copy_url = '/public_html/images/' . $url_image;
                                    $image_url = $poster->image->url;
                                    $ftp_result = ftp_put($ftp_connection, $copy_url, $image_url, FTP_BINARY);
                                    if($ftp_result) {
                                          list($width, $height, $type) = getimagesize('../images/' . $url_image);
                                          $image = create_file_type($type, '../images/' . $url_image);
                                          $small_image = '/home/cinema/files/publicity/' . $url_image;
                                          imagejpeg($image, $small_image, 50);
                                          imagedestroy($image);
                                          $ftp_result2 = ftp_put($ftp_connection, $copy_url, $small_image, FTP_BINARY);
                                          if($ftp_result2) {
                                                unlink($small_image);
                                                $sql = "UPDATE " . $sched_tbl . " SET backdrop='" . $url_image . "' WHERE id=" . $movie_id . ";";
                                                $result = mysql_query($sql);
                                                $_SESSION['upload_success'] = $url_image;
                                          }
                                    }
                              }
                        }
                  }
            }
      } else {
            if ($_FILES["image-file"]["error"] > 0) {
                  $_SESSION['upload_fail'] = true;
            } else {
                  $url_semester = str_replace(" ", "_", $semester);
                  $url_title = str_replace(" ", "_", $title);
                  if($image_type == 'poster') {
                        $url_image = $url_semester . '_' . string_to_filename($url_title) . '.' . pathinfo(parse_url($_FILES['image-file']['name'],PHP_URL_PATH),PATHINFO_EXTENSION);
                  } else {
                        $url_image = $url_semester . '_' . string_to_filename($url_title) . '_backdrop.' . pathinfo(parse_url($_FILES['image-file']['name'],PHP_URL_PATH),PATHINFO_EXTENSION);
                  }
                  $copy_url = '/public_html/images/' . $url_image;
                  $ftp_result = ftp_put($ftp_connection, $copy_url, $_FILES["image-file"]["tmp_name"], FTP_BINARY);
                  if($ftp_result) {
                        if($image_type == 'poster') {
                              $sql = "UPDATE " . $sched_tbl . " SET image='" . $url_image . "' WHERE id=" . $movie_id . ";";
                              $result = mysql_query($sql);
                              $_SESSION['upload_success'] = $url_image;
                        } else {
                              list($width, $height, $type) = getimagesize('../images/' . $url_image);
                              $image = create_file_type($type, '../images/' . $url_image);
                              $small_image = '/home/cinema/files/publicity/' . $url_image;
                              imagejpeg($image, $small_image, 50);
                              imagedestroy($image);
                              $ftp_result2 = ftp_put($ftp_connection, $copy_url, $small_image, FTP_BINARY);
                              if($ftp_result2) {
                                    unlink($small_image);
                                    $sql = "UPDATE " . $sched_tbl . " SET backdrop='" . $url_image . "' WHERE id=" . $movie_id . ";";
                                    $result = mysql_query($sql);
                                    $_SESSION['upload_success'] = $url_image;
                              }
                        }
                  } else {
                        $_SESSION['upload_fail'] = true;
                  }
            }
      }
      if( !(isset($_SESSION['upload_success'])) ) {
            $_SESSION['upload_fail'] = true;
      }
      
      ftp_close($ftp_connection);
      
      $_SESSION['changed_image'] = $movie_id;
      
      header("Location: gen_summary.php?semester=" . $semester);
      
} else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">


<html>
      <head>
            <link rel="stylesheet" type="text/css" href="../newstyles.css">
            <link rel="icon" href="../favicon.ico" type="image/x-icon">
            <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
            <title>UPAC Cinema - Image Picker</title>
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
                  <h1>Please select an image to use as the <?php echo $_GET['imagetype'] ?></h1>
                  <form id="commentForm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                        <div class="generator">
<?php
                                    if($_GET['tmdbid']) {
                                          $tmdb_id = $_GET['tmdbid'];
                                    }
                                    $image_type = $_GET['imagetype'];
                                    $semester = $_GET['semester'];
?>
                                    <div>
                                          <input type="hidden" name="image_type" value="<?php echo $image_type ?>">
                                          <input type="hidden" name="tmdb_id" value="<?php echo $tmdb_id ?>">
                                          <input type="hidden" name="movie_id" value="<?php echo $_GET['movieid'] ?>">
                                    </div>
                                    <table cellpadding="10">
<?php
                                    if(isset($tmdb_id)) {
                                          $image_list = json_decode($tmdb->getImages($tmdb_id,TMDb::JSON));
                                    }
                                    if($image_type == 'poster') {
                                          echo '<tr>';
                                          if(isset($image_list[0]->posters)) {
                                                foreach($image_list[0]->posters as $array_id => $poster) {
                                                      if(isset($poster->image->url) and $poster->image->size == 'cover') {
                                                            echo '<td align="center">
                                                                  <img src="' . $poster->image->url . '" alt="' . $poster->image->id . '" />
                                                                  </td>';
                                                      }
                                                }
                                          }
                                          echo '<td><img style="width:185px; height:270px;" src="../images/noposter.png" alt="No Poster" /></td>
                                                </tr>';
                                          echo '<tr>';
                                          $first_radio_button = true;
                                          if(isset($image_list[0]->posters)) {
                                                foreach($image_list[0]->posters as $array_id => $poster) {
                                                      if(isset($poster->image->url) and $poster->image->size == 'cover') {
                                                            echo '<td align="center">';
                                                            if($first_radio_button) {
                                                                  echo '<input type="radio" name="image-id" value="' . $poster->image->id . '" checked />Select';
                                                                  $first_radio_button = false;
                                                            } else {
                                                                  echo '<input type="radio" name="image-id" value="' . $poster->image->id . '" />Select';
                                                            }
                                                            echo '</td>';
                                                      }
                                                }
                                          }
                                          echo '<td>
                                                      <input type="file" name="image-file" /><br>';
                                                      if($first_radio_button) {
                                                            echo '<input type="radio" name="image-id" value="upload_new" checked />Upload';
                                                            $first_radio_button = false;
                                                      } else {
                                                            echo '<input type="radio" name="image-id" value="upload_new" />Upload';
                                                      }
                                          echo  '</td>
                                                </tr>';
                                    } elseif ($image_type == 'backdrop') {
                                          echo '<tr>';
                                          if(isset($image_list[0]->backdrops)) {
                                                foreach($image_list[0]->backdrops as $array_id => $poster) {
                                                      if(isset($poster->image->url) and $poster->image->size == 'thumb') {
                                                            echo '<td align="center">
                                                                  <img src="' . $poster->image->url . '" alt="' . $poster->image->id . '" />
                                                                  </td>';
                                                      }
                                                }
                                          }
                                          echo '<td><img style="width:300px; height:188px;" src="../images/nobackdrop.jpg" alt="No Poster" /></td>
                                                </tr>';
                                          echo '<tr>';
                                          $first_radio_button = true;
                                          if(isset($image_list[0]->backdrops)) {
                                                foreach($image_list[0]->backdrops as $array_id => $poster) {
                                                      if(isset($poster->image->url) and $poster->image->size == 'thumb') {
                                                            echo '<td align="center">';
                                                            if($first_radio_button) {
                                                                  echo '<input type="radio" name="image-id" value="' . $poster->image->id . '" checked />Select';
                                                                  $first_radio_button = false;
                                                            } else {
                                                                  echo '<input type="radio" name="image-id" value="' . $poster->image->id . '" />Select';
                                                            }
                                                            echo '</td>';
                                                      }
                                                }
                                          }
                                          echo '<td>
                                                      <input type="file" name="image-file" /><br>';
                                                      if($first_radio_button) {
                                                            echo '<input type="radio" name="image-id" value="upload_new" checked />Upload';
                                                            $first_radio_button = false;
                                                      } else {
                                                            echo '<input type="radio" name="image-id" value="upload_new" />Upload';
                                                      }
                                          echo '</td>
                                                </tr>';
                                    }
?>
                                    </table>
                        </div>
                        <div><input type="submit" name="submit" value="Submit" /><input type="button" name="Cancel" value="Cancel" onclick="window.location = 'gen_summary.php?semester=<?php echo $semester ?>' " /></div>
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

}

?>
