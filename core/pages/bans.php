<?php
/* Copyright (C) 2018-2021 Kobík Jakub ("Kuba1842"). All rights reserved 
 * File: database.php
 * Written by Kobík Jakub ("Kuba1842") 2018
*/

if(!defined("APP_IN")) die();

$loader->page_start("Bans", true);

if(isset($_GET["unban"])) {
	rcon_main::command($rcon, "bandel", array("banid" => $_GET["unban"]));
	$loader->message("Ban with id ".$_GET["unban"]." has been removed from banlist", "success");
	$loader->refresh("?page=bans");
}

$loader->table_start("Database bans:");
$bans = rcon_main::result($rcon, "banlist");
echo '<tr><th>Ban id</th><th>Ban ip address</th><th>Ban nickname</th><th>Ban unique identifier</th><th>Ban last nickname</th><th>Ban created</th><th>Ban duration</th><th>Ban from admin</th><th>Ban reason</th><th></th></tr>';
if(sizeof($bans)>0) {
	foreach($bans as $ban) {
		echo '<tr>';
		echo '<td>'.$ban["banid"].'</td>';
		echo '<td>'.$ban["ip"].'</td>';
		echo '<td>'.$ban["name"].'</td>';
		echo '<td>'.$ban["uid"].'</td>';
		echo '<td>'.$ban["lastnickname"].'</td>';
		echo '<td>'.date("Y/m/d H:i:s", $ban["created"]).'</td>';
		echo '<td>'.main::time($ban["duration"]).'</td>';
		echo '<td>'.$ban["invokername"].' ('.$ban["invokercldbid"].')</td>';
		echo '<td>'.str_replace("\s", " ", $ban["reason"]).'</td>';
		echo '<td><a href="?page=bans&unban='.$ban["banid"].'"><span class="label label-danger"><i class="fa fa-times"></i> Unban</span></a></td>';
		echo '</tr>';
	}
} else echo "<tr><td colspan='10'>Ban list empty</td></tr>";
$loader->table_end();