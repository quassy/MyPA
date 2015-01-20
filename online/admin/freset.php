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

require_once "admhead.php";
require_once "admform.php";
require_once "../create_user.php";

function create_gal ($x, $y) {
  global $db;

  $result = mysql_query ("SELECT id FROM galaxy WHERE x='$x' AND y='$y'", $db);

  if ($result && (mysql_num_rows($result) == 0)) {
    $result = mysql_query ("INSERT INTO galaxy set x='$x',y='$y'", $db);
  }
}

function trunc_table ($table) {
  global $db, $dbname;

  echo "TRUNCATE TABLE $dbname.$table<br>";
  if (file_exists('/tmp/ticker.run') || $table=="") {
    echo "<b>Cant do that now!</b><br>";
  } else {
    $result = mysql_query ("TRUNCATE TABLE $dbname.$table", $db);
    if ($result) echo "truncated $table...<br>\n"; 
  }
}

function create_admin () {
  global $db;

  $result = mysql_query("INSERT into user ".
                        "SET login='admin',password='admin'," .
                        "email='myphppa@web.de',planet_id='1'",$db);
  if (!$result) {
    echo "Failed to insert admin<br>";
    return;
  }
  $result = mysql_query("INSERT into user ".
                        "SET login='moderator',password='moderator'," .
                        "email='myphppa@web.de',planet_id='2'",$db);
  if (!$result) {
    echo "Failed to insert moderator<br>";
    return;
  }

  $result = mysql_query("INSERT into planet set planetname='here'," .
                        "leader='Admin',mode=0xF2,x=1,y=1,z=1", $db);
  $planet_id = mysql_insert_id ($db);

  /* signup date, first tick */
  $result = mysql_query("UPDATE user SET planet_id='$planet_id',".
                        "signup=NOW(),first_tick=0,last=NOW() WHERE ".
                        "login='admin' AND password='admin'", $db);

  create_user ($planet_id);

  $result = mysql_query("INSERT into planet set planetname='the game'," .
                        "leader='Moderator',mode=0xF2,x=1,y=1,z=2", $db);
  $planet_id = mysql_insert_id ($db);

  /* signup date, first tick */
  $result = mysql_query("UPDATE user SET planet_id='$planet_id',".
                        "signup=NOW(),first_tick=0,last=NOW() WHERE ".
                        "login='moderator' AND password='moderator'", $db);
  create_user ($planet_id);

  $result = mysql_query("UPDATE galaxy SET members=2, name='My Galaxy' ".
                        "WHERE id=1", $db);

}
?>


<br>

<?php

if ($submit) {
  trunc_table ("fleet");
  trunc_table ("fleet_cap");
  trunc_table ("galaxy");
  trunc_table ("politics");
  trunc_table ("poltext");
  trunc_table ("msg");
  trunc_table ("mail");
  trunc_table ("news");
  trunc_table ("pds");
  trunc_table ("pds_build");
  trunc_table ("planet");
  trunc_table ("rc");
  trunc_table ("rc_build");
  trunc_table ("scan");
  trunc_table ("scan_build");
  trunc_table ("unit_build");
  trunc_table ("units");
  trunc_table ("user");
  trunc_table ("alliance");
  trunc_table ("journal");

  trunc_table ("logging");
  trunc_table ("general");

  $result = mysql_query ("INSERT INTO general set tick=0", $db);
  if ($result)
    echo "reset ticks to 0...<br>\n";

  echo "creating gals...";
  for ($i=1; $i<=$universe_size;$i++) {
    for ($j=1; $j<=$cluster_size;$j++) {
      echo "$i $j<br>";
      create_gal($i, $j);
    }
  }
  create_admin();
  echo "done<br<\n";

  echo "<b>All data reset - plz signup again now";
} else {
?>
<center>
<form method="post" action="<?php echo $PHP_SELF?>">
<table width="650" border="1" cellpadding="10">
<tr><th>You really want to recreate theuniverse ?<br>
You will have to signup again after this</th></tr>
<tr><td align="center"><input type=submit value="DO IT" name="submit"></td></tr>
</table>
</form>
</center>
<?php
}

require_once "../footer.php";
?>
