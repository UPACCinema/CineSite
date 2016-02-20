#!/perl.exe
use strict;
use warnings;
use CGI ":standard";
use CGI::Carp qw(warningsToBrowser fatalsToBrowser);
use Data::Dumper;

print header, start_html('Installed Modules');

print "Script Name: $0<br>\n";

#foreach (keys %ENV){
#	print "$_ => $ENV{$_}<br>\n";
#}
my $core = `perldoc perlmodlib`;
my $installed = `perldoc perllocal`;

$\ = "<br>\n";
print "Installed Modules:";
print pre($installed);
print "Core Modules:";
print pre($core);

print end_html;