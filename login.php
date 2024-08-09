<?php
// login.php

header('Content-Type: application/json');

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

// Database connection
require 'vendor/autoload.php'; // Ensure MongoDB library is included
$client = new MongoDB\Client("mongodb+srv://FUNDGAMER:fundgamer7@cluster0.mgp9r.mongodb.net/phpthing?retryWrites=true&w=majority");
$collection = $client->phpthing->users;

// Find user
$user = $collection->findOne(['username' => $username]);

if ($user && password_verify($password, $user['password'])) {
    session_start();
    $_SESSION['user'] = $username;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
}
?>
