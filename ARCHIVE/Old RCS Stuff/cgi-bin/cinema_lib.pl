#
# library for UPAC Cinema web scripts
# written by Vishal Apte (aptev@rpi.edu)
#

# &day (date)
#	where date is of the form mm/dd/yy
# &print_detail (datastring,description)
#	datastring = all brief information
#	description = verbose information about movie being printed

# written by deven (deven@asylum.sf.ca.us)
# converts a date of form mm/dd/yy and returns day of the week
sub day {
    local($date) = @_;
    local($m,$d,$y,$C,$D,$day);
 
    return "" unless $date;
    ($m,$d,$y) = split(/\//,$date);
    $y += 1900 if $y < 100;
    $m = ($m - 3) % 12 + 1;
    $y-- if $m > 10;
    $C = int($y / 100);
    $D = $y % 100;
    $day = ($d + int(2.6 * $m - .2) - 2 * $C + $D + int($C/4) + int($D/4)) % 7;
    return $day;
}


# &print_foo(datastring, description);
sub print_detail {
   local($datastring) = $_[0];
   local($description) = $_[1];
   local($date,$title,$cast,$sponsor,$rating,$time) = split(/\|/,$datastring);

   ($m,$d,$y) = split(/\//,$date);
   $current = "$m"."$d"."$y";

   # TITLE (WITH LINK TO MOVIE DATABASE)
   # check to see if there is an entry for it on the Movie Database
   print "<a name=\"$current\"> <b>$title</b></a><br>\n";
   $prev = $current;

   # CAST
   print "$cast<br>\n";

   # DAY | DATE
   # extract mm/dd/yy, find day of week and print it
   $tmpday = &day($date);
   print "$daylist[$tmpday] - $d $month[$m-1]<br>\n";

   # TIME | PLACE
   if ($time eq "") {
      if ($tmpday == 3) {
         print "7 PM \& 10 PM - DCC 308<br>\n";
      }
      elsif ($tmpday == 5 || $tmpday == 6) {
         print "7 PM, 9:30 PM \& 12 AM - DCC 308<br>\n";
      }
   }
   else {
      print "$time - DCC 308<br>\n";
   }

   # SPONSOR information and print it
   if ($sponsor eq "R") {
      $sponsor = "Repertory Films";
   }
   elsif ($sponsor eq "M") {
      $sponsor = "Midweek Films";
   }
   elsif ($sponsor eq "P") {
      $sponsor = "Pop Films";
   }
   if ($sponsor eq "") {
      print "<i>Sponsor unknown at this time</i> - $rating\n";
   }
   else {
      print "<i>Sponsored by $sponsor</i> - $rating\n";
   }

   # DESCRIPTION
   print "<p>\n$description\n";
}
1;
