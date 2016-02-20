<?php
/*
 * Name:	testurlopen.php
 * Author:	Russell Robinson, Root Software, July 2005
 *          www.tectite.com
 * Description:
 *	Tests opening URLs from within PHP.
 */

ini_set('track_errors',1);			/* enable $php_errormsg */
$bSafeMode = ini_get('safe_mode');
?>
<html>
<body>

<p>PHP version is: <?php echo phpversion(); ?></p>

<p>Safe mode is: <?php echo ($bSafeMode) ? "On (this is usually bad)" : "Off (this is good!)"; ?></p>

<?php
    /*
     * Try opening www.microsoft.com
     */
@$fIn = fopen("http://www.microsoft.com/","r");
if ($fIn !== FALSE)
{
    echo "<p>URL open succeeded!</p>";
	fclose($fIn);
}
else
	echo "<p>URL open failed: $php_errormsg</p>";
?>
</body>
</html>
