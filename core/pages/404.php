<?php
/* Copyright (C) 2018-2021 Kob�k Jakub ("Kuba1842"). All rights reserved 
 * File: 404.php
 * Written by Kob�k Jakub ("Kuba1842") 2018
*/

if(!defined("APP_IN")) die();

$loader->page_start("404", true);
$loader->message("This page do not exist!", "danger");
$loader->page_end();