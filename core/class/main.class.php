<?php
/* Copyright (C) 2018-2021 Kobík Jakub ("Kuba1842"). All rights reserved 
 * File: main.class.php
 * Written by Kobík Jakub ("Kuba1842") 2018
*/

class rcon_main {
	public static function command($rcon, $command, array $params = array()) {
		try {
			//$rcon->request($rcon->prepare("clientupdate", array("client_nickname"	=>	"rcon")));
			return $rcon->request($rcon->prepare($command, $params));
		} catch(\Exception $e) {
			printf("Error occurred during page loading: ".$e->getMessage());;
		}
	}

	public static function result($rcon, $class, $params = NULL) {
		try {
			if($params == NULL) return $rcon->$class();
			else return $rcon->$class($params);
		} catch(\Exception $e) {
			//printf("Error occurred during page loading: ".$e->getMessage());
		}
	}

	public static function variable($rcon, $var) {
		try {
			return $rcon->$var;
		} catch(\Exception $e) {
			//printf("Error occurred during page loading: ".$e->getMessage());
		}
	}

	public static function clientinfo($rcon, $clid) {
		try {
			$client = rcon_main::result($rcon, "clientGetById", $clid);
			return $client;
		} catch(\Exception $e) {
			//printf("Error occurred during page loading: ".$e->getMessage());
		}
	}

	public static function clientgroups($rcon, $clid) {
		try {
			$list = array();
			$group_list = rcon_main::command($rcon, "clientinfo", array("clid" => $clid))->toList();
			$groups = explode(',', $group_list["client_servergroups"]);
			return $groups;
		} catch(\Exception $e) {
			//printf("Error occurred during page loading: ".$e->getMessage());
		}
	}

	public static function groupname($rcon, $gid) {
		try {
			$groups = rcon_main::result($rcon, "servergrouplist");
			foreach($groups as $group) {
				if($group["sgid"]==$gid) {
					return $group["name"];
					break;
				}
			}
		} catch(\Exception $e) {
			//printf("Error occurred during page loading: ".$e->getMessage());
		}
	}

	/*public static function clientlist($server) {
		try {
			$clients_list = array();
			$i = 0;
			$clients = rcon_main::func($server, "clientlist");
			foreach($clients as $client)
			{
				$i++;
				$clients_list[$i] = array(
					"client_nickname"	=>	$client["client_nickname"]
				);
			}
			return $clients_list;
		} catch(\Exception $e) {
			die("Error occurred during page loading: ".$e->getMessage());
		}
	}*/
}

class main {
	public static function time($seconds) {
		$string = "";

		$days = intval(intval($seconds) / (3600*24));
		$hours = (intval($seconds) / 3600) % 24;
		$minutes = (intval($seconds) / 60) % 60;
		$seconds = (intval($seconds)) % 60;

		if($days> 0){
		    $string .= $days."d ";
		}
		if($hours > 0){
		    $string .= $hours."h ";
		}
		if($minutes > 0){
		    $string .= $minutes."m ";
		}
		/*if ($seconds > 0){
		    $string .= $seconds."s ";
		}*/

		return $string;
	}

	public static function setting($value = NULL) {
		$setting = json_decode(file_get_contents("core/settings.json"), true);
		if($value == NULL) {
			return $setting;
		} else {
			return $setting[$value];
		}
	}

	public static function virtual() {
		if(file_exists("core/virtual_servers.json")) {
		    $data = file_get_contents("core/virtual_servers.json");
		    if($data == "NULL") {
		      return false;
		    } else {
		      return true;
		    }
		} else {
			return false;
		}
  	}
}