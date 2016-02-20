#!/usr/local/bin/perl 
use warnings;
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser warningsToBrowser set_message);
warningsToBrowser(1);

print header();
print start_html('test');
print "here I am!", br, "\n";
print end_html;
