<?php
session_start();

require_once '../../lib/db.php';
require_once '../../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($firstName) || empty($email) || empty($password)) {
        echo "All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    $db = new Database();
    $pdo = $db->getConnection();
    $user = new User($pdo);

    // Check if user already exists
    $existingUser = $user->readByEmail($email);
    if ($existingUser) {
        echo "This email is already registered.";
        exit;
    }

    // Prepare new user
    $user->setFirstName($firstName);
    $user->setEmail($email);
    $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

    try {
        $userId = $user->create();

        // Auto-login
        $_SESSION['Active'] = true;
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $firstName;

        header("Location: ../../dashboard/dashboard.php");
        exit;
    } catch (PDOException $e) {
        echo "Registration failed: " . $e->getMessage();
        exit;
    }
}
