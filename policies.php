<?php
  include_once("officers/include/session.php");
  include_once("menubar.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">



<html>
  <head>
    <title>UPAC Cinema - Policies</title>
    <link rel="stylesheet" type="text/css" href="newstyles.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
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
        
<h1>General UPAC Cinema Movie Policies</h1>
<br><br>

<dl>
<dt><strong>Fridays :</strong></dt>
  <dd> 
    Pop Films sponsored by UPAC Cinema and are held in DCC 308
    at 7 PM, 9:30 PM and 12 AM. Admission is $2.50
  </dd>
<dt><strong>Saturdays :</strong></dt>
  <dd> 
    Club Films sponsored by various RPI clubs, noted on the    
    summary page of the schedule. They are shown at 7 PM, 9:30 PM
    and 12 AM. Admission is $2.50
  </dd>
  <dd> Midweek/Repertory Films are sponsored by UPAC Cinema and
     are held in DCC 308 at 7 PM, 9:30 PM and 12 AM. Admission is $2.50
  </dd>
<dt><strong>Sneak Previews :</strong></dt>
  <dd>
    Sneak Previews are held on either Tuesday or Thursday.
    Passes can be obtained from the Union Admin Office.
  </dd>
</dl>
<hr>

All admission prices are <strong>PER</strong> screening.

<hr>

No refunds or exchanges on tickets, unless deemed necessary by the 
appropriate Cinema administration. In the event a refund must be given,
a free pass will be issued in lieu of cash.

For other information, please contact UPAC Cinema in Rensselaer Union Room
3802 or at 276-8585 or at <a href="mailto:upac-cinema@union.rpi.edu">upac-cinema@union.rpi.edu</a>.

<h2>UPAC Cinema Sneak Preview Movie Policies</h2>

This is one of the more misunderstood things we do, and we constantly
hear people complain about it to UPAC Cinema, but when we explain how
things work, we still hear the same complaints from the same people. So
pay attention!

Movie studios like to get advanced word-of-mouth publicity for their
movies, so they arrange to have free previews given. UPAC Cinema arranges
with a company to bring a preview here to show to the RPI community. To
make sure that we have a full theatre, we generally hand out more
admission passes than we have physical seats. While this may seem a
bad idea, the reality is offering all these passes ensures that DCC 308
will be full. Not everyone who receives a pass will be able to use it,
and not everyone who is unable to use a pass hands it off to someone
who can use the pass.

Because we are offering more potential entries to DCC 308 than we have 
seats in DCC 308, each pass has printed on it the following:
<strong> Seating is on a first come, first served basis and limited 
to theatre capacity.</strong>

When you show up to a preview, you will be asked to exchange your pass
for a ticket. We do this, so we know how many passes have been exchanged.
It also helps us keep track of how many people are attending the preview.
Plus, once you have a ticket, you're guarenteed a seat. We do not hand out 
more tickets than available seats.

The order for seating people is as follows :
<ol>
<li>People who have exchanged their passes for tickets get seated first.
<li>If all the tickets have been handed out and there are extra seats,
     they go to pass holders who have not exchanged passes for tickets.
<li>If all the pass holders have been admitted to the theatre and there
     are tickets left, then people who do not have passes will be 
     admitted to the theatre.
</ol>

Quite simply, a pass <strong>DOES NOT</strong> mean that you will get a 
seat (remember first come, first served?), but it DOES mean that you 
will be seated before those WITHOUT passes.

We'd also appreciate it if you fill out a survey (when we have them).
Why? Well, the preview company collects them, and based on the number 
of respondants and attendance we have at previews, we get a chance at
hosting another preview. This has allowed us to host as many as 5 sneak
previews in one semester.

So just remember the above, and if you have any questions, ask any of
the UPAC Cinema personnel at the movie, or send us an e-mail.
      &nbsp;
    </div>
        
    <div id="pagebottom">&nbsp;</div>
    
</div>
</body>
</html>
