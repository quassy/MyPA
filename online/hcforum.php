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

require_once "popup_header.inc";
require_once "standard.php";

require_once "alliance_func.inc";
require_once "forum.inc";

$all = get_alliance();
if (!ISSET($msg)) $msg = "";

if ($all && 
    $all["hc"] == $Planetid && 
    ($all["members"]>2 || $Planetid<2)) {
  $fstyle = 3; // alliance
  $fid = 1023;

  $msg .= forum_init ($fstyle, $fid);

} else {
  if ($all && $all["hc"] == $Planetid) {
    $msg = "Your alliance needs at least 3 members.";
  } else {
    $msg = "You arent allowed here.";
  }
}

top_header ($myrow);

if ($all && $all["hc"] == $Planetid && ($all["members"]>2 || $Planetid<2)) {
  
  if (ISSET($fthread)) {
    $msg .= forum_submit ($fstyle, $fid, $fthread);
  } else {
    $msg .= forum_submit ($fstyle, $fid, 0);
  }

  $ftitle = forum_title ($fstyle);

  titlebox ($ftitle, $msg);

  echo "<center>\n";

  if (ISSET($fthread)) {
    forum_show_thread ($fstyle, $fid, $fthread);
  } else {
    forum_list_thread ($fstyle, $fid);
  }
} else {
  titlebox ("HC Forum", $msg);
}

require "footer.inc";
