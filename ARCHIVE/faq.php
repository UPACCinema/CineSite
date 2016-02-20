<?php
$user = "upaccinema";
$pass = "kjfs923";
$dbname = "upaccinema";
$link = mysql_connect("db.union.rpi.edu", $user, $pass);
mysql_select_db($dbname);
?>

<?php
   #for the hell of it, I want to see who visits our page and how often
   $subj = "UPAC Cinema FAQ visited";
$from = "UPAC Cinema <upac-cinema@rpi.edu>";
$to = "plalli@gmail.com";
$date = date('l, n/j/y \a\t g:ia');
$body = "On $date, someone visited UPAC Cinema's FAQ page.  Server info follows:\n";
$ip = $_SERVER['REMOTE_ADDR'];
$host = gethostbyaddr($ip);
$body .= "Host: $host ($ip)";
if (array_key_exists('HTTP_REFERER', $_SERVER)){
  $refer = $_SERVER['HTTP_REFERER'];
  $body .=", referred by $refer.";
} 
if (array_key_exists('HTTP_USER_AGENT', $_SERVER)){
  $agent = $_SERVER['HTTP_USER_AGENT'];
  $body .= "\nThe user was browsing with: $agent\n";
}
#mail ($to, $subj, $body, "From: $from\r\n");
$sql = "INSERT INTO accesses SET `date`=NOW(), page='faq', IP='$ip', host='$host'";
if (isset($refer)) { $sql .= ", referer='".addslashes($refer)."'"; }
if (isset($agent)) { $sql .= ", agent='".addslashes($agent)."'"; }
$sql .= ";";
$result = mysql_query($sql);
if ($err = mysql_error()){
  echo "<!--ERROR: $err\nSQL: $sql\n-->\n\n";
}

?>
<html>
<head>
<title>UPAC Cinema Frequently Asked Quesitons</title>
<link rel="stylesheet" type="text/css" href="cinema.css">
<style type="text/css">
   p {
      font-style:italic;
      margin-bottom:0px;
      padding-bottom:0px;
	padding-top:0px;
	margin-top:0px;
      font-weight:bold;
      font-size:larger;
   }
   ol#nav li {
     margin:0px;
     padding:0px;
   }
   li {
      margin-top:10px;
	padding-top:0px;
   }
   h1 {
      text-align:center;
   }
</style>
</head>
<body>
<h1><a href="/"><img src="images/upac_cinema.png" alt="UPAC Cinema" border="0"></a><br>
Frequently Asked Questions</h1>

<h3>This FAQ is a work-in-progress.  Feel free to suggest additional
questions, and please be patient while we complete the answers to all
current questions.</h3>

<?php

$faqs[] = array('q'=>'What is UPAC? What is UPAC Cinema?', 'a'=>'UPAC
is the Union Programs and Activities Committee. Technically, it is a
standing committee of the RPI Student Union\'s Executive
Board. Practically, UPAC is a collection of student-run clubs
(officially sub-committees) with the common purpose of providing the
campus community with a variety of entertainment events. Currently,
the existing sub-committees are: UPAC Cinema, UPAC Comedy, UPAC
Lights, UPAC Sound, Mother\'s Wine Emporiem, UPAC Concerts, and The
Union Speakers Forum. <br><br> UPAC Cinema is a subcommittee of the
Union Programs and Activities Committee. It exists as a
student-managed and student-operated second run 35mm movie
theatre. UPAC Cinema\'s purpose is to provide the Rensselaer community
with motion picture entertainment.'); 

$faqs[] = array('q'=>'How do you pronounce UPAC?',
'a'=>'&quot;You-Pack&quot;'); 

$faqs[] = array('q'=>'What is UPAC Cinema\'s relationship with other
UPAC organizations?', 'a'=>'Historically, the seperate UPAC
organizations have been run very independently. While there is some
cooperation between the subcommittees (UPAC Lights and UPAC Sound
often provide their services to the same event, for example), they are
organized, staffed, and managed by wholly different groups of
students. There is, of course, nothing preventing any particular
student from joining more than one subcommittee. <br><br> In recent
years, an effort has been made to more closely allign the different
subcommittees. A "Programming Board" (P-Board) has been formed,
comprised of the chairpersons of each subcommittee. The P-Board\'s
goals include scheduling a showcase each semester which involves all
the UPAC organizations. Even with the existance of the P-Board,
however, each organization\'s operations are still distinct.'); 

$faqs[] = array('q'=>'What is UPAC Cinema\'s relationship with other
Union clubs?', 'a'=>'UPAC Cinema offers Union-recognized clubs the
opportunity to sponsor a UPAC Cinema movie. This provides the club
with both the ability to advertise or promote its events, as well as a
fundraiser. Most clubs take the "50-50" option when sponsoring a
movie. This means that UPAC Cinema will front the cost of the film,
shipping, and projectionist, and the club will provide the manpower
(other than a projectionist). If the movie makes a profit (after
deducting the cost of the film, shipping, and projectionist), UPAC
Cinema and the club split the profits 50/50. If the movie does not
make a profit, the loss is taken soley by UPAC Cinema, and the club is
not responsible. <br><br> Daring clubs (and any non-Union-funded
organizations) can take the "Full option" instead of 50-50. This means
that the club or organization will front the full cost of the movie -
film, shipping, projectionist, and manpower. Should the movie make any
profit at all, that money goes directly do the club. If it does not,
the club will be at a loss, and UPAC Cinema will not be
responsible. <br><br> Regardless of the option chosen, a sponsoring
club is also permitted to sell their own concessions during the
movie. Should a club elect to sell concessions, UPAC Cinema will agree
not to sell its own concessions on that night. Any profits made from
the sale of concessions will then belong to the club.'); 

$faqs[] = array('q'=>'On what kind of media are your movies shown?',
'a'=>'UPAC Cinema shows movies on 35mm film, the standard in the
motion picture industry. On rare occasions (special events located
outside the theatre, or very old or hard to locate films), we will use
16mm films and projectors. We do <strong>not</strong> simply project
DVDs or VHS tapes.'); 

$faqs[] = array('q'=>'What kind of equipment do you use?', 'a'=>'Our
projectors are two standard 35mm projector assemblies (affectionately
nicknamed &quot;Goblin&quot; and &quot;One-Eye&quot;).  Our sound
system is a Dolby CP65 Cinema Processor.  Every year, UPAC Cinema
requests a sum of money to be put into an account which will
eventually be used to upgrade the sound system.  Any year now. . . ');

$faqs[] = array('q'=>'What is a \'film series\'?', 'a'=>'A film series
is a category of movies that UPAC Cinema shows. Each series is managed
and operated slightly differently. There are currently four film
series in operation. The POP Films are the series of movies shown
every Friday night. These are the most recent, most popular 2nd run
films we can get a hold of. Club Films are movies shown every third
Saturday. These are films that are sponsored by other Union clubs and
organizations, both as a fundraiser and as a means of advertising for
the sponsoring club. Clubs are allowed to choose any movies they want
for this series - provided, however, that UPAC Cinema has not chosen
it for a POP Films movie. MidWeek and Repertory Films are the two
series which used to alternate every Wednesday. They now fall into a
once-per-three-week Saturday rotation with Club Films. MidWeek Films
are a combination of both movies that could be POP Films if we had more
room in the schedule, as well as "New Classics" - movies that might
have been POP Films a few years earlier. Repertory Films are movies
that tend to appeal to a slightly smaller crowd. These include Cult
Classics, Art films, and Foreign films. <br><br> A different elected
UPAC Cinema officer is in charge of each film series. The Friday Night
Coordinator (FNC) is responsible for POP Films. The Saturday Night
Coordinator (SNC) is responsible for the Club Films. The Midweek
Coordinator (Mid) and Reperatory Coordinator (Rep) are in charge of
the Midweek and Repertory series, respectively.'); 

$faqs[] = array('q'=>'How is UPAC Cinema funded?', 'a'=>'UPAC Cinema
is subsidized by the RPI Student Union. Each year, UPAC Cinema (along
with all other student clubs) submits a proposed budget to the
Executive Board, detailing our expected costs and income. The
Executive Board then decides how much money to give to UPAC Cinema for
the coming year. In addition to the financial contribution of the
Union, UPAC Cinema uses its income from the ticket sales and the
selling of concessions to help pay its operating costs.'); 

$faqs[] = array('q'=>'What is the operating budget of UPAC Cinema, and
what does it cover?', 'a'=>'Each Spring, UPAC Cinema submits a
requested budget to the Union\'s Executive Board. The following
year\'s actual budget is decided by the E-Board after a series of
reviews, decisions, and appeals. For the 2004-2005 academic year, UPAC
Cinema\'s budget is aproximately $62,000. Among the line items this
amount covers are: Rental of about 52 Friday and Saturday films;
Rental of 3 or 4 Wednesday films (back for 2004-2005 on a trial
basis); shipping fees for all films; trailers and posters for as many
of our movies as we can purchase; publicity materials such as the
weekly posters hung on Campus Notice boards and semesterly schedules
printed four times each year; and projectionists\' payroll. <br><br>
All activity-fee paying students are entitled to view the budgets of
any Union club. To see UPAC Cinema\'s (or any other club\'s) budget,
go to the Admin office of the RPI Union, and ask to speak with Martha
McElligott.'); 

$faqs[] = array('q'=>'Are UPAC Cinema members paid?', 'a'=>'Qualified
Projectionists are the only paid position in UPAC Cinema. These are
the students who spend between one and three semesters training to
learn how to operate the projection equipment to show UPAC Cinema
films. They are paid an hourly rate for the time they spend projecting
each film. Each film is projected by one projectionist. The number of
QPs in UPAC Cinema varies greatly, from as few as 2 to as many as
15. <br><br> All other members of UPAC Cinema are volunteers. They
help to operate UPAC Cinema\'s events for fun and for a small set of
member benefits (see below). They do not receive any financial
compensation from UPAC Cinema or from the Union.'); 

$faqs[] = array('q'=>'On what days and times are movies shown?',
'a'=>'Movies are shown every Friday and Saturday evening throughout
the academic year. (No movies are shown during school vacation
weeks). Standard showtimes are 7pm, 9:30pm, and 12am. These times are
occasionally altered for longer films. <br><br> Throughout the
academic year, UPAC Cinema tries to hold a few special events movies
on non-standard days and times. These include Weekend Matinees of
films that appeal to families with children, a special GMWeek
presentation of The Rocky Horror Picture Show, Sneak
Previews, and film shorts during the semi-annual UPAC Showcase. 
<br><br> UPAC Cinema\'s current schedule, including day and 
times, can always be found at <a
href="http://cinema.union.rpi.edu">http://cinema.union.rpi.edu</a>. We
also advertise our showtimes via weekly posters hung around campus,
one-sheet posters in the DCC and Union, ads in the Polytechnic, and on
the RPInfo Campus Events calendar. (Note that the Poly and Events
calendar have been known to get the times wrong - always check our
website to verify). <br><br> Prior to the 2002-2003 academic year,
UPAC Cinema also showed movies on Wednesday nights at 7pm and
10pm. These days were eliminated due to a decreased budget. Starting
in 2004-2005, UPAC Cinema is bringing back our Wednesday films on a
trial basis. Check our website for our full schedule.'); 

$faqs[] = array('q'=>'How much does admission cost?', 'a'=>'A single
ticket for one showing of a UPAC Cinema film is $2.50. Cash only is
accepted for single tickets. UPAC Cinema also sells &quot;Bulk
Passes&quot;. These cost $25 and are good for 13 shows. Bulk Passes do
not expire. They can be paid for either with cash, or by charging the
cost to your student bursar account.  (Once purchased, Bulk Passes are 
non-refundable in whole nor in part and cannot be replaced if lost or stolen).'); 

$faqs[] = array('q'=>'What is a Sneak Preview?', 'a'=>'Occasionally, a
movie studio wants to get the public talking about an upcoming
film. One way they do this is by releasing the film to a limited
number of locations, aproximately one week before its national
release. UPAC Cinema usually manages to acquire one or two of these
sneak previews each year. Because the film studio gives us these
&quot;sneaks&quot; to increase their own advertising, there is no cost
for admission. A sneak preview is shown only once, generally on a
Tuesday or Thursday evening. The film studio requires UPAC Cinema to
hand out passes for the week prior to the film. They can generally be
obtained in the Union\'s Admin office. It is very important to note
that a pass does <strong>not</strong> guarantee admission to the
film. To ensure that we have a full house, we are required to give out
many more passes than the theatre can accomodate. For this reason, the
passes have the phrase "First Come First Served" printed on them. When
you show up to the theatre, you can exchange your pass for an
admission ticket. An admission ticket <strong>does</strong> guarantee
admission to the film. For popular sneak previews, it is recommended
that you arrive, with a pass, well in advance of the show. (Some
customers have been known to arrive 3 hours early... or more).'); 

$faqs[] = array('q'=>'What are the jobs and benefits of UPAC Cinema
members?', 'a'=>'There are four main jobs available to all general
members of UPAC Cinema: Selling Tickets, Ripping Tickets, Selling
Concessions, and Security. These jobs are open to all members who come
to any show. The film\'s coordinator will usually decide which members
will work each position for each showing. <br><br> In addition to
these positions, a member can elect to become a
Projectionist-In-Training (PIT). PITs work with Qualified
Projectionists, learning how to operate the projection equipement. The
training process generally lasts between one and three semesters. When
the QPs believe a PIT is ready, the PIT is tested. If the PIT passes,
the PIT becomes a QP. All QPs are paid to project the UPAC Cinema
movies. <br><br> Members who desire a deeper involvement in UPAC
Cinema can run for an officer position. Officers are elected at the
end of the Fall semester. Officers have additional duties and
responsibilities beyond those of the general members. <br><br> All
members who fullfill an 8 show/semester requirement are entitled to
member benefits. These benefits include: 25&cent; off concessions while
working, free food (generally pizza or Chinese) on nights they work,
one free ticket to each non-Club-sponsored movie for that member\'s
own use, admission to each movie\'s preview conducted by the QP a day
or two before the show, and entry into the semesterly poster
lottery.'); 

$faqs[] = array('q'=>'How can I join UPAC Cinema?', 'a'=>'Joining is
very easy. UPAC Cinema will have a table at the annual Activities Fair
in the first week of the fall semester. There, you can sign up for
Cinema\'s mailing list, and you will be notified of the date and time
of our first meeting. If you cannot make the Activities Fair, or you
want to join after the fair, simply come to any of our movies in DCC
308. Ask to speak to an officer, and express your interest in
joining. <br><br> There are no membership dues or fees of any kind for
being a member of UPAC Cinema. You can work as little or as often as
you wish (though to receive benefits, you must fulfil an eight-show
requirement - see above).'); 

$faqs[] = array('q'=>'What is involved in being a projectionist?',
'a'=>'The process towards becoming a Qualified Projectionist starts
with talking to a current QP. They can explain to you everything
involved in the job of projecting UPAC Cinema movies. Some of the
duties include: Assembling ("building") the films from several small
reels onto two large reels; projecting a test-run (preview) of each of
your movies (usually one or two days before the movie is shown);
recording statistics such as movie length, film quality, changeover
locations, etc; projecting all three showings of the film on its
night; disassembling ("breaking down") the film back into its small
reels; and of course, training new Projectionists in Training on their
way to becoming QPs. <br><br> Due to the more involved duties of being
a projectionist, QPs are the only paid position in UPAC Cinema. Talk
to a current QP for more information.'); 

$faqs[] = array('q'=>'What\'s with the &quot;Whoop&quot;ing during
trailers?', 'a'=>'This is a long standing tradition in UPAC
Cinema. Some reports from former students have the tradition going back 
as much as 20 years. After the policies, if we have any trailers for upcoming
movies, we show them before the feature presentation. The very short
\'tags\' that precede the trailers have a disturbingly catchy
jingle. At one predefined moment during this tag, a voice on the soundtrack
shouts "WHOOP-WHOOP-WHOOP".  Shortly after these tags came into use, 
UPAC Cinema\'s customers started chanting along with these Whoops.  Thus, 
a tradition was born. Somewhere along the way,
a side tradition was developed of replying to the Whoop\'ing customers
with a hearty bellow of "Shut up, Geek!". In more recent years, this
side tradition somehow morphed into the rather nastier reply that
exists today. (UPAC Cinema, of course, neither condones nor in any way
prohibits such phraseology, though our customers would do well to take
into account the demographic make-up of the audience before engaging
in this tradition - especially during any "kid" films, or perhaps
during Family weekend...). <br><br> Should you ever come to a less 
popular show, you may be able to hear that the Whoop\'s are in fact 
still part of the sound track of the trailer tag.'); 

$faqs[] = array('q'=>'Why don\'t you sell popcorn at concessions?', 
'a'=>'Very simple.  UPAC Cinema members have to clean up after our customers 
after each show.  To clean up Popcorn, we\'d have to take a broom to every 
level of the entire DCC 308, rather than just walk up and down the stairs
picking up candy wrappers and cans and bottles.');

$faqs[] = array('q'=>"What's that game you're playing?", 'a'=>"We play a
variety of games in the hours between needing to sell tickets and restock
the concessions.  At any given moment, you may see us playing 
<a href='http://www.ninedragons.com/'>MahJong</a>, 
<a href='http://www.mattelgames.com/uno/nonflash/originalpart1.asp'>Uno</a> 
(Mortal Kombat style), 
<a href='http://www.wizards.com/vault/main.asp?x=traditional/dalmuti'>The 
Great Dalmuti</a>, 
<a href='http://www.pagat.com/beating/durak.html'>Durak</a>, 
<a href='http://www.otb-games.com/apples/apples_basic.html'>Apples to Apples</a>, 
<a href='http://www.trivialpursuit.com/'>Trivial Pursuit</a>, 
<a href='http://www.pagat.com/fishing/scopone.html#scopa'>Scopa</a>, 
<a href='http://www.hasbro.com/games/pl/page.viewproduct/product_id.9491/dn/default.cfm'>Risk</a>, 
<a href='http://www.hasbro.com/pl/page.viewproduct/product_id.9475/dn/default.cfm'>Pictionary</a>, 
or any other game we might be trying.  If you're not familiar with whatever 
game we're playing when you walk by, feel free to stop and ask us about it.");

$faqs[] = array('q'=>"Why aren't you playing MahJong correctly?", 'a'=>"We
are.  There's two possible explanations for your confusion.  The most likely
is that the game you're familar with that you were told is 'MahJong' isn't.
The game that uses MahJong tiles all laid out face up about 3 or 4 high in 
which the object is to clear the table by matching tiles is actually called 
'Tai Pei'.  While most variations of Tai Pei use MahJong tiles, the similarity
ends there.  MahJong has far more in common with the card game of Rummy than 
it does with Tai Pei.<br><br>  If you are familar with the actual game of
MahJong, then it's quite likely you are used to a different rule set than we
use.  MahJong is played in many countries throughout the world, and has many
different sets of rules for both playing and scoring.  (The MahJong game
produced by Four Winds comes with 
<a href='http://www.4windsmj.com/kb/help/4winpr01.htm'>over twenty different 
rulesets</a>).  The rules that UPAC Cinema uses are based upon the Hong Kong
rules.  For a brief overview, see the game 'Hong Kong Mahjong' produced
by <a href='http://www.ninedragons.com/'>Nine Dragons</a>.  We do also 
occasionally add in our own rule variants as well.");

$faqs[] = array('q'=>"Did it really bleed for days?", 'a'=>"
<span style=\"font-weight:bold;text-transform:uppercase\">It did not bleed for days!!!
</span>  &nbsp;&nbsp;&nbsp;<span style=\"font-size:8pt\">(If 
you want to understand this one, you'll have to stop by and ask us about it.)</span>");

$faqs[] = array('q'=>"How can I get in touch with UPAC Cinema?", 'a'=>"The best
way, of course, is to stop by any of our movies on a Friday or Saturday night in
the DCC and talk to us.  You can also email us at 
<a href='mailto:upac-cinema@rpi.edu'>upac-cinema@rpi.edu</a>.  Our officers can 
sometimes be found in the UPAC office in the Northwest corner of the third floor
of the Union (phone number 518-276-8585).  During movie nights, you can also try 
calling the projection booth at 518-276-6877.</a>");

$faqs[] = array('q'=>"What is UPAC Cinema's refund policy?", 'a'=>"UPAC Cinema does 
not give cash refunds for any of our shows.  Should circumstances force the 
cancellation of one of our shows, customers will be entitled to receive one free 
ticket to any 
future UPAC Cinema movie (including a later showing of the cancelled film, if 
applicable) upon exchange of their ticket stubs at the table outside the theater.
<br><br>Any customer asked to leave the theatre by UPAC Cinema, Public Saftey, or 
Troy Police as a result of disruptive behavior will not be entitled to any refund
nor exchange.");

?>
<ol id='nav'>
<? $num=0;
   foreach ($faqs as $faq) { 
     $num++;
?>
     <li><a href="#q<?=$num?>"><?=$faq['q']?></a></li>
<? }   
?>
</ol>

<ol>
<? $num = 0;
   foreach ($faqs as $faq) {
     $num++;
?>
   <li><a name='q<?=$num?>'></a>
      <p><?=$faq['q']?></p>
      <?=$faq['a']?>
   </li>
<? } ?>
</ol>




Should you have any questions not covered by this FAQ, please don't
hesitate to ask!  Email <a 
href="mailto:upac-cinema@rpi.edu">upac-cinema@rpi.edu</a>, or stop by
any of our movies to talk to an officer!

</body>
</html>   
   