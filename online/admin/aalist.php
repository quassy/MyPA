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

require "popup_header.php";
require_once "admhead.php";
require_once "admform.php";

require_once "../alliance_func.inc";

echo "<center>\n";

if ($allid && $Planetid<=2) {

  $myrow["alliance_id"] = $allid;
  $myrow["status"] = 0;
  $all = get_alliance ();
  echo "<a href=\"aalist.php?allid=$allid\">Status</a>&nbsp;|&nbsp".
       "<a href=\"amem.php?allid=$allid\">Members</a>&nbsp;|&nbsp".
       "<a href=\"afor.php?allid=$allid\">Forum</a><br><br>\n";
  $myrow["alliance_id"] = 0;
  print_alliance_status ($all);
} else {
  $ref = "$_SERVER[PHP_SELF]?allid=";
  list_alliances_admin($ref);
}

echo "</center>\n";

require_once "../footer.php";