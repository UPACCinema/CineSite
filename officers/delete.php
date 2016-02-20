<?php
include_once("include/session.php");

if(!($session->isAdmin())){
  header("Location: main.php");
} else {



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


$url		= $_POST['url'];
$id		= $_POST['id'];
$delete_id	= $_POST['delete_value'];

$sql = "DELETE FROM " . $sched_tbl . " WHERE id=" . $delete_id . ";";
$result = mysql_query($sql);
//sqlerr($sql, __FILE__, __LINE__);
if(!$result) {
      $json = array(
            "is_error"		=> true,
            "error_text"	=> "Failed to delete from database",
            "html"		=> "It worked"
      );

} else {
      $json = array(
            "is_error"		=> false,
            "error_text"	=> "Ack!  Something broke!",
            "html"		=> "It worked"
      );
}
$response =  json_encode( $json );

print $response;

}
?>