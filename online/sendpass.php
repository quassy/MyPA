<?php

/*
 * MyPHPpa
 * Copyright (C) 2003, 2007 Jens Beyer
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

require_once "options.php";
require_once "dblogon.php";

require_once "header.php";

$imgpath="true";
my_header(0,0);

if ($game_closed == 1) {
  echo "<BR>\n<H1 align=center>Sorry, game is closed for now</H1>";
  die();
}

if ($submit) {

  if ($login && $email) {
    $q = "SELECT password FROM user WHERE login='$login' ".
       "AND email='$email'";
    $result = mysqli_query($q, $db);

    if ($result && mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_row($result);

      mail("$email", "$game password reminder",
	   "\nLogin: $login\nPassword: $row[0]\n\nHave Fun!!\n",
	   "From: MyPHPpa@web.de\nReply-To: MyPHPpa@web.de\nX-Mailer: PHP/" . phpversion());

      echo "<br><center><b>The password has been mailed to you</b>";
      echo "<br><br><a href=\"index.php\" target=\"_top\">Login</a></center>";
      die;
    }
  }

  echo "<br><center><b>Login or Email not in database!</b></center>";
}

?>

<center>
<br>
<img src="/img/logo.jpg" width="290" height="145">
<br>
<br>

<table border=1>


<tr><td>
<FORM method="post" action="<?php echo $_SERVER[PHP_SELF]?>">
<TABLE width=400 border=0 cellpadding=4>
  <TR>
    <TH height=40 align="center" colspan="2"><br>Enter your login and email:</TH>
  </TR>
  <tr><td colspan="2"><hr></tr></td>
  <TR>
    <TD align=right width=120>Login:</TD>
    <TD><input type="text" name="login" size="25" maxlength="29"></TD>
  </TR>
  <TR>
    <TD align=right>Email:</TD>
    <TD><input type="text" name="email" size="25" maxlength="249"></TD>
  </TR>
  <TR>
    <TD></td><td>
    <input type=submit value="   Search !   " name="submit">
  </TR>
</TABLE>
</FORM>
</td></tr>
</table>
</CENTER>

<?php
require_once "footer.php";
