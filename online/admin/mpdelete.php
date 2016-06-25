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

require_once "admhead.php";
require_once "admform.php";

if($Planetid==1) {

  for ($playerid=608;$playerid<685; $playerid++) {

    $q = "SELECT x,y FROM planet WHERE id='$playerid'";
    $result = mysqli_query ($q, $db);
    if ($result && mysqli_num_rows($result) > 0) {
      $prow = mysqli_fetch_row($result);

      $q = "UPDATE user SET password='delete' WHERE planet_id='$playerid'";
      mysqli_query ($q, $db);
      $q = "DELETE FROM rc_build WHERE planet_id='$playerid'";
      mysqli_query ($q, $db);
      $q = "DELETE FROM rc WHERE planet_id='$playerid'";
      mysqli_query ($q, $db);
      $q = "DELETE FROM scan_build WHERE planet_id='$playerid'";
      mysqli_query ($q, $db);
      $q = "DELETE FROM scan WHERE planet_id='$playerid'";
      mysqli_query ($q, $db);
      $q = "DELETE FROM pds_build WHERE planet_id='$playerid'";
      mysqli_query ($q, $db);
      $q = "DELETE FROM pds WHERE planet_id='$playerid'";
      mysqli_query ($q, $db);
      $q = "DELETE FROM unit_build WHERE planet_id='$playerid'";
      mysqli_query ($q, $db);
      // eigentlich alle msg durchsehen
      $q = "SELECT id FROM mail WHERE sender_id='$playerid' OR ".
           "planet_id='$playerid'";
      $res = mysqli_query ($q, $db);
      while ($mr = mysqli_fetch_row($res)) {
         mysqli_query ("DELETE FROM msg WHERE mail_id='$row[0]'", $db);
      }
      $q = "DELETE FROM mail WHERE sender_id='$playerid' OR ".
           "planet_id='$playerid'";
      mysqli_query ($q, $db);
      // $q = "UPDATE msg SET planet_id=0,folder=0 WHERE planet_id='$playerid'";
      // mysqli_query ($q, $db);
      // $q = "UPDATE mail SET sender_id=0 WHERE sender_id='$playerid'";
      // mysqli_query ($q, $db);
      // $q = "UPDATE mail SET planet_id=0 WHERE planet_id='$playerid'";
      mysqli_query ($q, $db);
      $q = "DELETE FROM news WHERE planet_id='$playerid'";
      mysqli_query ($q, $db);

      $q = "SELECT fleet_id FROM fleet WHERE planet_id='$playerid'";
      $result = mysqli_query ($q, $db);
      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
          $q = "DELETE FROM units WHERE id='$row[0]'";
          mysqli_query ($q, $db);
        }
      }
      $q = "DELETE FROM fleet WHERE planet_id='$playerid'";
      mysqli_query ($q, $db);
      $q = "DELETE FROM user WHERE planet_id='$playerid'";
      mysqli_query ($q, $db);
      $q = "DELETE FROM planet WHERE id='$playerid'";
      mysqli_query ($q, $db);

      $q = "UPDATE galaxy set members=members-1 where x='$prow[0]' ".
        "AND y='$prow[1]'";
      mysqli_query ($q, $db);
      $q = "UPDATE galaxy set gc=0 where x='$prow[0]' ".
        "AND y='$prow[1]' AND gc='$playerid'";
      mysqli_query ($q, $db);
      $q = "UPDATE planet set vote=0 WHERE vote='$playerid' ".
        "AND x='$prow[0]' AND y='$prow[1]'";
      mysqli_query ($q, $db);

      echo "<center>Planet $playerid deleted</center>";
    } else {
      echo "<center>Planet $playerid not found</center>";
    }
  }
}

require_once "../footer.php";