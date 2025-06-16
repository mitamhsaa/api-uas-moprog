<?php
header('Content-Type: application/json');

$response = [
    'status' => true,
    'data' => null,
    'message' => 'Logout berhasil',
];

echo json_encode($response);
