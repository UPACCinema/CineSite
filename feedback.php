<?php
  include_once("officers/include/session.php");
  include_once("menubar.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">


<html>
  <head>
    <link rel="stylesheet" type="text/css" href="newstyles.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>UPAC Cinema - Feedback</title>
  </head>
<body>

<div id="wrapper">

<?php
    echo "<!-- Top Menu (Navigation) -->
    <div id=\"globalnavbar\" style=\"background-color:#000000;\">
      <img class=\"logo\"src=\"images/upac_logo.png\" alt=\"UPAC Cinema\" />
      <ul class=\"dropdown\">
        <li><a href=\"index.php\">Schedule</a></li>
        <li><a href=\"policies.php\">Policies</a></li>
        <li><a href=\"bylaws.php\">Bylaws</a></li>
        <li><a href=\"clubfilm.php\">Requests</a></li>
        <li><a href=\"faq.php\">FAQ</a></li>
        <li><a href=\"feedback.php\">Feedback</a></li>
        <li><a href=\"officers.php\">Contact</a></li>";
        if($session->logged_in){
            echo "<li>
                        <a href=\"#\">";
                        if($session->isAdmin()) { echo "Admin"; } else { echo "Members"; } 
                        echo "</a>
                        <ul>
                              <li><a href=\"officers/userinfo.php?user=$session->username\">Profile</a></li>
                              <li><a href=\"officers/managefiles.php\">Files</a></li>";
                              if($session->isAdmin()) {
                                    echo "<li><a href=\"officers/gen.php\">Schedule Generator</a></li>
                                          <li><a href=\"officers/editstaff.php\">Change Officers</a></li>
                                          <li><a href=\"officers/register.php\">Add Users</a></li>
                                          <li><a href=\"officers/admin/admin.php\">Admin Center</a></li>";
                              }
                        echo "</ul>
                  </li>";
            echo "<li><a href=\"officers/process.php\">Logout</a></li>";
        } else {
            echo "<li><a href=\"officers/main.php\">Login</a></li>";
        }
    echo
     "</ul>
    </div>";
  ?>

  
  <div id="content">
    &nbsp;
    
   <h1>Anonymous Feedback</h1>
<?php 
if(isset($_SESSION['feedbacksent'])) {
      if($_SESSION['feedbacksent']) {
            echo "Your message has been sent to UPAC Cinema.
                  Thanks for your input!";
      } else {
            echo "We're sorry. Your message failed to be sent. Please try again later.
                  If this is a persistent problem, please contact the webmaster.";
      }
      unset($_SESSION['feedbacksent']);
} else { ?>
   <h2>Got something to say? Let us know!</h2>
   <h2>If you want us to respond, make sure you enter your name and email!</h2>
    
   &nbsp;
   
  <form action="feedbackprocess.php" method="post">

  <div class="heading">
    <span class="feedback_head"><label for="tswname">Name (Optional) : </label><input type="text" name="fullname" id="tswname" size="25" value="<?php echo $form->value("fullname"); ?>"></span><br>
    <span class="feedback_head"><label for="tswemail">Email address (Optional) : </label><input type="text" id="tswemail" name="email" size="25" value="<?php echo $form->value("email"); ?>"></span><br>
    <br>
    <span class="feedback_head"><label for="tswcomments">Comments</label> <?php echo $form->error("comments"); ?></span><br>
    <textarea rows="25" cols="100" name="comments" id="tswcomments"></textarea><br>
	<?php
		require_once('recaptchalib.php');
		$publickey = "6LcBlckSAAAAACredx-TggMTKAh31XACtP3-Cfl8";
		echo recaptcha_get_html($publickey);
	?>
	<button type="submit">Send Feedback</button>
  </div>
  </form>
<?php } ?>
  &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div id="pagebottom">&nbsp;</div>

</div>
</body>
</html>