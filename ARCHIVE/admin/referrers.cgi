#!/usr/local/bin/perl 
use warnings;
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser warningsToBrowser set_message);
warningsToBrowser(1);
use DBI;
use DBD::mysql;
use Data::Dumper;
use strict;
#use URI;

BEGIN{
  set_message(q(Please email Paul at <a href="mailto:plalli@gmail.com?subject=Cinema Referrer Error">plalli@gmail.com</a> informing him of the exact text of the message above.));
}

sub sqlerr($;$$){
  print header;
  print start_html("Error!");
  print "Database Error: " . $dbh->errstr . "<br>\n";
  print "SQL: $_[0]<br>\n";
  print "Line: $_[1]" if $_[1];
  print ", File: $_[2] " if $_[2];
  print "<br>\n";
  print end_html();
  exit();
}

sub sqlquery {
  my ($sql) = @_;
  my $sth;
  if (!($sth = $dbh->prepare($sql))){
    print "(PREPARE)<br>\n";
    sqlerr($sql, __LINE__, __FILE__);
  }
  
  if (!($sth->execute())){
    print "(EXECUTE)<br>\n";
    sqlerr($sql, __LINE__, __FILE__);
  }
  return $sth;
}

my ($dbh, $sth, $sql); #Database variables

if (!($dbh = DBI->connect("DBI:mysql:upaccinema:cinema.union.rpi.edu", "upaccinema", "kjfs923"))){
  sqlerr("(No SQL)");
}

$sql = "SELECT referrer FROM accesses WHERE referrer IS NOT NULL AND page='index'";
$sth = sqlquery($sql);
while (my $h = $sth->fetchrow_hashref){
  local $\ = "\n";
  my $referer = $h->{referrer};
  print $referrer, br;
}
