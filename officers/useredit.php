<?php
/**
 * UserEdit.php
 *
 * This page is for users to edit their account information
 * such as their password, email address, etc. Their
 * usernames can not be edited. When changing their
 * password, they must first confirm their current password.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 */
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
    <title>UPAC Cinema - Edit Profile</title>
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
<?php
/**
 * User has submitted form without errors and user's
 * account has been edited successfully.
 */
if(isset($_SESSION['useredit'])){
   unset($_SESSION['useredit']);
   
   echo "<h1>User Account Edit Success!</h1>\n";
   echo "<div class=\"heading\">\n\t<p><b>$session->username</b>, your account has been successfully updated.</p>\n"
       ."\t<a href=\"main.php\">Return to Main</a>\n</div>\n";
}
else{
?>

<?php
/**
 * If user is not logged in, then do not display anything.
 * If user is logged in, then display the form to edit
 * account information, with the current email address
 * already in the field.
 */
if($session->logged_in){
?>

<h1>User Profile Edit : <?php echo $session->username; ?></h1>
<?php
if($form->num_errors > 0){
   echo "<h3><span class=\"error\">".$form->num_errors." error(s) found</span></h3>";
}
?>
    <form action="process.php" method="POST">
      <table class="centered_table" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td>Current Password:</td>
          <td><input class = "login" type="password" name="curpass" maxlength="30" value="<?php echo $form->value("curpass"); ?>"></td>
          <td><?php echo $form->error("curpass"); ?></td>
        </tr>
        <tr>
          <td>New Password:</td>
          <td><input class = "login" type="password" name="newpass" maxlength="30" value="<?php echo $form->value("newpass"); ?>"></td>
          <td><?php echo $form->error("newpass"); ?></td>
        </tr>
        <tr>
          <td>Email:</td>
          <td><input class = "login" type="text" name="email" maxlength="50" value="
<?php
            if($form->value("email") == ""){
               echo $session->userinfo['email'];
            }else{
               echo $form->value("email");
            }
?>">
          </td>
          <td><?php echo $form->error("email"); ?></td>
        </tr>
        <tr>
          <td colspan="2" align="right">
            <input type="hidden" name="subedit" value="1">
            <button type="submit">Edit Account</button>
          </td>
        </tr>
      </table>
      <div class="heading"><a href="main.php">Return to Main</a></div>
    </form>
<?php
}
}
?>
    &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div id="pagebottom">&nbsp;</div>

</div>
</body>
</html>
<?php } ?>
