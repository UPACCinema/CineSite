#!/usr/bin/perl
use strict;
use warnings;
use CGI qw/:standard/;
use CGI::Carp qw/fatalsToBrowser warningsToBrowser/;

print header();
print start_html('PPM Results');
warningsToBrowser(1);


my $cmd = "ppm install IMDB::Movie";
my $pid = open(my $PH, "$cmd 2>&1 |") or die "Cannot open ppm command: $!";
print "<pre>\n";
while (<$PH>) { 
  print;
}                

print "</pre>\n";
print end_html;
