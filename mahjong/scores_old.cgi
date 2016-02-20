#!/usr/local/bin/perl 
use warnings;
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser warningsToBrowser set_message);
warningsToBrowser(1);
use DBI;
use DBD::mysql;
use Data::Dumper;
use strict;
use Mail::Sendmail;
#use Time::localtime;
use POSIX;
BEGIN{
	set_message(q(Please email Paul at <a href="mailto:lallip@cs.rpi.edu?subject=MahJong Error">lallip@cs.rpi.edu</a> informing him of the exact text of the message above.));
}
#my $v = $DBD::mysql::VERSION;
#print "Version: $v<br>\n";
#exit();
{
	last;
    print header;
    print start_html('uh-oh');
    print h1('We are experiencing technical difficulties.  Please stand by.');
    print h2('-- Itty');
    print end_html;
    exit();
}

my ($password, $dbh, $sth, $sql, %players, $max);
$max = 10;
$password = "bitter";

sub convert_date($){
	my $stamp = $_[0];
	my ($Y, $m, $d, $h, $i, $s) = ($stamp =~ /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/);
	$Y -= 1900;
	$m -= 1;
	my $str = POSIX::strftime("%A, %B %d, %Y<br>\n%I:%M%p", $s, $i, $h, $d, $m, $Y);
	return $str;
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

my ($col, $meth);

if (param('meth') and param('meth') eq 'A'){
    $col = 'scorea';
    $meth = 'A';
} else {
    $col = 'scoreb';
    $meth = 'B';
}

if (!($dbh = DBI->connect("DBI:mysql:upaccinema:cinema.union.rpi.edu", "upaccinema", "kjfs923"))){
    sqlerr("(No SQL)");
}

#$dbh->{AutoCommit} = 0;

$sql = "SELECT * FROM player ORDER BY fname";
if (!($sth = $dbh->prepare($sql))){
    print "(PREPARE)<br>\n";
    sqlerr($sql);
}

if (!($sth->execute())){
    print "(PREPARE)<br>\n";
    sqlerr($sql);
}

while (my $h = $sth->fetchrow_hashref){
    $players{$$h{id}} = $h;
}

$sql = "SELECT player.id as winner , COUNT( game_id )  AS won FROM player LEFT  OUTER  JOIN game ON game.winner = player.id GROUP  BY player.id;";
if (!($sth = $dbh->prepare($sql))){
    print "(PREPARE)<br>\n";
    sqlerr($sql);
}

if (!($sth->execute())){
    print "(PREPARE)<br>\n";
    sqlerr($sql);
}

while (my $h = $sth->fetchrow_hashref){
    $players{$$h{winner}}{won} = $$h{won};
}

#calculate new scores, write to database/file
if (param('addnew')){
    import_names();
    $sql = "INSERT INTO player (fname, lname) VALUES (?,?)";
    if(!$dbh->do($sql, undef, $Q::fname, $Q::lname)){
	sqlerr($sql);
    }
    $sql = "SELECT * FROM player WHERE fname = ? AND lname = ?;";
    if (!($sth = $dbh->prepare($sql))){
	sqlerr($sql);
    }
    if (!($sth->execute($Q::fname, $Q::lname))){
	sqlerr($sql);
    }
    my $h = $sth->fetchrow_hashref;
    $players{$$h{id}} = $h;
#    my $temperr = 1;
#    if ($temperr){
#	sqlerr("Temp error");
#    } else {
#	my $rc = $dbh ->commit;
	print redirect('http://cinema.union.rpi.edu/mahjong/scores.cgi');
#    }

} elsif (param('save')){
 
    import_names();
    $Q::score = 12 if $Q::score =~ /^max$/i;
    if ($Q::password ne $password){
	print header();
	print start_html("ERROR");
	print h2("Invalid Password");
	
	print end_html();
	exit();
    }
    #update games played
    #Calculate base score
    #Recalc winner (examine selfpick)
    #Recalc losers (examine penalties)
    #Update player Table
    #Insert into games table
    #Insert into played table
    #Insert into hand table

    
    $sql = "UPDATE player SET games = ? WHERE id = ?";
    if (!($sth = $dbh->prepare($sql))){
	sqlerr($sql);
    }
    foreach my $id (@Q::players){
	$players{$id}{games}++;
	if (!($sth->execute($players{$id}{games}, $id))){
	    sqlerr($sql);
	}
    }

    if ($Q::penalty eq "false"){
	$players{$Q::winner}{scorea} -= (128 * 3);
	$players{$Q::winner}{scoreb} -= (128 * 3);
	foreach my $loser (@Q::players){
	    if ($loser ne $Q::winner){
		$players{$loser}{scorea} += 128;
		$players{$loser}{scoreb} += 128;
	    }
	}
    } else {
	my ($scorea, $scoreb) = (scoreA($Q::score), scoreB($Q::score));
	
	if ($Q::tosser eq 'self' or $Q::penalty == 12){
	    $players{$Q::winner}{scorea} += ($scorea * 6);
	    $players{$Q::winner}{scoreb} += ($scoreb * 6);
	    if ($Q::penalty == 12 or $Q::penalty == 5){
		$players{$Q::tosser}{scorea} -= ($scorea * 6);
		$players{$Q::tosser}{scoreb} -= ($scoreb * 6);
	    } else {
		foreach my $loser (@Q::players){
		    if ($loser ne $Q::winner){
			$players{$loser}{scorea} -= ($scorea * 2);
			$players{$loser}{scoreb} -= ($scoreb * 2);
		    }
		}
	    }
	} else {
	    $players{$Q::winner}{scorea} += ($scorea * 4);
	    $players{$Q::winner}{scoreb} += ($scoreb * 4);
	    if ($Q::penalty == 9 or $Q::penalty == 5){
		$players{$Q::tosser}{scorea} -= ($scorea * 4);
		$players{$Q::tosser}{scoreb} -= ($scoreb * 4);
	    } else {
		foreach my $loser (@Q::players){
		    if ($loser eq $Q::tosser){
			$players{$loser}{scorea} -= ($scorea * 2);
			$players{$loser}{scoreb} -= ($scoreb * 2);
		    } elsif ($loser ne $Q::winner){
			$players{$loser}{scorea} -= $scorea;
			$players{$loser}{scoreb} -= $scoreb;
		    }
		}
	    }
	}
    }
    
    $sql = "UPDATE player SET scorea = ?, scoreb = ? WHERE id = ?";
    if (!($sth = $dbh->prepare($sql))){
	sqlerr($sql);
    }
    foreach my $player (@Q::players){
	if (!$sth->execute($players{$player}{scorea}, $players{$player}{scoreb}, $player)){
	    sqlerr($sql);
	}
    }


    $sql = "INSERT INTO game SET ";
    my @terms;
    push(@terms, "winner = $Q::winner");
    if ($Q::tosser ne 'self'){
	push(@terms, "thrower = $Q::tosser");
    }
    push (@terms, "stamp = NOW()");
    push (@terms, "score = $Q::score");
    if ($Q::penalty ne 'none'){
	push (@terms, "penalty = '$Q::penalty'");
    }
    $sql .= join(", ", @terms);
    
    if (!($dbh->do($sql))){
	sqlerr($sql);
    }

    $sql = "SELECT LAST_INSERT_ID()";
    if (!($sth = $dbh->prepare($sql))){
	sqlerr($sql);
    }
    if (!($sth->execute)){
	sqlerr($sql);
    }
    my @temp = $sth->fetchrow_array();
    my $game_id = $temp[0];


    foreach my $player (@Q::players){
	$sql = "INSERT INTO played (game_id, player_id) VALUES ($game_id, $player);";
	if (!($dbh->do($sql))){
	    sqlerr($sql);
	}
    }
	


    foreach my $component (@Q::hand){
	$sql = "INSERT INTO hand (game_id, component_id) VALUES ($game_id, $component);";
	if (!($dbh->do($sql))){
	    sqlerr($sql);
	}
    }


#    my $rc = $dbh->commit;


    my %mail;

    my $from = 'upac-cinema@union.rpi.edu';

    $mail{smtp} = 'mail.rpi.edu';
    $mail{From} = $from;
    $mail{To} = 'lallip@cs.rpi.edu';
    #$mail{To} = "lallip\@cs.rpi.edu";
    $mail{Subject} = "Mahjong Scores Updated";

	my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
	$year += 1900;
	$mon++;
	my $date = sprintf "%d/%d/%d %d:%d:%d", $mon, $mday, $year, $hour, $min, $sec;


    #my $date = POSIX::strftime "%a %b %e %H:%M:%S %Y", localtime;
    #my $date = localtime();
    #my $date = `date`;
    local $" = ", ";
    my @names;
    foreach (@Q::players){
	push @names, $players{$_}{fname};
    }
    $mail{Message} = <<MAIL;
On $date, a new Mahjong game was recorded:
Players: @names.
Winner: $players{$Q::winner}{fname}
Thrower: $players{$Q::tosser}{fname}.
Value of hand: $Q::score.
Penalty: $Q::penalty
MAIL
    if (!sendmail(%mail)){
		print "Mail not sent: $Mail::Sendmail::error<br>\n";
    }
    
    print redirect('http://cinema.union.rpi.edu/mahjong/scores.cgi');

}

print header (-expires=>'-1d');
print start_html(-title=>'UPAC Cinema Mahjong Standings',
				 -style=>{src=>'scores.css'},
				 -script=>{type=>'text/javascript', src=>'mahjong.js'}
				 );
print <<END_HTML;

<h2 style='text-align:center'>UPAC Cinema Mahjong Standings</h2>
<h3 style='text-align:center'>
    <a href="http://cinema.union.rpi.edu/mahjong">
    Scoring and Hand descriptions
    </a>
</h3>
<table width="100%"><tr><td valign="top">
<form method="post" action="http://cinema.union.rpi.edu/mahjong/scores.cgi">
    <table id="addnew">
    <tr>
    <td>Add a new player:</td>
    </tr>
    <tr>
    <td align="right">First:</td>
    <td><input type="text" name="fname"></td>
    </tr>
    <tr>
    <td align="right">Last:</td>
    <td><input type="text" name="lname"></td>
    </tr>
    <tr><td></td>
    <td><input type="submit" name="addnew" value="Add new player"></td>
    </form>
    </tr>
    <tr>
<form method="post" action="http://cinema.union.rpi.edu/mahjong/scores.cgi">
    
    <td>Select the four players in this match:</td>
    <td><select name="players" id="players" size="6" multiple onChange="add_player(); return true;">
END_HTML
    
    foreach my $player (sort by_name_and_score keys %players){
	print "<option value='$player'>$players{$player}{fname} $players{$player}{lname}</option>\n";
    }

    print <<END_HTML;
</select></td>
    </tr>
    <tr>
      <td>Who won?</td>
      <td>
        <select name="winner" id="winner" size="4" onChange="add_tosser(); return true;"></select>
      </td>
    </tr>
    <tr>
       <td>Who tossed the winning tile?</td>
       <td>
         <select name="tosser" id="tosser" size="4" onChange="choose_tosser(this); return true;">
	   <option value="self">Self-Pick</option>
	 </select>
      </td>
		</tr>
		<tr>
			<td>How many points in the hand?<br>
			(Select hands at right to calculate)</td>
			<td><input type="text" name="score" id="score" size="3">
		</tr>
		<tr>
			<td valign="top">Were any penalties incurred by the thrower?</td>
			<td>
				<input type="radio" name="penalty" value="none" checked>None<br>
				<input type="radio" name="penalty" value="9">Nine Piece<br>
				<input type="radio" name="penalty" value="12">Twelve Piece<br>
				<input type="radio" name="penalty" value="5">Five Piece<br>
				<input type="radio" name="penalty" value="false">False MahJong<br>
			</td>
		</tr>

		<tr>
			<td colspan="2" style="text-align:center">
				Password:
				<input type="password" name="password">
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center">
				<input type="submit" name="save" onClick="return validate();" value="Record Scores and Update Standings">
			</td>
		</tr>
	</table>
</td><td valign="top" style="white-space:nowrap">
END_HTML
$sql = "SELECT * FROM hand_component ORDER BY id";
if (!($sth = $dbh->prepare($sql))){
   sqlerr($sql);
}
if (!($sth->execute)){
   sqlerr($sql);
}
while (my $h = $sth->fetchrow_hashref){
   print qq(<input type="checkbox" name="hand" onClick="update_score(this); return true;" alt="$$h{points}" value="$$h{id}" id="$$h{name}">$$h{big_name}<br>\n);
}
print <<END_HTML;
</form>
</td><td valign="top">


END_HTML

sub by_score_and_name(){
    return ($players{$b}{$col} <=> $players{$a}{$col} or
	    $players{$a}{fname} cmp $players{$b}{fname} or
	    $players{$a}{lname} cmp $players{$b}{lname});
}

sub by_name_and_score(){
  return ($players{$a}{fname} cmp $players{$b}{fname} or
	  $players{$a}{lname} cmp $players{$b}{lname} or
	  $players{$b}{$col} <=> $players{$a}{$col});
}
sub by_percent_and_name(){
  my $a_pct = eval{
    try {
      return $players{$a}{won}/$players{$a}{games} * 100;
    }
      catch DivideByZeroException with {
	my $ex = shift;
	return 0;
      }
    };
    
  my $b_pct = eval{
    try {
      return $players{$b}{won}/$players{$b}{games} * 100;
    }
      catch DivideByZeroException with {
	my $ex = shift;
	return 0;
      }
    };
    
  return $b_pct <=> $a_pct or $players{$a}{fname} cmp $players{$b}{fname};

}

sub by_games_and_name(){
  return ($players{$b}{games} <=> $players{$a}{games} or
	  $players{$a}{fname} cmp $players{$b}{fname} or
	  $players{$a}{lname} cmp $players{$b}{lname});
}

sub by_won_and_name(){
  return ($players{$b}{won} <=> $players{$a}{won} or
	  $players{$a}{fname} cmp $players{$b}{fname} or
	  $players{$a}{lname} cmp $players{$b}{lname});
}

if ($col eq 'scorea'){
    print qq(<b>Method A Scoring</b> - <a href="http://cinema.union.rpi.edu/mahjong/scores.cgi?meth=B">Method B Scoring</a>\n);
} else {
    print qq(<a href="http://cinema.union.rpi.edu/mahjong/scores.cgi?meth=A">Method A Scoring</a> - <b>Method B Scoring</b>\n);
}
print "<table id=\"scores\" cellspacing=0>\n";
print <<TR;
<tr>
  <th>
    <a href="http://cinema.union.rpi.edu/mahjong/scores.cgi?sort=name&meth=$meth">Player</a>
  </th>
  <th><a href="http://cinema.union.rpi.edu/mahjong/scores.cgi?sort=score&meth=$meth">Score</a></th>
  <th>Games <a href="http://cinema.union.rpi.edu/mahjong/scores.cgi?sort=won&meth=$meth">Won</a>/<a href="http://cinema.union.rpi.edu/mahjong/scores.cgi?sort=games&meth=$meth">Played</a>
  </th>
  <th><a href="http://cinema.union.rpi.edu/mahjong/scores.cgi?sort=percent&meth=$meth">Winning Percentage</th>
 </tr>
TR
my $r = 0;
my $order;
if (param('sort') and param('sort') eq 'percent'){
  $order = \&by_percent_and_name;
} elsif (param('sort') and param('sort') eq 'won'){
  $order = \&by_won_and_name;
} elsif (param('sort') and param('sort') eq 'games'){
  $order = \&by_games_and_name;
} elsif (param('sort') and param('sort') eq 'name'){
  $order = \&by_name_and_score;
} else {
  $order = \&by_score_and_name;
}

foreach my $player (sort $order keys %players){
    print "<tr class=\"row" . (($r % 2) + 1) . "\" ";
    if ($players{$player}{$col} < 0){
        print "style='color:#CC0000'";
    } elsif ($players{$player}{$col} == 0){
	print "style='color:#AA00AA'";
    } else {
	print "style='color:#000000'";
    }
    print qq(><td><a href="http://cinema.union.rpi.edu/mahjong/details.cgi?player=$players{$player}{id}">$players{$player}{fname} $players{$player}{lname}</a></td>\n);
    print "<td class=\"score\">$players{$player}{$col}</td>\n";
    printf "<td class=\"games\">%2d / %2d</td>\n", $players{$player}{won}, $players{$player}{games};
    printf "<td class=\"won\">%.2f%%</td></tr>\n", eval{
      try {
	  return $players{$player}{won}/$players{$player}{games} * 100;
      }
    catch DivideByZeroException with {
	my $ex = shift;
	return 0;
    }
      };
    $r++;
}
print "</table>\n";
print "</td></tr></table>\n";

print <<END_HTML;

<form action="http://cinema.union.rpi.edu/mahjong/reset.cgi" method="post">
<table id="games" cellspacing=0>
    <tr>
    <th class="date">Date</th>
    <th>Players</th>
    <th>Winner</th>
    <th>Thrower</th>
    <th>Points</th>
    <th>Hand</th>
    <th>Penalty</th>
	<th>
		Delete?<br>
		<input type="password" name="password" value=""><br>
		<input type="submit" name="submit" value="Delete Selected">
	</th>
    </tr>
END_HTML
    my ($sql2, $sth2, $sql3, $sth3, $sql4, $sth4, $sql5, $sth5);
    $sql = "SELECT * FROM game ORDER BY stamp DESC";
    $sql2 = "SELECT fname, lname FROM played, player WHERE played.player_id = player.id AND game_id = ? ORDER BY fname";
    $sql3 = "SELECT * FROM player WHERE id = ? ORDER BY fname";
    $sql4 = "SELECT SUM(points) AS score FROM hand, hand_component WHERE hand.component_id = hand_component.id AND hand.game_id = ?";
    $sql5 = "SELECT big_name FROM hand, hand_component WHERE hand.component_id = hand_component.id AND hand.game_id = ?";



    if (!($sth = $dbh->prepare($sql))){
	sqlerr($sql);
    }
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



    if (!($sth->execute)){
	sqlerr($sql);
    }
	my $r = 0;
    while (my $game = $sth->fetchrow_hashref){
	print "<tr class=\"row" . (($r%2) + 1) . "\">\n";
	print "<td class=\"width\">" . convert_date($$game{stamp}). "</td>\n";
	print "<td>\n";
  
	if (!($sth2->execute($$game{game_id}))){
	    sqlerr($sql2);
	}
	while (my $player = $sth2->fetchrow_hashref){
	    print "$$player{fname} $$player{lname}<br>\n";
	}
	print "</td>\n";
	if (!($sth3->execute($$game{winner}))){
	    sqlerr($sql3);
	}
	my $player = $sth3->fetchrow_hashref;
	print "<td>$$player{fname}</td>\n";
	if ($$game{thrower}){
	    if (!($sth3->execute($$game{thrower}))){
		sqlerr($sql3);
	    }
	    my $player = $sth3->fetchrow_hashref;
	    print "<td>$$player{fname}</td>\n";
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
	    $$game{penalty} =~ s/^(\d+)/$1 piece/;
	    $$game{penalty} = "False Mahjong" if $$game{penalty} eq 'false';
	    print "<td>$$game{penalty}</td>\n";
	} else {
	    print "<td>&nbsp;</td>\n";
	}
	print qq(<td><input type="radio" name="del_game" value="$$game{game_id}">Delete This Game</td>\n);
	print "</tr>\n";
	$r++;
    }
    print "</table>\n";
	print "</form>\n";
	    


print end_html();	
