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

require_once "admhead.php";
require_once "admform.php";

if ($units && $id) {

  $table = "unit_class";

  $values ="id='$id'";
  if ($name) $values .= ", name='$name'";
  if ($type) $values .= ", type='$type'";
  if ($t1) $values .= ", t1='$t1'";
  if ($t2) $values .= ", t2='$t2'";
  if ($t3) $values .= ", t3='$t3'";
  if ($init) $values .= ", init='$init'";
  if ($agility) $values .= ", agility='$agility'";
  if ($wsp) $values .= ", weapon_speed='$wsp'";
  if ($guns) $values .= ", guns='$guns'";
  if ($power) $values .= ", power='$power'";
  if ($armor) $values .= ", armor='$armor'";
  if ($resistance) $values .= ", resistance='$resistance'";
  if ($metal) $values .= ", metal='$metal'";
  if ($crystal) $values .= ", crystal='$crystal'";
  if ($eonium) $values .= ", eonium='$eonium'";
  if ($ticks) $values .= ", build_ticks='$ticks'";
  if ($fuel) $values .= ", fuel='$fuel'";
  if ($speed) $values .= ", speed='$speed'";
  if ($class) $values .= ", class='$class'";
  if ($rc_id) $values .= ", rc_id='$rc_id'";
  if ($description) $values .= ", description='$description'";

  submit_values ($id, $values, $table);
}
?>

<table border="1" style="font-size: 12px;">
<tr><th colspan="22">Units</th></tr>
<tr><th width="30">Id</th>
    <th width="100">Name</th>

    <th width="30">Type</th>
    <th width="30">T1</th>
    <th width="30">T2</th>
    <th width="30">T3</th>

    <th width="30">Init</th>
    <th width="30">Agil.</th>
    <th width="30">Wsp</th>

    <th width="30">Guns</th>
    <th width="30">Power</th>
    <th width="30">Armor</th>
    <th width="30">Resist.</th>

    <th width="30">Cost M</th>
    <th width="30">Cost C</th>
    <th width="30">Cost E</th>

    <th width="30">Ticks</th>
    <th width="30">Fuel</th>
    <th width="30">Speed</th>

    <th width="30">Class</th>
    <th width="30">RC needed</th>

    <th width="200">Description</th>
</tr>
<?php
$result = mysql_query("SELECT id,name,type,t1,t2,t3,init,agility,weapon_speed,guns,power,".
		      "armor,resistance,metal,crystal,eonium,build_ticks,fuel,speed,class,".
		      "rc_id,description FROM unit_class ORDER BY id",$db);
if ($result && mysql_num_rows($result) > 0) {
  while ($myres = mysql_fetch_row($result)) {
    print_admin_row ($myres, 22);
  }
}
?>
<form method="post" action="<?php echo $PHP_SELF?>">
<tr>
<?php
admin_form_field ("text","id",3,3);
admin_form_field ("text","name",10,30);
admin_form_field ("text","type",3,3);
admin_form_field ("text","t1",3,3);
admin_form_field ("text","t2",3,3);
admin_form_field ("text","t3",3,3);
admin_form_field ("text","init",3,3);
admin_form_field ("text","agility",3,3);
admin_form_field ("text","wsp",3,3);
admin_form_field ("text","guns",3,3);
admin_form_field ("text","power",3,3);
admin_form_field ("text","armor",3,3);
admin_form_field ("text","resistance",3,3);
admin_form_field ("text","metal",5,8);
admin_form_field ("text","crystal",5,8);
admin_form_field ("text","eonium",5,8);
admin_form_field ("text","ticks",3,3);
admin_form_field ("text","fuel",3,3);
admin_form_field ("text","speed",3,3);
admin_form_field ("text","class",3,3);
admin_form_field ("text","rc_id",3,3);
admin_form_field ("textarea","description",3,3);
?>
</tr>
<tr><td colspan="22" align="center"><input type=submit value=" Units " name="units">
&nbsp;&nbsp;<input type=reset value="  Reset  ">
</td></tr>
</form>
</table>
</center>

<?php
require_once "../footer.php";
?>
