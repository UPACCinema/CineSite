#!/usr/bin/perl
use warnings;
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser);

print header();
print start_html();
print "$_ => $ENV{$_}<br>\n" foreach sort keys %ENV;
print end_html();
