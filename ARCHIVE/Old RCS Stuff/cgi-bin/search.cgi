#!/usr/interp/perl

require 'cgi_handlers.pl';
require 'cinema_lib.pl';

$db = "/dept/union/cinema/data/spring95.db";

@month = (Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec);
@daylist = (Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday);

&get_request;
$search_month = $rqpairs{"month"};
$search_date = $rqpairs{"date"};
$search_title = $rqpairs{"title"};
$search_rating = $rqpairs{"rating"};
$search_sponsor = $rqpairs{"sponsor"};

&html_header( "UPAC Cinema: Search Results" );

print "$m<p>$d<p>\n";

open(FILE,"$db") || die "$db: $!\n";
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
      if($search_month == $m) {
         if(($search_date ne "" && $search_date == $d) || $search_date eq "") {
            print "\n<hr>\n\n";
            &print_detail( $datastrip,$description );
         }
      }
   }
}
close(FILE);

&html_trailer;
