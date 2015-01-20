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

$close_script="<SCRIPT LANGUAGE=\"javascript\">\n".
"<!--\n".
"// Begin\n".
"function wclose() {".
"  this.close();".
"}\n// END\n//-->\n</SCRIPT>\n";

$extra_header = "   <TITLE>Scan Window</TITLE>\n$close_script";

require "standard_pop.php";
require "planet_util.php";
require "news_util.php";

require "scan_util_2.inc";

$save_link = "";
if ($scan && $number && $x && $y && $z) {
  echo "<br>\n";
  $number = (int) $number;
  $number = ($number>1000?1000:$number);
  $reach = scan_target ($scan, $x, $y, $z, $number);
  echo "<center>";
  if ($reach && $scan != 7) $save_link = 
     "<a href=\"$PHP_SELF?save=$scan&x=$x&y=$y&z=$z\">Save scan</a>";
} else if ($save && $x && $y && $z ) {
  $tid = get_id ($x, $y, $z);

  if ($tid) {

    $q = "SELECT id,data FROM journal WHERE planet_id='$Planetid' ".
       "AND target_id='$tid' AND type='$save'"; // AND hidden=1
    $result = mysql_query ($q, $db);

    if ($result && mysql_num_rows($result) > 0) {
      $row = mysql_fetch_row($result);
      echo "<br>\n$row[1]";
      mysql_query ("UPDATE journal SET hidden=0 WHERE id=$row[0]", $db);
    }
  }
} else {
  $msg = "Submission failure!";
}

if ($msg != "") {
  echo "<center><table width=\"650\" border=\"1\" cellpadding=\"10\">".
      "<tr><td><font color=\"red\"><b>$msg</b></font></td></tr></table>";
}

echo <<<EOF
<table width="650" border="0"><tr><td align="left">$save_link</td>
<td align="right"><a href="javascript:close()">Close this Window</a></td>
</tr></table>
EOF;

require "footer.php";
?>
