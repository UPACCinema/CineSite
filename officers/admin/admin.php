<?php
/**
 * Admin.php
 *
 * This is the Admin Center page. Only administrators
 * are allowed to view this page. This page displays the
 * database table of users and banned users. Admins can
 * choose to delete specific users, delete inactive users,
 * ban users, update user levels, etc.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 */
include_once("../include/session.php");
include_once("../../menubar.php");

/**
 * displayUsers - Displays the users database table in
 * a nicely formatted html table.
 */
function displayUsers(){
   global $database;
   $q = "SELECT username,userlevel,email,timestamp "
       ."FROM ".TBL_USERS." ORDER BY userlevel DESC,username";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if(!$result || ($num_rows < 0)){
      echo "Error displaying info";
      return;
   }
   if($num_rows == 0){
      echo "Database table empty";
      return;
   }
   /* Display table contents */
   echo "<table class=\"centered_table_admin\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Username</b></td><td><b>Level</b></td><td><b>Email</b></td><td><b>Last Active</b></td></tr>\n";
   for($i=0; $i<$num_rows; $i++){
      $uname  = mysql_result($result,$i,"username");
      $ulevel = mysql_result($result,$i,"userlevel");
      switch ($ulevel){
         case 1:
            $ulevellabel = "Member";
            break;
         case 2:
            $ulevellabel = "Projectionist";
            break;
         case 3:
            $ulevellabel = "Rep";
            break;
         case 4:
            $ulevellabel = "Midweek";
            break;
         case 5:
            $ulevellabel = "SNC";
            break;
         case 6:
            $ulevellabel = "FNC";
            break;
         case 7:
            $ulevellabel = "Chair";
            break;
         case 9:
            $ulevellabel = "Publicity";
            break;
         default:
            $ulevellabel = "Invalid User Class";
            break;
      }
      $email  = mysql_result($result,$i,"email");
      $time   = date("D\, M\. dS Y g:i:s A",mysql_result($result,$i,"timestamp"));

      echo "<tr><td>$uname</td><td>$ulevellabel</td><td>$email</td><td>$time</td></tr>\n";
   }
   echo "</table><br>\n";
}

/**
 * displayBannedUsers - Displays the banned users
 * database table in a nicely formatted html table.
 */
function displayBannedUsers(){
   global $database;
   $q = "SELECT username,timestamp "
       ."FROM ".TBL_BANNED_USERS." ORDER BY username";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysql_numrows($result);
   if(!$result || ($num_rows < 0)){
      echo "Error displaying info";
      return;
   }
   if($num_rows == 0){
      echo "Database table empty";
      return;
   }
   /* Display table contents */
   echo "<table class=\"centered_table_admin\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Username</b></td><td><b>Time Banned</b></td></tr>\n";
   for($i=0; $i<$num_rows; $i++){
      $uname = mysql_result($result,$i,"username");
      $time  = mysql_result($result,$i,"timestamp");

      echo "<tr><td>$uname</td><td>$time</td></tr>\n";
   }
   echo "</table><br>\n";
}
   
/**
 * User not an administrator, redirect to main page
 * automatically.
 */
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else{
/**
 * Administrator is viewing page, so display all
 * forms.
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../../newstyles.css">
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon">
    <title>UPAC Cinema - Admin Center</title>
  </head>
<body>

<div id="wrapper">

<?php
    echo "<!-- Top Menu (Navigation) -->
    <div id=\"globalnavbar\" style=\"background-color:#000000;\">
      <img class=\"logo\"src=\"../../images/upac_logo.png\" alt=\"UPAC Cinema\" />
      <ul class=\"dropdown\">
        <li><a href=\"../../index.php\">Schedule</a></li>
        <li><a href=\"../../policies.php\">Policies</a></li>
        <li><a href=\"../../bylaws.php\">Bylaws</a></li>
        <li><a href=\"../../clubfilm.php\">Requests</a></li>
        <li><a href=\"../../faq.php\">FAQ</a></li>
        <li><a href=\"../../feedback.php\">Feedback</a></li>
        <li><a href=\"../../officers.php\">Contact</a></li>";
        if($session->logged_in){
            echo "<li>
                        <a href=\"#\">";
                        if($session->isAdmin()) { echo "Admin"; } else { echo "Members"; } 
                        echo "</a>
                        <ul>
                              <li><a href=\"../userinfo.php?user=$session->username\">Profile</a></li>
                              <li><a href=\"../managefiles.php\">Files</a></li>";
                              if($session->isAdmin()) {
                                    echo "<li><a href=\"../gen.php\">Schedule Generator</a></li>
                                          <li><a href=\"../editstaff.php\">Change Officers</a></li>
                                          <li><a href=\"../register.php\">Add Users</a></li>
                                          <li><a href=\"admin.php\">Admin Center</a></li>";
                              }
                        echo "</ul>
                  </li>";
            echo "<li><a href=\"../process.php\">Logout</a></li>";
        } else {
            echo "<li><a href=\"../main.php\">Login</a></li>";
        }
    echo
     "</ul>
    </div>";
  ?>

  
  <div id="content">
    &nbsp;

<div class="heading">
<h1>Admin Center</h1>
Logged in as <b><?php echo $session->username; ?></b><br><br>
<a href="../main.php">Back to Main</a><br><br>
<?php
if($form->num_errors > 0){
   echo "!*** Error with request, please fix<br><br>";
}
?>

<?php
/**
 * Display Users Table
 */
?>
<h3>Users Table Contents:</h3>
<?php
displayUsers();
?>
<hr>
<?php
/**
 * Update User Level
 */
?>
<h3>Update User Level</h3>
<?php echo $form->error("upduser"); ?>

<form action="adminprocess.php" method="POST">
  <table class="centered_table_admin">
    <tr>
      <td align="left">
        Username:
      </td>
      <td align="right">
        <input class="admin" type="text" name="upduser" maxlength="30" value="<?php echo $form->value("upduser"); ?>">
      </td>
    </tr>
    <tr>
      <td align="left">
        Level:
      </td>
      <td align="right">
        <select name="updlevel">
          <option value="1">Member
          <option value="2">Projectionist
          <option value="3">Rep
          <option value="4">Midweek
          <option value="5">SNC
          <option value="6">FNC
          <option value="7">Chair
          <option value="9">Publicity
        </select>
      </td>
    </tr>
    <tr>
      <td colspan=2>
        <input type="hidden" name="subupdlevel" value="1">
        <button type="submit">Update Level</button>
      </td>
    </tr>
  </table>
</form>

<hr>

<?php
/**
 * Delete User
 */
?>
<h3>Delete User</h3>
<?php echo $form->error("deluser"); ?>
<form action="adminprocess.php" method="POST">
  <div class="heading">
    Username:
    <input class="admin" type="text" name="deluser" maxlength="30" value="<?php echo $form->value("deluser"); ?>">
    <input type="hidden" name="subdeluser" value="1">
    <button type="submit">Delete User</button>
  </div>
</form>

<hr>

<?php
/**
 * Delete Inactive Users
 */
?>
<h3>Delete Inactive Users</h3>
This will delete all users (not administrators), who have not logged in to the site<br>
within a certain time period. You specify the days spent inactive.<br><br>

<form action="adminprocess.php" method="POST">
  <table class="centered_table_admin">
    <tr>
      <td>
        Days:
        <select name="inactdays">
          <option value="3">3
          <option value="7">7
          <option value="14">14
          <option value="30">30
          <option value="100">100
          <option value="365">365
        </select>
      </td>
      <td>
        <input type="hidden" name="subdelinact" value="1">
        <button type="submit">Delete All Inactive</button>
      </td>
    </tr>
  </table>
</form>

<hr>

<?php
/**
 * Ban User
 */
?>
<h3>Ban User</h3>
<?php echo $form->error("banuser"); ?>
<form action="adminprocess.php" method="POST">
  <div>
    Username:
    <input class="admin" type="text" name="banuser" maxlength="30" value="<?php echo $form->value("banuser"); ?>">
    <input type="hidden" name="subbanuser" value="1">
    <button type="submit">Ban User</button>
  </div>
</form>

<hr>

<?php
/**
 * Display Banned Users Table
 */
?>
<h3>Banned Users Table Contents:</h3>
<?php
displayBannedUsers();
?>

<hr>

<?php
/**
 * Delete Banned User
 */
?>
<h3>Delete Banned User</h3>
<?php echo $form->error("delbanuser"); ?>
<form action="adminprocess.php" method="POST">
  <div>
    Username:
    <input class="admin" type="text" name="delbanuser" maxlength="30" value="<?php echo $form->value("delbanuser"); ?>">
    <input type="hidden" name="subdelbanned" value="1">
    <button type="submit">Delete Banned User</button>
  </div>
</form>

</div>

    &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div id="pagebottom">&nbsp;</div>

</div>
</body>
</html>
<?php
}
?>

