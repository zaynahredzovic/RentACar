<?php 

namespace App\Models;

use App\Core\Database;
use PDO;

class User{
    private $db;

    public function __construct(){
        $this->db = Database::$conn;
    }

    // SIGN UP //
    public function register($fullName, $email, $password){
        if($this->findByEmail($email)){
            return ["status" => "error", "message"=> "Email already exists"];
        }

        $hashedPwd = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("INSERT INTO users (name, email, pwd) VALUES (?, ?, ?)");

        $success = $stmt->execute([$fullName, $email, $hashedPwd]);

        if($success) {
            return ["status" => "success", "message" => "Account created successfully"];
        }
        return [ "status" => "error", "message" => "Signup failed"];
    }


    // LOGIN

    public function login($email, $password) {

        $user = $this->findByEmail($email);

        if(!$user) {
            return ["status" => "error", "message" => "Invalid credentials"];
        }

        if(password_verify($password, $user['password'])){
            return ["status" => "success", "message" => "Login successful","user" => $user];
        }

        return ["status" => "error", "message" => "Invalid credentials"];
    }


    // FIND USER BY EMAIL
    public function findByEmail($email) {

        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = ? LIMIT 1"
        );

        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
