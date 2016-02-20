#!/usr/local/bin/perl
use CGI qw/:standard/;
use CGI::Carp qw/fatalsToBrowser warningsToBrowser/;

print header('text/plain');




use ExtUtils::Installed;
my $instmod = ExtUtils::Installed->new();
foreach my $module ($instmod->modules()) {
my $version = $instmod->version($module) || "???";
       print "$module -- $version\n";
}
