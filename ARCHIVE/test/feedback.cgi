#!/perl.exe
use strict;
use warnings;
use CGI qw(:standard :html3);
use CGI::Carp qw(warningsToBrowser fatalsToBrowser);
use DBI;
use DBD::mysql;
use File::Basename;
use POSIX qw(strftime);
use Time::Local;

my $dbh; #database handler

my $basedir = "http://$ENV{HTTP_HOST}" . dirname($ENV{SCRIPT_NAME});
my $basename = basename($ENV{SCRIPT_NAME});

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


sub prepexec($){
	my $sth;
	if (!($sth = $dbh->prepare($_[0]))){
		print STDERR "(PREPARE):\n";
		sqlerr($_[0]);
	}
	
	if (!($sth->execute())){
		print STDERR "(EXECUTE):\n";
		sqlerr($_[0]);
	}
	return $sth;
}

sub get_msg {
	my $sth = prepexec("SELECT * FROM feedback WHERE msg_id = $_[0]");
	my $h = $sth->fetchrow_hashref();
	my ($Y, $M, $d, $H, $m, $s) = $$h{date} =~ /(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/;
	my $time = timelocal($s, $m, $H, $d, $M-1, $Y);
	$$h{date} = strftime("%A, %B %d, %Y<br>%X", localtime($time));	
	return $h;
}

sub msg_types {
	my $sth = prepexec("DESCRIBE feedback `type`");
	my $row = $sth->fetchrow_hashref();
	my ($string) = $$row{Type} =~ /\('(.*)'\)/;
	my @fields = split /','/, $string;
	my $i = 1;
	return map {$i++ => $_} @fields;
}
my %types = msg_types();
		
sub show_form{
	my $reply_to = shift;
	print startform("post", "$basedir/$basename");
	print "<table>\n";
	local $\ = "\n";
	print TR({-valign=>'top'}, 
			[
				td(["Your name:",textfield(-name=>"name")]),
				td(["Your email: ", textfield(-name=>"email")]),
				td({colspan=>2}, ["(Used only for UPAC to reply - will not be posted)"]),
				td(["Subject: ", textfield(-name=>"subject")]),
				td(["Type of Feedback: "])."<td>". radio_group(
														-name=>'type', 
														-values=>[sort {$a<=>$b} keys %types],
														-labels=>\%types,
														-default=>'7',
														-linebreak=>1
													  )."</td>"
													  ,
				td(["Your Message: ", textarea(-name=>'msg', -rows=>5)]),
			]
		);
	print "</table>\n";
	print hidden(-name=>"reply_to", -value=>"$reply_to") if $reply_to;
	print submit(-name=>'add', -value=>'Leave Feedback');
	print endform;
}

sub topmsgs{
	my $sql = "SELECT * FROM feedback WHERE reply_to IS NULL ";
	$sql .= "AND `type` = '$_[0]' " if $_[0];
	$sql .= "ORDER BY date";
	my $sth = prepexec($sql);
	my @return;
	while (my $h = $sth->fetchrow_hashref()){
		my ($Y, $M, $d, $H, $m, $s) = $$h{date} =~ /(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/;
		my $time = timelocal($s, $m, $H, $d, $M-1, $Y);
		$$h{date} = strftime("%A, %B %d, %Y - %X", localtime($time));
		push @return, $h;
	}
	return @return;
}

sub get_replies{
	my $msg = shift;
	my $sth = prepexec("SELECT * FROM feedback WHERE reply_to = $msg");
	my @return;
	while (my $row = $sth->fetchrow_hashref()){
		my ($Y, $M, $d, $H, $m, $s) = $$row{date} =~ /(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/;
		my $time = timelocal($s, $m, $H, $d, $M-1, $Y);
		$$row{date} = strftime("%A, %B %d, %Y<br>%X", localtime($time));
		push @return, $row;
	}
	return @return;
}

sub print_replies{
	my $level = shift;
	my $msg = shift;
	my @replies = @_;
	
	print qq(<table width="100%" border="1">) if $level == 0;
	print qq(<tr>);
	print qq(<td width="100%">\n);
	print qq(<table><tr>);
	for (1..$level){
		print qq(<td width="10%">&nbsp;</td>);
	}
	print qq(<td style="white-space:nowrap;font-size:80%" valign="top">$$msg{date}<br><br>$$msg{name}</td>);
	print qq(<td style="width:100%;padding-left:5px" valign="top"><b>$$msg{subject}</b><br><br>$$msg{msg});
	print qq(<br><br><a href="$basedir/$basename?reply_to=$$msg{msg_id}">Reply to this Posting</a></td></tr></table>\n);
	print qq(</td></tr>);
	foreach my $reply (@replies){
		print_replies($level + 1, $reply, get_replies($$reply{msg_id}));
	}
	if ($level == 0){
		print qq(</table>);
	}
}



if (param('add')){

	my $sql = "INSERT INTO feedback SET name=?, email=?, subject=?, msg=?, type=?, reply_to=?,date=?";
	my $sth;
	if (!($sth = $dbh->prepare($sql))){
		print STDERR "(PREPARE):\n";
		sqlerr($sql);
	}
	my $date = strftime("%Y-%m-%d %H:%M:%S", localtime);
	my $p = CGI::Vars();
	local $\ = "<br>\n";

	if (!$sth->execute(@$p{qw(name email subject msg type reply_to)}, $date)){
		print STDERR "(EXECUTE):\n";
		sqlerr($sql);
	}

	if ($$p{reply_to}){
		my $sql = "UPDATE feedback SET replies = replies + 1 WHERE msg_id = $$p{reply_to}";
		if (!$dbh->do($sql)){
			print STDERR "(DO):\n";
			sqlerr($sql);
		}
	}	
	
	print redirect("$basedir/$basename");

} elsif (param('reply_to')){
	print header(-expires=>"-1d");

	print start_html("Reply to Post");
	my $msg = get_msg(param('reply_to'));
	print qq(Reply to Posting: "$$msg{subject}"<br>);
	show_form($$msg{msg_id});
	print end_html();
	exit();
} elsif (param('msg_id')){
	print header(-expires=>"-1d");
	print start_html('UPAC Cinema Feedback');
	print_replies (0, get_msg(param('msg_id')), get_replies(param('msg_id')));
	print "Return to", a ({-href=>"$basedir/$basename"}, "Feedback Page");
	print end_html;
	exit();
}
print header(-expires=>"-1d");


print start_html "UPAC Cinema Feedback Form";

print "Choose the messages to view: ";
print popup_menu (
			-name=>'type', 
			-values=>['', sort {$a <=> $b} keys %types], 
			-labels=>{''=>'all', %types},
			-default=>'', 
			-onChange=>qq(document.location.href='$basedir/$basename?type='+this.options[this.selectedIndex].value; return true;)
	);
print p();
print qq(<table border="1" width="100%">\n);
print Tr ({-valign=>"TOP"},
	[
		th([qw/Subject Author Date Replies/]),
		map {
			td ({-style=>'white-space:nowrap'}, [ 
				$_->{date},
				$_->{name},
				a ( 
					{-href=>"$basedir/$basename?msg_id=$_->{msg_id}"}, 
					$_->{subject} 
				),
				$_->{replies}
			
			] )	
		} topmsgs(param('type'))
	]);
print "</table>\n";

print "Give UPAC Cinema your feedback!";
show_form();


print end_html;

 