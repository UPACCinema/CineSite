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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">


<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../newstyles.css">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <title>UPAC Cinema - Edit Officers</title>
    <script type="text/javascript">
function addRowToTable()
{
  var tbl = document.getElementById('EditStaffTable');
  var lastRow = tbl.rows.length - 1;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow - 8;
  var row = tbl.insertRow(lastRow);
  
  // blank cell
  var cellLeft = row.insertCell(0);
  
  // name cell
  var cellRight = row.insertCell(1);
  var el = document.createElement('input');
  el.type = 'text';
  el.name = 'projname[NEW]';
  cellRight.appendChild(el);
  
  // email cell
  var cellRight = row.insertCell(2);
  var tel = document.createElement('input');
  tel.type = 'text';
  tel.name = 'projemail[NEW]';
  cellRight.appendChild(tel);
  
  // delete button cell
  var cellRightSel = row.insertCell(3);
  var sel = document.createElement('input');
  sel.type = 'button';
  sel.name = 'removerow' + iteration;
  sel.value = 'Remove';
  sel.onclick = removeRowFromTable;
  cellRightSel.appendChild(sel);
}
function removeRowFromTable()
{
  var tbl = document.getElementById('EditStaffTable');
  var lastRow = tbl.rows.length - 1;
  if (lastRow > 2) tbl.deleteRow(lastRow - 1);
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
    
    <h1>Change Officers</h1>
<?php 
if(isset($_SESSION['staffedited'])) {
      if($_SESSION['staffedited']) {
            echo "<p class=\"notify_good\">Update successful</p>";
      } else {
            echo "<p class=\"notify_bad\">Incorrect Password.</p>";
      }
      unset($_SESSION['staffedited']);
}

  $sql = "SELECT * FROM officers ORDER BY id ASC;";
  $result = mysql_query($sql);
  sqlerr($sql,__FILE__, __LINE__);
  while ( $officer = mysql_fetch_assoc($result) ) {
    switch($officer['position']) {
      case "Chair":
        $chairname = $officer['name'];
        $chairemail = $officer['email'];
        break;
      case "FridayNightCoordinator":
        $fncname = $officer['name'];
        $fncemail = $officer['email'];
        break;
      case "SaturdayNightCoordinator":
        $sncname = $officer['name'];
        $sncemail = $officer['email'];
        break;
      case "MidweekCoordinator":
        $midname = $officer['name'];
        $midemail = $officer['email'];
        break;
      case "RepertoryCoordinator":
        $repname = $officer['name'];
        $repemail = $officer['email'];
        break;
      case "PublicityCoordinator":
        $pubname = $officer['name'];
        $pubemail = $officer['email'];
        break;
      case "Projectionist":
        $projname[] = $officer['name'];
        $projemail[] = $officer['email'];
		$projid[] = $officer['id'];
        break;
      case "Webmaster":
        $webname = $officer['name'];
        $webemail = $officer['email'];
        break;
    }
  }
?>
    
    <form action="editstaffprocess.php" method="POST">
      <table id="EditStaffTable" class="centered_table_admin" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <th></th>
          <th>Name</th>
          <th>Email</th>
          <th>Delete?</th>
        </tr>
        <tr>
          <td>Chair</td>
          <td><input type="text" name="chairname" value="<?php echo $chairname ?>"></td>
          <td><input type="text" name="chairemail" value="<?php echo $chairemail ?>"></td>
        </tr>
        <tr>
          <td>Friday Night Coordinator</td>
          <td><input type="text" name="fncname" value="<?php echo $fncname ?>"></td>
          <td><input type="text" name="fncemail" value="<?php echo $fncemail ?>"></td>
        </tr>
        <tr>
          <td>Saturday Night Coordinator</td>
          <td><input type="text" name="sncname" value="<?php echo $sncname ?>"></td>
          <td><input type="text" name="sncemail" value="<?php echo $sncemail ?>"></td>
        </tr>
        <tr>
          <td>Midweek Coordinator</td>
          <td><input type="text" name="midname" value="<?php echo $midname ?>"></td>
          <td><input type="text" name="midemail" value="<?php echo $midemail ?>"></td>
        </tr>
        <tr>
          <td>Repertory Coordinator</td>
          <td><input type="text" name="repname" value="<?php echo $repname ?>"></td>
          <td><input type="text" name="repemail" value="<?php echo $repemail ?>"></td>
        </tr>
        <tr>
          <td>Publicity Coordinator</td>
          <td><input type="text" name="pubname" value="<?php echo $pubname ?>"></td>
          <td><input type="text" name="pubemail" value="<?php echo $pubemail ?>"></td>
        </tr>
        <tr>
          <td>Webmaster</td>
          <td><input type="text" name="webname" value="<?php echo $webname ?>"></td>
          <td><input type="text" name="webemail" value="<?php echo $webemail ?>"></td>
        </tr>
        <tr>
          <td>
            Projectionists 
            <input type="button" value="Add" onclick="addRowToTable();" />
          </td>
<?php foreach( $projname as $index => $fullname ) {
          if($index > 0) { echo '<td></td>'; } ?>
          <td><input type="text" name="projname[<?php echo $projid[$index] ?>]" value="<?php echo $fullname ?>"></td>
          <td><input type="text" name="projemail[<?php echo $projid[$index] ?>]" value="<?php echo $projemail[$index] ?>"></td>
          <td><input type="checkbox" name="delete[<?php echo $projid[$index] ?>]" value="1"></td>
        </tr>
        <tr>
<?php } ?>
          <td></td>
          <td align="center">
            <br>
            <input type="submit" name="submit" value="Submit" />
          </td>
          <td></td>
        </tr>
      </table>
    </form>
    &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div id="pagebottom">&nbsp;</div>

</div>
</body>
</html>
<?php } ?>