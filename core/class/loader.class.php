<?php
/* Copyright (C) Kuba Kobík. All rights reserved 
 * File: loader.inc.php
 * Written by Kuba Kobík 2018
*/

class loader_main {
  private $admin_path;
  public $close_modal;
  
  public function __construct($title="") {
    $this->admin_path = dirname($_SERVER['SCRIPT_FILENAME']);
  }
  
  public function html_start() {
    echo '<!DOCTYPE html>';
    echo '<html xmlns="http://www.w3.org/1999/xhtml">';
    
    echo '<head>';
    echo '<meta charset="utf-8" />';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';
    echo '<title>TeamSpeak3 administration</title>';
    
    echo '<link href="assets/css/bootstrap.css?v'.APP_VERSION.'" rel="stylesheet" />';
    echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">';
    echo '<link href="assets/css/custom.css?v'.APP_VERSION.'" rel="stylesheet" />';
    echo '<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />';
    echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js?v=2.3.1" type="text/javascript"></script>';
    
    echo '</head>';
  }
  
  public function html_end() {
    echo '</html>';
  }
  
  public function body_start() {
    echo '<body>';
    echo '<div id="wrapper">';
    
    echo '<div class="navbar navbar-inverse navbar-fixed-top">';
    echo '<div class="adjust-nav">';
    echo '<div class="navbar-header">';
    echo '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">';
    echo '<span class="icon-bar"></span>';
    echo '<span class="icon-bar"></span>';
    echo '<span class="icon-bar"></span>';
    echo '</button>';
    echo '<a class="navbar-brand" href="?"><h2 style="color: #fff;">TeamSpeak3 administration <small><span class="label label-danger">BETA v'.APP_VERSION.'</span></small></h2></a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
    echo '<nav class="navbar-default navbar-side" role="navigation">';
    echo '<div class="sidebar-collapse">';
    echo '<ul class="nav" id="main-menu">';

    if(file_exists("core/virtual_servers.json") && !empty("core/virtual_servers.json")) {
      echo '<center>';
      echo '<form method="post" class="form-inline">';
      echo '<div class="form-group">';
      echo '<select name="server" class="form-control">';

      /*global $rcon;
      $servers = rcon_main::result($rcon, "serverList");
      foreach($servers as $data) {
        $info = json_decode(file_get_contents("core/virtual_servers.json"), true);
        for($i = 0; $i<sizeof($info); $i++) {
          if($info[$i]["port"]==$data["virtualserver_port"]) {
            echo '<option value="'.$data["virtualserver_port"].'">localhost:'.$data["virtualserver_port"].'</option>';
          } else {
            echo '<option value="" disable>localhost:'.$data["virtualserver_port"].'</option>';
          }
        }
      }*/

      $data = json_decode(file_get_contents("core/virtual_servers.json"), true);
      for($i = 0; $i<sizeof($data); $i++) {
        echo '<option value="'.$i.'">'.$data[$i]["host"].':'.$data[$i]["port"].'</option>';
      }

      echo '</select>';
      echo ' <input type="submit" class="btn btn-primary" value="Set">';
      echo '</div>';
      echo '</form>';
      echo '</center><br>';
    }

    echo '<li><a href="?"><i class="fa fa-desktop"></i>Dashboard</a></li>';
    echo '<li><a href="?page=virtual-servers"><i class="fa fa-server"></i>Virtual servers</a></li>';
    echo '<br>';
    echo '<li><a href="?page=groups"><i class="fa fa-users-cog"></i>Groups</a></li>';
    echo '<li><a href="?page=tokens"><i class="fa fa-key"></i>Privilege keys</a></li>';
    echo '<li><a href="?page=database"><i class="fa fa-database"></i>Database</a></li>';
    echo '<li><a href="?page=bans"><i class="fa fa-ban"></i>Bans</a></li>';
    echo '<li><a href="?page=console"><i class="fa fa-terminal"></i>Console</a></li>';
    echo '</ul>';
    echo '</div>';
    echo '</nav>';
  }
  
  public function body_end() {
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '<div class="footer">';
    echo '<div class="row">';
    echo '<div class="col-lg-12" >';
    echo '<b><a href="https://github.com/KyBLKuBA/teamspeak3-administration">TeamSpeak3-administration</a></b> © '.date("Y", time()).'. Created and developed by <b>KyBLKuBA</b>';
    echo '<div style="float: right;">Version: <b>'.APP_VERSION.'</b></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '<script src="assets/js/jquery-1.10.2.js"></script>';
    echo '<script src="assets/js/bootstrap.min.js"></script>';
    echo '<script src="assets/js/custom.js?v'.APP_VERSION.'"></script>';
    echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>';
    echo '<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>';

    echo '</body>';
  }

  public function page_start($title, $hr = false) {
    echo '<div id="page-wrapper" >';
    echo '<div id="page-inner">';
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<h2>'.$title.'</h2>';
    echo '</div>';
    echo '</div>';

    if($hr == true) echo '<hr />';
  }

  public function page_end() {
    echo '</div>';
    echo '</div>';
  }

  public function heading_panel_start($class, $icon) {
    echo '<div class="col-lg-3 col-md-6">';
    echo '<div class="panel panel-'.$class.'">';
    echo '<div class="panel-heading">';
    echo '<div class="row">';
    echo '<div class="col-xs-3">';
    echo '<i class="fa fa-'.$icon.' fa-5x"></i>';
    echo '</div>';
    echo '<div class="col-xs-9 text-right">';
  }

  public function heading_panel_end() {
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }

  public function heading_square($link, $icon, $name) {
    echo '<div class="col-md-4">';
    echo '<div class="div-square">';
    echo '<a href="'.$link.'" >';
    echo '<i class="fa fa-'.$icon.' fa-5x"></i>';
    echo '<h4>'.$name.'</h4>';
    echo '</a>';
    echo '</div>';
    echo '</div>';
  }

  public function table_start($title, $style = "table-striped table-bordered table-hover") {
    echo $title;
    echo '<div class="table-responsive">';
    echo '<table class="table '.$style.'">';
  }

  public function table_end() {
    echo '</table>';
    echo '</div>';
  }

  public function div_start($div) {
    echo '<div class="'.$div.'">';
  }

  public function div_end() {
    echo '</div>';
  }

  public function message($text, $type = "danger") {
    echo '<div class="alert alert-'.$type.'">';
    echo $text;
    echo '</div>';  
  }

  public function error($error) {
    $this->page_start("Error", true);
    $this->message($error, "danger");
    if(main::virtual()==true) {
      echo '<form method="post">';
      echo '<button type="submit" name="resetup" class="btn btn-danger">Resetup TeamSpeak3 administration (insert server details)</button>';
      echo '</form>';
    }
    $this->page_end();
  }

  public function refresh($url = NULL) {
    if($url == NULL) {
      header("refresh:3;url=".$_SERVER["PHP_SELF"]);
    } else {
      header("refresh:3;url=".$url);
    }
  }

  public function modal_start($title, $id, $close = true) {
    $this->close_modal = $close;
  	echo '<div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="'.$id.'" data-keyboard="false" data-backdrop="static">';
  	echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
   	if($this->close_modal == true) echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    echo '<h4 class="modal-title" id="'.$id.'">'.$title.'</h4>';
    echo '</div>';
    echo '<div class="modal-body">';
  }

  public function modal_end() {
  	echo '</div>';
    echo '<div class="modal-footer">';
    if($this->close_modal == true) echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
    //echo '<button type="button" class="btn btn-primary">Save changes</button>';
    echo '</div>';
    echo '</div>';
  	echo '</div>';
	  echo '</div>';
  }

  public function modal_open($id) {
    echo '<script type="text/javascript"> $(window).load(function() { $("#'.$id.'").modal("show"); }); </script>';
  }
}