<?php
//include password
include("password.php");
//declare MySQL username
$user = "rhamilton469";
//declare webserver
$webserver = "localhost";
$db = "rhamilton469";

//mysqli api library in PHP to connect to the DB
$conn = mysqli_connect($webserver, $user, $password, $db);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error() );
}
