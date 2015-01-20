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

require "standard.php";

function print_cost ($m, $c, $e=0) {
  $res = "";
  if ($m) $res .= "$m M ";
  if ($c) {
    $res .= "$c C ";
  }
  if ($e) {
     $res .= "$e E ";
  }
  return $res;
}

function get_factor() {
  global $page;

  if ($page && $page=="sell") {
    $factor = 0.5;
  } else {
    $factor = 2;
  } 
  return $factor;
}

function print_unit_row ($row, $stock, $type, $base=-1) {

  $factor = get_factor();
  $cost = print_cost ($row[2] * $factor, $row[3] * $factor, $row[4] * $factor);
  // $cost = print_cost (555,0,1000);

  echo "<tr><td>$row[1]</td>".
    "<td align=\"right\">$cost</td>" .
    "<td align=\"right\">$row[5]</td>".
    "<td align=\"center\"><input type=\"text\" name=\"".
    $type . "_$row[0]\" size=\"9\"></td>";

  if ($base > -1) {
    echo "<td align=\"right\">$stock</td>".
      "<td align=\"right\">$base</td>".
      "</tr>\n"; 
  } else {
    echo "<td align=\"right\">$stock</td></tr>\n";
  }
}

function get_num_from_price ($price, $num) {
  global $myrow; /* resources */

  if ( $myrow["metal"] < ($price[0] * $num) ) {
    $num = (int) ($myrow["metal"] / $price[0]);
  }
  if ( $myrow["crystal"] < ($price[1] * $num) ) {
    $num = (int) ($myrow["crystal"] / $price[1]);
  }
  if ( $myrow["eonium"] < ($price[2] * $num) ) {
    $num = (int) ($myrow["eonium"] / $price[2]);
  }

  return $num;
}

function get_market_price ($num, $price) {
  global $myrow; /* resources */
  global $db, $Planetid, $msg;

  $myrow["metal"]   += $price[0] * $num;
  $myrow["crystal"] += $price[1] * $num;
  $myrow["eonium"]  += $price[2] * $num;
      
  $q = "UPDATE planet SET metal='$myrow[metal]',crystal='$myrow[crystal]',".
       "eonium='$myrow[eonium]' where id='$Planetid'";
  $result = mysql_query($q, $db);

  $msg .= $q . "<br>";
  return $result;
}

function pay_market_price ($num, $price) {
  global $myrow; /* resources */
  global $db, $Planetid;

  $myrow["metal"]   -= $price[0] * $num;
  $myrow["crystal"] -= $price[1] * $num;
  $myrow["eonium"]  -= $price[2] * $num;
      
  $q = "UPDATE planet SET metal='$myrow[metal]',crystal='$myrow[crystal]',".
       "eonium='$myrow[eonium]' where id='$Planetid'";
  $result = mysql_query($q, $db);
  return $result;
}

function trade_ship_unit ($unit, $num) {
  global $Planetid, $db, $msg;

  $msg .= "$unit, $num<br>";
  $num = (int) $num;
  if ($num < 1) {
    $msg .= "Trying to cheat, eh? ";
    return;
  }

  $q = "SELECT uc.metal, uc.crystal, uc.eonium FROM unit_class AS uc, rc ".
       "WHERE uc.id='$unit' AND uc.rc_id=rc.rc_id ".
       "AND rc.status=3 AND rc.planet_id='$Planetid'";

  $res = mysql_query($q, $db);
  $msg .= $q ."<br>";
 
  if ($res && mysql_num_rows($res) == 1) {
    $price = mysql_fetch_row($res);
    $factor = get_factor();
    for ($i=0; $i<3; $i++) $price[$i] *= $factor;

    $msg .= "Found $price[0] M $price[1] C $price[2] E<br>";
    // $num = get_num_from_price ($price, $num);

    if ($num > 0) {

      //$q = "SELECT LEAST(num,'$num') FROM market ".
      //  "WHERE unit_id='$unit' AND type=1";

      $q = "SELECT LEAST(units.num,'$num'),fleet.fleet_id ".
	"FROM units, fleet ".
	"WHERE fleet.num=0 AND fleet.planet_id='$Planetid' ".
	"AND units.id=fleet.fleet_id AND units.unit_id='$unit'";

      $msg .= $q . "<br>";
      $res = mysql_query ($q, $db);
      $nrow = mysql_fetch_row($res);
      $num = $nrow[0];

      if ($num >0) {

         // mysql_query ("UPDATE market set num=num-'$num' ".
         //   "WHERE unit_id='$unit' AND type=1", $db);
         mysql_query ("UPDATE market set num=num+'$num' ".
            "WHERE unit_id='$unit' AND type=1", $db);

         // $msg .= "Ordering $num Units<br>";
         // pay_market_price($num, $price);
         $msg .= "Selling $num Units ($nrow[1])<br>";
         get_market_price($num, $price);

         // mysql_query ("INSERT INTO units (id,num,unit_id) ".
         //   "SELECT fleet_id,'$num','$unit' ".
         //   "FROM fleet WHERE num=0 AND planet_id='$Planetid'", $db);
         mysql_query ("UPDATE units set num=num-'$num' ".
            "WHERE id='$nrow[1]' AND unit_id='$unit'", $db);

      } else {
        $msg .= "No units available!";
      }
    }
  }
}

function market_table_head ($type, $flag)
{
  echo<<<EOF
<table border="1" width="650">
<tr><th colspan="6" class="a">$type Market</th></tr>
<tr><th width="120">Unit</th>
    <th width="200">Price per unit for first 1k</th>
    <th width="85">Avail.</th>
    <th width="80">Order</th>
EOF;
  if ($flag) {
    echo "<th width=\"80\">Base</th><th width=\"85\">Stock</th></tr>\n";
  } else {
    echo "<th width=\"165\">Stock</th></tr>\n";
  }
}

function market_all($q, $qq, $name, $str_type, $qb=0)
{
  global $Planetid, $db, $page;

  $result = mysql_query ($q, $db);
  if ($result && mysql_num_rows($result) > 0) {

    market_table_head($name, $qb);

    while ($myunit = mysql_fetch_row($result)) {

      $nr = mysql_query ( $qq ."'$myunit[0]' AND planet_id='$Planetid'", $db);

      $stock = mysql_fetch_row ($nr);
      if ( !$stock[0]) $stock[0] = 0;

      if ($qb) {
        $nr = mysql_query ( $qb ."'$myunit[0]' AND planet_id='$Planetid'", $db);
        $base = mysql_fetch_row ($nr);
        if ( !$base[0]) $base[0] = 0;

        print_unit_row ($myunit, $stock[0], $str_type, $base[0]);
      } else {
        print_unit_row ($myunit, $stock[0], $str_type);
      }
    }

    if ($page && $page=="sell") {
      echo "<tr><td colspan=\"6\" align=\"center\">\n".
         "<input type=submit value=\"   Sell   \" name=\"sell_".$str_type."\">".
         "&nbsp;&nbsp;&nbsp;<input type=reset value=\"  Reset  \"></td>\n".
         "</tr></table>\n";
    } else { 
      echo "<tr><td colspan=\"6\" align=\"center\">\n".
         "<input type=submit value=\"   Buy   \" name=\"buy_".$str_type."\">".
         "&nbsp;&nbsp;&nbsp;<input type=reset value=\"  Reset  \"></td>\n".
         "</tr></table>\n";
   }
  }
}

/* top table is written now */
top_header($myrow);

$msg = "";

// rc_id=91 == Market House
$res = mysql_query ("SELECT status FROM rc ".
  "WHERE rc_id=91 AND status=3 AND planet_id='$Planetid'", $db);

if (!$res || mysql_num_rows($res)==0) {
  $msg = "You didnt build a Trading Unit";
  $fail=1;
} else {
 $fail=0;
 if ($buy_ship || $sell_ship) {
  $msg .= "$buy_ship - $sell_ship<br>";
  if ($ship_1) trade_ship_unit (1, $ship_1);
  if ($ship_2) trade_ship_unit (2, $ship_2);
  if ($ship_3) trade_ship_unit (3, $ship_3);
  if ($ship_4) trade_ship_unit (4, $ship_4);
  if ($ship_5) trade_ship_unit (5, $ship_5);
  if ($ship_6) trade_ship_unit (6, $ship_6);
  if ($ship_7) trade_ship_unit (7, $ship_7);
  if ($ship_8) trade_ship_unit (8, $ship_8);
  if ($ship_9) trade_ship_unit (9, $ship_9);
  if ($ship_10) trade_ship_unit (10, $ship_10);
  if ($ship_11) trade_ship_unit (11, $ship_11);
  if ($ship_12) trade_ship_unit (12, $ship_12);
  if ($ship_13) trade_ship_unit (13, $ship_13);
  if ($ship_14) trade_ship_unit (14, $ship_14);
 }

 if ($buy_pds || $sell_pds) {
  if ($pds_20) trade_pds_unit (20, $pds_20);
  if ($pds_21) trade_pds_unit (21, $pds_21);
  if ($pds_22) trade_pds_unit (22, $pds_22);
  if ($pds_23) trade_pds_unit (23, $pds_23);
  if ($pds_24) trade_pds_unit (24, $pds_24);
 }

 if ($buy_scan || $sell_scan) {
  if ($scan_1) trade_scan (1, $scan_1);
  if ($scan_2) trade_scan (2, $scan_2);
  if ($scan_3) trade_scan (3, $scan_3);
  if ($scan_4) trade_scan (4, $scan_4);
  if ($scan_5) trade_scan (5, $scan_5);
  if ($scan_6) trade_scan (6, $scan_6);
  if ($scan_7) trade_scan (7, $scan_7);
  if ($scan_8) trade_scan (8, $scan_8);
 }
}

titlebox("Market", $msg);

if (!$fail) {
  echo "<center>\n";

  echo <<<EOF
<table border="1" width="650">
<tr><th class="a">Market Place</th></tr>
<tr><td align="center"><a href="$PHP_SELF?page=sell">Sell</a> | <a href="$PHP_SELF?page=buy">Buy</a></td></tr>
</table>
EOF;

  if ($page)
    echo "<form method=\"post\" action=\"$PHP_SELF?page=$page\">";
  else
    echo "<form method=\"post\" action=\"$PHP_SELF\">";

  /* ship market */
  $q = "SELECT uc.id, uc.name, uc.metal, uc.crystal, uc.eonium, m.num ".
     "FROM unit_class AS uc, market AS m, rc ".
     "WHERE rc.planet_id='$Planetid' AND rc.status=3 AND ".
     "uc.rc_id=rc.rc_id AND uc.class!=5 AND m.unit_id=uc.id AND m.type=1";

  $qq = "SELECT sum(units.num) FROM fleet, units ".
  "WHERE units.id=fleet.fleet_id AND fleet.num=0 AND units.unit_id=";

  $qb = "SELECT sum(units.num) FROM fleet, units ".
  "WHERE units.id=fleet.fleet_id AND units.unit_id=";

  market_all($q, $qq, "Ship", "ship", $qb);
  echo <<<EOF
<table border="0" width="650">
<tr><td>Only ships in home base may be sold.</td></tr>
</table>
<br>
EOF;

  /* pds market */
  $q = "SELECT uc.id, uc.name, uc.metal, uc.crystal, uc.eonium, m.num ".
    "FROM unit_class AS uc, market AS m, rc ".
    "WHERE rc.planet_id='$Planetid' AND rc.status=3 AND ".
    "uc.rc_id=rc.rc_id AND uc.class=5 AND m.unit_id=uc.id AND m.type=2";

  $qq = "SELECT num FROM pds WHERE pds_id=";

  market_all($q, $qq, "PDS", "pds");
  echo "<br>\n";
  
  /* scans market */
  $q = "SELECT sc.id, sc.name, sc.metal, sc.crystal, sc.eonium, m.num ".
     "FROM scan_class AS sc, market AS m, rc ".
     "WHERE rc.planet_id='$Planetid' AND rc.status=3 ".
     "AND sc.rc_id=rc.rc_id AND m.unit_id=sc.id AND m.type=3";

  $qq = "SELECT sum(num) FROM scan WHERE wave_id=";

  market_all($q, $qq, "Wave", "scan");
}

?>
</form>
</center>

<?php
require "footer.php";
?>
