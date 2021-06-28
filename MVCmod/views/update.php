<?php
require_once './controllers/updateController.php';
$test = new updateC();
$test->result->updateMember();
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三點半</title>

    <link rel="stylesheet" href="./CSS/updateStyle.css">

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

    <!-- 更新表格 -->
    <div id="formTitle">修改資料</div>
    <form action="" method="post">
        <label for="newName">帳號</label>
        <input type="text" name="newName" id="newName" placeholder="請輸入8~15位的英文和數字" pattern="\w{8,15}" required value="<?= $test->member[1] ?>">
        <label for="newPassword">密碼</label>
        <input type="password" name="newPassword" id="newPassword" placeholder="請輸入8~15位的英文和數字" pattern="\w{8,15}" required value="<?= $test->member[2] ?>">
        <label for="truthName">本名</label>
        <input type="text" name="truthName" id="truthName" required value="<?= $test->member[3] ?>">
        <label for="phone">電話</label>
        <input type="text" name="phone" id="phone" placeholder="範例: 0912345678" pattern="\d{10}" required value="<?= $test->member[5] ?>">
        <label for="email">電子信箱</label>
        <input type="text" name="email" id="email" pattern="\w+([.-]\w+)*@\w+([.]\w+)+" required value="<?= $test->member[4] ?>">
        <label for="address">地址</label>
        <input type="text" name="address" id="address" required value="<?= $test->member[6] ?>">
        
        <input type="checkbox" name="check" id="check" value="1">
        <label for="check">我同意本平台的使用者規範</label>

        <div id="btnGroup">
            <input type="submit" value="確認" class="button" name="submit">
            <input type="reset" value="重設" class="button">
        </div>
    </form>

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