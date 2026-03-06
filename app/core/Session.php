<?php
namespace App\Core; 

class Session{
    
    public static function init(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

    public static function set($key, $value){
        self::init();
        $_SESSION[$key] = $value;
        error_log("Session::set - {$key} = " . print_r($value, true));
    }

    public static function get($key){
        self::init();
        $value = isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        error_log("Session::get - {$key} = " . print_r($value, true));
        return $value;
    }

    public static function destroy(){
        self::init();
        session_destroy();
    }
}