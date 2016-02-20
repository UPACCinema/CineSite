<?php
include_once("include/session.php");
include_once("../menubar.php");

if(!($session->isAdmin())){
  header("Location: main.php");
} else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../newstyles.css">
    <link rel="stylesheet" type="text/css" href="jquery-ui-1.8.2.custom.css">
    <style type="text/css">
      input.text { margin-bottom:12px; width:95%; padding: .4em; }
      .ui-state-error { padding: 0.3em; }
      .validateTips { border: 1px solid transparent; padding: 0.3em; }
    </style>
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <title>UPAC Cinema - Add Movies to Schedule</title>
    <script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui-1.8.2.custom.min.js"></script>
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
    <script type="text/javascript">
      $(document).ready(function () {
            $(".date").datepicker({showOtherMonths: true, selectOtherMonths: true, dateFormat: 'yy-mm-dd' });
      });
    </script>
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
    <h1>Add Movies</h1><br><br>
    
    <form action="gen_ops_tmdb.php" method="post" enctype="multipart/form-data">
      <div>
	  <input type="hidden" name="action" value="add">
	  <input type="hidden" name="semester" value="<?php echo $_GET['semester']?>">
      </div>
	<div class="generator">
      <table>
	   <tr>
	     <td>Movie</td>
	<?php for ($i = 0; $i<20; $i++){ ?>
	      <td><input type="text" name="title[<?php echo $i?>]" value=""></td>
	<?php } ?>
         </tr>
         <tr>
	     <td>Date (YYYY-MM-DD)</td>
	<?php for ($i = 0; $i<20; $i++){ ?>
	      <td><input class="date" id="date_<?php echo $i ?>" type="text" name="date[<?php echo $i?>]" value=""></td>
	<?php } ?>
         </tr>
         <tr>
	     <td>Special Times?</td>
	<?php for ($i = 0; $i<20; $i++){ ?>
	      <td>
		  <input type="checkbox" name="special[<?php echo $i ?>]" value="1" onClick="times(this, <?php echo $i?>); return true;">
		  <input type="text" id="times_<?php echo $i ?>" name="times[<?php echo $i?>]" value="7pm, 9:30pm, and 12am" style="display:none">
	      </td>
	<?php } ?>
         </tr>
         <tr>
	     <td>Special Cost?<br>(enter FREE for free)</td>
	<?php for ($i = 0; $i<20; $i++){ ?>
	      <td>
		  <input type="text" name="cost[<?php echo $i?>]" value="$2.50">
	      </td>
	<?php } ?>
         </tr>
         <tr>
           <td>During NRB?</td>
	 <?php for ($i = 0; $i<20; $i++){ ?>
           <td><input type="checkbox" name="nrb[<?php echo $i?>]" value="1"></td>
       <?php } ?>
         </tr>
         <tr>
           <td>Sneak?</td>
	 <?php for ($i = 0; $i<20; $i++){ ?>
           <td><input type="checkbox" name="sneak[<?php echo $i?>]" value="1"></td>
       <?php } ?>
         </tr>
         <tr>
	     <td>Club Sponsor</td>
	<?php for ($i = 0; $i<20; $i++){ ?>
            <td><input type="text" name="sponsor[<?php echo $i?>]" value=""></td>
	<?php } ?>
         </tr>
	</table>
      </div>
      <div>
      <button type="submit" name="submit">Edit Schedule</button>
	</div>
      </form>
      &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div id="pagebottom">&nbsp;</div>
</div>
</body>
</html>
<?php } ?>