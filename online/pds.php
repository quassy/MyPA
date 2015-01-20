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
  $res = "Cost: ";
  if ($m) $res .= "$m Metal";
  if ($c) {
    if ($m) $res .= ", $c Crystal";
    else  $res .= "$c Crystal";
  }
  if ($e) {
    if ($m || $c) $res .= ", $e Eonium";
    else  $res .= "$e Eonium";
  }
  return $res;
}

function print_unit_row ($row, $stock) {

  $cost = print_cost ($row[3], $row[4], $row[5]);

  echo "<tr><td>$row[1]</td><td>$row[2]<br>$cost" .
    "</td><td>$stock</td><td>$row[6] ticks</td>" .
    "<td><input type=\"text\" name=\"pds_$row[0]\" size=\"8\"></td></tr>\n"; 
}

function prod_unit ($unit, $num) {
  global $myrow; /* resources */
  global $Planetid, $db;

  $num = (int) $num;

  $q = "SELECT metal, crystal, eonium, build_ticks ".
     "FROM unit_class AS uc, rc WHERE uc.id='$unit' AND uc.class=5 ".
     "AND rc.rc_id=uc.rc_id AND rc.status=3 AND rc.planet_id='$Planetid'";

  $res = mysql_query ($q, $db);
  // echo $q;
  if ($res && mysql_num_rows($res) == 1) {
    $price = mysql_fetch_row($res);
    
    if ( $myrow["metal"] < ($price[0] * $num) ) {
      $num = (int) ($myrow["metal"] / $price[0]);
    }
    if ( $myrow["crystal"] < ($price[1] * $num) ) {
      $num = (int) ($myrow["crystal"] / $price[1]);
    }
    if ( $myrow["eonium"] < ($price[2] * $num) ) {
      $num = (int) ($myrow["eonium"] / $price[2]);
    }

    if ($num > 0) {
      $cm = $price[0] * $num;
      $cc = $price[1] * $num;
      $ce = $price[2] * $num;
      $myrow["metal"]   -= $cm;
      $myrow["crystal"] -= $cc;
      $myrow["eonium"]  -= $ce;

      $q = "UPDATE planet SET metal='$myrow[metal]',crystal='$myrow[crystal]',".
	   "eonium='$myrow[eonium]' where id='$Planetid' ".
           "AND metal>='$cm' AND crystal>='$cc' AND eonium>='$ce'";
      $result = mysql_query( $q, $db);

      if (mysql_affected_rows($db)==1) {
        $res = mysql_query ("INSERT INTO pds_build ".
	  		    "SET planet_id='$Planetid',pds_id='$unit',".
			    "build_ticks=$price[3], num=$num", $db);
      }
    }
  }
}

if ($submit) {

  /* aeusserst uncooles handling */
  if ($pds_20) prod_unit (20, $pds_20);
  if ($pds_21) prod_unit (21, $pds_21);
  if ($pds_22) prod_unit (22, $pds_22);
  if ($pds_23) prod_unit (23, $pds_23);
  if ($pds_24) prod_unit (24, $pds_24);
  if ($pds_25) prod_unit (25, $pds_25);
  if ($pds_27) prod_unit (27, $pds_27);
}

/* top table is written now */
top_header($myrow);

titlebox("PDS");
?>

<center>
<form method="post" action="<?php echo $PHP_SELF?>">
<table border="1" width="650">
<tr><th colspan="5" class="a">Order PDS component</th></tr>
<tr><th width="110">PDS</th>
    <th width="360">Description</th>
    <th width="50">Stock</th>
    <th width="50">Ticks</th>
    <th width="80">Order</th>
</tr>
<?php

$q = "SELECT uc.id, uc.name, uc.description, uc.metal, uc.crystal, ".
     "uc.eonium, uc.build_ticks " .
     "FROM unit_class AS uc, rc ".
     "WHERE rc.planet_id='$Planetid' AND rc.status=3 AND ".
     "uc.rc_id=rc.rc_id AND uc.class=5 ";

$result = mysql_query ($q, $db);
if ($result && mysql_num_rows($result) > 0) {

  while ($myunit = mysql_fetch_row($result)) {

    $nr = mysql_query ("SELECT num FROM pds WHERE ".
		       "planet_id='$Planetid' AND pds_id='$myunit[0]'", $db);
    $stock = mysql_fetch_row ($nr);
    if ( !$stock[0]) $stock[0] = 0;

    print_unit_row ($myunit, $stock[0]);
  }
}
?>

<tr>
  <td colspan="5" align="center">
    <input type=submit value="  Order  " name="submit">&nbsp;&nbsp;&nbsp;<input type=reset value="  Reset  "></td>
</tr>

</table>
</form>

<br>
<table border="1" width="650">
<tr><th colspan="25" class="a">Current Production</th></tr>
<tr><td width="150"></td>
<?php 
  for ($i=1; $i<=24; $i++) {
     echo "<td width=\"20\">$i</td>"; 
  }
?>
</tr>

<?php

$q = "SELECT uc.id, uc.name, uc.build_ticks FROM unit_class AS uc, rc ".
     "WHERE rc.planet_id='$Planetid' AND rc.status=3 ".
     "AND uc.rc_id=rc.rc_id AND uc.class=5 ";

$qq = "SELECT pds_id, sum(num), build_ticks FROM pds_build ".
      "WHERE planet_id='$Planetid' ".
      "AND build_ticks!=0 GROUP BY pds_id, build_ticks";

$result = mysql_query ($q, $db);
if ($result && mysql_num_rows($result) > 0) {

  $prod_res = mysql_query ($qq, $db);
  $mybuild = mysql_fetch_row($prod_res);

  while ($myunit = mysql_fetch_row($result)) {
    /* name of it */
    echo "<tr><td>$myunit[1]</td>";

    if ($mybuild && $mybuild[0] == $myunit[0]) {

      for ($i=1; $i<=$myunit[2]; $i++) {
	if ( $mybuild && $i == $mybuild[2] && $mybuild[0] == $myunit[0]) {
	  /* in bau */
	  echo "<td>$mybuild[1]</td>";
	  $mybuild = mysql_fetch_row($prod_res);
	} else {
	  echo "<td>&nbsp;</td>";
	}
      }
    } else {
      /* momentan keine schiffe des typs in bau */
      for ($i=1; $i<=$myunit[2]; $i++) {
	echo "<td>&nbsp;</td>";
      }
    }
    echo "</tr>\n";
  }
}

?>
</table>
</center>

<?php
require "footer.php";
?>
