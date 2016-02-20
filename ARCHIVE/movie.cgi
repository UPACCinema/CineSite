#!/usr/bin/perl
use strict;
use warnings;
use CGI qw/:standard/;
use CGI::Carp qw/fatalsToBrowser warningsToBrowser/;
use Data::Dumper;

use lib 'D:/WebSites/cinema/perllib';

use IMDB::Movie;

print header();

print start_html('Testing something...');

my $movie = new IMDB::Movie('terminator');

print pre(Dumper($movie));

print end_html();
