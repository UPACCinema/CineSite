#!/usr/bin/perl


use Mail::Sendmail;

use CGI ":standard";

%mail = (
         SMTP => 'mail.rpi.edu',
         from => 'from@rpi.edu',
         to => 'healer@rpi.edu',
         subject => 'Test mail',
		 body => 'Body of message'
        );

#my (%mail);

#$mail{SMTP} = "mail.union.rpi.edu";

#$mail{subject}='Saturday Film Request';

#$mail{To} = "parked@rpi.edu";

#$mail{From}=param('cmail');

#$mail{Message}="Test Message";
#$mail{Message}="Saturday Film Request\nClub: " . param('club') . "\nContact Info: " . param('cname') . "\nContact Email " . param('cmail') . "\nPayment Option: " . param('pay') . "\n 1st choice film: " . param('first') . "\n2nd Choice film: " . param('second') . "\n3rd Choice film: " . param('third') . "\n4th Choice film " . param('fourth') . "\n Desired Month: " . param('date') . "\n";


sendmail (%mail) or die "Sendmail Error!";


print header;
print start_html("Thank you!");
print "$mail{Message} <br>";
print "$mail{To} <br>";
print "$mail{From}<br>";
print "<P>You movie request has been mailed to upac-cinema.  You will be contacted within the next two days";
print "@params";
print Dump();
print "\n</p></body></html>";
