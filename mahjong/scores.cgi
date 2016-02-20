#!/usr/local/bin/perl
use strict;
use warnings;
use CGI qw/:standard/;
use CGI::Carp qw/fatalsToBrowser warningsToBrowser/;

print redirect('http://cinema.union.rpi.edu/mahjong/scores2.cgi');

__END__
