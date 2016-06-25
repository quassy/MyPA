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

require_once "planet_util.inc";
require_once "forum.inc";

$fstyle = 1; // politics
$fid = get_galaxy_id($myrow["x"], $myrow["y"]);

if (!ISSET($msg)) $msg = "";
$msg .= forum_init ($fstyle, $fid);

top_header ($myrow);

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

require "footer.inc";
