<?php
/**
 * Main.php
 *
 * This is an example of the main page of a website. Here
 * users will be able to login. However, like on most sites
 * the login form doesn't just have to be on the main page,
 * but re-appear on subsequent pages, depending on whether
 * the user has logged in or not.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 */
include_once("include/session.php");
include_once("../menubar.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../newstyles.css">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <title>UPAC Cinema - Login</title>
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
 * User has already logged in, so display relavent links, including
 * a link to the admin center if the user is an administrator.
 */
if($session->logged_in){
   echo "<h1>Logged In</h1>";
   echo "<div class=\"heading\"><p>Welcome <b>$session->username</b>, you are logged in.</p></div>";
   if($session->isAdmin()){
   }
   if($session->isChair()){
   }
   if($session->isFriday()){
   }
   if($session->isSaturday()){
   }
   if($session->isMidweek()){
   }
   if($session->isRep()){
   }
   if($session->isProj()){
   }
}
else{
?>

<h1>Officer Login</h1>
<?php
/**
 * User not logged in, display the login form.
 * If user has already tried to login, but errors were
 * found, display the total number of errors.
 * If errors occurred, they will be displayed.
 */
if($form->num_errors > 0){
   echo "<h2><span class=\"error\">".$form->num_errors." error(s) found</span></h2>";
}
?>
<form action="process.php" method="POST">
  <table class="centered_table">
    <tr>
      <td>Username:</td>
      <td align="right"><input class="login" type="text" name="user" maxlength="30" value="<?php echo $form->value("user"); ?>"></td>
      <td><?php echo $form->error("user"); ?></td>
    </tr>
    <tr>
      <td>Password:</td>
      <td align="right"><input class="login" type="password" name="pass" maxlength="30" value="<?php echo $form->value("pass"); ?>"></td>
      <td><?php echo $form->error("pass"); ?></td>
    <tr>
      <td colspan=2>
        <input type="checkbox" name="remember" <?php if($form->value("remember") != ""){ echo "checked"; } ?>>
        Remember me next time
        <input type="hidden" name="sublogin" value="1">
        <button type="submit">Login</button>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div class="heading">
    <br><a href="forgotpass.php">Forgot Password?</a><br>
    <br>Accounts are available only to UPAC Cinema Officers
  </div>
</form>

<?php
}
?>
    &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div id="pagebottom">&nbsp;</div>

</div>
</body>
</html>