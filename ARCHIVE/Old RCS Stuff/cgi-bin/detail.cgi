#!/usr/interp/perl

require 'cgi_handlers.pl';
require 'cinema_lib.pl';

$db_home = "/dept/union/cinema/data/";
$db = "spring95.db";

@month = (Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec);
@daylist = (Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday);

&get_request;
$search_db = $rqpairs{"db"};
$search_month = $rqpairs{"month"};
$search_date = $rqpairs{"date"};
$search_title = $rqpairs{"title"};
$search_rating = $rqpairs{"rating"};
$search_sponsor = $rqpairs{"sponsor"};

# &html_header( "UPAC Cinema: $title" );

if ($search_db eq "") {
   $foo = $db_home.$db;
} else {
   $foo = $db_home.$search_db;
}

open(FILE,"$foo") || die "$db: $!\n";
while($datastrip = <FILE>) {
   chop $datastrip;
   ($date,$remainder) = split(/\|/,$datastrip,2);
   if (index($date,"#") == -1) {
      $description = "";
      while (<FILE>) {
         last if /^ *$/;
         $description .= $_;
      }
      local($m,$d,$y) = split(/\//,$date);
      local($foodate,$title,$cast,$sponsor,$rating,$time) = split(/\|/,$datastrip);
      if($search_month == $m) {
         if(($search_date ne "" && $search_date == $d) || $search_date eq "") {
            &html_header( "UPAC Cinema: $title" );
            print "<b>Movie Information: $title</b>\n<hr>\n\n";
            &print_detail( $datastrip,$description );
            $search_complete = 1;
         }
      }
   }
}
close(FILE);

if ($search_complete == 0) {
   &html_header( "UPAC Cinema: Unsuccessful Search" );
   print "<b>No match to your query</b><hr>\n";
}

print "<p> <i>\n";
print "<a href=\"index.cgi\">Return to movie list</a> |\n";
print "<a href=\"http://www.rpi.edu/dept/union/cinema/htdocs/index.html\">UPAC";
print " Cinema</a>";
print "</i>\n";

&html_trailer;
