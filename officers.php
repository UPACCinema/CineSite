<?php
include_once("officers/include/session.php");
include_once("menubar.php");
$user = "cinema";
$old_bad_pass = "kkbpfo233";
$pass = "n@VSjEV4lG";
$dbname = "cinema_db";
$link = mysql_connect("db.union.rpi.edu", $user, $pass);
mysql_select_db($dbname);

function sqlerr($sql, $file, $line){
  if ($err = mysql_error()){
    echo "ERROR: $err<br>\n";
    echo "SQL: $sql<br>\n";
    echo "In $file, at line # $line<br>\n";
    exit();
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">


<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
    <link rel="stylesheet" type="text/css" href="newstyles.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>UPAC Cinema - Contact</title>
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
  
    
  $sql = "SELECT * FROM officers ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC;";
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
        break;
      case "Webmaster":
        $webname = $officer['name'];
        $webemail = $officer['email'];
        break;
    }
  }
?>

  
  <div id="content">
    &nbsp;
    
    <h1>UPAC Cinema Officers</h1>
    <h2>Mailing List: <a href="mailto:upac-cinema@union.rpi.edu">upac-cinema@union.rpi.edu</a></h2>
    <div class="heading">
      <h3>Chairperson</h3>
      <a href="mailto:<?php echo $chairemail ?>"><?php echo $chairname ?></a>
         
      <h3>Friday Night Coordinator</h3> 
      <a href="mailto:<?php echo $fncemail ?>"><?php echo $fncname ?></a>
         
      <h3>Saturday Night Coordinator</h3>
      <a href="mailto:<?php echo $sncemail ?>"><?php echo $sncname ?></a>
         
      <h3>Midweek Coordinator</h3> 
      <a href="mailto:<?php echo $midemail ?>"><?php echo $midname ?></a>
         
      <h3>Repertory Coordinator</h3> 
      <a href="mailto:<?php echo $repemail ?>"><?php echo $repname ?></a>
         
      <h3>Publicity Coordinator</h3> 
      <a href="mailto:<?php echo $pubemail ?>"><?php echo $pubname ?></a>
      
      <h3>Projectionists</h3>
<?php foreach( $projname as $id => $fullname ) {
          if($id > 0) { echo '<br>'; } ?>
      <a href="mailto:<?php echo $projemail[$id] ?>"><?php echo $fullname ?></a>
<?php } ?>
          
      <h3>Webmaster</h3> 
      <a href="mailto:<?php echo $webemail ?>"><?php echo $webname ?></a>
    </div>
  
    &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div id="pagebottom">&nbsp;</div>
   
</div>
</body>
</html>