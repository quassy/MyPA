<?php

/*
 * MyPA (continuation of MyPHPpa)
 * Copyright (C) 2003, 2007 Jens Beyer
 * Copyright (C) 2016 quassy
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

function getmicrotime(){
  list($usec, $sec) = explode(" ",microtime());  
  return ((float)$usec + (float)$sec);  
}    

// import_request_variables ("GPC", "");
// @quassy: Work-around to get tings going, huge security hole!
extract($_REQUEST, EXTR_PREFIX_ALL|EXTR_REFS, '');

$start_time = getmicrotime();

$dbuser = 'mypa';
$dbpass = 'defaultpassword';
$dbname = 'mypa';

$dbsock = "/var/run/mysqld/mysqld.sock";
$dbhost = "localhost";
$dbport = "3306";

$version = "1.0.0-devel";
$game = "MyPa";
$round = "round 01"; // used as hash against multi

$game_closed = 0; // should become boolean?
$signupclosed = 0;
$havoc = 0;

$gal_size = 7;
$cluster_size = 7;
$universe_size = 15;

$score_per_roid=1500;
$start_roids = 3;
$start_resource["metal"]=5000;
$start_resource["crystal"]=5000;
$start_resource["eonium"]=5000;

$start_resource["planet_m"]=250;
$start_resource["planet_c"]=250;
$start_resource["planet_e"]=250;

$resource_min_per_roid = 150;
$resource_max_per_roid = 350;
$number_of_fleets = 4; /* base + 3, has to be same as in ticker */

$end_of_round = 39250; // still 7 hours to go, but disable sleep/signup

$sleep_period = 23;
$high_prot = 0; // faktor nach oben
$noob_prot = 3; // faktor nach unten
$ticktime = 30; // needed for jscript

if ($havoc == 1) {
  $noob_prot = 20; // faktor nach unten
  $ticktime = 15;
}

// default settings
$mysettings=0;
