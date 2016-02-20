#!/perl.exe -w
use warnings;
use strict;
use CGI qw(:standard);
use CGI::Carp qw(warningsToBrowser fatalsToBrowser);

use CGI::Session;

print header;
print start_html 'hello world';
print "Hello World<br>\n";
print end_html;