#!/usr/local/bin/perl 
no warnings;
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser warningsToBrowser set_message);
use DBI;
use Data::Dumper;
use strict;
use Mail::Sendmail;
use DBD::mysql;
use Time::localtime;
use POSIX;
BEGIN{
	set_message(q(Please email Paul at <a href="mailto:lallip@cs.rpi.edu?subject=MahJong Error">lallip@cs.rpi.edu</a> informing him of the exact text of the message above.));
}
warningsToBrowser(1);
#my $v = $DBD::mysql::VERSION;
#print "Version: $v<br>\n";
#exit();


my ($dbh, $sth, $sql, $player_id);
my ($sql2, $sth2, $sql3, $sth3, $sql4, $sth4, $sql5, $sth5);
sub sqlerr($){
    print header;
    print start_html("Error!");
    print "Database Error: " . $dbh->errstr . "<br>\n";
    print "SQL: $_[0]<br>\n";
#    my $rc = $dbh->rollback;
#    if ($rc){
#	print "Changes rolled back.  (I think)\n";
#    } else {
#	print "Tried and failed to roll back changes.  (I think)\n";
#    }
    print end_html();
    exit();
}

sub convert_date($){
	my $stamp = $_[0];
	my ($Y, $m, $d, $h, $i, $s) = ($stamp =~ /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/);
	$Y -= 1900;
	$m -= 1;
	my $str = POSIX::strftime("%A, %B %d, %Y<br>\n%I:%M%p", $s, $i, $h, $d, $m, $Y);
	return $str;
}

sub scoreA{
    my $pts = shift;
    if ($pts >= 10){
	return 64;
    } elsif ($pts >= 7){
	return 32;
    } elsif ($pts >= 4){
	return 16;
    } else {
	return 2 ** $pts;
    }
}

sub scoreB{
    my $pts = shift;
    if ($pts >= 12){
	return 2 ** 12;
    } else {
	return 2 ** $pts;
    }
}

if (!($dbh = DBI->connect("DBI:mysql:upaccinema:cinema.union.rpi.edu", "upaccinema", "kjfs923"))){
    sqlerr("(No SQL)");
}

#$dbh->{AutoCommit} = 0;

if (!($player_id = param('player'))){
    print redirect('http://cinema.union.rpi.edu/mahjong/scores.cgi');
    exit();
}

$sql = "SELECT game.* FROM game NATURAL JOIN played WHERE player_id = $player_id ORDER BY stamp ASC;";
if (!($sth = $dbh->prepare($sql))){
    print "(PREPARE)<br>\n";
    sqlerr($sql);
}

if (!($sth->execute())){
    print "(PREPARE)<br>\n";
    sqlerr($sql);
}

$sql2 = "SELECT fname, lname, player.id FROM played, player WHERE played.player_id = player.id AND game_id = ? ORDER BY fname";
$sql3 = "SELECT * FROM player WHERE id = ? ORDER BY fname";
$sql4 = "SELECT SUM(points) AS score FROM hand, hand_component WHERE hand.component_id = hand_component.id AND hand.game_id = ?";
$sql5 = "SELECT big_name FROM hand, hand_component WHERE hand.component_id = hand_component.id AND hand.game_id = ?";

if (!($sth2 = $dbh->prepare($sql2))){
    sqlerr($sql2);
}
if (!($sth3 = $dbh->prepare($sql3))){
    sqlerr($sql3);
}
if (!($sth4 = $dbh->prepare($sql4))){
    sqlerr($sql4);
}
if (!($sth5 = $dbh->prepare($sql5))){
    sqlerr($sql5);
}


if (!($sth3->execute($player_id))){
    sqlerr($sql3);
}
my $player = $sth3->fetchrow_hashref;



print header;
print start_html(-title=>"Mahjong details for $$player{fname} $$player{lname}", -style=>{-src=>'scores.css'});
my $rows = $$player{games} + 2;
print <<HTML;
<h1>Mahjong Scoring details for $$player{fname} $$player{lname}</h1>
<table style="width:100%" id="scores" cellspacing=0>
<tr>
<th rowspan="2">Date</th>
<th rowspan="2">Players</th>
<th rowspan="2">Winner</th>
<th rowspan="2">Thrower</th>
<th rowspan="2">Points</th>
<th rowspan="2">Hand</th>
<th rowspan="2">Penalty</th>
    <th rowspan="$rows" style="width:2px;border-left:solid 1px black;border-right:solid 1px black">&nbsp;</th>
<th colspan="2">Method A</th>
<th colspan="2">Method B</th>
</tr>
<tr>
<th>Score</th>
<th>Total</th>
<th>Score</th>
<th>Total</th>
</tr>
HTML
my ($scorea, $scoreb, $totala, $totalb) = (0) x 4;
my $r = 0;
while (my $game = $sth->fetchrow_hashref){

  print "<tr class=\"row" . (($r%2) + 1) . "\">\n";
  print "<td class=\"width\">" . convert_date($$game{stamp}). "</td>\n";
  print "<td>\n";
  
  if (!($sth2->execute($$game{game_id}))){
    sqlerr($sql2);
  }
  while (my $player = $sth2->fetchrow_hashref){
    if ($$player{id} == $player_id){
      print "<b>$$player{fname} $$player{lname}</b><br>\n";
    } else {
      print "$$player{fname} $$player{lname}<br>\n";
    }
  }
  print "</td>\n";
  if (!($sth3->execute($$game{winner}))){
    sqlerr($sql3);
  }
  my $player = $sth3->fetchrow_hashref;
  if ($$player{id} == $player_id){
    print "<td><b>$$player{fname}</b></td>\n";
  } else {
    print "<td>$$player{fname}</td>\n";
  }
  if ($$game{thrower}){
    if (!($sth3->execute($$game{thrower}))){
      sqlerr($sql3);
    }
    my $player = $sth3->fetchrow_hashref;
    if ($$player{id} == $player_id){
      print "<td><b>$$player{fname}</b></td>\n";
    } else {
      print "<td>$$player{fname}</td>\n";
    }
  } else {
    print "<td>Self-Pick</td>\n";
  }
  print "<td class=\"score\">$$game{score}</td>\n";
  if (!($sth5->execute($$game{game_id}))){
    sqlerr($sql5);
  }
  my @hand;
  while (my $hand = $sth5->fetchrow_hashref){
    push (@hand, $$hand{big_name});
  }
  local $" = "<br>\n";
  print "<td>@hand</td>\n";
  if ($$game{penalty}){
    
    (my $penalty = $$game{penalty}) =~ s/^(\d+)/$1 piece/;
    $$game{penalty} = "False Mahjong" if $$game{penalty} eq 'false';
    print "<td>$penalty</td>\n";
  } else {
    print "<td>&nbsp;</td>\n";
  }
  
  if ($$game{penalty} eq "False Mahjong"){ ##False mahjong
    if ($player_id == $$game{winner}){
      $scorea = -128 * 3;
      $scoreb = -128 * 3;
    } else {
      $scorea = 128;
      $scoreb = 128;
    }
  } else { ## No false mahjong

    if ($player_id == $$game{winner}){ ##player won
      if ((!$$game{thrower}) or ($$game{penalty} and $$game{penalty}==12)){
	$scorea = scoreA($$game{score}) * 6;
	$scoreb = scoreB($$game{score}) * 6;
      } else {
	$scorea = scoreA($$game{score}) * 4;
	$scoreb = scoreB($$game{score}) * 4;
      }
    } else { ## Player didn't win


      if ($$game{penalty} > 0){  #there's a penalty
	if ($$game{thrower} == $player_id){ # Player threw the penalty
	  $scorea = scoreA($$game{score}) * (($$game{penalty} == 12) ? -6 : -4);
	  $scoreb = scoreB($$game{score}) * (($$game{penalty} == 12) ? -6 : -4);
	} else { #someone else threw the penalty
	  #player doesn't owe anything
	  $scorea = 0;
	  $scoreb = 0;
	}
      } else {
	if (!$$game{thrower} or $$game{thrower} == $player_id){
	  $scorea = scoreA($$game{score}) * -2;
	  $scoreb = scoreB($$game{score}) * -2;
	} else {
	  $scorea = scoreA($$game{score}) * -1;
	  $scoreb = scoreB($$game{score}) * -1;
	}
      }
    }
  }
  
  $totala += $scorea;
  $totalb += $scoreb;
  
  print <<HTML;
<td>$scorea</td>
<td><b>$totala</b></td>
<td>$scoreb</td>
<td><b>$totalb</b></td>
HTML

    print "</tr>\n";
    $r++;
}
print "</table>\n";
print qq(Return to <a href="scores.cgi">Full Standings</a><br>);






print end_html;



