#!/usr/bin/perl
use warnings;
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser warningsToBrowser set_message);
use DBI;
use Data::Dumper;
use Mail::Sendmail;
use DBD::mysql;
warningsToBrowser(1);
BEGIN{
  set_message(q(Please email Paul at <a href="mailto:lallip@cs.rpi.edu?subject=MahJong Errors">lallip@cs.rpi.edu</a> and inform him of the exact text of the error message above.));
}

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

sub scorea{
  my $pts = shift;
  if ($pts >= 10 ){
    return 64;
  } elsif ($pts >= 7){
    return 32;
  } elsif ($pts >= 4) {
    return 16;
  } else {
    return 2 ** $pts;
  }
}

sub scoreb{
  my $pts = shift;
  if ($pts >= 12 ){
    return 2 ** 12;
  } else {
    return 2 ** $pts;
  }
}

if (!($dbh = DBI->connect("DBI:mysql:upaccinema:cinema.union.rpi.edu", "upaccinema", "kjfs923"))){
  sqlerr("(No SQL)");
}


#This script will now also be used to delete a game from the record
if (param('del_game')){
  if (param('password') ne "bledfordays"){
    print header;
    print start_html('I think not');
    print "Uh, no, sorry, you can't delete a game without knowing the password.  Good try.<br>\n";
    print "If there was an error in inserting game, or if an accidentally inserted game needs to be deleted, please contact Paul at <a href='mailto:lallip\@cs.rpi.edu?subject=MahJong deletions'>lallip\@cs.rpi.edu</a><br>\n";
    print end_html();
    exit();
  }
  my $game = param('del_game');
  my $sql = "DELETE FROM game WHERE game_id = $game;";
  if (!($sth = $dbh->do($sql))){
    print "(DO)<br>\n";
    sqlerr($sql);
  }
  $sql = "DELETE FROM played WHERE game_id = $game;";
  if (!($sth = $dbh->do($sql))){
    print "(DO)<br>\n";
    sqlerr($sql);
  }
  $sql = "DELETE FROM hand WHERE game_id = $game;";
  if (!($sth = $dbh->do($sql))){
    print "(DO)<br>\n";
    sqlerr($sql);
  }
}


#$dbh->{AutoCommit} = 0;

$sql = "SELECT id FROM player;";
if (!($sth = $dbh->prepare($sql))){
  print "(PREPARE)<br>\n";
  sqlerr($sql);
}

if (!($sth->execute())){
  print "(EXECUTE)<br>\n";
  sqlerr($sql);
}

while (my $h = $sth->fetchrow_hashref){
  push @players, $$h{id};
}

my ($scorea, $scoreb, @games);

if (!param('del_game')){
  print header;
  print start_html ('Resetting scores...');
}

foreach $player (@players){
  $scorea = 0;
  $scoreb = 0;
  $games = 0;
  $sql = "SELECT * FROM game, played WHERE game.game_id = played.game_id AND player_id = $player;";
  if (!($sth = $dbh->prepare($sql))){
    print "(PREPARE)<br>\n";
    sqlerr($sql);
  }
  
  if (!($sth->execute())){
    print "(EXECUTE)<br>\n";
    sqlerr($sql);
  }
  
  while (my $h = $sth->fetchrow_hashref){
    $games ++;
    ####FALSE MAHJONG##
    if ($$h{penalty} and $$h{penalty} eq "false"){
      if ($player == $$h{winner}){
	$scorea -= 128 * 3;
	$scoreb -= 128 * 3;
      } else {	
	$scorea += 128;
	$scoreb += 128;
      }
    } else {


      if ($$h{winner} == $player){      ### Player Won###
	if ((!$$h{thrower}) or ($$h{penalty} and $$h{penalty}==12)){
	  $scorea += (scorea($$h{score})) * 6;
	  $scoreb += (scoreb($$h{score})) * 6;
	} else {
	  $scorea += (scorea($$h{score})) * 4;
	  $scoreb += (scoreb($$h{score})) * 4;
	}
      } else {	### Player Lost ###
	if ($$h{penalty}){	  ## There was a penalty
	  if ($$h{thrower} == $player){ ##Player threw
	    if ($$h{penalty} == 12){
	      $scorea -= (scorea($$h{score})) * 6;
	      $scoreb -= (scoreb($$h{score})) * 6;
	    } else {
	      $scorea -= (scorea($$h{score})) * 4;
	      $scoreb -= (scoreb($$h{score})) * 4;
	    }
	  } else { ##Player didn't throw
	    #Player doesn't owe anything...
	  }
	} else {	  ## No Penalty ##
	  if (!$$h{thrower} or $$h{thrower} == $player){
	    $scorea -= ((scorea($$h{score})) * 2);
	    $scoreb -= ((scoreb($$h{score})) * 2);
	  } else {
	    $scorea -= (scorea($$h{score}));
	    $scoreb -= (scoreb($$h{score}));
	  }
	}
      }
    }
  }
  
  $sql = "UPDATE player SET scorea = $scorea, scoreb = $scoreb, games = $games WHERE id = $player;";
  if (!param('del_game')){
    print $sql, "<br>\n";
  }
  if (!($sth = $dbh->prepare($sql))){
    print "(PREPARE)<br>\n";
    sqlerr($sql);
  }
  
  if (!($sth->execute())){
    print "(EXECUTE)<br>\n";
    sqlerr($sql);
  }
  
}
if (!param('del_game')){
  print end_html();
} else {
  print redirect("http://cinema.union.rpi.edu/mahjong/scores.cgi");
}



