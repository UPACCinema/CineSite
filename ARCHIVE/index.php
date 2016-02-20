<?php
$user = "cinema";
$pass = "kkbpfo233";
$dbname = "cinema_db";
$link = mysql_connect("db.union.rpi.edu", $user, $pass);
mysql_select_db($dbname);
?>

<?php
   #for the hell of it, I want to see who visits our page and how often
	#AKA "Paul's stalker routine"
   $subj = "UPAC Cinema website visited";
$from = "UPAC Cinema <upac-cinema@rpi.edu>";
$to = "plalli@gmail.com";
$date = date('l, n/j/y \a\t g:ia');
$body = "On $date, someone visited UPAC Cinema's index page.  Server info follows:\n";
$ip = $_SERVER['REMOTE_ADDR'];
$host = gethostbyaddr($ip);
$body .= "Host: $host ($ip)";
if (array_key_exists('HTTP_REFERER', $_SERVER)){
  $refer = $_SERVER['HTTP_REFERER'];
  $body .=", referred by $refer.";
}
if (array_key_exists('HTTP_USER_AGENT', $_SERVER)){
  $agent = $_SERVER['HTTP_USER_AGENT'];
  $body .= "\nThe user was browsing with: $agent\n";
}
#mail ($to, $subj, $body, "From: $from\r\n");
$sql = "INSERT INTO accesses SET `date`=NOW(), page='index', IP='$ip', host='$host'";
if (isset($refer)) { $sql .= ", referer='".addslashes($refer)."'"; }
if (isset($agent)) { $sql .= ", agent='".addslashes($agent)."'"; }
$sql .= ";";
$result = mysql_query($sql);
if ($err = mysql_error()){
  echo "<!--ERROR: $err\nSQL: $sql\n-->\n\n";
}

?>

<?
$sched_tbl = "schedule";
$other_tbl = "sched_mat";

function sqlerr($sql, $file='',$line=''){
  if ($err = mysql_error()){
    echo "ERROR: $err<br>\nSQL: $sql<br>\n";
    if ($file){
      echo "File: $file, line $line<br>\n";
    }
    exit();
  }
}


?>


<html>
<head>
<link rel="stylesheet" href="http://cinema.union.rpi.edu/cinema.css" />
<title>UPAC Cinema - Schedule</title>
</head>
<body>

<div align=center>
<table class="main">
 <tr>
  <td colspan=3 align="center"><img src="images/upac_cinema.png"></td>
 </tr>
 <tr>
  <td class="navigate">

<!-- Left Sidebar (Navigation) -->
<table class="reel" cellspacing="0" cellpadding="0">
 <tr>
  <td class="titlepic" colspan=2>&nbsp</td>
  <td class="title"><span class="title">Navigation</span></td>
  <td>&nbsp</td>
 </tr>
 <tr>
  <td class="bul1">&nbsp</td>
  <td class="bul2">&nbsp</td>
  <td class="bh">&nbsp</td>
  <td class="bur">&nbsp</td>
 </tr>
 <tr>
  <td class="bv">&nbsp</td>
  <td class="bullet">&nbsp</td>
  <td class="links">
   <table>
   <!-- <tr><td class="links">>Join UPAC Cinema</td></tr>-->
    <tr><td class="links">><a href="http://cinema.union.rpi.edu/clubfilm.html">Sponsor a Film</a></td></tr>
    <tr><td class="links">><a href="http://cinema.union.rpi.edu/request.html">Request a Club Film</a></td></tr>
	<tr><td class="links">><a href="faq.php">Frequently Asked Questions</a></td></tr>
    <tr><td class="links">><a href="http://cinema.union.rpi.edu/officers_10.html">Contact an Officer</a></td></tr>
   </table>
  </td>
  <td class="bv">&nbsp</td>
 </tr>
 <tr>
  <td class="bll">&nbsp</td>
  <td class="bh" colspan=2>&nbsp</td>
  <td class="blr">&nbsp</td>
 </tr>
</table>

  </td>
  <td class="content">

<!-- Middle table (Content) -->
<table class="reel" cellspacing="0" cellpadding="0">
 <tr>
  <td class="titlepic" colspan=2>&nbsp</td>
  <td class="title"><span class="title">Our Schedule</span></td>
  <td>&nbsp</td>
 </tr>
 <tr>
  <td class="bul1">&nbsp</td>
  <td class="bul2">&nbsp</td>
  <td class="bh">&nbsp</td>
  <td class="bur">&nbsp</td>
 </tr>
 <tr>
  <td class="bv">&nbsp</td>
  <td>&nbsp</td>
  <td class="cencontent">
   <?

	#Change this to display other semesters.  Each semester listed
	#will be shown on the site.
        $semesters = array();
        $semesters["F10A"] = array(
				   'title'=>'Fall 2010 First Half',
				   'days'=>array('Friday', 'Saturday'),
				   );
	

	foreach ($semesters as $semester=>$data){
   ?>		
   <span class="title"><?=$data['title']?></span><br>
   <span class="time">Normal Showtimes 7, 9:30, and Midnight<br>All movies are shown in DCC308</span>
   <?


		$days = $data['days'];
		$sql = "SELECT * FROM $sched_tbl WHERE semester = '$semester' AND day IN ('".join("', '", $days)."') ORDER BY date;";
		$result = mysql_query($sql);
		#echo "SQL: $sql<br>\n";
		sqlerr($sql, __FILE__, __LINE__);

	?>
   <center><table class="schedule" align="center" style="width: 50%">
	<!-- Use this block for sneaks, etc-->
	<tr>
		 <td colspan=2 class="schedule"><strong>NRB Showings - FREE</strong></td>
        </tr><tr>
                 <td class="schedule">
                     <a href="http://www.imdb.com/title/tt0077975/">Animal House</a><br>
                     <span class="time">Thursday, August 26<br><strong>10pm only</strong></span>
                 </td>
                 <td class="schedule">
                     <a href="http://www.imdb.com/title/tt0800320/">Clash of the Titans</a><br>
                     <span class="time">Saturday, August 28<br><strong>10pm only</strong></span>
                 </td>
	</tr>
	
   </table></center>
   <center><table class="schedule" align="center">
    <tr>
     <? foreach ($days as $day) {?>
     <td class="schedhead"><?=$day?></td>
     <? } ?>
    </tr>
	<? 	
		unset($movies);
		while ($movie = mysql_fetch_assoc($result)) {
			$movies[] = $movie;
		}
		$i = 0;
		for ($j = 0; $j<count($movies); $j++){
			$movie = $movies[$j];
	?>
	<?if ($i % count($days) == 0 ){ echo "<tr>\n"; } ?>
		<? if ($days[$i%(count($days))] != $movie['day']) {?>
		<td class="schedule">
			- No Movie -
		</td>
		<?$j--;?>
		<? } else { ?>
		<td class="schedule">
			<? if($movie['imdb']) { ?><a href="http://www.imdb.com/title/<?=$movie['imdb']?>/" target="_blank"><?=stripslashes($movie['title'])?></a><? } else { ?><?=stripslashes($movie['title'])?><? } ?>
			<br><span class="time"><?=date('F j', strtotime($movie['date']));?></span>
			<? if ($movie['special']) { ?>
			<br><span class="time" style="font-weight:bold"><?=$movie['times']?></span>
			<? } ?>
											       <? $others = othershows($movie['id']);
		foreach ($others as $other){?>
 <br><span class="time" style="font-weight:bold"><?=$other['type']?>:<br> <?=date('l n/j', strtotime($other['date']))?> <?=$other['times']?></span>
    <? } ?>
		</td>
		<? } ?>
	<? $i ++; ?>
	<? if ($i % count($days) == 0) { echo "</tr>\n"; } ?>
	<? }  ?>
   </table>
<!--<a href="http://www.google.com/calendar/render?cid=http%3A%2F%2Fwww.google.com%2Fcalendar%2Ffeeds%2Fdo6de78tj36dvop1dari1qq92k%40group.calendar.google.com%2Fpublic%2Fbasic" target="_blank"><img src="http://www.google.com/calendar/images/ext/gc_button6.gif" 
border=0></a><br>-->
<span class="time">Movie descriptions are from an outside source and do not necessarily reflect the views of UPAC Cinema, the Rensselaer Student Union, or Rensselaer Polytechnic Institute</span>
	<br><!--<img src="slogan-ie.png"><br>-->
      <? } //end foreach? ?>
</center>
  </td>
  <td class="bv">&nbsp</td>
 </tr>
 <tr>
  <td class="bll">&nbsp</td>
  <td class="bh" colspan=2>&nbsp</td>
  <td class="blr">&nbsp</td>
 </tr>
</table>

  </td>
  <td class="thisweek">

<!-- Right Sidebar -->
<table class="reel" cellspacing="0" cellpadding="0">
 <tr>
  <td class="titlepic" colspan=2>&nbsp</td>
  <td class="title"><span class="title">This Week</span></td>
  <td>&nbsp</td>
 </tr>
 <tr>
  <td class="bul1">&nbsp</td>
  <td class="bul2">&nbsp</td>
  <td class="bh">&nbsp</td>
  <td class="bur">&nbsp</td>
 </tr>
 <tr>  
  <td class="bv">&nbsp</td>
  <td class="content" colspan=2>
    <? 
	reset ($semesters);
	$semester = current($semesters);
        foreach(array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday', 'Saturday') as $day){
	  $mdays[] = array('n'=>date('w', strtotime($day)), 'd'=>$day);
	}
#This function is used to put the days in the correct order, soonest occurring
#movie will be first.
function ordered ($a, $b){
  $today = date('w');
  if ($a['n'] < $today and $b['n'] >= $today){
    return 1;
  } elseif ($b['n'] < $today and $a['n'] >= $today){
    return -1;
  } else {
    if ($a['n'] < $b['n']){
      return -1;
    } else {
      return 1;
    }
  }
}

usort ($mdays, 'ordered');

	foreach ($mdays as $dn) {
	  $day = $dn['d'];?>
      <?   //I tried and failed to find an elegant way to do this.  
           //We want the posters to switch at 2am of the next day, rather than midnight
	   if (date('G') < 2  and date('l', strtotime('Yesterday')) == $day){
		$date = date('Y-m-d', strtotime('Yesterday'));
	   } else { 
		$date = date('Y-m-d', strtotime($day));
	   }
           $sql = "SELECT $sched_tbl.*, $other_tbl.date AS `other_date`, $other_tbl.times AS `other_times` FROM $sched_tbl LEFT JOIN $other_tbl ON (id = movie_id) WHERE $sched_tbl.date = '$date' OR $other_tbl.date = '$date'";
	   echo "<!--POSTER SQL: $sql-->\n";
	   $result = mysql_query($sql);
	   sqlerr($sql, __FILE__, __LINE__);
	   if (mysql_num_rows($result)){
              ?>
              <div class="poster">
              <?=$day?>
	      <?while ($movie = mysql_fetch_assoc($result)){?>
              <br>
              <a href="http://www.imdb.com/title/<?=$movie['imdb']?>" target="_blank"><?
		   if (file_exists("images/$movie[image]")){
		     ?><img class="poster" src="images/<?=$movie['image']?>" alt="<?=$movie['title']?>"><? 
		   } else { 
                     ?><img class="poster" src="images/noposter.png" alt="<?=$movie['title']?>"><? 
		   }
		?></a>
			<br>
			<span class="time"><?=$movie['date']==$date?$movie['times']:$movie['other_times']?></span><?
	      }
	   } else {
	     if (array_search($day, $semester['days'])!== FALSE){?>
                     <div class="poster">
                     <?=$day?>
                     <br>
                     <img class="poster" src="images/nomovie.png" alt="No Movie"><?
	      }
	   } ?>
	</div>
   <? } ?>
   </div>
  </td>
  <td class="bv">&nbsp</td>
 </tr>
 <tr>
  <td class="bll">&nbsp</td>
  <td class="bh" colspan=2>&nbsp</td>
  <td class="blr">&nbsp</td>
 </tr>
</table>

  </td>
 </tr>
</table>
</div>

</body>
</html>



<? 
   function othershows($mov_id){
     global $other_tbl;
     $sql = "SELECT * FROM $other_tbl WHERE movie_id = $mov_id ORDER BY `date`";
     $result = mysql_query($sql);
     sqlerr($sql, __FILE__, __LINE__);
     $others = array();
     while ($other = mysql_fetch_assoc($result)){
       $others[] = $other;
     }
     return $others;
   }
?>