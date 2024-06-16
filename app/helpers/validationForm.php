<?php

function validateUserData(array $userData) {
    $errors = ['errName' => '', 'errEmail' => '', 'errPassword' => ''];
    $name = htmlspecialchars($userData['name'] ?? '');
    $email = htmlspecialchars($userData['email'] ?? '');
    $password = htmlspecialchars($userData['password'] ?? '');

    if (empty($name)) {
        $errors['errName'] = 'Name is required!';
    } elseif (strlen($name) < 10) {
        $errors['errName'] = 'Name must be at least 10 characters!';
    }

    if (empty($email)) {
        $errors['errEmail'] = 'Email is required!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['errEmail'] = 'Invalid email format!';
    }

    if (empty($password)) {
        $errors['errPassword'] = 'Password is required!';
    } elseif (strlen($password) < 8) {
        $errors['errPassword'] = 'Password must be at least 8 characters!';
    }

    $hasErrors = array_filter($errors);

    if (!$hasErrors) {
        return [
            'isValid' => true,
            'data' => [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ],
        ];
    } else {
        return [
            'isValid' => false,
            'errors' => $errors,
        ];
    }
}
