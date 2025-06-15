<?php
$response = [
    'status' => false,
    'data' => null,
    'message' => '',
];
$response['message'] = 'Logout berhasil';
$response['status'] = true;
echo json_encode($response);
?>