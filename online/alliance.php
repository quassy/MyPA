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

require "popup_header.inc";

require "standard.php";
require "planet_util.inc";
require "news_util.php";
include_once "alliance_func.inc";

$msg = "";

$all = get_alliance ();

if (ISSET($ncreate) && $myrow["alliance_id"] == 0) 
  $msg .= create_alliance ($nhc, $ntag, $nname);

if (ISSET($ojoin) && ISSET($osecret) && $osecret!="") 
  $msg .= join_alliance ($osecret);

if (ISSET($oquit))
  $msg .= leave_alliance();

if (ISSET($osec))
  $msg .= change_secret ();

if (ISSET($odel)) 
  $msg .= delete_alliance();

if (ISSET($oela) && ISSET($offa))
  $msg .= elect_offa($offa);

/* top table is written now */
top_header($myrow);

titlebox("Alliance", $msg);

echo "<center>\n";

if (!$all || $myrow["alliance_id"] == 0) {

  create_menu();
  echo "<br>\n";
  join_menu();

} else {

  print_alliance_status ($all);

  if ($all && $all["offa"] == $myrow["id"]) {
    off_menu ();
  } 
  if ($all && $all["hc"] == $myrow["id"]) {
    hc_menu ();
  } 

}
?>
</center>

<?php
require "footer.php";
