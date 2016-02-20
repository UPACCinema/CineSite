#!/perl.exe

use warnings;
use strict;
use CGI qw(:standard);
use CGI::Carp qw(warningsToBrowser fatalsToBrowser);
use POSIX qw(strftime);

print header;
my ($format, $string);
for ('a'..'z','A'..'Z'){
	$format .= "$_ : %$_<br>\n";
}
$string = strftime($format, localtime);

print "$string<br>\n";
