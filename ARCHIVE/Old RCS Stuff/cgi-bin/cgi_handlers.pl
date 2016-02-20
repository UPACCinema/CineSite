# The CGI_HANDLERS deal with basic CGI POST or GET method request
# elements such as those delivered by an HTTPD form, i.e. a url
# encoded line of "=" separated key=value pairs separated by &'s

# Routines:
# get_request:	reads the request and returns both the raw and
#               processed version.
# url_decode:	URL decodes a string or array of strings
# html_header:	Transmits a HTML header back to the caller
# html_trailer: Transmits a HTML trailer back to the caller

# Author:
# 	James Tappin: sjt@xun8.sr.bham.ac.uk
#	School of Physics & Space Research University of Birmingham
#	Feb 1993.		

# Copyright & Disclaimer.
#	This set of routines may be freely distributed, modified and
#	used, provided this copyright & disclaimer remains intact.
#	This package is used at your own risk, if it does what you
#	want, good; if it doesn't, modify it or use something else--but
#	don't blame me. Support level = negligable (i.e. mail bugs but
#	not requests for extensions)

# Usage:
#	needs a 'require "cgi_handlers.pl";' line in the main script
#
#	&get_request;    will get the request and decode it into an
#			 indexed array %rqpairs, the raw request is in
#			 $request
#
#	... = &url_decode(LIST); will return a URL decoded version of
#			         the contents of LIST
#
#	&html_header(TITLE); 	will write to standard output an HTML
#				header (including the content-type
#				field) giving the document the title
#				specified by TITLE.
#
#	&html_trailer;		Writes a trailer to the html document
#				with the name of the script generating
#				it and the date (in UT).

sub get_request {

    # Subroutine get_request reads the POST or GET form request from STDIN
    # into the variable  $request, and then splits it into its
    # name=value pairs in the associative array %rqpairs.
    # The number of bytes is given in the environment variable
    # CONTENT_LENGTH which is automatically set by the request generator.

    # Encoded HEX values and spaces are decoded in the values at this
    # stage.

    # $request will contain the RAW request. N.B. spaces and other
    # special characters are not handler in the name field.

    if ($ENV{'REQUEST_METHOD'} eq "POST") {
	read(STDIN, $request, $ENV{'CONTENT_LENGTH'});
    } elsif ($ENV{'REQUEST_METHOD'} eq "GET" ) {
	$request = $ENV{'QUERY_STRING'};
    }

    %rqpairs = &url_decode(split(/[&=]/, $request));
}

sub url_decode {

#	Decode a URL encoded string or array of strings 
#		+ -> space
#		%xx -> character xx

    foreach (@_) {
	tr/+/ /;
	s/%(..)/pack("c",hex($1))/ge;
    }
    @_;
}

sub html_header {

    # Subroutine html_header sends to Standard Output the necessary
    # material to form an HHTML header for the document to be
    # returned, the single argument is the TITLE field.

    local($title) = @_;

    print "Content-type: text/html\n\n";
    print "<html><head>\n";
    print "<title>$title</title>\n";
    print "</head>\n<body>\n";
}

sub html_trailer {

    # subroutine html_trailer sends the trailing material to the HTML
    # on STDOUT.

    local($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst)
	= localtime;

    local($mname) = ("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul",
		     "Aug", "Sep", "Oct", "Nov", "Dec")[$mon];
    local($dname) = ("Sun", "Mon", "Tue", "Wed", "Thu", "Fri",
		     "Sat")[$wday]; 

#   print "<p>\nGenerated by: <var>$0</var><br>\n";
    print "<hr>\n";
#   print "<hr> <address>\n";
#   print "Copyright &#169; 1995";
    print "<b><a href=\"http://acm.rpi.edu/~thinker/\">Vishal Apte</a></b> ";
    print "\(aptev\@rpi.edu\)";
#   print "</address>\n";
    print "<p>Date: $hour:$min:$sec EST on $dname $mday $mname $year.<p>\n";
    print "</body></html>\n";
}
1;

