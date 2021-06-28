<?php

require_once './models/database.php';
session_start();

class helloM extends database{

    // 搜尋前三大熱門商品
    public function searchTop(){
        $searchList = <<<searchlist
        SELECT p.id, productImg, productName,
        (SELECT SUM(demand) FROM orderDetail WHERE productId = (SELECT p.id)) demand 
        FROM product p
        ORDER BY demand DESC LIMIT 3
        searchlist;

        $search = self::query($searchList);
        return $search;
    }

    // 登入系統
    public function memberLogin(){
        if($_POST["login"]){
            $userName = $_POST["userName"];
            $userPassword = $_POST["userPassword"];
            $userPassword = sha1($userPassword);

            if(isset($userName)){
                $searchIt = <<<searchit
                SELECT id, userName, userPassword, black
                FROM member
                WHERE userName = '$userName';
                searchit;
                $search = self::query($searchIt);

                $passwordCheck = $search[0]['userPassword'];

                if(($userPassword == $passwordCheck) && ($search[0]['black'] != 1)){
                    return $search[0]['id'];
                }
            }
        }
    }

    // 登出系統
    public function logout(){
        if(isset($_GET["logout"])){
            unset($_SESSION["uid"]);
            header("location: ./hello");
            exit();
        }
    }

}

?>