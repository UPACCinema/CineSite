#!/usr/bin/perl
use CGI qw(:standard);

use Mail::Sendmail;

import_names();

print header;
if (!param('auth')){
	print start_html('Authorization missing');
	print "Thank you for your interest in the Preferred Player Card. \n";
	print "Unfortunately, we are unable to process your purchase request ";
	print "without proper authorization.  Please go back and check the ";
	print "box labeled 'I hearby authorize a charge of $20...'\n";
	print "<p>Thank you very much\n";
	print end_html;
	exit();
} 
$msg = "Thank you for ordering an RPI Games Room Preferred Player Card\n";
$msg .= "Following is the information we have received.  If there are any problems with this information, please email GAMESROOM-L-request@lists.rpi.edu\n\n";
$msg .= "Name: $Q::FName $Q::LName\n";
$msg .= "Address: $Q::address\n";
$msg .= "Phone #: $Q::phone\n";
$msg .= "RIN: $Q::RIN\n";
$msg .= "Email: $Q::email\n";
$msg .= "# of cards: $Q::number\n\n";

$msg .= "Your request will generally be processed within one business day. ";
$msg .= "You will be notified via email when your card is ready to be picked up.";

$msg .= "\n\nThank you very much for your order\n";

my %mail;
$mail{smtp} = 'mail.rpi.edu';
$mail{Subject} = "Preferred Player Card order received";
$mail{From} = "GAMESROOM-L-request\@lists.rpi.edu";
$mail{To} = $Q::email;
$mail{Cc} = "GAMESROOM-L-request\@lists.rpi.edu";
$mail{Message} = $msg;

if (!sendmail(%mail)){
	print start_html('An Error has occurred');
	print "We're sorry, there seems to be a problem with the online ordering system.  Please go back and make sure all fields are properly filled in.  If this error persists, please notify <a href='mailto:GAMESROOM-L-request@lists.rpi.edu'>GAMESROOM-L-request@lists.rpi.edu</a> ASAP.  Thank you";
	print "<p>The error received is $Mail::Sendmail::error\n";
	print end_html;
} else {
	print start_html("Thank you for your order");
	$msg =~ s/\n/<br>/g;
	print "$msg";
	print end_html;
}

	



