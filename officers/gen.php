<?php
include_once("include/session.php");
include_once("../menubar.php");

function sqlerr($sql, $file, $line){
  if ($err = mysql_error()){
    echo "ERROR: $err<br>\n";
    echo "SQL: $sql<br>\n";
    echo "In $file, at line # $line<br>\n";
    exit();
  }
}

if(!($session->isAdmin())){
  header("Location: main.php");
} else {

$user = "cinema";
$pass = "kkbpfo233";
$dbname = "cinema_db";
$link = mysql_connect("db.union.rpi.edu", $user, $pass);
mysql_select_db($dbname);

$sched_tbl = "sched_new";


if(isset($_SESSION['schedgen'])) {
      if($_SESSION['schedgen']) {
            echo "<p class=\"notify_good\">Update successful</p>";
      } else {
            echo "<p class=\"notify_bad\">Incorrect Password.</p>";
      }
      unset($_SESSION['schedgen']);
}

  if (!$_POST) { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../newstyles.css">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <title>UPAC Cinema - Schedule Generator</title>
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
    <h1>UPAC Cinema Schedule Generator</h1><br><br>
<?php
      if(isset($_SESSION['semester_selected'])) {
            if($_SESSION['semester_selected'] == false) {
                  echo '<p class="notify_bad">Select a semester to edit</p>';
            }
            unset($_SESSION['semester_selected']);
      }    
      if(isset($_SESSION['term_selected'])) {
            if($_SESSION['term_selected'] == false) {
                  echo '<p class="notify_bad">Select the semester season</p>';
            }
            unset($_SESSION['term_selected']);
      }    
      if(isset($_SESSION['year_selected'])) {
            if($_SESSION['year_selected'] == false) {
                  echo '<p class="notify_bad">Select the semester year</p>';
            }
            unset($_SESSION['year_selected']);
      }    
      if(isset($_SESSION['half_selected'])) {
            if($_SESSION['half_selected'] == false) {
                  echo '<p class="notify_bad">Select the semester half</p>';
            }
            unset($_SESSION['half_selected']);
      }
?>
  <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <div>
      <p>
      View/Edit an existing semester: 
      <select name="semester">
        <option value="">Select a Semester</option>
<?php   $sql = "SELECT DISTINCT semester FROM $sched_tbl ORDER BY `date`"; 
        $result = mysql_query($sql);
        sqlerr($sql, __FILE__, __LINE__);
        while ($row = mysql_fetch_row($result)) { ?>
          <option value="<?php echo $row[0] ?>"><?php echo $row[0] ?></option>
<?php   } ?>
      </select>
      <input type="submit" name="edit" value="Edit Semester"/>
      </p>
      <p>
      or Add a New semester:
      <select name="term">
            <option value="">Select a season</option>
            <option value="fall">Fall</option>
            <option value="spring">Spring</option>
            <option value="summer">Summer</option>
            <option value="winter">Winter</option>
      </select>
      <select name="year">
            <option value="">Select a year</option>
      <?php
      for($i = 2010; $i <= 2109; $i++) {
            ?>
            <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php
      }
      ?>
      </select>
      <select name="half">
            <option value="">Select a half</option>
            <option value="first">First Half</option>
            <option value="second">Second Half</option>
            <option value="all">Entire Semester</option>
      </select>
      <input type="submit" name="add" value="Add Semester" />
      </p>
    </div>
  </form>
    <br>
    Semester Labeling<br>
    <hr>
    S: Spring<br>
    F: Fall<br>
    U: Summer<br>
    W: Winter<br>
    ##: Last two digits of the year<br>
    A: First half of the semester<br>
    B: Second half of the semester<br><br>
    Example: "S10B" is the second half of the Spring 2010 semester<br>
    &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div id="pagebottom">&nbsp;</div>
</div>
</body>
</html>
<?php } elseif(array_key_exists('edit',$_POST)) {
            if(!($_POST['semester'])) {
                  $_SESSION['semester_selected'] = false;
                  header('Location: gen.php');
                  exit();
            }
            $_SESSION['semester'] = $_POST[semester];
            header('Location: gen_summary.php?semester=' . $_POST['semester']);
      } elseif (array_key_exists('add',$_POST)) {
            if(!($_POST['term'])) {
                  $_SESSION['term_selected'] = false;
                  header('Location: gen.php');
                  exit();
            }
            if(!($_POST['year'])) {
                  $_SESSION['year_selected'] = false;
                  header('Location: gen.php');
                  exit();
            }
            if(!($_POST['half'])) {
                  $_SESSION['half_selected'] = false;
                  header('Location: gen.php');
                  exit();
            }
            switch ($_POST['term']) {
                  case 'fall':
                        $semester = 'Fall';
                        break;
                  case 'spring':
                        $semester = 'Spring';
                        break;
                  case 'summer':
                        $semester = 'Summer';
                        break;
                  case 'winter':
                        $semester = 'Winter';
                        break;
            }
            $semester = $semester . $_POST['year'];
            switch ($_POST['half']) {
                  case 'first':
                        $semester = $semester . 'A';
                        break;
                  case 'second':
                        $semester = $semester . 'B';
                        break;
                  case 'all':
                        break;
            }
            header('Location: gen_add.php?semester=' . $semester);
      }
}
?>