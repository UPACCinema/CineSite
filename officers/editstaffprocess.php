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

function sqlerr($sql, $file, $line){
  if ($err = mysql_error()){
    echo "ERROR: $err<br>\n";
    echo "SQL: $sql<br>\n";
    echo "In $file, at line # $line<br>\n";
    exit();
  }
}


  $chairsql = "UPDATE officers SET name='$_POST[chairname]', email='$_POST[chairemail]' WHERE position='Chair'";
  $result = mysql_query($chairsql);
  sqlerr($chairsql, __FILE__, __LINE__);

  $fncsql = "UPDATE officers SET name='$_POST[fncname]', email='$_POST[fncemail]' WHERE position='FridayNightCoordinator'";
  $result = mysql_query($fncsql);
  sqlerr($fncsql, __FILE__, __LINE__);

  $sncsql = "UPDATE officers SET name='$_POST[sncname]', email='$_POST[sncemail]' WHERE position='SaturdayNightCoordinator'";
  $result = mysql_query($sncsql);
  sqlerr($sncsql, __FILE__, __LINE__);

  $midsql = "UPDATE officers SET name='$_POST[midname]', email='$_POST[midemail]' WHERE position='MidweekCoordinator'";
  $result = mysql_query($midsql);
  sqlerr($midsql, __FILE__, __LINE__);

  $repsql = "UPDATE officers SET name='$_POST[repname]', email='$_POST[repemail]' WHERE position='RepertoryCoordinator'";
  $result = mysql_query($repsql);
  sqlerr($repsql, __FILE__, __LINE__);

  $pubsql = "UPDATE officers SET name='$_POST[pubname]', email='$_POST[pubemail]' WHERE position='PublicityCoordinator'";
  $result = mysql_query($pubsql);
  sqlerr($pubsql, __FILE__, __LINE__);

  $websql = "UPDATE officers SET name='$_POST[webname]', email='$_POST[webemail]' WHERE position='Webmaster'";
  $result = mysql_query($websql);
  sqlerr($websql, __FILE__, __LINE__);
  
  foreach($_POST['projname'] as $id => $fullname) {
    $fullemail=$_POST['projemail'][$id];
	if ($id == "NEW") {
	  $projsql = "INSERT INTO officers SET position='Projectionist', name='$fullname', email='$fullemail'";
      $result = mysql_query($projsql);
      sqlerr($projsql, __FILE__, __LINE__);
	} else if(array_key_exists('delete', $_POST) and array_key_exists($id, $_POST['delete'])) {
      $projsql = "DELETE FROM officers WHERE id=$id";
      $result = mysql_query($projsql);
      sqlerr($projsql, __FILE__, __LINE__);
    } else {
      $projsql = "UPDATE officers SET name='$fullname', email='$fullemail' WHERE id = $id";
      $result = mysql_query($projsql);
      sqlerr($projsql, __FILE__, __LINE__);
    }
  }
  
  $_SESSION['staffedited'] = true;

header("Location: editstaff.php");

}
?>