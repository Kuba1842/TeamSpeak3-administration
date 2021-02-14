<script type="text/javascript">
$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
});
</script>
<?php
/* Copyright (C) 2018-2021 Kobík Jakub ("Kuba1842"). All rights reserved 
 * File: home.php
 * Written by Kobík Jakub ("Kuba1842") 2018
*/

if(!defined("APP_IN")) die();

$loader->page_start("Main page", true);

if(isset($_GET["client"]) && isset($_GET["clid"])) {
	if($_GET["client"]=="nickname") {
		$loader->modal_open("nickname");
		$loader->modal_start("Change nickname", "nickname");

		$loader->message("Sorry, but this function don't work now. Check new TeamSpeak 3 administration update. Thanks.", "danger");
		/*if(isset($_POST["nickname"])) {
			$loader->message("You changed client ".rcon_main::nicknamefromid($rcon, $clid).' nickname to '.$_POST["nickname"], "success");
			rcon_main::command($rcon, "clientedit", array("clid" => $clid, "CLIENT_NICKNAME" => $_POST["nickname"]));
			$loader->refresh("?");
		}

		$loader->div_start("row");
		$loader->div_start("col-md-12");
		echo '<form method="post">';

		$loader->div_start("form-group form-inline");
		echo 'Client nickname: <input type="text" name="nickname" value="'.rcon_main::nicknamefromid($rcon, $clid).'" class="form-control" /> ';
		echo '<input type="submit" class="btn btn-success" value="Save" />';
		$loader->div_end();

		$loader->div_end();
		$loader->div_end();*/

		$loader->modal_end();
	} else if($_GET["client"]=="kick-channel") {
		$loader->modal_open("kick-channel");
		$loader->modal_start("Kick client from channel", "kick-channel");

		$clid = $_GET["clid"];

		if(rcon_main::clientinfo($rcon, $clid)["cid"]=="1") {
			$loader->message("You can't kick client from default channel!", "danger");
		} else {
			if(isset($_POST["kick-channel"])) {
				$loader->message("You kicked client ".rcon_main::clientinfo($rcon, $clid)["client_nickname"].' from channel', "success");
				rcon_main::command($rcon, "clientkick", array("clid" => $clid, "reasonid" => "4", "reasonmsg" => $_POST["kick-channel"]));
				$loader->refresh("?");
			}

			$loader->div_start("row");
			$loader->div_start("col-md-12");
			echo '<form method="post">';

			$loader->div_start("form-group");
			echo 'You want kick client <b>'.rcon_main::clientinfo($rcon, $clid)["client_nickname"].'</b> from <b>channel</b><br />';
			echo 'Kick reason:';
			echo '<input type="text" name="kick-channel" class="form-control" />';
			$loader->div_end();
			echo '<input type="submit" class="btn btn-success" value="Kick" />';

			$loader->div_end();
			$loader->div_end();
		}
		$loader->modal_end();
	} else if($_GET["client"]=="kick-server") {
		$loader->modal_open("kick-server");
		$loader->modal_start("Kick client from server", "kick-server");

		$clid = $_GET["clid"];

		if(isset($_POST["kick-server"])) {
			$loader->message("You kicked client ".rcon_main::clientinfo($rcon, $clid)["client_nickname"].' from server', "success");
			rcon_main::command($rcon, "clientkick", array("clid" => $clid, "reasonid" => "5", "reasonmsg" => $_POST["kick-server"]));
			$loader->refresh("?");
		}

		$loader->div_start("row");
		$loader->div_start("col-md-12");
		echo '<form method="post">';

		$loader->div_start("form-group");
		echo 'You want kick client <b>'.rcon_main::clientinfo($rcon, $clid)["client_nickname"].'</b> from <b>server</b><br />';
		echo 'Kick reason:';
		echo '<input type="text" name="kick-server" class="form-control" />';
		$loader->div_end();
		echo '<input type="submit" class="btn btn-success" value="Kick" />';

		$loader->div_end();
		$loader->div_end();
		$loader->modal_end();
	} else if($_GET["client"]=="ban") {
		$loader->modal_open("ban");
		$loader->modal_start("Ban client", "ban");

		$clid = $_GET["clid"];

		if(isset($_POST["ban"])) {
			$loader->message("You banned client ".rcon_main::clientinfo($rcon, $clid)["client_nickname"].' from server', "success");
			rcon_main::command($rcon, "banclient", array("clid" => $clid, "reasonid" => "5", "reasonmsg" => $_POST["ban-server"]));
			$loader->refresh("?");
		}

		$loader->div_start("row");
		$loader->div_start("col-md-12");
		echo '<form method="post">';

		$loader->div_start("form-group");
		echo 'You want ban client <b>'.rcon_main::clientinfo($rcon, $clid)["client_nickname"].'</b> from <b>server</b><br />';
		echo 'Ban reason:';
		echo '<input type="text" name="ban-server" class="form-control" />';
		$loader->div_end();
		echo '<input type="submit" class="btn btn-success" value="Ban" />';

		$loader->div_end();
		$loader->div_end();
		$loader->modal_end();
	} else if($_GET["client"]=="move") {
		$loader->modal_open("move");
		$loader->modal_start("Move client", "move");

		$clid = $_GET["clid"];

		if(isset($_POST["move"])) {
			$loader->message("You moved client ".rcon_main::clientinfo($rcon, $clid)["client_nickname"]." to channel ".$_POST["move"], "success");
			rcon_main::command($rcon, "clientmove", array("clid" => $clid, "cid" => $_POST["move"]));
			$loader->refresh("?");
		}

		$loader->div_start("row");
		$loader->div_start("col-md-12");
		echo '<form method="post">';

		$loader->div_start("form-group");
		echo 'Channel:';
		echo '<select name="move" class="form-control">';
		$channels = rcon_main::result($rcon, "channellist");
		foreach($channels as $channel) {
			echo '<option value="'.$channel["cid"].'">'.$channel["channel_name"].'</option>';
		}
		echo '</select>';
		$loader->div_end();
		echo '<input type="submit" class="btn btn-success" value="Move" />';

		$loader->div_end();
		$loader->div_end();
		$loader->modal_end();
	} else if($_GET["client"]=="group") {
		$loader->modal_open("group");
		$loader->modal_start("Set client group", "group");

		$clid = $_GET["clid"];
		$info = rcon_main::clientinfo($rcon, $clid);
		$groups = explode(',', $info["client_servergroups"]);

		if(isset($_POST["group"])) {
			$group = $_POST["group"];
			$loader->message("You set client ".rcon_main::clientinfo($rcon, $clid)["client_nickname"]." groups", "success");

			for($i = 0; $i<sizeof($group); $i++) {
				if(!in_array($group[$i], $groups)) {
					rcon_main::command($rcon, "servergroupaddclient", array("sgid" => $group[$i], "cldbid" => $info["client_database_id"]));
				}
			}

			for($i = 0; $i<sizeof($groups); $i++) {
				if(!in_array($groups[$i], $group)) {
					rcon_main::command($rcon, "servergroupdelclient", array("sgid" => $groups[$i], "cldbid" => $info["client_database_id"]));
				}
			}
			$loader->refresh("?");
		}

		$loader->div_start("row");
		$loader->div_start("col-md-12");
		echo '<form method="post">';

		$loader->div_start("form-group");
		echo 'Groups:<br />';
		echo '<small>Selected are the groups that the client has</small>';
		echo '<select name="group[]" class="form-control" multiple>';
		$groups_server = rcon_main::result($rcon, "servergrouplist");
		foreach($groups_server as $group) {
			echo '<option value="'.$group["sgid"].'"';
			for($i = 0; $i<sizeof($groups); $i++) {
				if($groups[$i]==$group["sgid"]) {
					echo " selected";
					break;
				}
			}
			echo '>'.$group["name"].'</option>';
		}
		echo '</select>';
		echo '<small><b>For multiple select hold Ctrl</b></small>';
		$loader->div_end();
		echo '<input type="submit" class="btn btn-success" value="Set groups" />';

		$loader->div_end();
		$loader->div_end();
		$loader->modal_end();
	}
}

echo '<div class="row text-center pad-top">';
echo "<style>.panel-green { border-color: #5cb85c; } .panel-green > .panel-heading { border-color: #5cb85c;color: white;background-color: #5cb85c; }</style>";
echo "<style>.panel-red { border-color: #b75d5d; } .panel-red > .panel-heading { border-color: #b75d5d;color: white;background-color: #b75d5d; }</style>";

$loader->heading_panel_start("primary", "signal");
echo '<h1 style="margin: 0;">'.ucfirst(rcon_main::variable($rcon, "virtualserver_status")).'</h1>';
echo '<div>Server status</div>';
$loader->heading_panel_end();

$loader->heading_panel_start("green", "microphone");
echo '<h1 style="margin: 0;">'.rcon_main::variable($rcon, "virtualserver_clientsonline").'/'.rcon_main::variable($rcon, "virtualserver_maxclients").'</h1>';
echo '<div>Clients</div>';
$loader->heading_panel_end();

$loader->heading_panel_start("red", "clock");
echo '<h1 style="margin: 0;">'.main::time(rcon_main::variable($rcon, "virtualserver_uptime")).'</h1>';
echo '<div>Uptime</div>';
$loader->heading_panel_end();

$loader->heading_panel_start("default", "bug");
echo '<h1 style="margin: 0;">'.rcon_main::variable($rcon, "virtualserver_platform").'</h1>';
echo '<div>System</div>';
$loader->heading_panel_end();

echo '</div>';

echo '<div class="row">';
echo '<div class="col-md-6">';
$loader->table_start("<b>".rcon_main::variable($rcon, "virtualserver_name")."</b>", "");
$channels = rcon_main::result($rcon, "channellist");
$clients = rcon_main::result($rcon, "clientlist");
if(sizeof($channels)>0) {
	foreach($channels as $channel) {
		echo '<tr>';
		if(strpos($channel["channel_name"], "cspacer")==true) {
			echo '<td><center>'.str_replace("[cspacer]", "", $channel["channel_name"]).'</center>';
		} else if(strpos($channel["channel_name"], "spacer")==true) {
			echo '<td> ';
		} else {
			echo '<td>'.$channel["channel_name"].' ('.$channel["cid"].')';
		}
		foreach($clients as $client) {
			if($client["cid"] == $channel["cid"]) {
				echo '<ul style="margin-bottom: 0;">';
				if($client["client_input_muted"]==0) echo '<i class="fa fa-microphone" data-toggle="tooltip" title="microphone on"></i> ';
				else if($client["client_input_muted"]==1) echo '<i class="fa fa-microphone-slash" data-toggle="tooltip" title="microphone off"></i> ';
				if($client["client_output_muted"]==0) echo '<i class="fa fa-volume-up" data-toggle="tooltip" title="volume on"></i> ';
				else if($client["client_output_muted"]==1) echo '<i class="fa fa-volume-off" data-toggle="tooltip" title="volume off"></i> ';
				echo '<a href="#" class="client" id="client" data-clid="'.$client["clid"].'" data-toggle="tooltip" title="';
					$group_list = explode(',', $client["client_servergroups"]);
					$groups = array();
					for($i = 0; $i<sizeof($group_list); $i++) {
						$groups[$i] = rcon_main::groupname($rcon, $group_list[$i]);
					}
					echo implode(", ", $groups);
				echo '">';
				echo $client["client_nickname"];
				echo '</a></ul>';
			}
		}
		echo '</td>';
		echo '</tr>';
	}
} else echo "Server don't have any channels..";
$loader->table_end();
echo '</div>';

echo '<div class="col-md-4 col-md-offset-1">';
echo '<div class="text-center pad-top">';

$loader->heading_square("?page=groups", "users-cog", "Groups");
$loader->heading_square("?page=tokens", "key", "Privilege keys");
$loader->heading_square("?page=database", "database", "Database");
$loader->heading_square("?page=bans", "ban", "Bans");
$loader->heading_square("?page=console", "terminal", "Console");

echo '</div>';

echo '</div>';
echo '</div>';

echo '<div class="hide-client-menu" id="client-menu">';
echo '<ul>';
echo '<li><a id="client-nickname" href="&nickname"><i class="fa fa-edit"></i> <b>Change nickname</b></a></li>';
echo '<li><a id="client-group" href="&group"><i class="fa fa-users-cog"></i> <b>Set server group</b></a></li>';
echo '<li><a id="client-kick-channel" href="&kick-channel"><i class="fa fa-ban"></i> <b>Kick client from channel</b></a></li>';
echo '<li><a id="client-kick-server" href="&kick-server"><i class="fa fa-ban"></i> <b>Kick client from server</b></a></li>';
echo '<li><a id="client-ban" href="&ban"><i class="fa fa-ban"></i> <b>Ban client</b></a></li>';
echo '<li><a id="client-move" href="&move"><i class="fa fa-arrow-left"></i> <b>Move client</b></a></li>';
echo '</ul>';
echo '</div>';

$loader->page_end();