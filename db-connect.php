<?php
$host = "mysql.railway.internal";
$username = "root";
$password = "VKMrTFdpwspXhYzjOQYUjyAgYLvjFNED";
$dbname = "railway";

try{
    $conn = new MySQLi($host, $username, $password, $dbname);
} catch (Exception $e){
    die($e->getMessage());
}