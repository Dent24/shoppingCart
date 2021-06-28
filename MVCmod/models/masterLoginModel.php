<?php

require_once './models/database.php';
session_start();

class masterLoginM extends database{

    public function __construct(){

    }

    // 登入系統
    public function login(){
        if(isset($_POST["submit"])){
            $userName = $_POST["masterName"];
            $userPassword = $_POST["masterPassword"];
            $search = self::query("SELECT * FROM webMaster WHERE userName = '$userName'");

            if($userPassword == $search[0]['userPassword']){
                $_SESSION["mid"] = $search[0]['id'];
                header("location: ./master");
                exit();
            }
        }
    }

}

?>