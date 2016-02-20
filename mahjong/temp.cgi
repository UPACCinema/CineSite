#!/usr/bin/perl

use CGI qw(:standard);
use DBI;
use Data::Dumper;

print header;
print start_html();

sub sqlerr($){
    print header;
    print start_html("Error!");
    print "Database Error: " . $dbh->errstr . "<br>\n";
    print "SQL: $_[0]<br>\n";
    print end_html();
    exit();
}

if (!($dbh = DBI->connect("DBI:mysql:upaccinema:cinema.union.rpi.edu", "upaccinema", "kjfs923"))){
    sqlerr("(No SQL)");
}

$sql = "INSERT INTO temp (foo) VALUES (0);";
if (!($sth = $dbh->prepare($sql))){
    print "(PREPARE)<br>\n";
    sqlerr($sql);
}
print "<pre>\n";
print "<br><br>After Prepare<br>\n";

print "sth<br>\n";
print Dumper(\$sth);
print "<br>\n";
print "dbh<br>\n";
print Dumper(\$dbh);
print "<br>\n";

if (!$sth->execute()){
	print "(EXECUTE)<br>\n";
	sqlerr($sql);
}

$rv= $dbh->{'mysql_insertid'};
#$rv = $dbh->last_insert_id(undef, undef, undef, undef);
print "RV: $rv<br>\n";

print "<br><br>After Execute<br>\n";

print "sth<br>\n";
print Dumper(\$sth);
print "<br>\n";
print "dbh<br>\n";
print Dumper(\$dbh);
print "<br>\n";
print "</pre>\n";



print end_html;


