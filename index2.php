<?php
include_once("officers/include/session.php");
include_once("menubar.php");
include_once("TMDb.php");

$tmdb = new TMDb('a1425b80993f31c6030c2af97272750b');

$user = "cinema";
$pass = "n@VSjEV4lG";
$dbname = "cinema_db";
$link = mysql_connect("db.union.rpi.edu", $user, $pass);
mysql_select_db($dbname);

$sched_tbl = "sched_new";

function sqlerr($sql, $file='',$line=''){
  if ($err = mysql_error()){
    echo "ERROR: $err<br>\nSQL: $sql<br>\n";
    if ($file){
      echo "File: $file, line $line<br>\n";
    }
    exit();
  }
}

  //This function is used to put the days in the correct order, soonest occurring
  //movie will be first.
  function ordered ($a, $b){
    $today = date('w')*100 + 2;
    if ($a['n'] < $today and $b['n'] >= $today){
      return 1;
    } elseif ($b['n'] < $today and $a['n'] >= $today){
      return -1;
    } else {
      if ($a['n'] < $b['n']){
        return -1;
      } else {
        return 1;
      }
    }
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
      <link rel="stylesheet" type="text/css" href="newstyles.css">
      <link rel="stylesheet" type="text/css" href="css/skin.css">
      <link rel="icon" href="favicon.ico" type="image/x-icon">
      <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
      <style type="text/css">
           /**
            * Overwrite for having a carousel with dynamic width.
            */
            .jcarousel-skin-tango .jcarousel-container-horizontal {
                  padding:0px 42px;
                  width: auto;
            }

            .jcarousel-skin-tango .jcarousel-clip-horizontal {
                  width: 100%;
            }
      </style>
      <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
      <script type="text/javascript" src="js/jquery.cycle.all.min.js"></script>
      <script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>
      <script type="text/javascript" src="js/jquery.tools.min.js"></script>
      <script type="text/javascript">
            $(document).ready( function() {
                  $(window).load( function() {
                        var windowWidth, windowHeight;
                        
                        $('#noscroll').css('overflow', 'hidden');
                        
                        windowWidth = $(window).width();
                        windowHeight = $(window).height();
                        $('.schedule').each(function(){ $(this).width(windowWidth).height(windowHeight) });
                        $('.slide').each(function(){ $(this).width(windowWidth).height(windowHeight) });
                        $('.schedule_backdrop').each( function() { $(this).css('margin-left', -$(this).width()/2) });
                        
                        
                        $(window).resize( function() {
                              windowWidth = $(window).width();
                              windowHeight = $(window).height();
                              $('.schedule').each(function(){ $(this).width(windowWidth).height(windowHeight) });
                              $('.slide').each(function(){ $(this).width(windowWidth).height(windowHeight) });
                              $('.schedule_backdrop').each( function() { 
                                    if ($(this).css('display') !== 'none') {
                                          $(this).css('margin-left', -$(this).width()/2);
                                    }
                              });
                        });
                        
                        function BackdropFix(currSlideElement, nextSlideElement, options, forwardFlag) {
                              $('> .schedule_backdrop', nextSlideElement).css('margin-left', -$('> .schedule_backdrop', nextSlideElement).width()/2);
                        };
                        
                        function AdvancePager(currSlideElement, nextSlideElement, options, forwardFlag) {
                              var carousel = $('#nav').data('jcarousel');
                              var CycleIndex = $('.schedule').children().index(nextSlideElement)+1;
                              var CarouselFirstIndex = carousel.first;
                              var CarouselLastIndex = carousel.last;
                              var CarouselEndIndex = carousel.options.size;
                              var IsInTail = carousel.inTail;
                              if(CarouselLastIndex == CarouselEndIndex && !IsInTail && CycleIndex != CarouselFirstIndex) {
                                    carousel.scrollTail(false);
                              } else if(CycleIndex == CarouselFirstIndex && IsInTail) {
                                    carousel.scrollTail(true);
                              } else {
                                    carousel.scroll($.jcarousel.intval(CycleIndex),true);
                              }
                        };
                        
                        $('#nav').jcarousel({
                              scroll:     1,
                              wrap:       'both'
                        });
                        
                        $('.schedule').cycle({
                              fx:               'scrollHorz',
                              speed:            1000,
                              after:            BackdropFix,
                              before:           AdvancePager,
                              timeout:          10000,
                              pager:            '#nav',
                              activePagerClass: 'activePoster',
                              pagerAnchorBuilder: function(idx, slide) {
                                    // return selector string for existing anchor
                                    return '#nav li:eq(' + idx + ') a';
                              }
                        });
                        
                        $('.slide').click( function() {
                              $('.schedule').cycle('pause');
                              $('#schedule-resume-tag').fadeIn();
                        });
                        
                        $('.nav-item').click( function() {
                              $('.schedule').cycle('pause');
                              $('#schedule-resume-tag').fadeIn();
                        });
                        
                        $('#schedule-resume-tag').click( function() {
                              $('#schedule-resume-tag').fadeOut();
                              $('.schedule').cycle('resume');
                        });
                        
                        $('#schedule_container').fadeOut();
                        $('#schedule_container').css('display', 'none');
                        $('#schedule_container').css('visibility', 'visible');
                        $('#load_screen').fadeOut();
                        $('#schedule_container').fadeIn();
                        
                        $('.nav-item img[title]').tooltip({ effect: 'slide' });
                        
                  });
            });
      </script>
      <title>UPAC Cinema - Schedule</title>
</head>
<?php
//We want the posters to switch at 2am of the next day, rather than midnight
  if (date('G') < 2){
    $date = date('Y-m-d', strtotime('Yesterday'));
  } else { 
    $date = date('Y-m-d');
  }
  
  $sql = "SELECT * FROM $sched_tbl WHERE date >= '$date' ORDER BY date;";
  $result = mysql_query($sql);
  sqlerr($sql, __FILE__, __LINE__);

  unset($movie);
  
  while ($movie = mysql_fetch_assoc($result)) {
    $movies[]=$movie;
  }
  
  unset($movie);
  if(count($movies) > 0) {
?>
<body id="noscroll">
<?php
    echo "<!-- Top Menu (Navigation) -->
    <div id=\"globalnavbar\">
      <img class=\"logo\" src=\"images/upac_logo.png\" alt=\"UPAC Cinema\" />
      <a href=\"http://www.google.com/calendar/embed?src=do6de78tj36dvop1dari1qq92k%40group.calendar.google.com&ctz=America/New_York\"><img style=\"position:absolute; top:4px; right:4px;\" src=\"images/googlecal.gif\" alt=\"Google Calendar\" /></a>
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
  
  <div id="load_screen">
      <img src="images/schedule-loader.gif" alt="loading image" />
      <p>Loading...</p>
      <noscript>
            <p>This page requires Javascript to be enabled.</p>
            <p>Please enable Javascript or use the Lite schedule</p>
      </noscript>
      <a href="index_lite.php">Lite version</a>
  </div>
<!-- Movie Schedule -->
<div id="schedule_container" class="loading_schedule">
<!--
  <div id="nav_background"  class="transparent_class">&nbsp;</div>
-->
  <a id="schedule-resume-tag" href="#"><img src="images/tags/resume.png" alt="Resume Slideshow" /></a>
  <div id="nav_container">
  <ul id="nav" class="jcarousel-skin-tango">
<?php
  for ($j=0;$j<count($movies);$j++) {
      $movie = $movies[$j];
      echo '<li>';
            echo '<div class="tag">';
                  if (strtotime($date) == strtotime($movie['date'])) {
                        echo '<img src="images/tags/tonight.png" alt="Tonight tag" />';
                  } elseif (strtotime($date) + 86400 == strtotime($movie['date'])) {
                        echo '<img src="images/tags/tomorrow.png" alt="Tomorrow tag" />';
                  } elseif (strtotime($date) + 604800 >= strtotime($movie['date'])) {
                        echo '<img src="images/tags/' . strtolower($movie['day']) . '.png" alt="' . $movie['day'] . ' tag" />';
                  }
            echo '</div>';
            if((strtolower($movie['cost']) == 'free') || ($movie['nrb'] == 1) || ($movie['sneak'] == 1)) {
                  echo '<div class="free-movie">'; 
                  if(strtolower($movie['cost']) == 'free') {
                        echo '<img src="images/tags/free.png" alt="Free tag" />'; 
                  }
                  if($movie['nrb'] == 1) {
                        echo '<img src="images/tags/nrb.png" alt="NRB tag" />'; 
                  }
                  if($movie['sneak'] == 1) {
                        echo '<img src="images/tags/sneak.png" alt="Sneak tag" />'; 
                  }
                  echo '</div>';
            }
            echo '<a class="nav-item" href="#">';
                  echo '<img class="schedule_pager" src="images/';
                  if ($movie['image']) {
                        echo $movie['image'];
                  } else {
                        echo 'noposter.png';
                  }
                  echo '" alt="' . $movie['title'] . ' Poster" title="<p>' . stripslashes($movie['title']) . '</p><span>' . date('M. jS', strtotime($movie['date'])) . '</span>" />';
            echo '</a>';
      echo '</li>';
  }
?>
  </ul>
  </div>
  <div class="schedule">
<?php

  for ($j=0;$j<count($movies);$j++) {
    $movie = $movies[$j];
?>
      <div class="slide">
            <img class="schedule_backdrop" src="images/<?php echo $movie['backdrop'] ? $movie['backdrop'] : "nobackdrop.jpg" ?>" alt="<?php echo $movie['title'] ?> Backdrop" />
            <img class="schedule_poster" src="images/<?php echo $movie['image'] ? $movie['image'] : "noposter.png" ?>" alt="<?php echo $movie['title'] ?> Poster" />
            
            <div class="movie_metadata">
                  <p class="title"><?php echo stripslashes($movie['title']) ?></p>
                  <p>
                        <span style="float:left;"><?php echo date('l, M. jS', strtotime($movie['date'])) ?>,&nbsp;&nbsp;<?php echo $movie['times'] ?></span>
                        <span style="float:right;">&nbsp;&nbsp;&nbsp;<?php echo $movie['cost'] ?></span>
                  </p>
                  <?php if($movie['sponsor']) { ?>
                        <p>
                              <span style="margin-top:0.5em; float:right;"><b>Sponsored by: </b><?php echo stripslashes($movie['sponsor']) ?></span>
                        </p>
                  <?php } ?>
            </div>
            <?php if($movie['imdb'] || $movie['trailer'] || $movie['categories'] || $movie['rating'] || $movie['length'] || $movie['overview']) { ?>
            <div class="movie_overview">
                  <?php if($movie['imdb'] || $movie['trailer'] || $movie['categories']) { ?>
                  <p>
                        <?php if($movie['imdb']) { ?>
                        <a href="http://www.imdb.com/title/<?php echo $movie['imdb'] ?>"><img style="vertical-align:top;" src="images/imdb-logo.png" alt="IMDb" /></a>
                        <?php } 
                        if($movie['trailer']) { ?>
                        <a href="<?php echo $movie['trailer'] ?>"><img style="vertical-align:top;" src="images/youtube_logo.png" alt="YouTube" /></a>
                        <?php } 
                        if ($movie['categories']) { ?>
                        <span>Tags: <?php echo $movie['categories'] ?></span><br>
                        <?php } ?>
                  </p>
                  <?php } 
                  if($movie['rating'] || $movie['length']) { ?>
                  <p>
                        <?php if($movie['rating']) { ?>
                        <span>Rated <img style="vertical-align:middle;" src="images/<?php echo $movie['rating'] ?>.png" alt="<?php echo $movie['rating'] ?>" /></span>
                        <?php }
                        if ($movie['length']) { ?>
                        <span><?php echo $movie['length'] ?> minutes</span><br>
                        <?php } ?>
                  </p>
                  <?php }
                  if ($movie['overview']) { ?>
                  <p><?php echo stripslashes($movie['overview']) ?></p>
                  <?php } ?>
            </div>
            <?php } ?>
      </div>
<?php
  }
  ?>
  </div>
</div>

<?php
  } else {
?>    
<body>
<?php
    echo "<!-- Top Menu (Navigation) -->
    <div id=\"globalnavbar\" style=\"background-color:#000000;\">
      <img class=\"logo\"src=\"images/upac_logo.png\" alt=\"UPAC Cinema\" />
      <ul class=\"dropdown\">
        <li><a href=\"index.php\">Schedule</a></li>
        <li><a href=\"policies.php\">Policies</a></li>
        <li><a href=\"bylaws.php\">Bylaws</a></li>
        <li><a href=\"join.php\">Join</a></li>
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
      <div id="no_movies">
            <p>No movies are currently scheduled.</p>
            <p>Check back soon!</p>
      </div>
<?php
  }
?>

</body>
<!-- not-inept was here -->
</html>