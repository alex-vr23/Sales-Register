<?php
$user = "user";
$password = "P@ssw0rd";
$server = "localhost";
$bbd= "clicktechdata";


$connexio = new PDO("mysql:host=$server;dbname=$bbd",$user,$password);

