<?php
session_start();

$response = array('loggedIn' => false);

if (isset($_SESSION['user'])) {
    $response['loggedIn'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
