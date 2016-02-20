#!/usr/bin/perl

use strict;
use warnings;
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser warningsToBrowser);
use ExtUtils::Installed;

print header();
warningsToBrowser(1);
print start_html("Times");


my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);

$year += 1900;
$mon++;

printf "Date/Time: %d/%d/%d %d:%d:%d<br>\n", $mon, $mday, $year, $hour, $min, $sec;

print "Local time: ", scalar(localtime), "<br>\n";

local $, = " ";
print "Local time: ", localtime, "<br>\n";

local $, = "<br>\n";
#print "Modules: ", ExtUtils::Installed->new()->modules();

print end_html();

