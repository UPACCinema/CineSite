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



?>

<html>
<head>
<title>UPAC Cinema Schedule Generator</title>
<script type="text/javascript">
function times(chk, movie){
  var time;
  //alert ("Movie id: " + movie);
  time = document.getElementById('times_' + movie);
  if (chk.checked){
    time.style.display='';
    time.disabled = 0;
  } else {
    time.style.display='none';
    time.disabled = 1;
  }
}
function new_times(chk, movie){
  var time;
  //alert ("Movie id: " + movie);
  time = document.getElementById('new_times_' + movie);
  if (chk.checked){
    time.style.display='';
    time.disabled = 0;
  } else {
    time.style.display='none';
    time.disabled = 1;
  }
}

</script>
</head>
<body>

<? if (!$_POST) { ?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
View/Edit an existing semester: 
<select name="semester">
   <option value=""></option>
   <? $sql = "SELECT DISTINCT semester FROM schedule ORDER BY `date`"; 
 $result = mysql_query($sql);
 sqlerr($sql, __FILE__, __LINE__);
 while ($row = mysql_fetch_row($result)){?>
 <option value="<?=$row[0]?>"><?=$row[0]?></option>
    <?}?>
</select>
    <input type="submit" name="edit" value="Edit Semester">
    <br><br>
    or Add a New semester: <input type="text" name="newsem" size="5">
    <input type="submit" name="add" value="Add Semester">
    <? } elseif (array_key_exists('edit',$_POST)) {
      $sql = "SELECT * FROM schedule WHERE semester = '$_POST[semester]' ORDER BY date;";
      $result = mysql_query($sql);
      sqlerr($sql, __FILE__, __LINE__);
	?>
	<form action="gen_ops.php" method="post">
	   <input type="hidden" name="action" value="edit">
	   <input type="hidden" name="semester" value="<?=$_POST['semester']?>">
	   <table border="0">
	   <tr valign="bottom">
	   <th>Date<br>(YYYY-MM-DD)</th>
	   <th>Movie</th>
	   <th>Special Times?</th>
	   <th>IMDb ID</th>
	   <th>Poster file</th>
	   <th>Delete?</th>
	   </tr>
	   <?while ($movie = mysql_fetch_assoc($result)){?>
	   <tr valign="bottom">
	      <td><input type="text" name="date[<?=$movie['id']?>]" value="<?=$movie['date']?>"></td>
	      <td><input type="text" name="title[<?=$movie['id']?>]" value="<?=stripslashes($movie['title'])?>"></td>
	      <td><input type="checkbox" name="special[<?=$movie['id']?>]" <?=$movie['special']?'checked' : ''?> value="1" onClick="times(this, <?=$movie['id']?>); return true;">
		  <input type="text" id="times_<?=$movie['id']?>" name="times[<?=$movie['id']?>]" value="<?=$movie['times']?>" <?=$movie['special']? '' : 'style="display:none" disabled'?>>
	      </td>
	      <td><input type="text" name="imdb[<?=$movie['id']?>]" value="<?=$movie['imdb']?>"></td>
	      <td><input type="text" name="image[<?=$movie['id']?>]" value="<?=$movie['image']?>">
		   <img src="images/<?=($movie['image'] and file_exists("images/$movie[image]"))?$movie['image']:'noposter.png'?>">
	      </td>
	      <td><input type="checkbox" name="delete[<?=$movie['id']?>]" value="1"></td>
	    </tr>
	<? } ?>
	  <tr>
	     <td colspan="6">Add new movies here:</td>
	     </tr>
	     <tr valign="bottom">
	     <th>Date<br>(YYYY-MM-DD)</th>
	     <th>Movie</th>
	     <th>Special Times?</th>
	     <th>IMDb ID</th>
	     <th>Poster file</th>
	     <th></th>
	     </tr>
	     <? for ($i = 0; $i<5; $i++){?>
	     <tr valign="bottom">
	     <td><input type="text" name="new_date[<?=$i?>]" value=""></td>
	     <td><input type="text" name="new_title[<?=$i?>]" value=""></td>
	     <td>
	       <input type="checkbox" name="new_special[<?=$i?>]" value="1" onClick="new_times(this, <?=$i?>); return true;">
	       <input type="text" id="new_times_<?=$i?>" name="new_times[<?=$i?>]" value="" style="display:none" disabled>
	     </td>
	     <td><input type="text" name="new_imdb[<?=$i?>]" value=""></td>
	     <td>
		 <input type="text" name="new_image[<?=$i?>]" value="">
	     </td>
	     <td></td>
	     </tr>
	<? } ?>
	</table>
	Password: <input type="password" name="password" value=""><br>
	<input type="submit" name="submit" value="Edit Schedule">
	</form>
<? } elseif (array_key_exists('add',$_POST)) { ?>
	<form action="gen_ops.php" method="post">
	<input type="hidden" name="action" value="add">
	<input type="hidden" name="semester" value="<?=$_POST['newsem']?>">
	<table border="0">
	   <tr valign="bottom">
	   <th>Date<br>(YYYY-MM-DD)</th>
	   <th>Movie</th>
	   <th>Special Times?</th>
	   <th>IMDb ID</th>
	   <th>Poster file</th>
	   </tr>
	<? for ($i = 0; $i<20; $i++){?>
	   <tr valign="bottom">
	      <td><input type="text" name="date[<?=$i?>]" value=""></td>
	      <td><input type="text" name="title[<?=$i?>]" value=""></td>
	      <td>
		  <input type="checkbox" name="special[<?=$i?>]" value="1" onClick="times(this, <?=$i?>); return true;">
	      	  <input type="text" id="times_<?=$i?>" name="times[<?=$i?>]" value="7, 9:30, &amp; 12" style="display:none">
	      </td>
	      <td><input type="text" name="imdb[<?=$i?>]" value=""></td>
	      <td>
		  <input type="text" name="image[<?=$i?>]" value="">
	      </td>
	  </tr>
	<? } ?>
	  <tr>
	    <td colspan="5">
	      (More movies can be added later by editing the semester from the main page)
	    </td>
	 </tr>
	</table>
	Password: <input type="password" name="password" value=""><br>
	<input type="submit" name="submit" value="Edit Schedule">
	</form>
<? } ?>
</body>
</html>
				


</body>
</html>