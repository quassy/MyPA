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


if ($submit) echo "Found submit<br>";
if ($playerid) echo "Playerid $playerid<br>";
if ($verification) echo "Verification: $verification<br>";

if ($submit && $playerid && $playerid != 1) {

  if ($verification && $verification==$playerid) {

    $q = "SELECT x,y,alliance_id FROM planet WHERE id='$playerid'";
    $result = mysql_query ($q, $db);
    if ($result && mysql_num_rows($result) > 0) {
      $prow = mysql_fetch_row($result);

      if ($prow[2] != 0) {
        $q = "SELECT hc FROM alliance WHERE id='$prow[2]' AND hc='$playerid'";
        $res = mysql_query ($q, $db);
        if ($res && mysql_num_rows($result) > 0) {
           // this is an HC .. deleting alliance
           mysql_query("UPDATE planet SET alliance_id=0,status=status&0xFD ".
                       "WHERE alliance_id='$prow[2]'", $db);
           mysql_query("DELETE FROM alliance WHERE id='$prow[2]'", $db);
           echo "Alliance deleted ..";
        }
      }

      $q = "UPDATE user SET password='delete' WHERE planet_id='$playerid'";
      mysql_query ($q, $db);
      $q = "DELETE FROM rc_build WHERE planet_id='$playerid'";
      mysql_query ($q, $db);
      $q = "DELETE FROM rc WHERE planet_id='$playerid'";
      mysql_query ($q, $db);
      $q = "DELETE FROM scan_build WHERE planet_id='$playerid'";
      mysql_query ($q, $db);
      $q = "DELETE FROM journal WHERE planet_id='$playerid'";
      mysql_query ($q, $db);
      $q = "DELETE FROM journal WHERE target_id='$playerid'";
      mysql_query ($q, $db);
      $q = "DELETE FROM scan WHERE planet_id='$playerid'";
      mysql_query ($q, $db);
      $q = "DELETE FROM pds_build WHERE planet_id='$playerid'";
      mysql_query ($q, $db);
      $q = "DELETE FROM pds WHERE planet_id='$playerid'";
      mysql_query ($q, $db);
      $q = "DELETE FROM unit_build WHERE planet_id='$playerid'";
      mysql_query ($q, $db);

      // eigentlich alle msg durchsehen
      $q = "SELECT id FROM mail WHERE sender_id='$playerid' OR ".
           "planet_id='$playerid'";
      $res = mysql_query ($q, $db);
      while ($mr = mysql_fetch_row($res)) {
         mysql_query ("DELETE FROM msg WHERE mail_id='$row[0]'", $db);
      }
      $q = "DELETE FROM mail WHERE sender_id='$playerid' OR ".
           "planet_id='$playerid'";
      mysql_query ($q, $db);
      // $q = "UPDATE msg SET planet_id=0,folder=0 WHERE planet_id='$playerid'";
      // mysql_query ($q, $db);
      // $q = "UPDATE mail SET sender_id=0 WHERE sender_id='$playerid'";
      // mysql_query ($q, $db);
      // $q = "UPDATE mail SET planet_id=0 WHERE planet_id='$playerid'";
      mysql_query ($q, $db);
      $q = "DELETE FROM news WHERE planet_id='$playerid'";
      mysql_query ($q, $db);

      $q = "SELECT fleet_id FROM fleet WHERE planet_id='$playerid'";
      $result = mysql_query ($q, $db);
      if ($result && mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_row($result)) {
          $q = "DELETE FROM units WHERE id='$row[0]'";
          mysql_query ($q, $db);
        }
      }
      $q = "DELETE FROM fleet WHERE planet_id='$playerid'";
      mysql_query ($q, $db);
      $q = "DELETE FROM user WHERE planet_id='$playerid'";
      mysql_query ($q, $db);
      $q = "DELETE FROM planet WHERE id='$playerid'";
      mysql_query ($q, $db);

      $q = "SELECT exile_id FROM galaxy WHERE x='$prow[0]' ".
        "AND y='$prow[1]' AND exile_id='$playerid'";
      $res = mysql_query ($q, $db);
      if ($res && mysql_num_rows($result) > 0) {
        mysql_query ("UPDATE planet SET exile_vote=0 ".
                     "WHERE x='$prow[0]' AND y='$prow[1]'", $db);
        mysql_query ("UPDATE galaxy SET exile_date=0,exile_id=0 ".
                     "WHERE x='$prow[0]' AND y='$prow[1]'", $db);
      } 

      $q = "UPDATE galaxy set members=members-1 where x='$prow[0]' ".
        "AND y='$prow[1]'";
      mysql_query ($q, $db);
      $q = "UPDATE galaxy set gc=0,moc=0 where x='$prow[0]' ".
        "AND y='$prow[1]' AND gc='$playerid'";
      mysql_query ($q, $db);
      $q = "UPDATE galaxy set moc=0 where x='$prow[0]' ".
        "AND y='$prow[1]' AND moc='$playerid'";
      mysql_query ($q, $db);
      $q = "UPDATE planet set vote=0 WHERE vote='$playerid' ".
        "AND x='$prow[0]' AND y='$prow[1]'";
      mysql_query ($q, $db);

      echo "<center>Planet deleted</center>";
    } else {
      echo "<center>Planet not found</center>";
    }
  } else {
    $q = "SELECT leader,planetname,x,y,z FROM planet  WHERE id='$playerid'";
    $result = mysql_query ($q, $db);

    if ($result && mysql_num_rows($result) > 0) {
      $row = mysql_fetch_row($result);
      echo "<center>\n".
	"<table  width=640 border=1 cellpadding=2 >".
	"<tr><td>Really delete this player?</td></tr>".
	"<tr><td>$row[0] of $row[1] ($row[2]:$row[3]:$row[4])</td></tr>".
	"<tr><td align=\"center\"><a href=\"$PHP_SELF?submit=1&playerid=$playerid&verification=$playerid\">Yes</a></td></tr>".
	"</table>";
    } else {
      echo "<center> No such Planet </center>";
    }
  } 
} else {
  echo <<<EOF
<center>
<table  width="640" border="1" cellpadding="2" >
<tr>
<form method="post" action="$PHP_SELF">
  <td align="center" bgcolor="#c0c0c0">Enter target id:</td>
  <td><input type="text" name="playerid" size="25"></td>
  <td colspan="2"><input type=submit value="  Delete  " name=submit></td>
</form>
</tr>
</table>
</center>
EOF;
}

require_once "../footer.php";
?>
