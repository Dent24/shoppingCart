<?php

require_once './models/database.php';
session_start();

class updateM extends database{

    public function __construct(){
        if(!isset($_SESSION['uid'])){
            header("location: ./hello");
            exit();
        }
    }

    // 抓取此使用者資訊
    public function searchMember(){
        $id = $_SESSION["uid"];
        $search = self::query("SELECT * FROM member WHERE id = $id");
        return $search;
    }

    // 更改會員資料
    public function updateMember(){
        if(isset($_POST["submit"])){
            if(isset($_POST["check"])){
                $id = $_SESSION["uid"];
                $userName = $_POST["newName"];
                $userPassword = $_POST["newPassword"];
                $truthName = $_POST["truthName"];
                $email = $_POST["email"];
                $phone = $_POST["phone"];
                $userAddress = $_POST["address"];

                $userPassword = sha1($userPassword);

                $update = <<<updateSql
                UPDATE member SET userName = '$userName', userPassword = '$userPassword', truthName = '$truthName',
                email = '$email', phone = '$phone', userAddress = '$userAddress'
                WHERE id = $id;
                updateSql;
                $updateIt = self::query($update);
                header("location: ./member");
                exit();
            }
        }
    }

}

?>