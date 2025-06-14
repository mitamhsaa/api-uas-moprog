<?php

$severname = "localhost";
$username = "root";
$password = "";
$dbname = "unitime";

$conn = new mysqli($severname, $username, $password, $dbname);

if ($conn->connect_error){
    die("Koneksi gagal : ". $conn->connect_error);
}
?>