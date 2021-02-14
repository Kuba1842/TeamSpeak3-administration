<?php
/* Copyright (C) 2018-2021 Kobík Jakub ("Kuba1842"). All rights reserved 
 * File: console.php
 * Written by Kobík Jakub ("Kuba1842") 2018
*/

if(!defined("APP_IN")) die();

$loader->page_start("Console", true);

if(isset($_POST["command"]) && isset($_POST["send"])) {
	$_SESSION["console_log"].= $_POST["command"]."\r\n";
	if(!$_SESSION["console_log"].= rcon_main::command($rcon, $_POST["command"])->toString()."\r\n") {
		$_SESSION["console_log"].= "error with command";
	}
}

if(isset($_POST["clear"])) {
	$_SESSION["console_log"] = "";
}

echo '<textarea disabled rows="25" class="form-control" id="console" style="background-color: #000;color: #fff;">';
if(!isset($_SESSION["console_log"])) {
	$text = "Welcome to the TeamSpeak 3 ServerQuery interface, type 'help' for a list of commands and 'help <command>' for information on a specific command.\r\n\n";
	$_SESSION["console_log"] = $text;
}
printf($_SESSION["console_log"]);
echo '</textarea>';

echo '<form method="post">';
$loader->div_start("row");
$loader->div_start("col-md-12");
echo '<div class="input-group input-group-lg">';
echo '<input type="text" name="command" class="form-control input-sm" placeholder="Command">';
echo '<span class="input-group-btn">';
echo '<button class="btn btn-primary btn-sm" name="send" type="submit">Send</button>';
echo '</span>';
echo '</div>';
$loader->div_end();
$loader->div_end();
echo '<br /><button type="submit" name="clear" class="btn btn-danger btn-sm">Clear console</button>';
echo '</form>';

?>