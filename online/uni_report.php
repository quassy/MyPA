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

function get_alliance_tag($aid) {
  global $db, $myrow;

  if ($aid == 0)
    return "";

  $res = mysql_query("SELECT tag FROM alliance WHERE id='$aid'",$db);
  if ($res && mysql_num_rows($res)>0) {
    $row = mysql_fetch_row($res);
    return "$row[0]";
  } else {
    return "";
 }
}

function print_uni_row ($rank, $row) {
  global $Planetid, $myrow, $tag;

  $tag_cell = "";

  if ($Planetid > 2) {
    if ($row[8] != 0 && $myrow["alliance_id"] == $row[8] && $tag != "") {
      $tag_cell="<td align=\"center\"><span class=\"red\">".
                "<b>$tag</b></span></td>\n";
    } else {
      if ($myrow["alliance_id"] !=0)
        $tag_cell="<td style=\"visibility:hidden\"></td>\n";
    }
  } else {
    if ($row[8] != 0) {
      $tag_cell="<td align=\"center\ align=\"center\">".
               "<span class=\"red\"><b>". get_alliance_tag($row[8]) .
               "</b></span></td>\n";
    } else {
      $tag_cell="<td style=\"visibility:hidden\"></td>\n";
    }
  }

  if ($Planetid == $row[7]) {
    echo "<tr class=\"uni\">\n";
  } else {
    echo "<tr>\n";
  }

  echo "<td align=\"right\">$rank</td>\n".
    "<td align=\"left\">$row[0]</td>\n".
    "<td align=\"left\">$row[1]</td>\n".
    "<td align=\"center\">".
    "<a href=\"galaxy.php?submit=search&x=$row[2]&y=$row[3]\">".
    "$row[2]:$row[3]:$row[4]</a></td>\n".
    "<td align=\"right\">".pval($row[5])."</td>\n".
    "<td align=\"right\">$row[6]</td>\n$tag_cell".
    "</tr>\n";
}

function print_universe_player_report ($db) {
  global $tag, $myrow;

  if (($myrow["status"] & 2)==0 && $myrow["alliance_id"] != 0)
    $tag = get_alliance_tag($myrow["alliance_id"]);
  
  /* sollte aus einem file kommen */

  $result = mysql_query ("SELECT leader, planetname, x, y, z, score, ".
			 "metalroids+crystalroids+eoniumroids+uniniroids ".
			 "AS roids, id, alliance_id FROM planet ".
			 "WHERE mode != 0 ".
			 "ORDER BY score DESC LIMIT 40 ", $db);

  if (mysql_num_rows($result) == 0) {
    /* empty  */
    echo "<tr><td colspan=\"6\" align=\"center\"><font color=\"red\">".
      "No rankings found</font></td></tr>\n";
  } else {
    $count = 1;
    while ($myuni=mysql_fetch_row ($result)) {
      print_uni_row ($count,$myuni);
      $count += 1;
    }
  }
}

function print_gal_row ($rank, $row) {
  global $myrow, $db;

  if ($myrow["x"] == $row[0] && $myrow["y"] == $row[1]) {
    echo "<tr class=\"uni\">\n";
  } else {
    echo "<tr>\n";
  }

  $result = mysql_query ("SELECT name FROM galaxy ".
			 "WHERE x='$row[0]' AND y='$row[1]'", $db);

  if ($result && mysql_num_rows($result)) {
    $grow = mysql_fetch_row($result);
    $gname = $grow[0];
  } else {
    $gname = "Far Far Away";
  }
  
  echo "<td align=\"right\">$rank</td>\n".
    "<td align=\"left\">$gname</td>\n".
    "<td align=\"center\">".
    "<a href=\"galaxy.php?submit=search&x=$row[0]&y=$row[1]\">".
    "$row[0]:$row[1]</a></td>\n".
    "<td align=\"right\">".pval($row[2])."</td>\n".
    "<td align=\"right\">$row[3]</td>\n".
    "</tr>\n";
}

function print_universe_galaxy_report ($galrank) {
  // global $db;

  if ($galrank != 0) {
    $len = count($galrank);
    for ($i=1; $i<=$len; $i++) {
      print_gal_row ($i,$galrank[$i]);
    }
  } else {
    echo "<tr><td colspan=\"5\" align=\"center\"><font color=\"red\">".
      "No rankings found</font></td></tr>\n";
  }

}

function get_universe_galaxy_report (&$myrank) {
  global $db, $myrow;

  $myrank = 0;

  /* sollte aus einem file kommen */
  $q = "SELECT x, y, SUM(score) AS sc, SUM(metalroids + crystalroids + ".
     "eoniumroids + uniniroids) FROM planet WHERE mode != 0 ".
     "GROUP by x, y ORDER BY sc DESC";

  $result = mysql_query ($q, $db);

  if (mysql_num_rows($result) > 0) {
    $count = 1;
    while ($mygal=mysql_fetch_array ($result)) {

      if ($count <= 20) {
        $ret[$count] = $mygal;
      } else {
        if ($mygal["x"] == $myrow["x"] && 
            $mygal["y"] == $myrow["y"]) { 
          $myrank = $count;
        }
      }
      $count += 1;
    }
    return $ret;
  } else {
    return 0;
  }
}

function print_alliance_row ($rank, $row) {
  global $myrow;

  if ($myrow["alliance_id"] == $row["aid"])
    echo "<tr class=\"uni\">\n";
  else 
    echo "<tr>\n";

  $ascore = pval($row["a_score"]);
  echo <<<EOF
  <td align="right">$rank</td>
  <td align="center">[$row[tag]]</td>
  <td>$row[hcname]</td>
  <td align="center">$row[members]</td>
  <td align="right">$ascore</td></tr>
EOF;
}

function print_universe_alliance_report () {
  global $db;

  $q = "SELECT alliance.id AS aid, tag, hcname, members, ".
       "SUM(score)/members AS a_score ".
       "FROM planet, alliance WHERE members>2 ".
       "AND alliance.id=planet.alliance_id ".
       "GROUP BY alliance.id ORDER BY a_score DESC";
  $res = mysql_query ($q, $db);

  if (mysql_num_rows($res) > 0) {
    $rank = 1;
    while ($row = mysql_fetch_array($res)) {
      print_alliance_row ($rank, $row);
      $rank += 1;
    }
  } else {
    echo "<tr><td colspan=\"5\"><span class=\"red\">".
         "No alliances found</span></td></tr>\n";
  }
}

?>
