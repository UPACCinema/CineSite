#!/usr/bin/perl


use Mail::Sendmail;

use CGI ":standard";

if (!param('cname') or !param('club') or !param('cmail') or !param('pay') or !param('first') or !param('terms')or !param('funds') or !param('funds'))
{
print header;	
print "<html><head><title>Sorry!</title></head><body>We can not process your request at this time.  One or more required fields are missing.  Please press the back button on your browser and try again.</body></html>";
}
else
{

my (%mail);

$mail{smtp} = "mail.rpi.edu";

$mail{subject}='Saturday Film Request';

$mail{To} = "upac-cinema\@rpi.edu";

$mail{From}=param('cmail');

$mail{Message}="Saturday Film Request\nClub: " . param('club') . "\nContact Info: " . param('cname') . "\nContact Email: " . param('cmail') . "\nPayment Option: " . param('pay') . "\n1st choice film: " . param('first') . "\n2nd Choice film: " . param('second') . "\n3rd Choice film: " . param('third') . "\n4th Choice film: " . param('fourth') . "\nDesired Month: " . param('date') . ", " . param('year') . "\nRead Club Film Info: " . param('terms') . "\n";


sendmail (%mail) or die "Sendmail Error!";


print header;
print start_html("Thank you!");
print "<P>You movie request has been mailed to upac-cinema.  You will be contacted within the next two days";
print "\n</p></body></html>";
}
