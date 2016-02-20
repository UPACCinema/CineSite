<?php
include_once("include/session.php");
include_once("../menubar.php");

if(!($session->logged_in)){
  header("Location: main.php");
} else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../newstyles.css">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <title>UPAC Cinema - Upload</title>
    <script type="text/javascript">
function addRowToTable()
{
  var tbl = document.getElementById('UploadTable');
  var lastRow = tbl.rows.length - 2;
if(lastRow <= 20)
{  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  
  // File label cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode('File');
  cellLeft.appendChild(textNode);
  
  // Filename cell
  var cellRight = row.insertCell(1);
  var tel = document.createElement('input');
  tel.type = 'file';
  tel.size = '100';
  tel.name = 'ufile[' + iteration + ']';
  cellRight.appendChild(tel);
  
  // delete button cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('input');
  sel.type = 'button';
  sel.name = 'removerow' + iteration;
  sel.value = 'Remove';
  sel.onclick = removeRowFromTable;
  cellRightSel.appendChild(sel);
}
}
function removeRowFromTable()
{
  var tbl = document.getElementById('UploadTable');
  var lastRow = tbl.rows.length - 2;
  if (lastRow > 1) tbl.deleteRow(lastRow - 1);
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
    
    <h1>Upload Files</h1>
    <p class="heading">Maximum File Size: 5 MB<br>Maximum Simultaneous Uploads: 20</p>
<?php    
    if(isset($_SESSION['uploaded'])) {
      if($_SESSION['uploaded']) {
            echo "<p class=\"notify_good\">Upload successful</p>";
      } else {
            echo "<p class=\"notify_bad\">Incorrect Password.</p>";
      }
      unset($_SESSION['uploaded']);
    }
?>
    <form action="uploadprocess.php" method="POST" enctype="multipart/form-data">
      <div>
	  <input type="hidden" name="officerlevel" value="<?php echo $session->userlevel ?>">
      </div>
      <table id="UploadTable" class="centered_table_admin">
        <tr>
          <td>File:</td>
          <td><input type="file" size="100" name="ufile[0]">
        </tr>
        <tr>
          <td><input type="button" value="Add" onclick="addRowToTable();" /></td>
        </tr>
        <tr>
          <td colspan=2>
            <input type="submit" name="submit" value="Submit">
            <button type="reset" name="reset">Reset</button>
          </td>
        </tr>
      </table>
    </form>
    
    <p class="heading"><a href="managefiles.php">Back to File Manager</a></p>
    &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div id="pagebottom">&nbsp;</div>

</div>
</body>
</html>
<?php } ?>