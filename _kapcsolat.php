<?php
Class kapcsolat{
  var $servername = "localhost";
  var $username = "root";
  var $password = "";
  var $dbname = "mynodejsrestdb";
  var $conn;

   function getConnstring() {
    $con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());
      
    if (mysqli_connect_errno()) {
       printf("Hiba a kapcsolatban: %s\n", mysqli_connect_error());
       exit();
    } else {
       $this->conn = $con;
      }
      return $this->conn;
    }
  }
?>