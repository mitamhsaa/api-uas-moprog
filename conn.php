<?php

// development
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "unitime";

// production
// $severname = "localhost";
// $username = "masjid29_altaf";
// $password = "altafunitimemoprog";
// $dbname = "masjid29_unitime";


$conn = new mysqli($severname, $username, $password, $dbname);

if ($conn->connect_error){
    die("Koneksi gagal : ". $conn->connect_error);
}
?>