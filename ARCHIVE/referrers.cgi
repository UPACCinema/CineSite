#!/usr/bin/perl 
use warnings;
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser warningsToBrowser set_message);
warningsToBrowser(1);
use DBI;
use DBD::mysql;
use Data::Dumper;
use strict;
use URI;

BEGIN{
  set_message(q(Please email Paul at <a href="mailto:plalli@gmail.com?subject=Cinema Referrer Error">plalli@gmail.com</a> informing him of the exact text of the message above.));
}

print header();
print start_html(-title=>'UPAC Cinema Referrers stats',-style=>{-src=>'cinema.css'});

my ($dbh, $sth, $sql); #Database variables


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

if (!($dbh = DBI->connect("DBI:mysql:upaccinema:cinema.union.rpi.edu", "upaccinema", "kjfs923"))){
  sqlerr("(No SQL)");
}

$sql = "SELECT referer FROM accesses WHERE referer IS NOT NULL AND page='index'";
$sth = sqlquery($sql);

my %referrers;
my %queries;

while (my $h = $sth->fetchrow_hashref){
  my $referrer = $h->{referer};
  my $URI = new URI($referrer);
  my %query = $URI->query_form();
  $referrers{$URI->authority}++;
  if ($URI->authority =~ /google/){
    no warnings 'uninitialized';
    if ($query{domains} eq 'rpi.edu' or $query{sitesearch} eq 'rpi.edu' or $URI->path =~ /univ\/rpi/){
      $queries{'rpi-google'}{$query{q}}++;
    } else {
      $queries{'google'}{$query{q}}++;
    }
  }
			       
}

$sql = "SELECT agent FROM accesses WHERE agent IS NOT NULL AND agent LIKE '%bot%' AND page='index'";
$sth = sqlquery($sql);

my %bots;
while (my $h = $sth->fetchrow_hashref){
  my $agent = $h->{agent};
  if ($agent =~ /^\s*(\w*bot\w*)\/|(\S*bot\S*)/i){
    $bots{$+}++;
  } else {
    print "<!-- '$agent' did not match -->\n";
  }
}


print qq|<table width="100%">
  <tr valign="top">
    <th width="50%">Referrers to UPAC Cinema:</th>
    <th>Google Queries leading to UPAC Cinema:</th>
  </tr>
  <tr valign="top">|;

print td(table ( Tr (map {th($_)} qw/Site Referrals/) . "\n",
		 (map {Tr(td($_), td($referrers{$_})) . "\n"} 
		 sort 
		 {$referrers{$b} <=> $referrers{$a} or $a cmp $b}
		 keys %referrers),
	      
		 Tr (map {th($_)} qw/Bot Hits/),
		 (map {Tr(td($_), td($bots{$_})) . "\n"} 
		 sort 
		 {$bots{$b} <=> $bots{$a} or $a cmp $b}
		 keys %bots),
	       ),
	);
print td(table ( Tr (map {th($_)} ('Google.com Query', 'Referrals')) . "\n",
		 (map {Tr({-valign=>'top'}, td($_), td($queries{'google'}{$_})) . "\n"} 
		 sort 
		 {$queries{'google'}{$b} <=> $queries{'google'}{$a} or $a cmp $b}
		 keys %{$queries{'google'}}),

		 Tr (map {th($_)} ('RPInfo Query', 'Referrals')) . "\n",
		 (map {Tr({-valign=>'top'}, td($_), td($queries{'rpi-google'}{$_})) . "\n"} 
		 sort 
		 {$queries{'rpi-google'}{$b} <=> $queries{'rpi-google'}{$a} or $a cmp $b}
		 keys %{$queries{'rpi-google'}}),
	       )
	);
print "</tr></table>\n";

$sql = "SELECT COUNT(*) FROM accesses WHERE referer IS NULL";
my $ref = $dbh->selectall_arrayref($sql);
print "<!--".Dumper($ref)."-->\n";
print "Note: There are an additional $ref->[0][0] hits which did not supply an HTTP Referer.\n";

$sql = "SELECT COUNT(*) FROM accesses";
$ref = $dbh->selectall_arrayref($sql);
print "($ref->[0][0] hits total)<br>\n";

$sql = "SELECT MIN(date) FROM accesses";
$ref = $dbh->selectall_arrayref($sql);
print "These statistics record hits to the main UPAC Cinema webpage (http://cinema.union.rpi.edu/index.php) beginning at $ref->[0][0]<br>\n";

print end_html;
