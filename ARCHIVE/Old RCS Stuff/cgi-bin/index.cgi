#!/usr/interp/perl

# (C) vishal apte (aptev@rpi.edu)
# this script just presents all the data in a static form

require 'cgi_handlers.pl';
require 'cinema_lib.pl';

$schedule = "/dept/union/cinema/data/spring95.db";
$semester = "Spring 1995";
$index = "index.html";
$main = "main.html";

if ($ARGV[0] eq "-f") {
   $file = $ARGV[1];
}
else {
   $file = $schedule;
}
open(FILE,"$file") || die "$file: $!\n";

@month = (Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec);
@daylist = (Sun,Mon,Tue,Wed,Thu,Fri,Sat);

# MAIN SCRIPT
&html_header( "UPAC Cinema: $semester" );

print "Movies being shown by UPAC Cinema for the semester of $semester.\n";
print "This list is generated automatically. Additional searching ";
print "functionality\netc. will be available shortly.\n<p>\n\n";

print "<dl>\n";
# title
# cast
# day | date
# time | place (almost always DCC 308)
# sponsor | rating
while($datastrip = <FILE>) {
   chop $datastrip;
   ($date,$title,$cast,$sponsor,$rating,$time) = split(/\|/,$datastrip);
   if (index($date,"#") == -1) {
      $description = "";
      while (<FILE>) {
         last if /^ *$/;
         $description .= $_;
      }
      ($m,$d,$y) = split(/\//,$date);
      $current = "$m"."$d"."$y";

      # DAY | DATE
      # extract mm/dd/yy, find day of week and print it
      $tmpday = &day($date);

      # TITLE (WITH LINK TO MOVIE DATABASE)
      # check to see if there is an entry for it on the Movie Database
      print "<a href=\"http://acm.rpi.edu/thinker-bin/cinema/detail.cgi?month=$m\&date=$d\"> <i>$title</i></a> ";
      print "($daylist[$tmpday], $month[$m-1] $d)<br>\n";
      if ($tmpday == 6) {
         print "<p>\n";
      }
   }
}

print "</dl>\n\n";
print "<hr> <i>\n";
print "<a href=\"http://www.rpi.edu/dept/union/cinema/htdocs/index.html\">UPAC";
print " Cinema</a>";
print "</i>\n";


&html_trailer;
