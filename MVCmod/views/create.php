<?php
require_once './controllers/createController.php';
require_once './controllers/helloController.php';
$login = new helloC();
$login->result->logout();
$login->login();
$test = new createC();
$test->result->create();
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三點半</title>

    <link rel="stylesheet" href="./CSS/createStyle.css">

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

    <!-- 創建表格 -->
    <div id="formTitle">註冊會員</div>
    <form action="" method="post" id="create">
        <label for="newName">帳號</label>
        <input type="text" name="newName" id="newName" placeholder="請輸入8~15位的英文和數字" pattern="\w{8,15}" required>
        <?= $test->nameCheck() ?>
        <label for="newPassword">密碼</label>
        <input type="password" name="newPassword" id="newPassword" placeholder="請輸入8~15位的英文和數字" pattern="\w{8,15}" required>
        <label for="truthName">本名</label>
        <input type="text" name="truthName" id="truthName" required>
        <?= $test->truthCheck() ?>
        <label for="phone">電話</label>
        <input type="text" name="phone" id="phone" placeholder="範例: 0912345678" pattern="\d{10}" required>
        <?= $test->phoneCheck() ?>
        <label for="email">電子信箱</label>
        <input type="text" name="email" id="email" pattern="\w+([.-]\w+)*@\w+([.]\w+)+" required>
        <?= $test->mailCheck() ?>
        <label for="address">地址</label>
        <input type="text" name="address" id="address" required>
        
        <input type="checkbox" name="check" id="check" value="1">
        <label for="check">我同意本平台的使用者規範</label>

        <div id="btnGroup">
            <input type="submit" value="確認" class="button" name="submit">
            <input type="reset" value="重設" class="button">
        </div>
    </form>

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
                <!-- <div id="close"></div> -->
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