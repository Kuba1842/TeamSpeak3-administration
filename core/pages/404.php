<?php
/* Copyright (C) Kuba Kobík. All rights reserved 
 * File: 404.php
 * Written by Kuba Kobík 2018
*/

if(!defined("APP_IN")) die();

$loader->page_start("404", true);
$loader->message("This page do not exist!", "danger");
$loader->page_end();