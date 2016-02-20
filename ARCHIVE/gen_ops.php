<?php
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

if ($_POST['password'] != 'mahnamahna'){?>
 <html>
    <head>
    <title>Invalid Password</title>
    </head>
    <body>Password entered is incorrect.  Please contact the current publicity coordinator to add or edit schedules
    </body>
    </html>
    <? exit();
}

switch ($_POST['action']){
 case 'edit':
   $sem = $_POST['semester'];
   $fields = array('title', 'date', 'special', 'times', 'image', 'imdb');
   foreach ($_POST['title'] as $id=>$title){
     if (array_key_exists('delete', $_POST) and array_key_exists($id, $_POST['delete'])) {
       $sql = "DELETE FROM schedule WHERE id = $id";
       $result = mysql_query($sql);
       sqlerr($sql, __FILE__, __LINE__);
     } else {
       $terms = array();
       $day = date('l',strtotime($_POST['date'][$id]));
       foreach ($fields as $field){
	 if (array_key_exists($field, $_POST) and array_key_exists($id, $_POST[$field])){
	   $terms[] = "$field='".addslashes($_POST[$field][$id])."'";
	 }
       }
       $terms[] = "day='$day'";
       $sql = "UPDATE schedule SET " . join(", ", $terms) . " WHERE id = $id";
       //echo "SQL: $sql<br>\n";
       $result = mysql_query($sql);
       sqlerr($sql, __FILE__, __LINE__);
     }
   }
   foreach ($_POST['new_title'] as $id=>$title){
     if ($title){
       $terms = array();
       $day = date('l',strtotime($_POST['new_date'][$id]));
       
       foreach ($fields as $field){
	 if (array_key_exists("new_$field", $_POST) and array_key_exists($id, $_POST["new_$field"])){
	   $terms[] = "$field='".addslashes($_POST["new_$field"][$id])."'";
	 }
       }
       $terms[] = "day='$day'";
       $terms[] = "semester='$sem'";
       $sql = "INSERT INTO schedule SET " . join(", ", $terms);
       //echo "SQL: $sql<br>\n";
       $result = mysql_query($sql);
       sqlerr($sql, __FILE__, __LINE__);
     }
   }
   header ("Location: gen.php");
   exit();
   break;
 case 'add':
   $sem = $_POST['semester'];
   $fields = array('title', 'date', 'times', 'image', 'imdb');
   foreach ($_POST['title'] as $id=>$title){
     if ($title){
       $day = date('l',strtotime($_POST['date'][$id]));
       $terms = array();
       foreach ($fields as $field){
	 if (array_key_exists($id, $_POST[$field])){
	   $terms[] = "$field='".addslashes($_POST["$field"][$id])."'";
	 }
       }
       $terms[] = "day='$day'";
       $terms[] = "semester='$sem'";
       $sql = "INSERT INTO schedule SET " . join(", ", $terms);
       $result = mysql_query($sql);
       sqlerr($sql, __FILE__, __LINE__);
     }
   }
   header ("Location: gen.php");
   exit();
   break;
}
?>
<pre>
<?print_r($_REQUEST);?>
</pre>	
