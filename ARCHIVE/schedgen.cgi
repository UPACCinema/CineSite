#!/usr/bin/perl
use warnings;
use strict;
use CGI qw (:standard);
use CGI::Carp qw(fatalsToBrowser warningsToBrowser);
use LWP::Simple qw(!head);
use Net::FTP;

print header();
#my $img = get('http://ia.imdb.com/media/imdb/01/I/47/14/36m.jpg');
print start_html('Trying');
print start_multipart_form(-method=>'post');
print filefield(-name=>'file');
print submit();
print endform();

if (my $file = param('file')) {

	my $name = "$file";

	print "File uploaded: $name<br>\n";
	{ last; 
		 my ($host, $user, $pass) = qw(upac.cinema.union.rpi.edu upac-cinema projector);
		 my $ftp = Net::FTP->new($host, Debug => 0)
		   or die "Cannot connect to some.host.name: $@";

		 $ftp->login($user,$pass)
		   or die "Cannot login ", $ftp->message;

		 $ftp->cwd("cinema/images")
		   or die "Cannot change working directory ", $ftp->message;

		 $ftp->binary()
			or die "Cannot set binary mode ", $ftp->message;

		 $ftp->put($file, $name)
		   or die "put failed ", $ftp->message;

		 $ftp->quit;
	}

}


print "Should be done now<br>\n";
print end_html();
