#!perl.exe

use CGI qw(:standard);

sub cgidie($){
	print start_html("Error");
	print "<pre>$_[0]</pre>\n";
	print end_html();
	exit();
}


print header;
opendir (DIR, ".") or cgidie("Could not open current directory: $!\n");
print start_html('DIR listing');

print "<pre>\n";
while ($file = readdir(DIR)){
	print "$file\n";
	if (-d $file){
		opendir (DIR2, $file) or cgidie("Could not open directory $file: $!\n");
		print "\t$file2\n" while $file2 = readdir(DIR2);
		closedir DIR2;
	}
}
close DIR;

print end_html;