<?php
/* Copyright (C) Kuba Kobík. All rights reserved 
 * File: database.php
 * Written by Kuba Kobík 2018
*/

if(!defined("APP_IN")) die();

$loader->page_start("Privilege keys", true);

if(isset($_GET["remove"])) {
	$token = str_replace(" ", "+", $_GET["remove"]);
	$loader->message("You removed privilege key ".$token, "success");
	rcon_main::command($rcon, "tokendelete", array("token" => $token));
	$loader->refresh("?page=tokens");
}

if(isset($_GET["create-new"])) {
	$loader->modal_open("create-new");
	$loader->modal_start("Create new privilege key", "create-new");

	if(isset($_POST["token-group"])) {
		$loader->message("You created new privilege key", "success");
		rcon_main::command($rcon, "tokenadd", array("tokentype" => 0, "tokenid1" => $_POST["token-group"], "tokenid2" => 0, "tokendescription" => $_POST["token-desc"]));
		$loader->refresh("?page=tokens");
	}

	$loader->div_start("row");
	$loader->div_start("col-md-12");
	echo '<form method="post">';
	$loader->div_start("form-group");
	echo 'Privilege key group:';
	echo '<select name="token-group" class="form-control">';
	$groups = rcon_main::result($rcon, "servergrouplist");
	foreach($groups as $group) {
	  echo '<option value="'.$group["sgid"].'">';
	  echo $group["name"];
	  echo '</option>';
	}
	echo '</select>';
	$loader->div_end();
	$loader->div_start("form-group");
	echo 'Privilege key description: (not required)';
	echo '<input type="text" name="token-desc" class="form-control" />';
	$loader->div_end();
	echo '<input type="submit" class="btn btn-success" value="Create" />';

	$loader->div_end();
	$loader->div_end();
	$loader->modal_end();
}

echo '<a href="?page=tokens&create-new"><button class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Create new privilege key</button></a> <a href="#"><i class="fa fa-file-pdf"></i> Export privilege keys pdf</a><br /><br />';
$loader->table_start("Database keys:");
$tokens = rcon_main::result($rcon, "tokenlist");
echo '<tr><th>Token</th><th>Token type</th><th>Group</th><th>Channel</th><th>Token created</th><th>Token description</th><th></th></tr>';
if(sizeof($tokens)>0) {
	foreach($tokens as $token) {
		echo '<tr>';
		echo '<td>'.$token["token"].'</td>';
		echo '<td>'.$token["token_type"].'</td>';
		$groups = rcon_main::result($rcon, "servergrouplist");
		foreach($groups as $group) {
			if($group["sgid"]==$token["token_id1"]) {
				echo '<td>'.$group["name"].'</td>';
				break;
			}
		}
		echo '<td>'.$token["token_id2"].'</td>';
		echo '<td>'.date("Y/m/d H:i:s", $token["token_created"]).'</td>';
		echo '<td>'.$token["token_description"].'</td>';
		echo '<td><a href="?page=tokens&remove='.$token["token"].'"><span class="label label-danger"><i class="fa fa-times"></i> Remove</span></a></td>';
		echo '</tr>';
	}
} else echo "<tr><td colspan='7'>Privilege key list empty..</td></tr>";
$loader->table_end();