#!/usr/bin/perl
use CGI qw(:standard);
use Mail::Sendmail;

my %mail;

$from = param('email');

$mail{smtp} = 'mail.rpi.edu';
$mail{From} = $from;
$mail{To} = "listproc\@lists.rpi.edu";
$mail{Cc} = "lallip\@rpi.edu";
$from =~ s/\@.*//;
$mail{Message} = "subscribe GAMESROOM-L $from\n";

print header;
print start_html("Thank you!");

sendmail(%mail) or print $Mail::Sendmail::error;

print "Thank you for signing up for the Games Room mailing list. ";
print "You should shortly be receiving an email soon asking you to confirm ";
print "your subscription.";

print end_html;
