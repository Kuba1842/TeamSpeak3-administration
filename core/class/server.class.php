<?php
/* Copyright (C) Kuba Kobík. All rights reserved 
 * File: server.inc.php
 * Written by Kuba Kobík 2018
*/

class server_main {
  private $server, $values;

  public function __construct($server) {
    try {
      $this->server = $server;
    } catch(\Exception $e) {
      printf("Error occurred during page loading: ".$e->getMessage());
    }
  }
  
  public function loader() {
    try {
      if(!file_exists("core/virtual_servers.json")) throw new \Exception("File settings.json does not exist!");
      if(empty("core/virtual_servers.json")) throw new \Exception("File settings.json empty!");

      $data = json_decode(file_get_contents("core/virtual_servers.json"), true);
      for($i = 0; $i<sizeof($data); $i++) {
        if($data[$i]["port"]==$this->server) {
          $this->values = $data[$i];
        }
      }

    } catch(\Exception $e) {
      //printf("Error occurred during page loading: ".$e->getMessage());
    }
  }

  public function value($text) {
    try {
      //if(!array_key_exists($text, $this->values)) throw new \Exception("Value: ".$text." in virtual_servers.json does not exist!");
      if(isset($this->values[$text])) {
        return $this->values[$text];
      } else {
        return "unknown";
      }
    } catch(\Exception $e) {
      printf("Error occurred during page loading: ".$e->getMessage());
    }
  }
}