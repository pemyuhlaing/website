<?php

session_start();

const USERS_FILE = 'users.json';

function load_users() {
    if (file_exists(USERS_FILE)) {
        return json_decode(file_get_contents(USERS_FILE), true) ?? [];
    }
    return [];
}

function save_users($users) {
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
}

function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function register($username, $password) {
    $users = load_users();
    if (isset($users[$username])) {
        echo "Username already exists!";
        return false;
    }
    $users[$username] = hash_password($password);
    save_users($users);
    echo "User registered successfully!";
    return true;
}

function login($username, $password) {
    $users = load_users();
    if (isset($users[$username]) && password_verify($password, $users[$username])) {
        $_SESSION['username'] = $username;
        echo "Login successful!";
        return true;
    }
    echo "Invalid username or password!";
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($action === 'register') {
        register($username, $password);
    } elseif ($action === 'login') {
        login($username, $password);
    }
}
?>