<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use MongoDB\Client as MongoClient;

$uri = 'mongodb+srv://FUNDGAMER:fundgamer7@cluster0.mgp9r.mongodb.net/phpthing?retryWrites=true&w=majority';
$client = new MongoClient($uri);
$collection = $client->phpthing->users;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $message = 'All fields are required!';
    } else {
        $user = $collection->findOne(['email' => $email]);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            header('Location: welcome.php');
            exit();
        } else {
            $message = 'Invalid email or password!';
        }
    }
    echo $message;
}
?>
