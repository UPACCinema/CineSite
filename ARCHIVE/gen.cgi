#!/usr/bin/perl 
use warnings;
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser warningsToBrowser set_message);
warningsToBrowser(1);
use DBI;
use DBD::mysql;
use Data::Dumper;
use strict;
use lib 'D:/WebSites/cinema/perllib';

use IMDB::Movie;
use POSIX qw/strftime/;
BEGIN{
	set_message(q(Please email Paul at <a href="mailto:plalli@gmail.com?subject=MahJong Error">plalli@gmail.com</a> informing him of the exact text of the message above.));
}

my $dbh;

sub sqlerr($;$$){
  if ($dbh->errstr){
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
}


if (!($dbh = DBI->connect("DBI:mysql:upaccinema:cinema.union.rpi.edu", "upaccinema", "kjfs923"))){
    sqlerr("(No SQL)");
}


my ($sched_tbl, $other_tbl) = ('sched_temp', 'sched_mat');

print header;
print start_html('UPAC Cinema Schedule Generator');

my $semester = param('semester');

if (param('edit') ) {
  #print Dump();
  #first edit current schedule
  my %schedule;
  my %params;
  foreach (param()){
    $params{$_} = [param($_)];
  }
  print pre(Dumper \%params);
    

  for my $i (0..$#{$params{id}}) {
    my $id = $params{id}[$i];
    $schedule{$id}{semester} = param('semester');
    foreach (qw/imdb title image special id date times/) {
      $schedule{$id}{$_} = $params{$_}[$i] if $params{$_} and @{$params{$_}} > $i ;
    }
    my ($y, $m, $d) = $schedule{$id}{date} =~ /(\d+)-(\d+)-(\d+)/;
    $schedule{$id}{day} = strftime('%A', 0,0,0,$d, $m-1, $y-1900);
    @{$schedule{$id}{matinees}} = map { {date=>$params{mat_date}[$i*2+$_], times=>$params{mat_times}[$i*2+$_]}} (0,1);
  }
  
  my $sql_update = "UPDATE $sched_tbl SET day=?, imdb=?, semester=?, title=?, image=?, date=?, times=? WHERE id=?";
  my $sth_update = $dbh->prepare($sql_update);
  sqlerr($sql_update);
  my $sql_delmat = "DELETE FROM $other_tbl WHERE movie_id = ?";
  my $sth_delmat = $dbh->prepare($sql_delmat);
  my $sql_insmat = "INSERT INTO $other_tbl SET movie_id=?, type='Family Matinee', date=?, times=?";
  my $sth_insmat = $dbh->prepare($sql_insmat);
  
  foreach my $id (keys %schedule){
    $sth_update->execute(@{$schedule{$id}}{qw/day imdb semester title image date times id/});
    sqlerr($sql_update, __FILE__, __LINE__);
    $sth_delmat->execute($id);
    sqlerr($sql_delmat, __FILE__, __LINE__);
    if ($schedule{$id}{matinees}[0]{date}){
      $sth_insmat->execute($id, $schedule{$id}{matinees}[0]{date}, $schedule{$id}{matinees}[0]{times});
      sqlerr($sql_insmat, __FILE__, __LINE__);
      if ($schedule{$id}{matinees}[1]{date}){
	$sth_insmat->execute($id, $schedule{$id}{matinees}[0]{date}, $schedule{$id}{matinees}[0]{times});
	sqlerr($sql_insmat, __FILE__, __LINE__);
      }
    }
  }
  


  #Now Add New Movies
  for my $i (0..$#{$params{new_title}}){
    next unless $params{new_title}[$i];
    my %movie;
    print "About to create new movie with title: $params{new_title}[$i]<br>\n";
    my $imdb = new IMDB::Movie($params{new_title}[$i]);
    print pre(Dumper($imdb));
    foreach (qw/date special times/){
      $movie{$_} = $params{'new_'.$_}[$i];
    }
    $movie{'title'} = $imdb->title;
    $movie{'imdb'} = 'tt' . $imdb->id;
    $movie{'image'} = $imdb->img;
    $movie{'semester'} = param('semester');
    my ($y, $m, $d) = $movie{date} =~ /(\d+)-(\d+)-(\d+)/;
    $movie{day} = strftime('%A', 0,0,0,$d, $m-1, $y-1900);
    @{$movie{matinees}} = map { {date=>$params{new_mat_date}[$i*2+$_], times=>$params{new_mat_times}[$i*2+$_]}} (0,1);
    my $sql_insert = "INSERT INTO $sched_tbl (day, imdb, semester, title, image, date, times) VALUES ('".join("', '", @movie{qw/day imdb semester title image date times/})."');";
    my $sth_insert = $dbh->prepare($sql_insert);
    sqlerr('Prepare:' . $sql_insert);
    $sth_insert->execute();
    sqlerr('Execute:' . $sql_insert);
    print "<!-- INSERT SQL: $sql_insert-->\n";
    if ($movie{matinees}[0]{date}){
      my $new_id =$dbh->last_insert_id((undef)x4);
      $sth_insmat->execute($new_id, $movie{matinees}[0]{date}, $movie{matinees}[0]{times});
      sqlerr($sql_insmat, __FILE__, __LINE__);
      if ($movie{matinees}[1]{date}){
	$sth_insmat->execute($new_id, $movie{matinees}[0]{date}, $movie{matinees}[0]{times});
	sqlerr($sql_insmat, __FILE__, __LINE__);
      }
    }
    undef $imdb;
    %movie=();
  }
    
}



my $sql = "SELECT * FROM $sched_tbl WHERE semester = '$semester' ORDER BY date";
print "SQL: $sql<br>\n";

my $sth = $dbh->prepare($sql);
$sth->execute();
sqlerr($sql, __FILE__, __LINE__);
my $movies;
while (my $row = $sth->fetchrow_hashref()){
  my $sql = "SELECT * FROM $other_tbl WHERE movie_id = $row->{id} ORDER BY date";
  my $sth2= $dbh->prepare($sql);
  $sth2->execute();
  sqlerr($sql, __FILE__, __LINE__);
  while (my $mat = $sth2->fetchrow_hashref()){
    push @{$row->{matinees}}, {date=>$mat->{date}, times=>$mat->{times}};
  }
  push @$movies, $row;
}

#print pre(Dumper($movies));

print startform();
print hidden(-name=>'semester', -value=>$semester);
{#last;
  print table({width=>'100%'},
	      Tr(
		 [ th([
		       'Date<br>(YYYY-MM-DD)',
		       'Title',
		       'Special Times?',
		       'IMDB id',
		       'Poster',
		       'Matinees<br>Date - Times',
		      ]),
		   map {
		     hidden(-name=>'id', -value=>$movies->[$_]{id}, -override=>1) .
		     td([
			 textfield(-name=>"date", -value=>$movies->[$_]{date}, -override=>1),
			 textfield(-name=>"title", -value=>$movies->[$_]{title}, -override=>1),
			 checkbox(-name=>"special", -label=>'', -value=>1, -checked=>$movies->[$_]{special}, -override=>1) .
			 textfield(-name=>"times", -value=>$movies->[$_]{times}, -override=>1),
			 textfield(-name=>"imdb", -value=>$movies->[$_]{imdb}, -override=>1),
			 img({-src=>($movies->[$_]{image}=~/^http:/ ? $movies->[$_]{image} : "images/$movies->[$_]{image}")}).br.
			 textfield(-name=>"image", -value=>$movies->[$_]{image}, -override=>1),
			 textfield(-name=>"mat_date", -value=>$movies->[$_]{matinees}[0]{date}, -override=>1) . ' - ' .
			 textfield(-name=>"mat_times", -value=>$movies->[$_]{matinees}[0]{times}, -override=>1) . '<br>' .
			 textfield(-name=>"mat_date", -value=>$movies->[$_]{matinees}[1]{date}, -override=>1) . ' - ' .
			 textfield(-name=>"mat_times", -value=>$movies->[$_]{matinees}[1]{times}, -override=>1) ,
			]) ."\n"}
		   (0..$#$movies)
		 ])
	     );
}
my $numnew = @$movies ? 5 : 20;

print "Add new Movies", br;

print table({width=>'100%'},
	   Tr([
	       th ([
		    'Date<br>(YYYY-MM-DD)',
		    'Title/IMDb id',
		    'Speical Times?',
		    'Matinees<br>Date - Times',
		    ]),
	       map {td([
			textfield(-name=>'new_date', -value=>'', -override=>1),
			textfield(-name=>'new_title', -value=>'', -override=>1),
			checkbox(-name=>'new_special', -label=>'', -value=>1, -checked=>0).
			textfield(-name=>'new_times', -value=>'7, 9:30 & 12', -override=>1),
			 textfield(-name=>"newmat_date", -value=>'', -override=>1) . ' - ' .
			 textfield(-name=>"newmat_times", -value=>'', -override=>1) . '<br>' .
			 textfield(-name=>"newmat_date", -value=>'', -override=>1) . ' - ' .
			 textfield(-name=>"newmat_times", -value=>'', -override=>1) ,
		       ]) . "\n"}
	       (1..$numnew)
	       ])
	   );

print submit(-name=>'edit', -value=>"Edit the $semester schedule");
print endform();

		      
		      
