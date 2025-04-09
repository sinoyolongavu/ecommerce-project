<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reflectahome"; 

// Database connection
$dbConnection = new mysqli($servername, $username, $password, $dbname);

// connection  check

if ($dbConnection->connect_error) { die("Connection failed: " . $dbConnection->connect_error);

}

?>