<?php
/**
 * Register.php
 * 
 * Displays the registration form if the user needs to sign-up,
 * or lets the user know, if he's already logged in, that he
 * can't register another name.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 */
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
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <title>UPAC Cinema - Register</title>
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
 * The user has submitted the registration form and the
 * results have been processed.
 */
if(isset($_SESSION['regsuccess'])){
   /* Registration was successful */
   if($_SESSION['regsuccess']){
      echo "<h1>Registered!</h1>";
      echo "<p>" . $_SESSION['reguname'] . " has been added to the members list.</p>";
   }
   /* Registration failed */
   else{
      echo "<h1>Registration Failed</h1>";
      echo "<p>An error has occurred and your registration for the username <b>".$_SESSION['reguname']."</b>, "
          ."could not be completed.<br>Please try again.</p>";
   }
   unset($_SESSION['regsuccess']);
   unset($_SESSION['reguname']);
}
/**
 * The user has not filled out the registration form yet.
 * Below is the page with the sign-up form, the names
 * of the input fields are important and should not
 * be changed.
 */
else{
?>

    <h1>Register</h1>
    <h4>
      The member's username must be between 5 and 30 characters long.<br>
      The member's password must be between 5 and 30 characters long.<br>
      The member's email may be up to 50 characters long.
    </h4>
    <?php
    if($form->num_errors > 0){
      echo "<h2><span class=\"error\">".$form->num_errors." error(s) found</span></h2>";
    }
    ?>
    <form action="process.php" method="POST">
      <table class="centered_table" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td>Username:</td>
          <td><input class="login" type="text" name="user" maxlength="30" value="<?php echo $form->value("user"); ?>"></td>
          <td><?php echo $form->error("user"); ?></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><input class="login" type="password" name="pass" maxlength="30" value="<?php echo $form->value("pass"); ?>"></td>
          <td><?php echo $form->error("pass"); ?></td>
        </tr>
        <tr>
          <td>Email:</td>
          <td><input class="login" type="text" name="email" maxlength="50" value="<?php echo $form->value("email"); ?>"></td>
          <td><?php echo $form->error("email"); ?></td>
        </tr>
        <tr>
          <td colspan="2" align="right">
            <input type="hidden" name="subjoin" value="1">
            <button type="submit">Register</button>
          </td>
        </tr>
      </table>
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
<?php } ?>