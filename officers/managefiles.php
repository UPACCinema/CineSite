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
    <title>UPAC Cinema - File Manager</title>
    <script type="text/javascript">
function download_check(chk, movie){
  var time;
  //alert ("Movie id: " + movie);
  time = document.getElementById('delete_' + movie);
  if (!chk.checked){
    time.disabled = 0;
  } else {
    time.disabled = 1;
  }
}
function delete_check(chk, movie){
  var time;
  //alert ("Movie id: " + movie);
  time = document.getElementById('download_' + movie);
  if (!chk.checked){
    time.disabled = 0;
  } else {
    time.disabled = 1;
  }
}
function addRowToTable()
{
  var tbl = document.getElementById('UploadTable');
  var lastRow = tbl.rows.length - 2;
  // if there's no header row in the table, then iteration = lastRow + 1
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
  
    
  if($session->isAdmin()) {
    $savedir = '/home/cinema/files/publicity/';
  } elseif($session->isChair()) {
    $savedir = '/home/cinema/files/chair/';
  } elseif($session->isFriday()) {
    $savedir = '/home/cinema/files/fnc/';
  } elseif($session->isSaturday()) {
    $savedir = '/home/cinema/files/snc/';
  } elseif($session->isMidweek()) {
    $savedir = '/home/cinema/files/midweek/';
  } elseif($session->isRep()) {
    $savedir = '/home/cinema/files/rep/';
  } elseif($session->isProj()) {
    $savedir = '/home/cinema/files/projectionists/';
  }
?>

  
  <div id="content">
    &nbsp;
    
    <h1>File Manager</h1>
<?php
    if($session->isProj()) {
      echo "<p class=\"notify_bad\">All of the files listed below are shared with all projectionists</p>";
    }
?>
    <p class="heading"><a href="upload.php">Upload Files</a></p>
    <form action="processfiles.php" method="post">
      <div>
        <button type="submit" name="submit">Submit</button>
      </div>
    <table class="file_table" border="1" cellspacing="0" cellpadding="3">
      <tr>
        <th>File</th>
        <th>Download</th>
        <th>Delete</th>
      </tr>
    <?php
      $id = 0;
      $files_exist = false;
      if($handle = opendir($savedir)) {
        while(($file = readdir($handle)) !== false) {
          if($file !== "." && $file !== "..") {
            $files_exist = true;
            echo "<tr>
                    <td>
                      <a href=\"download.php?download_file=$file\">$file</a>
                      <input type=\"hidden\" name=\"dfile[$id]\" value=\"$file\">
                    </td>
                    <td><input type=\"checkbox\" id=\"download_$id\" name=\"download[$id]\" value=\"1\" onclick=\"download_check(this, $id); return true;\"></td>
                    <td><input type=\"checkbox\" id=\"delete_$id\" name=\"delete[$id]\" value=\"1\" onclick=\"delete_check(this, $id); return true;\"></td>
                  </tr>";
                  $id = $id + 1;
          }
        }
        closedir($handle);
      }
    ?>
      </table>
<?php
      if(!$files_exist) {
        echo "<p>You have no files. <a href=\"upload.php\">Upload Files</a></p>";
      }
?>
      <div>
        <br>
        <button type="submit" name="submit">Submit</button>
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