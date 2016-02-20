<?php
include_once("include/session.php");
include_once("TMDb.php");


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

$tmdb = new TMDb('a1425b80993f31c6030c2af97272750b');

$url		= $_POST['url'];
$form_type	= $_POST['form_type'];
$id			= $_POST['id'];
$orig_value	= $_POST['orig_value'];
$new_value	= $_POST['new_value'];
if( $form_type == 'select' ) {
	$orig_option_text	= $_POST['orig_option_text'];
	$new_option_text	= $_POST['new_option_text'];

	$new_value			= $new_option_text;
}

$field_and_id = explode("-", $id);
$field = $field_and_id[0];
$id = $field_and_id[1];

if($new_value == "") {
      $sql = "UPDATE " . $sched_tbl . " SET " . $field . "='" . addslashes($new_value) . "' WHERE id=" . $id . ";";
      $result = mysql_query($sql);
      if($result) {
            $json = array(
                  "is_error"		=> false,
                  "error_text"	        => "Ack!  Something broke!",
                  "html"		=> "Add"
            );
      } else {
            $json = array(
                  "is_error"		=> true,
                  "error_text"	        => "Failed to save to the database",
                  "html"		=> "Add"
            );
      }
} else {

$sql = "SELECT " . $field . " FROM " . $sched_tbl . " WHERE id=" . $id . ";";


$result = mysql_query($sql);
//sqlerr($sql, __FILE__, __LINE__);

/*while ($field_value = mysql_fetch_assoc($result)) {
      if($field_value[$field] == "") {
            $sql_query_type = "INSERT INTO ";
      } else {*/
            $sql_query_type = "UPDATE ";
      /*}
}*/

if( $form_type == 'select' ) {
	$orig_option_text	= $_POST['orig_option_text'];
	$new_option_text	= $_POST['new_option_text'];

	$new_value			= $new_option_text;
      
      switch($field) {
            case "rating":
                  $sql = "UPDATE " . $sched_tbl . " SET " . $field . "='" . addslashes($new_value) . "' WHERE id=" . $id . ";";
                  break;
            case "other":
                  if($new_value == "NRB") {
                        $sql = "UPDATE " . $sched_tbl . " SET nrb=1, sneak=0 WHERE id=" . $id . ";";
                  } elseif($new_value == "Sneak") {
                        $sql = "UPDATE " . $sched_tbl . " SET nrb=0, sneak=1 WHERE id=" . $id . ";";
                  } elseif($new_value == "Sneak and NRB") {
                        $sql = "UPDATE " . $sched_tbl . " SET nrb=1, sneak=1 WHERE id=" . $id . ";";
                  } else {
                        $sql = "UPDATE " . $sched_tbl . " SET nrb=0, sneak=0 WHERE id=" . $id . ";";
                  }
                  break;
      }
      
} elseif($field == 'length') {
      $new_value = preg_replace("/[^0-9]/", "", $new_value);
      $sql = $sql_query_type . $sched_tbl . " SET " . $field . "=" . addslashes($new_value) . " WHERE id=" . $id . ";";
} elseif($field == 'times') {
      if($new_value == '7, 9:30, & 12') {
            $sql = $sql_query_type . $sched_tbl . " SET " . $field . "='" . addslashes($new_value) . "', special=0 WHERE id=" . $id . ";";
      } else {
            $sql = $sql_query_type . $sched_tbl . " SET " . $field . "='" . addslashes($new_value) . "', special=1 WHERE id=" . $id . ";";
      }
} elseif($field == 'imdb') {
      $sql = $sql_query_type . $sched_tbl . " SET " . $field . "='" . addslashes(str_replace("http://www.imdb.com/title/", "", $new_value)) . "' WHERE id=" . $id . ";";
} elseif ($field == 'date') {
      $date = date('Y-m-d', strtotime($new_value));
      $day = date('l', strtotime($new_value));
      $sql = $sql_query_type . $sched_tbl . " SET date='" . addslashes($date) . "', day='" . addslashes($day) . "' WHERE id=" . $id . ";";
} else {
      $sql = $sql_query_type . $sched_tbl . " SET " . $field . "='" . addslashes($new_value) . "' WHERE id=" . $id . ";";
}

  $result = mysql_query($sql);
  //sqlerr($sql, __FILE__, __LINE__);
  

  if(!($result)) {
      $json = array(
            "is_error"		=> true,
            "error_text"	=> "Failed to save to the database",
            "html"		=> stripslashes($new_value)
      );
  } else {
      $json = array(
            "is_error"		=> false,
            "error_text"	=> "Ack!  Something broke!",
            "html"		=> stripslashes($new_value)
      );
  }
}

$response =  json_encode( $json );

print $response;

}
?>