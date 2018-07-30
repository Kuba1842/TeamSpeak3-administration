<?php
/* Copyright (C) Kuba Kobík. All rights reserved 
 * File: index.php
 * Written by Kuba Kobík 2018
*/

require_once "core.inc.php";

if(isset($_POST["server"])) {
	$_SESSION["server"] = $_POST["server"];
}

if(isset($_POST["resetup"])) {
	file_put_contents("core/virtual_servers.json", "NULL");
}

/*if(isset($_SESSION["server"])) {
	$server = new server_main($_SESSION["server"]);*/
if(isset($_SESSION["server"]) && !empty($_SESSION["server"])) {
	$server = new server_main($_SESSION["server"]);
} else {
	$server = new server_main("9987");
}
$server->loader();

$loader = new loader_main();
$loader->html_start();
$loader->body_start();

$run = false;
try {
	$rcon = \TeamSpeak3::factory("serverquery://serveradmin:".$server->value("login")."@".$server->value("host").":".$server->value("query")."/?server_port=".$server->value("port")."&nickname=rcon");
	$run = true;
} catch(\Exception $e) {
	$loader->error("Error occurred during page loading: ".$e->getMessage());
}

if(main::virtual()==false) {
	$loader->modal_open("setup");
	$loader->modal_start("Setup", "setup", false);

	if(!file_exists("core/virtual_servers.json")) {
		$loader->message("File: <b>core/virtual_servers.json</b> don't exists! You must create him and set chmod 666!");
	} else {

		if(isset($_POST["connect"])) {
			if(!empty($_POST["server-port"]) && !empty($_POST["server-query"]) && !empty($_POST["server-login"])) {
				$server_port = $_POST["server-port"];
				$server_query = $_POST["server-query"];
				$server_login = $_POST["server-login"];

				$data = array();
				$data[0] = array(
					"host" => "localhost",
					"port" => $server_port,
					"query" => $server_query,
					"login" => $server_login
				);
				file_put_contents("core/virtual_servers.json", json_encode($data, JSON_PRETTY_PRINT));
				$loader->message("You success added your TeamSpeak3 virtual server! Now you can full use administration", "success");
				$loader->refresh("?");
			} else {
				$loader->message("You must fill all fields completely", "danger");
			}
		}

		echo 'We need connect to your server:';
		echo '<form method="post">';
		$loader->div_start("form-group");
		echo 'Server port: <input type="number" name="server-port" class="form-control" placeholder="default 9987" />';
		$loader->div_end();
		$loader->div_start("form-group");
		echo 'Query port: <input type="number" name="server-query" class="form-control" value="10011" />';
		$loader->div_end();
		$loader->div_start("form-group");
		echo 'ServerAdmin login: <input type="text" name="server-login" class="form-control" placeholder="password" />';
		$loader->div_end();
		echo '<button type="submit" name="connect" class="btn btn-success">Connect</button>';
		echo '</form><br />';
		$loader->message("Check, if yours teamspeak3 virtual server details is correct! If you insert a bad details, administration will don't work", "warning");
	}
	$loader->modal_end();
}

if($run == true) {
	if(isset($_GET["page"])) {
		if(file_exists("core/pages/".$_GET["page"].".php")) {
			include "core/pages/".$_GET["page"].".php";
		} else include "core/pages/404.php";
	} else include "core/pages/home.php";
}

$loader->body_end();
$loader->html_end();