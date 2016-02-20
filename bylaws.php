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
    <title>UPAC Cinema - Bylaws</title>
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
    
    <div class="bylaws">
      
      <h1>UPAC Cinema</h1>
      <h2>Bylaws</h2>
      
      <p class="heading">
        Initial Approval: 11/12/1989<br>
        Revised: 11/15/1991<br>
        Revised: 03/29/2007
      </p>
      <ol class="outline_level1">
        <li>
          Statement of Purpose:
          <ol class="outline_level2">
            <li>
              These Bylaws have been written to be the basis for 
              the operation of UPAC Cinema.  They shall be the official 
              UPAC Cinema Bylaws and remain in effect until otherwise 
              changed and voted on by the UPAC Cinema committee.
            </li>
          </ol>
        </li>
        <li>
          Effective Date:
          <ol class="outline_level2">
            <li>
              The guidelines and policies stated in this set of Bylaws 
              shall become effective immediately upon a majority vote of 
              all members present at the UPAC Cinema meeting at which an 
              official vote of approval is held.
            </li>
          </ol>
        </li>
        <li>
          Amendments:
          <ol class="outline_level2">
            <li>
              These Bylaws may be amended at any official UPAC Cinema 
              meeting in accordance with the Voting Procedure Section 9 
              of these Bylaws. 
            </li>
            <li>
              Proposed amendments must be presented to all eligible 
              voting members one week prior to the meeting where 
              discussion and voting over the proposed changes can occur.
            </li>
            <li>
              These Bylaws shall be amended when a 2/3 approval vote 
              is obtained from eligible voting Cinema members present 
              at the meeting.
            </li>
            <li>
              After such a vote, the Bylaws must be updated accordingly 
              and a notification sent to all active and affected members.
            </li>
            <li>
              All changes to the Bylaws are subject to E-board approval.
            </li>
          </ol>
        </li>
        <li>
          Mission of UPAC Cinema:
          <ol class="outline_level2">
            <li>
              UPAC Cinema is a student run and staffed fully functional 
              movie theater whose purpose is to provide Rensselaer 
              Polytechnic Institute and the surrounding community with 
              motion picture entertainment. In this capacity, UPAC Cinema 
              shows over 40 35mm films each academic year, averaging 2 
              films per week.  Film genres range from new pop films just 
              leaving theaters to foreign pictures and old favorites. 
              Beyond providing entertainment for the larger community, 
              UPAC Cinema provides many unique opportunities for its 
              members, such as learning how a movie theater operates 
              and learning how to operate industry standard equipment.
            </li>
          </ol>
        </li>
        <li>
          Membership:
          <ol class="outline_level2">
            <li>
              Membership Guidelines:
              <ol class="outline_level3">
                <li>
                  All members, including Officers, must attend and help 
                  staff at least 4 distinct movies, working at least 8 
                  distinct show times.
                </li>
                <li>
                  Each member must stay for at least one Midnight or 
                  1am show in the course of the semester.
                </li>
                <li>
                  The job of security can not be held more than twice 
                  for the 8 distinct shows to be worked.
                </li>
                <li>
                  All members (regardless of date joined) must fulfill 
                  all requirements in order to receive all privileges 
                  of membership.
                </li>
              </ol>
            </li>
            <li>
              Member Privileges:
              <ol class="outline_level3">
                <li>
                  All members, after working an initial amount of shows, 
                  are granted the ability to view all non-Club films for 
                  free.
                </li>
                <li>
                  All members are allowed to attend movie previews.
                </li>
                <li>
                  All members fulfilling membership requirements are 
                  eligible to participate in the semi-annual poster lottery.
                </li>
              </ol>
            </li>
            <li>
              Officer Privileges:
              <ol class="outline_level3">
                <li>
                  Officers are given all the privileges listed in the 
                  Membership Privileges above.
                </li>
                <li>
                  In addition Officers and up to one guest are allowed 
                  to view any movies for free.
                </li>
                <li>
                  Officers may bring a guest to the previews.
                </li>
              </ol>
            </li>
          </ol>
        </li>
        <li>
          UPAC Cinema Elected Officers:
          <ol class="outline_level2">
            <li>
              The Chair:
              <ol class="outline_level3">
                <li>
                  Films:
                  <ol class="outline_level4">
                    <li>
                      The Chair is responsible for choosing and booking films with the respective film distributors.
                    </li>
                    <li>
                      Collect information from the film companies on prospective movies.
                    </li>
                    <li>
                      Coordinate pick-up and delivery of all films as necessary.
                    </li>
                    <li>
                      Coordinate the return and mailing of all films as necessary.
                    </li>
                  </ol>
                </li>
                <li>
                  Film Coordinator:
                  <ol class="outline_level4">
                    <li>
                      The Chair is in charge of all film contacts and shall work with the club to make any necessary arrangements for these movies.
                    </li>
                  </ol>
                </li>
                <li>
                  Financial Matters:
                  <ol class="outline_level4">
                    <li>
                      The Chair is the chief financial officer of UPAC Cinema and responsible for knowing and following all Union policies for all fiscal matters.
                    </li>
                    <li>
                      Approving bills and submitting them to the Administration Office for processing and payment in a timely manner.
                    </li>
                    <li>
                      Arranging for purchase orders, check requests and other necessary financial work needed in obtaining and paying for film rentals.
                    </li>
                    <li>
                      Maintaining an up-to-date financial record.
                    </li>
                    <li>
                      Preparing and turning in payroll sheets for processing.
                    </li>
                    <li>
                      Initiating account transfers as necessary.
                    </li>
                    <li>
                      Preparing the following year’s budget as requested by the Union.
                    </li>
                  </ol>
                </li>
                <li>
                  Correspondence and Contacts:
                  <ol class="outline_level4">
                    <li>
                      The Chair handles all contacts and correspondence with outside companies and with other departments.  This also includes responsibility for attendance reports, Union key lists, and room reservations.  The Chair or the Chair’s appointee also acts as the UPAC Cinema representative on the UPAC P-board.
                    </li>
                  </ol>
                </li>
                <li>
                  Duties of the Chair:
                  <ol class="outline_level4">
                    <li>
                      Schedule and run weekly meetings.
                    </li>
                    <li>
                      Schedule and run special meetings as necessary.
                    </li>
                    <li>
                      Work for UPAC Cinema’s general planning and direction.
                    </li>
                    <li>
                      Order all supplies needed by Cinema for its operations.
                    </li>
                    <li>
                      Coordinate with Head QP to schedule maintenance visits from our service technician.
                    </li>
                    <li>
                      Meet with the UPAC Cinema Advisor as necessary to keep him/her informed of what is happening.
                    </li>
                  </ol>
                </li>
              </ol>
            </li>
            <li>
              Friday Night Coordinator (FNC)
              <ol class="outline_level3">
                <li>
                  Film Selection:
                  <ol class="outline_level4">
                    <li>
                      The FNC is responsible for assisting the Chair with the choosing and planning of Friday Night Pop Films by holding a semi-annual pop films selection meeting.
                    </li>
                  </ol>
                </li>
                <li>
                  Film Jurisdiction:
                  <ol class="outline_level4">
                    <li>
                      The FNC is in charge of all Friday night films as well as all films that are considered part of the Pop Film Series.
                    </li>
                  </ol>
                </li>
                <li>
                  Membership:
                  <ol class="outline_level4">
                    <li>
                      The FNC is responsible for keeping track of UPAC Cinema membership and ensuring that all active members have met requirements stated in section 5.a.  The FNC is responsible for deciding if a member is eligible for privileges listed in section 5.b. when and if a question of such eligibility arises.
                    </li>
                  </ol>
                </li>
                <li>
                  Team Leaders:
                  <ol class="outline_level4">
                    <li>
                      The FNC is responsible for selecting Team Leaders and dividing active membership into teams under his/her selected Team Leaders.  Teams are to be assigned films at which they are expected to staff.
                    </li>
                  </ol>
                </li>
                <li>
                  Concessions:
                  <ol class="outline_level4">
                    <li>
                      The FNC must coordinate with the Concessions Runner to make sure that the concessions cabinet is stocked and arrange for necessary replenishment of products.
                    </li>
                    <li>
                      The FNC is responsible for keeping track of purchases, income and the financial record of concessions.
                    </li>
                    <li>
                      The FNC is responsible for deciding what products are to be sold and setting the concession prices.
                    </li>
                  </ol>
                </li>
                <li>
                  Before the Show:
                  <ol class="outline_level4">
                    <li>
                      The FNC is responsible for contacting the Team Leader prior to his/her team’s night to staff.  The FNC is responsible for ensuring that Team Leaders fulfill their responsibilities.
                    </li>
                    <li>
                      The FNC needs to arrange for a cash bag and obtain starting cash prior to the night of the show.
                    </li>
                    <li>
                      The FNC is responsible for making any other necessary arrangements to ensure a well run show.
                    </li>
                  </ol>
                </li>
                <li>
                  At the Show:
                  <ol class="outline_level4">
                    <li>
                      The FNC is responsible for securing all doors in the DCC including those of room 308.  He/She should note the general condition and report any major damages found in the building.
                    </li>
                    <li>
                      The FNC is in charge of the setting up of all necessary parts for running the night, such as the ticket selling table and concessions table.
                    </li>
                    <li>
                      During the show the FNC is in charge and has authority over anyone else present.  The FNC assists the Team Leader as necessary and is responsible for handling any situations that may occur in the course of the night.
                    </li>
                  </ol>
                </li>
                <li>
                  At the End of the Night:
                  <ol class="outline_level4">
                    <li>
                      The FNC is responsible for making sure that all outside doors of the DCC are locked.
                    </li>
                    <li>
                      To make sure that the theater and the building are clean and free from trash.
                    </li>
                    <li>
                      To make sure all tables and chairs are returned to their original locations.
                    </li>
                  </ol>
                </li>
              </ol>
            </li>
            <li>
              Saturday Night Coordinator (SNC)
              <ol class="outline_level3">
                <li>
                  Film Selection:
                  <ol class="outline_level4">
                    <li>
                      The SNC is responsible for assisting the Chair with the choosing and planning of both Saturday Night Films and Club Films.  All film selections will be shown on Saturday nights.
                    </li>
                    <li>  
                      The SNC is responsible for contacting clubs who may have an interest in showing films or responding to clubs who approach Cinema with an interest to host a film.  It is the SNC’s responsibility to work with these clubs to select an appropriate film.  Film selection is subject to Chair approval.
                    </li>
                    <li>
                      For Saturday nights that lack a Club sponsored film, The SNC will assist the Chair in the selection of appropriate film choices within the budget of the film series.
                    </li>
                  </ol>
                </li>
                <li>
                  Film Jurisdiction:
                  <ol class="outline_level4">
                    <li>
                      The SNC is in charge of all club films shown as well as all Saturday night movies booked for the Saturday Night Film Series.  The SNC is also in charge of any non-UPAC Cinema sponsored films.
                    </li>
                  </ol>
                </li>
                <li>
                  Before the Show:
                  <ol class="outline_level4">
                    <li>
                      The SNC is responsible for contacting the club to review our policy, explain what will happen the night of the show, and answer any questions the club may have.  The SNC must also have the club read and sign the Club Contract form before UPAC Cinema can show the selected film.
                    </li>
                    <li>
                      The SNC needs to arrange for a cash bag and obtain starting cash prior to the night of the show.
                    </li>
                    <li>
                      The SNC is responsible for taking care of making any other necessary arrangements to ensure a well run show.
                    </li>
                  </ol>
                </li>
                <li>
                  At the Show:
                  <ol class="outline_level4">
                    <li>
                      The SNC is responsible for securing all doors in the DCC including those of room 308.  He/She should note the general condition and report any major damages found in the building.
                    </li>
                    <li>
                      The SNC is in charge of the setting up of all necessary parts for running the night, such as the ticket selling table and concessions table.
                    </li>
                    <li>
                      During the show the SNC is in charge and has authority over anyone else present.  The SNC directs the hosting club as necessary and is responsible for handling any situations that may occur in the course of the night.
                    </li>
                  </ol>
                </li>
                <li>
                  At the End of the Night:
                  <ol class="outline_level4">
                    <li>
                      The SNC is responsible for making sure that all outside doors of the DCC are locked. 
                    </li>
                    <li>
                      To make sure that the theater and building are clean and free from trash.
                    </li>
                    <li>
                      To make sure all tables and chairs are returned to their original locations.
                    </li>
                  </ol>
                </li>
              </ol>
            </li>
            <li>
              Repertory Films Coordinator (REP)
              <ol class="outline_level3">
                <li>
                  Film Selection:
                  <ol class="outline_level4">
                    <li>
                      The REP shall have the ability to submit to the Chair which films his/her film series will show the following semester provided that the selection meets the guidelines of the Repertory Films line item in the UPAC Cinema budget.
                    </li>
                  </ol>
                </li>
                <li>
                  Before the Show:
                  <ol class="outline_level4">
                    <li>
                      The REP needs to arrange for a cash bag and obtain starting cash prior to the night of the show.
                    </li>
                    <li>
                      The REP is responsible for taking care of making any other necessary arrangements to ensure a well run show.
                    </li>
                  </ol>
                </li>
                <li>
                  At the Show:
                  <ol class="outline_level4">
                    <li>
                      The REP is responsible for securing all doors in the DCC including those of room 308.  He/She should note the general condition and report any major damages found in the building.
                    </li>
                    <li>
                      The REP is in charge of the setting up of all necessary parts for running the night, such as the ticket selling table and concessions table.
                    </li>
                    <li>
                      During the show the REP is in charge and has authority over anyone else present.  The REP is also responsible for handling any situations that may occur in the course of the night.
                    </li>
                  </ol>
                </li>
                <li>
                  At the End of the Night:
                  <ol class="outline_level4">
                    <li>
                      The REP is responsible for making sure that all outside doors of the DCC are locked. 
                    </li>
                    <li>
                      To make sure that the theater and building are clean and free from trash.
                    </li>
                    <li>
                      To make sure all tables and chairs are returned to their original locations.
                    </li>
                  </ol>
                </li>
              </ol>
            </li>
            <li>
              Mid-Week Films Coordinator (MID)
              <ol class="outline_level3">
                <li>
                  Film Selection:
                  <ol class="outline_level4">
                    <li>
                      The MID shall have the ability to submit to the Chair which films his/her film series will show the following semester provided that the selection meets the guidelines of the Mid-Week Films line item in the UPAC Cinema budget.
                    </li>
                  </ol>
                </li>
                <li>
                  Before the Show:
                  <ol class="outline_level4">
                    <li>
                      The MID needs to arrange for a cash bag and obtain starting cash prior to the night of the show.
                    </li>
                    <li>
                      The MID is responsible for taking care of making any other necessary arrangements to ensure a well run show.
                    </li>
                  </ol>
                </li>
                <li>
                  At the Show:
                  <ol class="outline_level4">
                    <li>
                      The MID is responsible for securing all doors in the DCC including those of room 308.  He/She should note the general condition and report any major damages found in the building.
                    </li>
                    <li>
                      The MID is in charge of the setting up of all necessary parts for running the night, such as the ticket selling table and concessions table.
                    </li>
                    <li>
                      During the show the MID is in charge and has authority over anyone else present.  The MID is also responsible for handling any situations that may occur in the course of the night.
                    </li>
                  </ol>
                </li>
                <li>
                  At the End of the Night:
                  <ol class="outline_level4">
                    <li>
                      The MID is responsible for making sure that all outside doors of the DCC are locked.
                    </li>
                    <li>
                      To make sure that the theater and building are clean and free from trash.
                    </li>
                    <li>
                      To make sure all tables and chairs are returned to their original locations.
                    </li>
                  </ol>
                </li>
                <li>
                  Special Stipulations:
                  <ol class="outline_level4">
                    <li>
                      The Mid-Week film series is held during the week, usually on Wednesdays.  In times when mid-week films are deemed to be failing, the MID can obtain approval from the Chair to move the film series to Saturday nights until such time it is decided to return the series to the middle of the week.
                    </li>
                  </ol>
                </li>
              </ol>
            </li>
            <li>
              Publicity Coordinator (PC)
              <ol class="outline_level3">
                <li>
                  Publicity Materials:
                  <ol class="outline_level4">
                    <li>
                      The PC is responsible for obtaining all necessary advertising materials that he/she will need in order to adequately publicize UPAC Cinema’s movies.  This will include one sheets, trailers, supplies, etc.
                    </li>
                  </ol>
                </li>
                <li>
                  Advertising:
                  <ol class="outline_level4">
                    <li>
                      The PC is responsible for making all of the arrangements for the production and printing of the weekly and semesterly advertising.
                    </li>
                    <li>
                      To place advertisements as necessary in the Poly.
                    </li>
                    <li>
                      To receive Union approval to use sign board space within the Union.
                    </li>
                    <li>
                      To put up the appropriate weekly posters when available and to make plots as necessary.
                    </li>
                    <li>
                      To make arrangements for the one sheets to be displayed in a timely manner.
                    </li>
                    <li>
                      To submit television slides to RPI TV for upcoming film titles.
                    </li>
                    <li>
                      The PC is responsible for the content and layout of this advertising.  All publications may be subject to committee approval
                    </li>
                  </ol>
                </li>
                <li>
                  Trailers:
                  <ol class="outline_level4">
                    <li>
                      The PC shall make all the necessary arrangements to secure trailers for all of our movies and ensure they are shown on the proper weekends.
                    </li>
                  </ol>
                </li>
                <li>
                  Budget:
                  <ol class="outline_level4">
                    <li>
                      The PC shall have control over the publicity related programs of the UPAC Cinema budget and must comply with the allocated costs of the programs.  Any overages must be approved by the Chair.
                    </li>
                  </ol>
                </li>
              </ol>
            </li>
          </ol>
        </li>
        <li>
          UPAC Cinema Appointed Officers:
          <ol class="outline_level2">
            <li>
              Head Qualified Projectionist (HQP):
              <ol class="outline_level3">
                <li>
                  Appointment:
                  <ol class="outline_level4">
                    <li>
                      The HQP is appointed by majority vote from the active QPs.  The general membership can not partake in the choosing of this position.  The HQP is usually considered to be the senior projectionist or most experienced projectionist.
                    </li>
                    <li>
                      Appointment is subject to Chair approval.
                    </li>
                  </ol>
                </li>
                <li>
                  Qualifications:
                  <ol class="outline_level4">
                    <li>
                      The HQP must be a Qualified Projectionist.
                    </li>
                    <li>
                      The HQP should have a full understanding of the mechanical and electrical workings of the projectors, sound cabinet, and theater (DCC 308).
                    </li>
                  </ol>
                </li>
                <li>
                  Job Description:
                  <ol class="outline_level4">
                    <li>
                      The HQP is in charge of the theater’s projectionist staff.  This includes developing a work schedule to ensure a projectionist is present at every film, making sure all projectionists are properly qualified, and to ensure that all projectionist training is carried out properly.
                    </li>
                    <li>
                      The HQP is in charge of the projection booth, its maintenance, and the stock of supplies stored there.  This includes the checking of all projecting equipment and making note of any problems for a service technician to fix as well as making requests to the Chair to replenish or replace supplies and equipment.
                    </li>
                    <li>
                      The HQP should also coordinate with the Chair in the scheduling of the service technician and be present for the visit to ensure that all problems are corrected.
                    </li>
                  </ol>
                </li>
              </ol>
            </li>
          </ol>
        </li>
        <li>
          UPAC Cinema Jobs and Positions:
          <ol class="outline_level2">
            <li>
              Team Leader (TL):
              <ol class="outline_level3">
                <li>
                  Appointment:
                  <ol class="outline_level4">
                    <li>
                      A TL is appointed by the FNC.
                    </li>
                    <li>
                      Appointment is subject to Chair approval.
                    </li>
                  </ol>
                </li>
                <li>
                  Qualifications:
                  <ol class="outline_level4">
                    <li>
                      A TL must be an active member of UPAC Cinema.
                    </li>
                    <li>
                      A TL must be free to staff assigned films on Friday nights.
                    </li>
                  </ol>
                </li>
                <li>
                  Jobs and Responsibilities:
                  <ol class="outline_level4">
                    <li>
                      The TLs will work with the FNC to create a team from the active general members of UPAC Cinema.
                    </li>
                    <li>
                      Prior to the film that a TL’s team is to staff, the TL is responsible for contacting team members and working out a schedule to ensure all jobs are being covered.  This may involve assigning jobs as necessary.
                    </li>
                    <li>
                      A TL is responsible for making sure that all team members are working at their proper positions and training new members in their positions.
                    </li>
                  </ol>
                </li>
              </ol>
            </li>
            <li>
              Concessions Runner (CR):
              <ol class="outline_level3">
                <li>
                  Appointment:
                  <ol class="outline_level4">
                    <li>
                      The CR is appointed by the FNC.
                    </li>
                    <li>
                      Appointment is subject to Chair approval.
                    </li>
                  </ol>
                </li>
                <li>
                  Qualifications:
                  <ol class="outline_level4">
                    <li>
                      The CR must be a licensed driver with access to a car.
                    </li>
                  </ol>
                </li>
                <li>
                  Job Description:
                  <ol class="outline_level4">
                    <li>
                      The CR works in conjunction with the FNC in the purchasing and stocking of the Concessions Cabinet.  This usually involves driving with the FNC to the club’s current distributor and helping with the transport and purchase of needed concessions.
                    </li>
                    <li>
                      The CR is one of the positions in Cinema that is able to receive a paycheck.
                    </li>
                  </ol>
                </li>
              </ol>
            </li>
            <li>
              Film Runner (FR):
              <ol class="outline_level3">
                <li>
                  Appointment:
                  <ol class="outline_level4">
                    <li>
                      The FR is selected by the Chair.
                    </li>
                  </ol>
                </li>
                <li>
                  Qualifications:
                  <ol class="outline_level4">
                    <li>
                      The FR must be a licensed driver with access to a car and available to pick-up and return film from and to the depot within the necessary deadlines.
                    </li>
                  </ol>
                </li>
                <li>
                  Job Description:
                  <ol class="outline_level4">
                    <li>
                      The FR is responsible for the pick-up and return of film on Thursday and Monday mornings/afternoons respectively.  The film should be delivered to the booth before 8:00pm on Thursdays to give the projectionist staff sufficient time for building or training.
                    </li>
                    <li>
                      The FR is one of the positions in Cinema that is able to receive a paycheck.
                    </li>
                  </ol>
                </li>
              </ol>
            </li>
            <li>
              Qualified Projectionist (QP):
              <ol class="outline_level3">
                <li>
                  Appointment:
                  <ol class="outline_level4">
                    <li>
                      A member can considered a QP only after passing a Qualifying Exam administered by a group of QPs appointed by the HQP.
                    </li>
                    <li>
                      Appointment is subject to a majority vote of the active QPs.
                    </li>
                  </ol>
                </li>
                <li>
                  Qualifications:
                  <ol class="outline_level4">
                    <li>
                      The QP must be an active member of UPAC Cinema.
                    </li>
                    <li>
                      The QP should have a understanding of the mechanical and electrical workings of the projectors, sound cabinet, and theater (DCC 308).  This understanding is subject to the guidelines and standards set by the HQP.
                    </li>
                    <li>
                      The QP is required to pass a qualifying test administered in the method detailed above in Section 8.d.i.a. of these Bylaws.
                    </li>
                  </ol>
                </li>
                <li>
                  Jobs and Responsibilities:
                  <ol class="outline_level4">
                    <li>
                      The QP is responsible for the projecting of films on his/her assigned nights.  The projecting of the film must follow guidelines and standards set forth by the HQP.
                    </li>
                    <li>
                      The QP is in charge of the booth and theater during the night of his movie.  If the Coordinator fails to show up, the running of the entire movie falls to the projectionist.
                    </li>
                    <li>
                      The QP is one of the positions in Cinema that is able to receive a paycheck.
                    </li>
                  </ol>
                </li>
              </ol>
            </li>
            <li>
              Projectionist in Training (PIT):
              <ol class="outline_level3">
                <li>
                  Appointment:
                  <ol class="outline_level4">
                    <li>
                      Any member can request the appointment to be a PIT for any given film.  Approval for the appointment comes from the QP in charge of the film in question.
                    </li>
                  </ol>
                </li>
                <li>
                  Qualifications:
                  <ol class="outline_level4">
                    <li>
                      A PIT must be an active member of UPAC Cinema.
                    </li>
                  </ol>
                </li>
                <li>
                  Jobs and Responsibilities:
                  <ol class="outline_level4">
                    <li>
                      A PIT is to fulfill the responsibilities given to him/her by the supervising QP.  The extent to which a PIT is allowed to run a show is at the discretion of the QP.
                    </li>
                    <li>
                      After sufficient training, a PIT can discuss becoming a QP with the HQP.  The procedure for qualification will be at the discretion of the HQP.
                    </li>
                  </ol>
                </li>
              </ol>
            </li>
          </ol>
        </li>
        <li>
          Voting Procedures:
          <ol class="outline_level2">
            <li>
              Eligibility to Vote:
              <ol class="outline_level3">
                <li>
                  A member is eligible to vote if he/she has attended at least eighty percent of the UPAC Cinema meetings or has attended the three consecutive meetings prior to the vote in question.
                </li>
                <li>
                  Should be considered an active member as outlined in Section 5.a. of these Bylaws or considered to be actively working toward meeting these requirements.
                </li>
                <li>
                  Any question of voter eligibility falls to the FNC who is responsible for keeping track of membership requirements and activity.
                </li>
              </ol>
            </li>
            <li>
              The Voting Process:
              <ol class="outline_level3">
                <li>
                  All proposals requiring a vote for approval must be first introduced to the club as a motion.  Any member considered to be an eligible voter can make a motion.
                </li>
                <li>
                  Before a motion can be moved to discussion, the motion must be seconded by a member considered to be an eligible voter.
                </li>
                <li>
                  Discussion of the motion may last at the Chair’s discretion or until a majority of the voting members call for a commencement of the vote.
                </li>
                <li>
                  A majority vote is necessary for a motion to be approved.  In cases of a tie, the Chair reserves the right to cast one vote on behalf of the club to break the tie.
                </li>
              </ol>
            </li>
            <li>
              Special Stipulations:
              <ol class="outline_level3">
                <li>
                  Voting can be done by show of hands.  A single request for secret ballot before a vote is taken, however, is all that is required to mandate the vote be done by private ballots.
                </li>
                <li>
                  Votes for Amendment Process as outlined in Section 3 of these Bylaws and votes for an Elected Officer position as outlined in Section 10 of these Bylaws both require a quorum of 75% of active eligible voting members to attend in order for a vote to be valid.
                </li>
              </ol>
            </li>
          </ol>
        </li>
        <li>
          Election Procedures:
          <ol class="outline_level2">
            <li>
              Notification:
              <ol class="outline_level3">
                <li>
                  A one week notification is required prior to the beginning of Chair nominations.  This notice needs to be sent to all active members of UPAC Cinema and detail the coming procedure for nomination, election, and voting for the officer positions detailed in Section 6 of these Bylaws.  A description of each position should be included to inform members of what to look for in a candidate and help him/her decide if they themselves wish to run for a position.  The conducting of all votes should follow the procedure outlined in Section 9 of these Bylaws.
                </li>
              </ol>
            </li>
            <li>
              Eligibility:
              <ol class="outline_level3">
                <li>
                  All nominations for elected UPAC Cinema Officer positions must be for current and active students of Rensselaer Polytechnic Institute.
                </li>
              </ol>
            </li>
            <li>
              The Chair:
              <ol class="outline_level3">
                <li>
                  Nominations for the position of the Chair are to be made three meetings prior to Thanksgiving break in the Fall semester.  
                </li>
                <li>  
                  The election for the Chair position will take place the following week (two meetings before Thanksgiving break).
                </li>
              </ol>
            </li>
            <li>
              Other Elected Positions:
              <ol class="outline_level3">
                <li>
                  Nominations for other elected positions will be held at the same meeting in which the Chair is elected (two meetings before Thanksgiving break).  Nominations will be taken in the order the positions are outlined in Section 6 of these Bylaws.
                </li>
                <li>
                  The election for these positions will be held the following week (the meeting before Thanksgiving break).
                </li>
              </ol>
            </li>
            <li>
              Qualifications and Nominations:
              <ol class="outline_level3">
                <li>
                  Nominations and seconds for any Officer position outlined in Section 6 of these Bylaws can be made by any eligible voting member of UPAC Cinema.  Nominations must be made during the appropriate meeting.
                </li>
                <li>
                  Before a nominee can be considered a candidate, a second must be offered followed by an acceptance by the nominee.  In the person’s absence, a proxy can accept on his/her behalf.
                </li>
                <li>
                  All nominated candidates must be active members of UPAC Cinema.
                </li>
              </ol>
            </li>
            <li>
              Election Process:
              <ol class="outline_level3">
                <li>
                  The election proceedings will be presided over by the Chair.  If the Chair is running for the position in question, the responsibility falls down the line of Officers as listed in Section 6 of these Bylaws.
                </li>
                <li>
                  The order of positions to be voted on will follow the same order of positions as listed in Section 6 of these Bylaws.
                </li>
                <li>
                  Each candidate will be allowed 2 minutes for a personal speech followed by an amount of time for questioning by the general members.  During this time all other candidates for the same position should wait outside of the room.
                </li>
                <li>
                  A candidate reserves the right to withdraw from their nominated position at any point prior to the actual vote.
                </li>
                <li>
                  If only one person is running for a position, the Chair can cast a single vote on behalf of the club and vote the person into the officer position.
                </li>
                <li>
                  If two people are running for a position, the winner shall be decided by majority vote of attending members at the election meeting.
                </li>
                <li>
                  If three or more people are running for a position, an initial vote is taken.  The two people with the highest number of votes will then go through a final election in which a winner shall be decided by majority vote of attending voting eligible members at the election meeting.
                </li>
                <li>
                  In the case of a tie, the Chair holds the power to cast a single vote on behalf of the entire club to break the tie.
                </li>
              </ol>
            </li>
            <li>
              Vacancies:
              <ol class="outline_level3">
                <li>
                  If a position becomes vacant, nominations for a replacement will be held at the first meeting after the date of the vacancy.  An election will take place the following week.  The election process described above is to be followed.
                </li>
                <li>
                  In the event that a vacancy occurs over the summer, the Chair may make an appointment if anyone expresses an interest in holding the vacant position.  This appointment is subject to approval by the voting members present at the first meeting in the fall.
                </li>
                <li>
                  In the case of the UPAC Chair position becoming vacant, the FNC shall temporarily become Chair until the above procedures are followed and a new Chair properly elected.
                </li>
              </ol>
            </li>
          </ol>
        </li>
        <li>
          Disciplinary Actions:
          <ol class="outline_level2">
            <li>
              Disciplinary action can be taken against any member of UPAC Cinema, may they be a general member or an officer.  Such action can be taken if any member is found in violation of the guidelines and rules set forth in these Bylaws
            </li>
            <li>
              Disciplinary Action of a Member:
              <ol class="outline_level3">
                <li>
                  Any member charged with violating these Bylaws is subject to disciplinary action.
                </li>
                <li>
                  Such action will take place in a private meeting between the party in question and the club officers.  Any penalties will be decided upon by a majority vote of the officers present at the meeting.
                </li>
              </ol>
            </li>
            <li>
              Impeachment and Removal of Officers:
              <ol class="outline_level3">
                <li>
                  There must be a general consensus before an officer can be impeached.  This can be shown as either a petition signed by at least half of the eligible voters or by a petition signed by at least half of the officers.  The petition must then be presented to the Chair or, in the case of impeaching the Chair, to the FNC.
                </li>
                <li>
                  Once the petition has been submitted a meeting to discuss the list of grievances against the officer must be held.  The meeting is limited to officers, eligible voting members, and anyone considered necessary to ensure a fair outcome.  All parties to be present must be given at least a three day notice as to the time and location of the meeting.
                </li>
                <li>
                  For an officer to be removed, a vote of 2/3 approval is required of the present voters.  No abstentions for this vote are allowed.
                </li>
                <li>
                  In the case of removing the Chair, the running of the meeting falls to the FNC.  For the removal of a Chair, a vote of 2/3 approval is required of the present officers.  No abstentions for this vote are allowed.
                </li>
                <li>
                  If the accused officer is not present at the meeting, but can provide justifiable cause, the meeting and vote are considered null and void.  A new meeting must be scheduled to give the officer a chance to defend himself/herself.
                </li>
                <li>
                  Any removals approved through vote come into effect at the end of the meeting and the position of the removed officer shall be considered Vacant and handled in the method outlined in section 10.f.
                </li>
              </ol>
            </li>
          </ol>
        </li>
        <li>
          The Theater:
          <ol class="outline_level2">
            <li>
              The Theater Room:
              <ol class="outline_level3">
                <li>
                  Normally shown weekend/weekday movies are to be held in DCC 308.  (Special shows at special locations may occur when equipment permits)
                </li>
                <li>
                  The DCC and its rooms can only be used with a reservation.  This means that UPAC Cinema has no right to be in and utilize the facilities of the DCC without the Chair confirming a reservation with the appropriate school officials.  
                </li>
              </ol>
            </li>
            <li>
              Alcohol Policy:
              <ol class="outline_level3">
                <li>
                  The DCC building policy prohibits the possession or consumption of alcohol in the building.  All alcohol brought into the building by patrons must be confiscated and disposed of properly, that is by dumping it down the sink or throwing it in the garbage.  UPAC Cinema members, regardless of age, are NOT allowed to dispose of the alcohol by drinking it themselves or saving it to take it home later.  Empty bottles or cans should be thrown out and not saved.
                </li>
                <li>
                  While UPAC Cinema has any rooms reserved in the DCC, we are responsible for enforcing this policy.  This means that if any officer is “on-duty” and sees someone with alcohol, they are responsible for removing it from them, or notifying someone else from Cinema in authority to handle the situation.  
                </li>
                <li>
                  All persons working for Cinema (projectionist, team members, coordinators, etc) MUST be sober.  All Officers are responsible for upholding the Alcohol Policy at any UPAC Cinema event.
                </li>
                <li>
                  As per the revised campus alcohol policy (1/90), if a person does not present his/her alcohol upon request, the night’s coordinator must contact Public Safety immediately; they should not handle the situation further by themselves.  Having Public Safety handle the situation removes any liability for UPAC.
                </li>
              </ol>
            </li>
          </ol>
        </li>
        <li>
          Showing of Movies:
          <ol class="outline_level2">
            <li>
              Use of Projection Equipment:
              <ol class="outline_level3">
                <li>
                  The Projection Equipment can only be used by, or in the presence of, a QP.  This means that all movies are to be run by a QP.
                </li>
                <li>
                  A PIT may run a movie as long as a QP is present for the show.
                </li>
              </ol>
            </li>
            <li>
              Movies can only be shown for the following reasons:
              <ol class="outline_level3">
                <li>
                  One preview prior to the actual showing
                </li>
                <li>
                  The actual showing.
                </li>
                <li>
                  Qualification shows (provided that the movie has already had its actual showing)
                </li>
                <li>
                  Used at a training session with a QP and several PITs (no one else).  
                </li>
                <li>
                  Extra showings other than listed above must be approved by the Chair in advance.
                </li>
              </ol>
            </li>
            <li>
              How to Run a Movie:
              <ol class="outline_level3">
                <li>
                  The proper procedure for the running of a preview and actual screening of a film is to be outlined by the HQP.
                </li>
                <li>
                  It is the responsibility of the HQP to make sure that all the QPs are well informed of and following the proper procedure for showing a film.
                </li>
              </ol>
            </li>
          </ol>
        </li>
        <li>
          Poster Lottery:
          <ol class="outline_level2">
            <li>
              The semi-annual poster lottery is to be held at the end of both the Fall and Spring semesters.
            </li>
            <li>
              All posters from the semester will be included.
            </li>
            <li>
              All members who have completed the requirements found in Section 5.a. of these Bylaws are eligible to participate.  Any question of eligibility will be answered by the FNC who should have a record of member activity.
            </li>
            <li>
              All lottery picks will be chosen randomly from all those eligible members present at the meeting.
            </li>
            <li>
              The first round of the lottery is open only to Officers of UPAC Cinema.  The subsequent rounds are to be open to all eligible members.  The number of rounds continue until all the posters are gone or until no more members wish to participate.
            </li>
          </ol>
        </li>
      </ol>
      
    </div>
    
    &nbsp;
  </div> <!-- End content -->
  
  <!-- The bottom of the gray area with shadow -->
  <div id="pagebottom">&nbsp;</div>

</div>
</body>
</html>