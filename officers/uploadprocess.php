<?php
include_once("include/session.php");
include_once("include/constants.php");

if(!($session->logged_in)){
  header("Location: main.php");
} else {

global $session, $form;



  if($_POST['officerlevel'] == ADMIN_LEVEL) {
    $savedir = '/home/cinema/files/publicity/';
  } elseif($_POST['officerlevel'] == CHAIR_LEVEL) {
    $savedir = '/home/cinema/files/chair/';
  } elseif($_POST['officerlevel'] == FRIDAY_LEVEL) {
    $savedir = '/home/cinema/files/fnc/';
  } elseif($_POST['officerlevel'] == SATURDAY_LEVEL) {
    $savedir = '/home/cinema/files/snc/';
  } elseif($_POST['officerlevel'] == MIDWEEK_LEVEL) {
    $savedir = '/home/cinema/files/midweek/';
  } elseif($_POST['officerlevel'] == REP_LEVEL) {
    $savedir = '/home/cinema/files/rep/';
  } elseif($_POST['officerlevel'] == PROJ_LEVEL) {
    $savedir = '/home/cinema/files/projectionists/';
  }
  foreach($_FILES['ufile']['name'] as $id => $filename) {
    if ($_FILES["ufile"]["error"][$id] > 0) {
  //    echo "Upload Error Code: " . $_FILES["ufile"]["error"][$id] . "<br />";
    } else {
      if (file_exists($savedir . $filename)) {
     //   echo $filename . " already exists. ";
      } else {
        $result = move_uploaded_file($_FILES["ufile"]["tmp_name"][$id], $savedir . $filename);
      }
    }
  }
  if($result) {
        $_SESSION['uploaded'] = true;
  } else {
        $_SESSION['uploaded'] = false;
  }
  
header("Location: upload.php");
}
?>