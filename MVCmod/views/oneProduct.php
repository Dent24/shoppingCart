<?php
require_once './controllers/oneProductController.php';
require_once './controllers/helloController.php';
$login = new helloC();
$login->result->logout();
$login->login();
$test = new oneProductC();
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三點半</title>

    <link rel="stylesheet" href="./CSS/oneProductStyle.css">

</head>
<body>

    <!-- 導覽列 -->
    <nav>
        <div id="box">

            <!--  本頁面各連結 -->
            <div id="link">
                <a href="./hello">三點半</a>
                <a href="./hello">關於我們</a>
                <a href="./product">熱門商品</a>
                <a href="./hello">聯絡我們</a>
            </div>
            <div></div>
            <div id="member">
            <?= $login->checkLogin() ?>
            </div>

        </div>

        <!-- 手機版漢堡區域 -->
        <div id="burger">
            <a href=""><img src="burger.png" alt=""></a>
            <a href="./hello">三點半</a>
            <a href="./hello">關於我們</a>
            <a href="./product">熱門商品</a>
            <a href="./hello">聯絡我們</a>
            <?= $login->checkLogin() ?>
        </div>
    </nav>

    <!-- 輪轉圖 -->
    <div id="banner"></div>

    <!-- 產品介紹 -->
    <div id="product">
        <?= $test->product() ?>
    </div>

    <!-- 測試 -->

    <!-- 登入區塊 -->
    <div id="login">
        <div id="loginInput">
            <div id="image"></div>
            <div id="text">
                <form action="" method="POST" id="loginForm">
                    <label for="userName">帳號</label>
                    <input type="text" name="userName" id="userName">
                    <label for="userPassword">密碼</label>
                    <input type="password" name="userPassword" id="userPassword">
                    <input type="submit" value="送出" id="submit" name="login">
                    <a href="./create">會員註冊</a>
                </form>
                <button id="close">X</button>
            </div>
        </div>
    </div>
    

    <!-- 聯絡我們 -->
    <footer>
        <div id="contact">
            <div id="logo">
                <h2>三點半</h2>
            </div>
            <div id="content">
                <p>
                    地址: 台中市西屯區逢甲路20巷<br>
                    聯絡電話: (04)4536782
                </p>
            </div>
        </div>
    </footer>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function (){
            // 設定數量增減效果
            var need = $("#need").val();
            $("#sub").on("click",function (){
                need++;
                $("#need").val(need);
            });

            $("#cut").on("click", function (){
                if(need > 0){
                    need--;
                    $("#need").val(need);
                }
            });

            // 顯示和隱藏登入區塊
            $("#login").hide();

            $("#member").on("click", function(){
                $("#login").show();
            });

            $("#close").on("click", function(){
                $("#userName").val("");
                $("#userPassword").val("");
                $("#login").hide();
            });
        });

    </script>
</body>
</html>