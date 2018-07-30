<?php
/* Copyright (C) Kuba Kobík. All rights reserved 
 * File: database.php
 * Written by Kuba Kobík 2018
*/

if(!defined("APP_IN")) die();

$loader->page_start("Database", true);

echo '<form method="post">';
$loader->div_start("form-group form-inline");
echo 'Search: <input name="find" type="text" class="form-control" /> ';
echo '<input type="submit" class="btn btn-success" value="Search" />';
echo '<br /><small>You can either search for a clients last known nickname or his unique identity</small>';
$loader->div_end();
echo '</form>';

if(!isset($_POST["find"])) {
	$pocet = rcon_main::command($rcon, "clientdblist -count", array("duration" => 1))->toList("count")["count"];

	if(isset($_GET['s'])) {$p = $_GET['s']-1; $p = $p*25;}
	else $p=0;

	$loader->table_start("Database clients:");
	$clients = rcon_main::result($rcon, "clientlistdb", array("start" => $p, 30));
	echo '<tr><th>Client dbid</th><th>Client nickname</th><th>Client unique identifier</th><th>Client created</th><th>Client last connected</th><th>Client total connected</th><th>Client description</th><th>Client IP address</th></tr>';
	foreach($clients as $client) {
		echo '<tr>';
		echo '<td>'.$client["cldbid"].'</td>';
		echo '<td>'.$client["client_nickname"].'</td>';
		echo '<td>'.$client["client_unique_identifier"].'</td>';
		echo '<td>'.date("Y/m/d H:i:s", $client["client_created"]).'</td>';
		echo '<td>'.date("Y/m/d H:i:s", $client["client_lastconnected"]).'</td>';
		echo '<td>'.$client["client_totalconnections"].'</td>';
		echo '<td>'.$client["client_description"].'</td>';
		echo '<td>'.$client["client_lastip"].'</td>';
		echo '</tr>';
	}
	$loader->table_end();

	$stranky = ceil($pocet/25);
	//if($stranky > 11) $stranky = 11;
	if($pocet!=0) {
		echo '<center><nav>';
		echo '<ul class="pagination">';
		if($p == 0) echo '<li class="disabled"><a><i class="fa fa-angle-left"></i></a></li>';
		else {
			$prev = $p/25;
			echo "<li><a href='?page=database&s=".$prev."'><span><i class='fa fa-angle-left'></i></span></a></li>";
		}
		$current = 1;
		for ($key=0; $key<$stranky; $key++) {
			$page = $key+1;
			echo '<li';
			if(($key*25)==$p) { $current = $page; echo " class='active'"; } 
			echo '><a href="?page=database&s='.$page.'">'.$page.'</a></li>';
		}
		if($current == $stranky) echo "<li class='disabled'><a><i class='fa fa-angle-right'></i></a></li>";
		else { 
			$next = $current+1;
			echo "<li><a href='?page=database&s=".$next."'><span><i class='fa fa-angle-right'></i></span></a></li>";
		}
		echo '</ul>';
		echo '</nav></center>';
	}
} else {
	if(strlen($_POST["find"])>3) {
		$loader->table_start("Database clients:");
		$clients = rcon_main::result($rcon, "clientFindDb", array("pattern" => "%".$_POST["find"]."%"));
		echo '<tr><th>Client dbid</th><th>Client nickname</th><th>Client unique identifier</th><th>Client created</th><th>Client last connected</th><th>Client total connected</th><th>Client description</th><th>Client IP address</th></tr>';
		if(sizeof($clients)>0) {
			foreach($clients as $client) {
				$info = rcon_main::command($rcon, "clientdbinfo", array("cldbid" => $client))->toList();
				echo '<tr>';
				echo '<td>'.$client.'</td>';
				echo '<td>'.$info["client_nickname"].'</td>';
				echo '<td>'.$info["client_unique_identifier"].'</td>';
				echo '<td>'.date("Y/m/d H:i:s", $info["client_created"]).'</td>';
				echo '<td>'.date("Y/m/d H:i:s", $info["client_lastconnected"]).'</td>';
				echo '<td>'.$info["client_totalconnections"].'</td>';
				echo '<td>'.$info["client_description"].'</td>';
				echo '<td>'.$info["client_lastip"].'</td>';
				echo '</tr>';
			}
		} else {
			echo '<tr><td colspan="8">Ouuch, we cant find anything :-(</td></tr>';
		}
		$loader->table_end();
	} else {
		$loader->message("Insert minimum 3 characters", "danger");
	}
}