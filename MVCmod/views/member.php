<?php
require_once './controllers/memberController.php';
$test = new memberC();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三點半</title>

    <link rel="stylesheet" href="./CSS/memberStyle.css">

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
            <a href="./member">會員中心</a>
            &nbsp;
            <a href="./buyBus">購物車</a>
            <a href="./hello?logout=1">登出</a>
            </div>

        </div>

        <!-- 手機版漢堡區域 -->
        <div id="burger">
            <a href=""><img src="burger.png" alt=""></a>
            <a href="./hello">三點半</a>
            <a href="./hello">關於我們</a>
            <a href="./product">熱門商品</a>
            <a href="./hello">聯絡我們</a>
            <a href="./member">會員中心</a>
            &nbsp;
            <a href="./buyBus">購物車</a>
            <a href="./hello?logout=1">登出</a>
        </div>
    </nav>

    <!-- 輪轉圖 -->
    <div id="banner"></div>

    <!-- 關於會員 -->
    <div id="memberOnly">
        <h1>Hello <?= $test->result->member() ?> !!!</h1>
        <div id="change">
            <a href="./update">修改資料</a>
        </div>
    </div>

    <!-- 歷史紀錄 -->
    <h5>購買紀錄</h5>
    <div id="line"></div>

    <?= $test->showList() ?>

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
    </script>
</body>
</html>