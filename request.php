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
    <title>UPAC Cinema - Request</title>
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
<h1>
Request a Saturday Club Film
</h1><br><br>
<?php 
if(isset($_SESSION['requestfilm'])) {
      if($_SESSION['requestfilm']) {
            echo "Your movie request has been sent to UPAC Cinema.
                  We will get back to you within the next 48 hours.";
      } else {
            echo "We're sorry. Your request failed to be sent. Please try again later.
                  If this is a persistent problem, please contact the webmaster.";
      }
      unset($_SESSION['requestfilm']);
} else { ?>

<form method="post" action="requestprocess.php">
<table>
      <tr>
        <td>* Organization Name: </td><td><input type="text" name="club" value="<?php echo $form->value("club"); ?>"></td>
        <td><?php echo $form->error("club"); ?></td>
      </tr>
      <tr>
        <td>* Contact Name: </td><td><input type="text" name="cname" value="<?php echo $form->value("cname"); ?>"></td>
        <td><?php echo $form->error("cname"); ?></td>
      </tr>
      <tr>
        <td>* Contact Email: </td><td><input type="text" name="cmail" value="<?php echo $form->value("cmail"); ?>"></td>
        <td><?php echo $form->error("cmail"); ?></td>
      </tr>
      <tr>
        <td>* Union Funded: </td><td><input type="radio" name="funds" value="Yes" <?php if($form->value("funds") == "Yes"){ echo "checked"; } ?>>Yes <input type="radio" name="funds" value="No" <?php if($form->value("funds") == "No"){ echo "checked"; } ?>>No</td>
        <td><?php echo $form->error("funds"); ?></td>
      </tr>
      <tr>
        <td>* Payment Option: </td><td><input type="radio" name="pay" value="50/50" <?php if($form->value("pay") == "50/50"){ echo "checked"; } ?>>50/50 option<br> <input type="radio" name="pay" value="Full" <?php if($form->value("pay") == "Full"){ echo "checked"; } ?>>Full Payment</td>
        <td><?php echo $form->error("pay"); ?></td>
      </tr>
      <tr>
        <td>
         * Desired Date:</td><td>
         <select name="date">
         <option <?php if($form->value("date") == "January"){ echo "selected=\"selected\""; } ?> value="January">January
         <option <?php if($form->value("date") == "February"){ echo "selected=\"selected\""; } ?> value="February">Febuary
         <option <?php if($form->value("date") == "March"){ echo "selected=\"selected\""; } ?> value="March">March
         <option <?php if($form->value("date") == "April"){ echo "selected=\"selected\""; } ?> value="April">April
         <option <?php if($form->value("date") == "May"){ echo "selected=\"selected\""; } ?> value="May">May
         <option <?php if($form->value("date") == "August"){ echo "selected=\"selected\""; } ?> value="August">August
         <option <?php if($form->value("date") == "September"){ echo "selected=\"selected\""; } ?> value="September">September
         <option <?php if($form->value("date") == "October"){ echo "selected=\"selected\""; } ?> value="October">October
         <option <?php if($form->value("date") == "November"){ echo "selected=\"selected\""; } ?> value="November">November
         <option <?php if($form->value("date") == "December"){ echo "selected=\"selected\""; } ?> value="December">December
         </select> 
        </td>
        <td><?php echo $form->error("date"); ?></td>
      </tr>
      <tr>
        <td>
         * Year </td><td><input type="text" name="year" value="<?php echo $form->value("year"); ?>">
        </td>
        <td><?php echo $form->error("year"); ?></td>
      </tr>
      <tr>
        <td>* First Choice Movie: </td><td><input type="text" name="first" value="<?php echo $form->value("first"); ?>"></td>
        <td><?php echo $form->error("first"); ?></td>
      </tr>
      <tr>
        <td>Second Choice Movie: </td><td><input type="text" name="second" value="<?php echo $form->value("second"); ?>"></td>
      </tr>
      <tr>
        <td>Third Choice Movie: </td><td><input type="text" name="third" value="<?php echo $form->value("third"); ?>"></td>
      </tr>
      <tr>
        <td>Fourth Choice Movie: </td><td><input type="text" name="fourth" value="<?php echo $form->value("fourth"); ?>"></td>
      </tr>
      <tr>
        <td colspan=2>* I have read the How to Sponser a Club Film Document: <input type="radio" name="terms" value="Yes">Yes <input type="radio" name="terms" value="No">No</td>
        <td><?php echo $form->error("terms"); ?></td>
      </tr>
</table>
<div>
<button type="submit">Request Movie</button>
<button type="reset">Clear Form</button>
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

