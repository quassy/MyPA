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

require "logging.php";

function check_post () {
  global $db, $Planetid;

//  if ($Planetid!=1) 
//    return;

  $q = "SELECT last_post,error FROM user WHERE planet_id='$Planetid' AND last_post > now() - 2";
  $res = mysql_query($q, $db);
  if (mysql_num_rows($res)>0) {

    $row = mysql_fetch_row($res);
    mysql_query("UPDATE user SET error=error+1 WHERE planet_id='$Planetid'");

    if ($row[1]>1) {
//    echo "<b>SPAM PROTECTION ACTIVATED</b>";
//    echo "</body></html>\n";
//    mysql_query("UPDATE planet set mode=1 WHERE id='$Planetid'");
      do_log_me(2, 10, "Repeated posting autologout ($row[1])");
      // for auto-ban ?!
      // die;
    }

    mysql_query("UPDATE user set last_post=now() WHERE planet_id='$Planetid'",$db);
  } else {
    mysql_query("UPDATE user set last_post=now(),error=0 WHERE planet_id='$Planetid'",$db);
  }
}

?>
