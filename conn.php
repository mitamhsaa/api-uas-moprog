<?php

// development
// $severname = "localhost";
// $username = "root";
// $password = "";
// $dbname = "unitime";


// production altaf
$severname = "localhost";
$username = "aftx9255_aftlah_unitime";
$password = "aftlah_unitime";
$dbname = "aftx9255_unitime";


$conn = new mysqli($severname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal : " . $conn->connect_error);
}
?>