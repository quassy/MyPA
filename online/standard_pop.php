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

require "auth_check.php";
require "options.php";
include_once "get_ip.php";

$player_ip=get_ip();

pre_auth($Username,$Password,$Planetid,$Valid);

require "dblogon.php";

db_auth($db,$Username,$Password,$Planetid);

$result = mysql_query("SELECT tick FROM general"); 
$row = mysql_fetch_row($result);
$mytick = $row[0];

require "header.php";
if ($extra_header) {
  my_header($extra_header,0,0);
} else {
  my_header("",0,0);
}

$result = mysql_query("SELECT * FROM planet WHERE id='$Planetid'",$db);
$myrow = mysql_fetch_array($result);

mysql_query("UPDATE user set last=NOW(),last_tick='$mytick',".
	    "ip='$player_ip' ".
            "WHERE planet_id='$Planetid'"); 

?>
