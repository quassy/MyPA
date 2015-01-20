<?php

/*
 * MyPHPpa
 * Copyright (C) 2005, 2007 Jens Beyer
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

/*
 * Module to handle PHP-style Sessions
 */

/*
 * Should go into global options
 */

$session_lifetime = 1800;

int session_init() 
{
  session_cache_expire($session_lifetime);
  session_start ();
}

int session_create($ip)
{
  global $Planetid;

  if (_find_session($Planetid)) 
    return 1;

  $_SESSION["Planetid"] = $Planetid;
  $_SESSION["IP"] = get_ip();
  $_SESSION["TimStamp"] = ;

  // generate a session_hash
  // return the session_hash
  // or put it in db
  return 0;
}

int _session_ip_check($ip)
{
  if (!isset($_SESSION["IP"]))
    return 1;
 
  if ($ip != $_SESSION["IP"])
    return 2;

  return 0;
}

int session_check($ip)
{
  global $Planetid;

  if (!isset($_SESSION["Planetid"]))
    return 1;

  if (_session_ip_check(get_ip()))
    return 2;

  $Planetid = $_SESSION["Planetid"];

  // get session_hash from db
  // compare it

  return 0;
}

int session_kill()
{
  global $Planetid;
  session_destroy();

  $Planetid = -1;
}

void session_flush()
{
  session_write_close();
}

?>
