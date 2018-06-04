<?php

class Database {
    private $host;
    private $user;
    private $pass;
    private $db;

   protected function connect() {
        $this->host = 'localhost';
        $this->user = 'root';
        $this->pass = '';
        $this->db = 'cmdb';
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if (!$conn) {
            die('Could not connect: ' . mysql_error());
        }
        $conn->set_charset("utf8");
        return $conn;
    }
}