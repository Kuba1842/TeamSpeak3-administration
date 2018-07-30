<?php
/* Copyright (C) Kuba Kobík. All rights reserved 
 * File: database.php
 * Written by Kuba Kobík 2018
*/

if(!defined("APP_IN")) die();

$loader->page_start("Virtual servers", true);

if(isset($_GET["stop"])) {
	$sid = $_GET["stop"];
	$loader->message("You stopped virtual server id ".$sid, "success");
	rcon_main::command($rcon, "serverstop", array("sid" => $sid));
	$loader->refresh("?page=virtual-servers");
}

else if(isset($_GET["start"])) {
	$sid = $_GET["start"];
	$loader->message("You started virtual server id ".$sid, "success");
	rcon_main::command($rcon, "serverstart", array("sid" => $sid));
	$loader->refresh("?page=virtual-servers");
}

if(isset($_GET["create-new"])) {
	$loader->modal_open("create-new");
	$loader->modal_start("Create new virtual server", "create-new");

	if(isset($_POST["server-name"])) {
		$loader->message("You created new TeamSpeak3 virtual server", "success");
		rcon_main::command($rcon, "servercreate", array("virtualserver_name" => str_replace(" ", "\s", $_POST["server-name"]), "virtualserver_password" => $_POST["server-pass"]));
		$loader->refresh("?page=virtual-servers");
	}

	$loader->div_start("row");
	$loader->div_start("col-md-12");
	echo '<form method="post">';
	$loader->message("For create new virtual server you need a TeamSpeak3 licence!", "danger");
	$loader->div_start("form-group");
	echo 'Virtual server name:';
	echo '<input type="text" name="server-name" class="form-control" />';
	$loader->div_end();
	$loader->div_start("form-group");
	echo 'Virtual server password: (not required)';
	echo '<input type="text" name="server-pass" class="form-control" />';
	$loader->div_end();
	echo '<input type="submit" class="btn btn-success" value="Create" />';

	$loader->div_end();
	$loader->div_end();
	$loader->modal_end();
}

echo '<a href="?page=virtual-servers&create-new"><button class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Create new virtual server</button></a> <a href="#"><i class="fa fa-file-pdf"></i> Export virtual server list pdf</a><br /><br />';
$loader->table_start("Virtual servers database:", "table-bordered");
$servers = rcon_main::result($rcon, "serverlist");
echo '<tr><th>Server id</th><th>Server port</th><th>Server status</th><th>Clients online</th><th>Query clients online</th><th>Max clients</th><th>Server uptime</th><th>Server name</th><th></th></tr>';
foreach($servers as $data) {
	echo '<tr>';
	echo '<td>'.$data["virtualserver_id"].'</td>';
	echo '<td>'.$data["virtualserver_port"].'</td>';
	echo '<td>'.ucfirst($data["virtualserver_status"]).'</td>';
	echo '<td>'.$data["virtualserver_clientsonline"].'</td>';
	echo '<td>'.$data["virtualserver_queryclientsonline"].'</td>';
	echo '<td>'.$data["virtualserver_maxclients"].'</td>';
	echo '<td>'.main::time($data["virtualserver_uptime"]).'</td>';
	echo '<td>'.$data["virtualserver_name"].'</td>';
	$server = json_decode(file_get_contents("core/virtual_servers.json"), true);
	$config = false;
	for($i = 0; $i<sizeof($server); $i++) {
		if($server[$i]["port"]==$data["virtualserver_port"]) {
			$config = true;
		}
		continue;
	}
	echo '<td>';
	if($config == false) echo '<a href="?page=virtual_servers&config='.$data["virtualserver_port"].'"><span class="label label-primary"><i class="fa fa-cogs"></i> Configure for administration</span></a> ';
	else {
		if($data["virtualserver_status"]=="online") echo '<a href="?page=virtual-servers&stop='.$data["virtualserver_id"].'"><span class="label label-danger"><i class="fa fa-stop"></i> Stop server</span></a> ';
		else if($data["virtualserver_status"]=="offline") {
			echo '<a href="?page=virtual-servers&start='.$data["virtualserver_id"].'"><span class="label label-success"><i class="fa fa-play"></i> Start server</span></a> ';
		}
	}
	echo '</td>';

	echo '</tr>';
}
$loader->table_end();