<?
	$username = "";
	$password = "";

	if ( $username && ($PHP_AUTH_USER != $username || $PHP_AUTH_PW != $password) )
	{
		// no authentication data -> deny access.
		Header( "WWW-Authenticate: Basic Realm=\"BC logcount\"");
		Header( "HTTP/1.0 401 Unauthorized");
		echo "<html><body bgcolor='white'><h1>Access Denied</h1></body></html>";
		exit;
	}

	$logfile = "logs.php";

	if ( filesize($logfile) == 0 )
		die( "Zippo in the logfiles... perhaps you should read the install.txt again, hmmm?" );

	if (!$hits )
		$hits = 60000;

?>
<html><body>
<form>
Get the last <input type=text value="<?= $hits ?>" size=6 name=hits> hits <input type=submit value="Now!">
</form>
<?
	set_time_limit( 6000 );

	/* log file */

	$pagehits = 0;
 	$visitors = 0;
 	$fp = fopen ($logfile,"r");

//	die("Peace");
	if ( $hits )
		fseek($fp,filesize($logfile) - ($hits * 4) );


	$binarydata = fread( $fp, 4 );

	list($msec, $sec) = split( " ", microtime());
	$utime = $msec + $sec;

	$nowis = mktime (0,0,0,date("m")  ,date("d"),date("Y"));

	while( strlen($binarydata) == 4 )
	{
		$pagehits++;

		$data = unpack ("Ltime", $binarydata);

		$h = date("H", $data["time"]);

		$hours[$h]++;
		if ( $data["time"] > $nowis )
			$lasthours[$h]++;
		$daysoftheweek[date("l", $data["time"])]++;
		$days[date("M j", $data["time"])]++;
		$visitors++;

		$binarydata = fread( $fp, 4 );
 	}
 	fclose( $fp );

	list($msec, $sec) = split( " ", microtime());
	$itime = $msec + $sec;
	$diff = $itime - $utime;

	echo "Took me ". round($diff,2) ." freaking seconds! That is almost ". ceil($diff/60) ." minute(s)..<br>";

	ksort($hours);
	ksort($lasthours);

	echo "Pagehits : ". $pagehits .", Unique visitors : ". $visitors .", Logfile size : ". filesize($logfile) ."<br><br>";

	$row = 0;

	/* hours */
	echo "<table cellspacing=1 border=1 cellpadding=2>";
	echo "<tr><th colspan=24 align=center>Hourly hits</th></tr>";
	foreach ( (array)$hours as $hour => $count )
	{
		if ( $tel++ == 12 ) $row++;
		$row1[$row] .= "<th>$hour:00</th>";
		$row2[$row] .= "<td>$count</td>";
		if ( $max <  $count )
			$max = $count;
	}
	for ( $i = 0; $i < sizeof($row1); $i++ )
		echo "<tr>". $row1[$i] ."</tr><tr>". $row2[$i] ."</tr>";
	echo "</table><br>";
	echo "<table cellspacing=2 celpadding=0 border=0><tr valign=bottom align=center>";
	foreach ( (array)$hours as $hour => $count )
		echo "<td><img src='bar_topbot.gif'><br><img src='bar.gif' width=20 height=". round(($count/$max)*200) ."><br><img src='bar_topbot.gif' height=1 width=20><br>". $hour ."</td>";
	echo "<td valign=top>-". $max ."</td>";
	echo "</tr></table><br>";

	$tel = 0;$row = 0;unset($row1);unset($row2); $max = 0;

	/* daysoftheweek */
	echo "<table cellspacing=1 border=1 cellpadding=2>";
	echo "<tr><th colspan=24 align=center>Hits per day of the week</th></tr>";
	foreach ( (array)$daysoftheweek as $dayoftheweek => $count )
	{
		$row1[$row] .= "<th>$dayoftheweek</th>";
		$row2[$row] .= "<td>$count</td>";
		if ( $max <  $count )
			$max = $count;
	}
	for ( $i = 0; $i < sizeof($row1); $i++ )
		echo "<tr>". $row1[$i] ."</tr><tr>". $row2[$i] ."</tr>";
	echo "</table><br>";
	echo "<table cellspacing=2 celpadding=0 border=0><tr valign=bottom align=center>";
	foreach ( (array)$daysoftheweek as $dayoftheweek => $count )
		echo "<td><img src='bar_topbot.gif'><br><img src='bar.gif' width=20 height=". round(($count/$max)*200) ."><br><img src='bar_topbot.gif' height=1 width=20><br>". substr($dayoftheweek,0,3) ."</td>";
	echo "<td valign=top>-". $max ."</td>";
	echo "</tr></table><br>";


	$tel = 0;$row = 0;unset($row1);unset($row2); $max = 0;

	/* days */
	echo "<table cellspacing=1 border=1 cellpadding=2>";
	echo "<tr><th colspan=24 align=center>Hits per day of the week</th></tr>";
	foreach ( (array)$days as $day => $count )
	{
		if ( $tel++ == 12 ) $row++;
		$row1[$row] .= "<th>$day</th>";
		$row2[$row] .= "<td>$count</td>";
		if ( $max <  $count )
			$max = $count;
	}
	for ( $i = 0; $i < sizeof($row1); $i++ )
		echo "<tr>". $row1[$i] ."</tr><tr>". $row2[$i] ."</tr>";
	echo "</table><br>";
	echo "<table cellspacing=2 celpadding=0 border=0><tr valign=bottom align=center>";
	foreach ( (array)$days as $day => $count )
		echo "<td valign=bottom><img src='bar_topbot.gif'><br><img src='bar.gif' width=20 height=". round(($count/$max)*200) ."><br><img src='bar_topbot.gif' height=1 width=20><br>". substr($day,-2,2) ."</td>";
	echo "<td valign=top>-". $max ."</td>";
	echo "</tr></table><br>";


	$tel = 0;$row = 0;unset($row1);unset($row2); $max = 0;

	/* hours */
	echo "<table cellspacing=1 border=1 cellpadding=2>";
	echo "<tr><th colspan=24 align=center>Hourly hits today</th></tr>";
	foreach ( (array)$lasthours as $hour => $count )
	{
		if ( $tel++ == 12 ) $row++;
		$row1[$row] .= "<th>$hour:00</th>";
		$row2[$row] .= "<td>$count</td>";
		if ( $max <  $count )
			$max = $count;
	}
	for ( $i = 0; $i < sizeof($row1); $i++ )
		echo "<tr>". $row1[$i] ."</tr><tr>". $row2[$i] ."</tr>";
	echo "</table><br>";
	echo "<table cellspacing=2 celpadding=0 border=0><tr valign=bottom align=center>";
	foreach ( (array)$lasthours as $hour => $count )
		echo "<td valign=bottom><img src='bar_topbot.gif'><br><img src='bar.gif' width=20 height=". round(($count/$max)*200) ."><br><img src='bar_topbot.gif' height=1 width=20><br>". $hour ."</td>";
	echo "<td valign=top>-". $max ."</td>";
	echo "</tr></table><br>";

?>
</html></body>