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

require_once "auth_check.php";

require_once "options.php";
pre_auth($Username,$Password,$Planetid, $Valid);

require_once "dblogon.php";

db_auth($db,$Username,$Password,$Planetid);

if ($Planetid > 2) {
  Header("Location: overview.php");
  die;
}

require_once "headerf.php";

?>

<FRAMESET rows="80,*" border="1" frameborder="1" framespacing="0">
  <FRAME SRC="admin/admnav.php" NAME="admnav" noresize>
  <FRAME SRC="admin/admmain.php" NAME="admmain">
</FRAMESET>

<?php
require "footerf.php";
?>
