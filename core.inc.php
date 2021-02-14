<?php
/* Copyright 2018-2021 Kob�k Jakub ("Kuba1842"). All rights reserved 
 * File: core.inc.php
 * Written by Kob�k Jakub ("Kuba1842") 2018
*/

ini_set('display_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Prague');

define("APP_IN", true);
define("APP_VERSION", "0.5.4");

if(!isset($_SESSION)) {
	session_start();
}

require_once "core/class/server.class.php";
require_once "core/class/loader.class.php";
require_once "core/class/main.class.php";

require_once "core/class/TeamSpeak3/TeamSpeak3.php";