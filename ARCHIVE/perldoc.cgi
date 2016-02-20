#!/usr/local/bin/perl
use warnings;
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser warningsToBrowser set_message);
warningsToBrowser(1);
use strict;

print header();

my $title = "RPI Union Perldoc Interface";
my $arg;

if (!param('arg')){
  print start_html($title);
} else {
  my $arg = param('arg');
  if ($arg !~ /^([-\s\w]+)$/){
    print start_html("$title - Invalid Request");
    print "`perldoc $arg` cannot be run due to security concerns.\n", br,br;
    print "Please try again:\n",br,br;
  } else {
    $arg = $1;
    print start_html("$title - $arg");
    
    print "`perldoc $arg` returns:",br,pre(`perldoc $arg`),br,br,"\n";
  }
}

local $\ = "\n";
print "Enter arguments to be fed to `perldoc`:";
print startform();
print textfield(-name=>'arg', -value=>$arg);
print submit (-name=>'submit', -value=>'Lookup documentation');
print endform();

if (my $test = param('test')){
  print pre(`$test`);
}

print end_html();


