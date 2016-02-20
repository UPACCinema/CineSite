#!perl.exe
use CGI qw(:standard);
use DBI;
use Data::Dumper;
print header;
print start_html;

{ last;
$" = "<br>\n";
print "Include directories:\n@INC \n";

foreach (@INC){
	if (opendir DIR, "$_"){
		print "Directory: $_:\n";
		while ($file = readdir(DIR)){
			print "  $file<br>\n";
		}
		closedir DIR;
	} else {
		print "Could not open $_: $!<br>\n";
	}

}
}
print "Trying to connect now....";

if ($dbh = DBI->connect("DBI:mysql:upaccinema:cinema.union.rpi.edu", "upaccinema", "kjfs923")){
	print "Connected?!<br>";
} else {
	print "No, didn't think so<br>\n";
}

$sth = $dbh->prepare('SELECT * FROM player') or die "Couldn't prepare statement: " . $dbh->errstr;

$sth->execute();

while ($hash = $sth->fetchrow_hashref){
	foreach (keys %$hash){
		print "$_ : $$hash{$_}<br>\n";
	}
	print "<br>\n";
}

print end_html;