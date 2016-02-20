<?php
  include_once("officers/include/session.php");
  include_once("menubar.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">


<html>
  <head>
    <title>UPAC Cinema - Sponsor a Film</title>
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
        <div class="heading">
          <H1>How To Sponsor A Club Film</H1>
          written by
          <h3>Mark Stapleton</h3>
          Last updated August 31, 2002
          <br>
          by: Robert Healey
          <br>
        </div>
        <a id="Top">&nbsp;</a>
          <ol>
            <li><a href="#Get">Getting Started</a></li>
            <li><a href="#Lottery">The Lottery</a></li> 
            <li><a href="#Scheduled">The Movie is Scheduled</a></li>
            <li><a href="#Contract">The Contract</a></li>
            <li><a href="#Running">Running the Movie</a></li>
            <li><a href="#Submit">Submit a Request</a></li>
          </ol>
        <!-- Getting Started -->
        
        <h2>
          <a id="Get">Getting Started</a>
        </h2>
        
        <ol>
          <li>When do we get started?</li>
        </ol>
        <p>
          As soon as you can. Either you will get a notice in the club mailbox in the 
          Union, or you will be contacted directly from the Saturday Night Coordinator 
          (SNC). Usually the notices in the mailbox goes out the semester before the scheduled 
          semester. For example, if this is the Fall 96 semester, we would have sent a 
          notice out a month or two before the end of the Spring 96 semester ended.
        </p>
        <p>
          If you did not get a notice, then the SNC may have attempted to contact you 
          directly by either 1) finding out who is in charge through the Administration’s 
          Office list, or 2) sending a member, officer, or friend of the aforesaid electronic 
          mail, or lastly 3) calling any of these people on the phone. In practice, the 
          SNC usually doesn't take the time to hunt down the clubs.
        </p>
        <p>
          &nbsp;
        </p>
        
        <ol>
          <li>How do I get started?</li>
        </ol>
        <p>
          If you have been contacted, or even if you <i>have not</i>, the first step 
          its to submit a list of five to ten movies to the SNC. Please rank them in preference 
          in a descending order. It would also help to tell us around which Saturdays 
          you’ll want to show this film. Usually it is nearly impossible to negotiate 
          that with the distributor, but at least indicate which half of the semester 
          you’d like to do it in. Also bear in mind that the Friday Night Film Series 
          will take all the &quot;blockbusters&quot; - usually - not always though. The 
          Midweek Film Series will attempt to schedule films that are more &quot;culturally 
          enriching,&quot; but they have been to known to do popular films as well.
        </p>
        <p>
          If you feel that you MUST have a new film that has come out, you need to negotiate 
          this with the SNC and the president of UPAC <b>BEFORE</b> the movie schedule 
          has been set.The schedule is made towards the end of the previous semester.
        </p>
        <p>
          &nbsp;
        </p>
        
        <ol>
          <li>Who Do I contact?</li>
        </ol>
        <p>
          The person to contact is the Saturday Night Coordinator, or SNC for short. 
          This person can be contacted via electronic mail at 
          <a href="mailto:upac-cinema@union.rpi.edu">upac-cinema@union.rpi.edu</a>. This 
          address is a mail alias to all the coordinators and the president of UPAC Cinema. 
          If you get no response, you may feel free to leave us a message at our office 
          number - 276-8585; or continue to spam that electronic mail address.
        </p>
        <p>
          &nbsp;
        </p>
        
        <ol>
          <li>What if the movies have been scheduled already? Can I still participate?</li>
        </ol>
        <p>
          <b>Yes.</b> Well, usually. If all the Saturday slots have not been taken, you 
          can negotiate with the SNC to obtain a scheduled movie.
        </p>
        
        <div class="heading">
          [<a href="#Top">Top</a>]
        </div>
        
        <h2>
          <a id="Lottery">The Lottery</a>
        </h2>
        <p>
          After the SNC has received the movie ideas via electronic mail, he will hold 
          a lottery where he picks which ranks the clubs in preference to be scheduled. 
          The exact date of this drawing will be posted on the notice that goes out to 
          the clubs. If your club has already shown a movie in the current semester of 
          the drawing, preference is given to those who have not participated yet. 
        </p>
        <p>
          After the lottery you <i>might</i> be given a letter that indicates that you 
          were given preference and that we’re trying to schedule your movie, otherwise 
          it’ll say that we can’t show your requests. If you are not scheduled, DO NOT 
          give up! There are good chances you can show another scheduled movie that another 
          club doesn’t want or can't do. The memo that tells you that you’ve got the reservation 
          looks something like this:
        </p>
        <div class="faqemail">
          <p>
            Dear The Ballroom Dancing Club,
          </p>
          <br>
          <p>
            I am happy to inform you that your club has been selected 
            to show a movie with us for Saturday films in this semester. At this time 
            we are in negotiations with the distributor as to the exact date of this 
            showing. Once this date has been agreed upon by us (UPAC Cinema and the 
            distributor), we will then contact you with the details.
          </p>
          <p>
            Please also bear in mind that you can read the contract 
            available from our homepage to see our terms and conditions. This memo to 
            you DOES NOT constitute a signed contract between you, the club, and us, 
            UPAC Cinema.
          </p>
          <p>
            Thank you for your time and efforts.
          </p>
          <br>
          Sincerely,<br>
          Joshua Ashby,<br>
          Saturday Night Coordinator - UPAC Cinema<br>
        </div>
        
        <div class="heading">
          [<a href="#Top">Top</a>]
        </div>

        <h2>
          <a id="Scheduled">The Movie is Scheduled</a>
        </h2>
        <p>
          Once the date has been settled upon between UPAC and the distributor, we will 
          attempt to contact all the clubs and tell them that their films have been scheduled. 
          At this point a decent amount of time has passed and the request for a movie 
          by a club, and the name associated with that request my have been lost in the 
          shuffle. This is why it is important that if you’re doing a movie with UPAC Cinema, 
          you should <b>FOLLOW UP</b> with us to make sure that we’ve not lost track of 
          you. You should then receive mail to the effect that we either have scheduled 
          one of the movies, or were not able to schedule anything for you. Here is a 
          memo that exemplifies a positive response:
        </p>
        <div class="faqemail">
          <p>Dear Gymnastics Club,</p>
          <br>
          <p>
            I am happy to inform you that your request to show 
            "Addicted to Love" has been decided to be honored. UPAC Cinema has negotiated 
            with the distributor for the date of February 21th, 1998. This is a Saturday, 
            and the show times will be 7pm, 9:30pm. and midnight. If this seems acceptable 
            to you, then you need to take the next step. If for any reason you no longer 
            wish to show this movie, please notify me so that we may make this movie 
            available for someone else to show.
          </p>
          <br>
          <p>
            What is the next step? The contact for your club or 
            the person in your club that is responsible for the club needs to get a 
            copy of the contract and fill it out. A link can be found at directly at 
            <a href="contract.pdf">http://cinema.union.rpi.edu/contract.pdf</a>. 
            Print this out and complete it.
          </p>
          <br>
          <p>
            If you are a union sponsored club, then you want the 
            50/50 option. This basically allows you to take 50% of the profits after 
            overage and expenses and we assume all the risk. If you think you'll do 
            better with the Full option then you may choose to do it, but this option 
            makes you assume ALL of the risk, and you must post $1000.00 in your account 
            to do it. However, you get ALL the profits after overage and expenses. You 
            also PAY US for ALL LOSSES if there are any.
          </p>
          <br>
          <p>
            You need to read the contract, in full, and sign it 
            to the effect that you understand it. Should you have any questions about 
            it, please feel free to call me (276 8585). There is no "Option A", and 
            the cartoons are not available as a matter of choice, if we have them, we 
            will show them. Just put the title of the film in the "Film Title" line, 
            and you can leave the others blank.
          </p>
          <br>
          <p>
            Once you have read the contract and completed it, 
            you need to get it to me. At this point you should contact me so that I 
            can get it, review it, and go over what you need to get ready for the Saturday 
            Film.
          </p>
          <br>
          <p>
            Well, welcome to another glorious semester at RPI!
          </p>
          <br>
          Joshua Ashby,<br>
          Saturday Night Coordinator - UPAC Cinema<br>
        </div>
          
        <div class="heading">
          [<a href="#Top">Top</a>]
        </div>

        <h2>
          <a id="Contract">The Contract</a>
        </h2>
        <p>
          As you can see from the memo, once you’ve been selected to show a movie and 
          it is scheduled, you need to fill out a contract and give it to the SNC before 
          a movie starts. The contract is a binding document between the Club and UPAC Cinema 
          to ensure that all parties have been treated fairly and both understand what 
          they agree to when a movie is &quot;sponsored&quot; by a club. It is very important 
          that you read this contract and sign it to the effect that you <i>understand</i> 
          it. It is especially important if you’re doing a &quot;Full&quot; contract that 
          you understand that it is possible that you can lose you’re $1000.00 that you’re 
          posting in your account.
        </p>
        
        <ul>
          <li><b>Where do I find the contract?</b></li>
        </ul>
        <p>
          The contract can be found in two places:
        </p>
        <ol>
          <li>
            Off the cinema web page:
            <a href="contract.pdf">http://cinema.union.rpi.edu/contract.pdf</a>
          </li>
          <li>At the UPAC Office in Room 3802 at the Union</li>
        </ol>

        <ul>
          <li><b>When do I turn the contract in?</b></li>
        </ul>
        <p>
          You need to sign the contract and turn it in to the SNC at least a week before 
          the scheduled date of the film. The sooner the better since it makes for less 
          stress for the SNC. If you have any questions or special cases, we can work 
          things out with you. Just contact us at the electronic mail or phone number 
          should you need to.
        </p>

        <ul>
          <li><b>What about the options?</b></li>
          <li>
            <i>Cartoons</i> - You have no choice over cartoons. If we have them we 
            will show them
          </li>
          <li>
            <i>&quot;Full&quot; Option</i> - You should talk to your club coordinator 
            in the Admin office about this if you want to do it.
          </li>
          <li>
            <i>&quot;50/50&quot; Option</i> - You should do this if you are Union 
            funded and/or do not want to risk any money to show the movie.
          </li>
          <li>
            <i>Show Times</i> - We can negotiate special times if it is not for a 
            Saturday, otherwise the standard is 7pm, 9:30, &amp; Midnight. This may 
            change slightly if it is a long movie.
          </li>
          <li>
            <i>Account &amp; Subcode</i> - This is where we make your payment, or 
            debit your account. Please make sure that this number is correct.
          </li>
        </ul>
        
        <div class="heading">
          [<a href="#Top">Top</a>]
        </div>

        <h2>
          <a id="Running">Running the Movie</a>
        </h2>
        <p>
        The night of the movie, you'll need to have <i>six</i> members of your club there 
        at all times (according to the contract). These people do not need to be the same 
        six people all night, but at least six people at any given time. We usually split 
        it up this way:
        </p>
        <ul>
          <li>2 people selling tickets,</li>
          <li>1 person ripping tickets,</li>
          <li>1 person selling concessions,</li>
          <li>and the last 2 people doing security inside the theater. </li>
        </ul>
        <p>
        It is your group's responsibility to clean the theater after every show, please 
        make sure that there are enough hands to do this after the movie ends.
        </p>
        <p>
          <b>Concessions</b> - You have the option of selling your own concessions during 
          the movie. You need to tell us (the SNC) if you are going to since we will need 
          to prepare ahead of time if you are. If you do not want to sell concessions, 
          you may have UPAC Cinema sell theirs, however you do NOT get the profits from 
          these sales, nor do you get any "discount." If you sell your concessions, UPAC 
          members do NOT get their discount on your items. Whoever buys the candy needs 
          to tel the SNC if the club expects UPAC Cinema to buy back the concessions. 
          If you do, you must abide by some guidelines. UAPC-CINEMA IS UNDER NO OBLIGATION 
          TO BUY BACK ANY CONCESSIONS FROM THE CLUB. We ask that you follow these guidelines 
          so that we can facilitate your request to buy your concessions back. There are 
          only two: don't buy more than $125.00 worth of 
          food, and don't pay taxes! On many occasions I have seen the profits of a club 
          been wiped out because they've paid taxes. You can get a "no-tax" code from 
          the Administration office, and then find someone willing to take you to the 
          store. Ideally if you know someone who has a <a href="http://www.samsclub.com">Sam's 
          Club</a> or <a href="http://www.bjswholesale.com">BJ's</a> membership, corner 
          them to take you.
        </p>
        <p>Lastly, keep you receipt! We will be unable to buy you concessions back from 
           you if we don't know how much you paid for them. We usually count what is left 
           over, take that percentage of what is left and apply it to the receipt to get 
           a number.
        </p>
        <p>
        <i>Concessions Suggestions</i>: We have gotten these in the past and they sell 
        (from fastest to slowest): Kit Kat, <a href="http://www.m-ms.com">M+M plain &amp; 
        peanut</a>, <a href="http://www.snickers.com">Snickers</a>, Combos, Crunch, Twix 
        Butterfinger, Milky Way, 3 Musketeers, Baby Ruth, Mounds, Starburst.
        <br>
        <i>For sodas</i>: Coke and <a href="http://www.pepsi.com">Pepsi</a> of course, 
        Mountain Dew, Dr. Pepper, Sprite, <a href="http://www.7up.com">7up</a>, Minute 
        Maid Orange, Canada Dry, Snapple Iced tea, AZ Iced tea, and Veryfine Juices.
        <br>
        </p>
        <p>
          <b>Alcohol</b> - Yeah I know it stinks, but we can't let anyone in with alcohol. 
          They can reek of high heaven of it, but no alcohol out side of the body in any 
          container. We are obligated by the institute to follow up on this. If you have 
          belligerent customers, please get the SNC, or another UPAC person to help you 
          before any more confrontation.
        </p>
        <br>
        <p>
          <b>Selling tickets</b> - Before you sell any tickets you will need to fill 
          out a "ticket sales" sheet for accounting purposes. The coordinator on duty 
          that night will give you one and show you how to do this. DO NOT SELL ANY TICKETS 
          prior to completing this sheet. We calculate your profit from these numbers, 
          so it is imperative that you fill it out.
        </p>
        <p>
          While you are selling tickets, you may be approached by another general UPAC Cinema 
          member. He or she will need to announce their name and tell you which team they're 
          on. You then need to check with the coordinator to make sure that this checks 
          out before you give them their free ticket.
        </p>
        <p>
          Generally we say kiddies get in for free, and we say 10-12 is the cut off year 
          of age for that. You can negotiate that number with the SNC if you wish to change 
          it.
        </p>
        <br>
        <p><b>Ripping Tickets </b>- Please make sure that the people who are ripping tickets 
          at the door rip everyone's ticket and keep the stubs. We do NOT throw the extra 
          stubs in the trash, we keep them. Please be aware of this.
        </p>
        <br>
        <p>
          <b>Letting People In: </b>- Please do not let people in until you get authorization 
          from the SNC, or the projectionist. We (UPAC) has to make sure the quality of 
          the film and equipment is ready. This may requre us to run some test film or 
          such activities, and we do not want people in the theater when this happens. 
          So, again, DO NOT let people in until a UPAC coordinator or projectionist indicates 
          that the theater is ready.
        </p>

        <div class="heading">
          [<a href="#Top">Top</a>]
        </div>
        
        <h2>
          <a id="Submit">Submit a Request</a>
        </h2>
        <p>
          Fill out <a href="request.php">this</a> form. An email containing your request information will be
          sent to the UPAC Cinema Officers.
        </p>
        
        <hr>
        &nbsp;
    </div>
        
    <div id="pagebottom"><a href="index.php">Return To Schedule</a></div>
    
</div>

</body>
</html>