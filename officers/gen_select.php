<?php
include_once("include/session.php");

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

if(isset($_SESSION['multiple_movies_found'])) {
      foreach($_POST['movie_title'] as $id=>$title) {
            if($title && $_POST[$title] != 'tmdb_movie_not_found') {
                  $POSTtitle = str_replace(" ","_",$title);
                  $tmdb_id = $_POST[$POSTtitle];
                  $terms = $_SESSION[stripslashes($title)];
                  $terms[]= "tmdb_id='".$tmdb_id."'";
                  $sql = "INSERT INTO $sched_tbl SET " . join(", ", $terms);
                  $result = mysql_query($sql);
                  sqlerr($sql, __FILE__, __LINE__);
                  unset($_SESSION[$title]);
            }
      }
      unset($_SESSION['multiple_movies_found']);
}
header("Location: gen_summary.php?semester=" . $_POST['semester']);
}
?>