<?php
// register.php

header('Content-Type: application/json');

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
    echo json_encode(['success' => false, 'message' => 'Invalid Gmail address.']);
    exit;
}

// Database connection
$client = new MongoDB\Client("mongodb+srv://FUNDGAMER:fundgamer7@cluster0.mgp9r.mongodb.net/phpthing?retryWrites=true&w=majority");
$collection = $client->phpthing->users;

// Check if email already exists
$existingUser = $collection->findOne(['email' => $email]);

if ($existingUser) {
    echo json_encode(['success' => false, 'message' => 'Email already taken.']);
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Insert new user
$collection->insertOne(['email' => $email, 'password' => $hashedPassword]);

echo json_encode(['success' => true]);
?>
