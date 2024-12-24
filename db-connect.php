<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "reset";

try{
    $conn = new MySQLi($host, $username, $password, $dbname);
} catch (Exception $e){
    die($e->getMessage());
}