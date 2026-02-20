<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Session;

class AuthController {

    public function login() {
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function signup() {
        require __DIR__ . '/../Views/auth/signup.php';
    }

    // SIGNUP API
    public function signupPost() {

        header('Content-Type: application/json');

        $userModel = new User();

        $result = $userModel->register(
            $_POST['fullname'],
            $_POST['email'],
            $_POST['password']
        );

        echo json_encode($result);
    }

    // LOGIN API
    public function loginPost() {

        header('Content-Type: application/json');

        $userModel = new User();

        $result = $userModel->login(
            $_POST['email'],
            $_POST['password']
        );

        if($result['status'] === 'success') {
            Session::set('user', $result['user']);
        }

        echo json_encode([
            "status" => $result['status'],
            "message" => $result['message']
        ]);
    }
}