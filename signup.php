<?php
require 'vendor/autoload.php'; // Ensure this path is correct

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$username = $input['username'] ?? '';
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';
$confirmPassword = $input['confirmPassword'] ?? '';

if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

if ($password !== $confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
    exit;
}

// MongoDB connection
$client = new MongoDB\Client('mongodb+srv://FUNDGAMER:fundgamer7@cluster0.mgp9r.mongodb.net/phpthing?retryWrites=true&w=majority');
$collection = $client->phpthing->users;

$user = $collection->findOne(['username' => $username]);

if ($user) {
    echo json_encode(['success' => false, 'message' => 'Username already exists.']);
    exit;
}

$collection->insertOne([
    'username' => $username,
    'email' => $email,
    'password' => password_hash($password, PASSWORD_BCRYPT) // Hash password for security
]);

echo json_encode(['success' => true, 'message' => 'Signup successful.']);
?>
