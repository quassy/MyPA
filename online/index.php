<?php

/*
 * MyPHPpa
 * Copyright (C) 2003 Jens Beyer
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

require "options.php";
require "dblogon.php";
require "logging.php";
include_once "get_ip.php";
include_once "check_ip.php";
include_once "auth_check.php";

$imgpath="true";
require "header.php";

if ($submit && $game_closed) {
  if ($login!="admin") {
    $login = "";
    $password = "";
  }
}

if ( !check_ip(get_ip()) ) {
  Header("Location: http://web.de");
  die;
}

$result = mysql_query("SELECT tick FROM general"); 
$mtrow = mysql_fetch_row($result);
$mytick = $mtrow[0];

if ($submit && $login && $password) {
 
  $result = mysql_query("SELECT user.planet_id, planet.mode, " .
                        "user.last + interval 5 minute < now(), ".
                        "user.last IS NOT NULL ".
			"FROM user, planet ".
			"WHERE login='$login' ".
			"AND password='$password' " .
			"AND planet.id=user.planet_id", $db);

  if (mysql_num_rows($result) == 1) {
    $myrow = mysql_fetch_row($result);

    if (($myrow[1] & 0x0F) == 4 ) {
      // Vacation mode
      $result = mysql_query("SELECT last_sleep+INTERVAL 48 HOUR > now(), ".
			    "last_sleep+INTERVAL 48 HOUR FROM user ".
			    "WHERE planet_id='$myrow[0]'", $db);
      if ($result) {
	$stat = mysql_fetch_row($result);
	if ($stat[0] == 1) {
          my_header($topscript,0,0);

          echo "<center><br><img src=\"".
               "/img/logo.jpg\"" .
               "width=\"290\" height=\"145\"><br><br>\n";
	  echo "<b>Your account is in Vacation until ".
	    "$stat[1]</b></center>";
	  die;
	}
	// echo " found ended Vacation";

      } else {
	Header("Location: error.php");
	die;
      }
    } else if (($myrow[1] & 0x0F) == 3 && $force != 1) {
      // sleep mode
      $result = mysql_query("SELECT last_sleep+INTERVAL 6 HOUR < now(), ".
                            "last_sleep+INTERVAL 6 HOUR FROM user ".
                            "WHERE planet_id='$myrow[0]'", $db);
      if ($result) {
        $stat = mysql_fetch_row($result);

        if ($stat[0] == 0) {
	  my_header("",0,0);
          echo "<br><br><br><br><br><br>\n";
	  echo "<center><b>Your account is in sleep mode until ".
            "$stat[1]</b>\n";
	  echo "<br><br><br><form method=post action=$PHP_SELF>\n";
	  echo "<input type=submit value=\"Enter anyway\" name=submit>";
	  echo "<input type=hidden value=\"1\" name=force>";
	  echo "<input type=hidden value=\"$login\" name=login>";
	  echo "<input type=hidden value=\"$password\" name=password>";
	  echo "</form></center></body></html>";
          die;
        }
      } 
    } else if ($myrow[1] != 0  && $myrow[2] == 0 && $myrow[3] == 1 
               && $mytick>0 && $myrow[0]>2) {
        // just logged out
        my_header("",0,0);
        echo "<center><br><img src=\"".
               "/img/logo.jpg\"" .
               "width=\"290\" height=\"145\"><br><br>\n";
        echo "<table border=\"1\" cellpadding=\"15\">\n";
        echo "<tr><td><b>Your account is already logged in</b> or ".
             "<b>You logged out during the past 5 minutes.</b><br>";
        echo "You will have to wait up to 5 minutes to ".
             "<a href=\"/index.php\">login</a> again.";
        echo "</td></tr></table></center></body></html>";
        die; 
    } else if ($myrow[1] == 0) {
      $res = mysql_query ("SELECT data FROM logging ".
                          "WHERE class=2 and type=5 and planet_id='$myrow[0]'",
			  $db);
      $reason = "Unspecified";
      if ($res && mysql_num_rows($res)>0) {
        $ro = mysql_fetch_row($res);
        $reason=$ro[0];
      }
      setcookie("Username","");
      my_header($topscript,0,0);

      echo "<center><br><img src=\"".
           "/img/logo.jpg\"" .
           "width=\"290\" height=\"145\"><br><br>\n";
      echo "Your account has been <b>banned</b>, reason: \"$reason\"<br>".
           "Have a look at the <a href=help_general.php>".
           "Rules</a></center></body></html>\n";
      die;
    }

    setcookie("Username",$login);
    setcookie("Password",md5($password));
    setcookie("Planetid",$myrow[0]);
    setcookie("Valid",md5($round),time()+432000);

    $result = mysql_query("UPDATE planet SET mode=((mode & 0xF0) + 2) ".
			  "WHERE id='$myrow[0]'", $db);
    if (($myrow[1] & 0x0F) == 2) {
      $result = mysql_query("UPDATE user SET last=NOW() ".
			  "WHERE planet_id='$myrow[0]'", $db);
    } else {
      $result = mysql_query("UPDATE user SET last=NOW(),login_date=NOW() ".
			  "WHERE planet_id='$myrow[0]'", $db);
    }
    do_log_id($myrow[0], 1, 1, get_ip()); 
    do_log_id($myrow[0], 1, 2, get_type()); 
    // event:login=1, class:login/out=1    
 
    Header("Location: main.php");
    die;
  } else {
    setcookie("Username","");
  }
}

$result = mysql_query("SELECT COUNT(*) from user",$db);
$myrow = mysql_fetch_row($result);
$numuser = $myrow[0];
$result = mysql_query("SELECT COUNT(*) from planet where mode=2 OR mode=0xF2",$db);
$myrow = mysql_fetch_row($result);
$numonline = $myrow[0];


if (file_exists('/tmp/ticker.run')) {
   $tdate = date("d/m/y H:i:s", filemtime('/tmp/ticker.run'));
} else {
   $tdate = "<b><span class=\"red\">Ticker stopped</span></b>";
}

$topscript="<TITLE>MyPHPpa</TITLE>".
  "<script type=\"text/javascript\">\n".
  "<!--\n if(top!=self)\n top.location=self.location;\n".
  "//-->\n </script>\n";

my_header($topscript,0,0);

echo "<center><br><img src=\"/img/logo.jpg\"" .
     "width=\"290\" height=\"145\"><br><br>\n";

echo <<<EOF

<table border=1 cellspacing=8 cellpadding=8>
<tr><td colspan=3 >
EOF;

require_once "index_msg.inc";

if ($game_closed) {
  echo "<BR><center><h2><span class=\"red\">Game is currently ".
       "closed</span></h2></center>\n";
} else {
  if ($submit) {
    /* Failed login */
      echo "<BR><br><center><span class=\"red\"><b>Wrong Login ".
           "or Password !!</b></span></center><br>\n";
  }
}

echo <<<EOF
</td></tr>
<tr><td>

<table width=229 border=0 cellpadding=3>
 <tr>
  <td>Last tick:</td>
  <td align="right">$tdate</td>
 </tr>
 <tr>
  <td>MyT:</td>
  <td align="right">$mytick</td>
 </tr>
</table>

<table width=229 border=0 cellpadding=3>
 <tr>
  <td width="90%">Total registred users:</td>
  <td align="right">$numuser</td>
 </tr>
 <tr>
  <td width="90%">Total users online:</td>
  <td align="right">$numonline</td>
 </tr>
</table>

</td>
<td  width=230 valign=center>

<FORM method="post" action="$PHP_SELF">
<TABLE border=0 cellspacing=5 cellpadding=2>
  <TR>
    <TD align=right>Login:</TD>
    <TD><input type="text" name="login" size="16" maxlength="29"></TD>
  </TR>
  <TR>
    <TD align=right>Password:</TD>
    <TD><input type="password" name="password" size="16" maxlength="29"></TD>
  </TR>
  <TR>
    <TD></td>
    <TD>
    <input type=submit value="   Login   " name="submit">
  </TR>
</TABLE>
</FORM>

</td><td align="center" width=220>
<TABLE border=0>
 <tr>
EOF;

if ($mytick > $end_of_round) {
  echo "<td height=60 bgcolor=#212548><B>".
       "Signup is currently<br>closed</B></td>\n";
} else {
  echo "<td height=60 bgcolor=#212548><B><A HREF=\"signup.php\">".
       "Signup and create<br>your own account!</a></B></td>\n";
}

echo <<<EOF
 </tr>
 <tr><td><a href="sendpass.php">Lost</a> your password?</td></tr>
 <tr><td><a href="help.php">About</a> MyPHPpa</td></tr>
</table>
</center>

</td></tr>
<tr><td align=right colspan=3>

<div style="font-size: 10px;text-align:right;">
<a href="mailto:MyPHPpa@web.de">MyPHPpa@web.de</a>
</div>

</td></tr>
</table>

EOF;

require "footer.php";

?>
