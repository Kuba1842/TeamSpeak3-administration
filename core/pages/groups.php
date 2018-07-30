<?php
/* Copyright (C) Kuba Kobík. All rights reserved 
 * File: groups.php
 * Written by Kuba Kobík 2018
*/

if(!defined("APP_IN")) die();

$loader->page_start("Groups", true);

if(isset($_POST["group"])) {
  if(!empty($_POST["group"]) && !empty($_POST["client"])) {
      $client = $_POST["client"];
      $group = $_POST["group"];

      rcon_main::command($rcon, "servergroupaddclient", array("sgid" => $group, "cldbid" => $client));
      $loader->message($client." has been added to the group ".$group, "success");
      $loader->refresh();
  }
}

$loader->div_start("row");
$loader->div_start("col-md-6");
$loader->table_start("Created groups:");
$groups = rcon_main::result($rcon, "servergrouplist");
foreach($groups as $group) {
  echo '<tr>';
  echo '<td>'.$group["name"].' ('.$group["sgid"].')</td>';
  echo '</tr>';
}
$loader->table_end();
$loader->div_end();

$loader->div_start("col-md-6");
echo "Add client to group:";
echo '<form method="post">';
echo '<div class="col-lg-4 col-md-4">';
echo '<label>Client</label>';
echo '<select class="form-control" name="client">';

$clients = rcon_main::result($rcon, "clientlist");
foreach($clients as $client) {
  echo '<option value="'.$client["client_database_id"].'">'.$client["client_nickname"].'</option>';
}

echo '</select>';

echo '<div class="form-group">';
echo '<label>Group</label>';
echo '<select class="form-control" name="group">';

$groups = rcon_main::result($rcon, "servergrouplist");
foreach($groups as $group) {
  echo '<option value="'.$group["sgid"].'">'.$group["name"].'</option>';
}

echo '</select>';
echo '</div>';
echo '<input type="submit" class="btn btn-success" value="Add client" />';
echo '</div>';
echo '</div>';
echo '</form>';
$loader->div_end();
$loader->div_end();

$loader->page_end();