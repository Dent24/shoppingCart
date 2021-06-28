<?php

session_start();
require_once("connect.php");

$searchAll = "SELECT * FROM `product`";
$result = mysqli_query($link, $searchAll);

if($_POST["submit"]){

    $userName = $_POST["userName"];
    $userPassword = $_POST["userPassword"];
    $userPassword = sha1($userPassword);

    if(isset($userName)){
        $search = <<<searchIt
        SELECT id, userName, userPassword, black
        FROM member
        WHERE userName = '$userName';
        searchIt;
        $result = mysqli_query($link, $search);
        $row = mysqli_fetch_assoc($result);
        $passwordCheck = $row["userPassword"];

        if(($userPassword == $passwordCheck) && ($row["black"] != 1)){
            $_SESSION["uid"] = $row["id"];
            header("location: index.php");
            exit();
        }
    }

}

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三點半</title>

    <link rel="stylesheet" href="./CSS/productStyle.css">

</head>
<body>

    <!-- 導覽列 -->
    <nav>
        <div id="box">

            <!--  本頁面各連結 -->
            <div id="link">
                <a href="index.php">三點半</a>
                <a href="index.php#about">關於我們</a>
                <a href="#">熱門商品</a>
                <a href="index.php#contact">聯絡我們</a>
            </div>
            <div></div>
            <div id="member">
                <?php if(isset($_SESSION["uid"])) { ?>
                    <a href="member.php">會員中心</a>
                    &nbsp;
                    <a href="buyBus.php">購物車</a>
                    <a href="index.php?logout=1">登出</a>
                <?php } else { ?>
                    <a id="loginOpen">登入</a>
                <?php } ?>
            </div>

        </div>

        <!-- 手機版漢堡區域 -->
        <div id="burger">
            <a href=""><img src="burger.png" alt=""></a>
            <a href="index.php">三點半</a>
            <a href="index.php#about">關於我們</a>
            <a href="#">熱門商品</a>
            <a href="index.php#contact">聯絡我們</a>
            <?php if(isset($_SESSION["uid"])) { ?>
                <div id="moreA">
                    <a href="member.php">會員中心</a>
                    <a href="buyBus.php">購物車</a>
                    <a href="index.php?logout=1">登出</a>
                </div>
            <?php } else { ?>
                <a id="loginOpen">登入</a>
            <?php } ?>
        </div>
    </nav>

    <!-- 輪轉圖 -->
    <div id="banner"></div>

    <!-- 產品 -->
        <div id="product">
            <?php while( $row = mysqli_fetch_assoc($result) ) { ?>
                <a href="oneProduct.php?productId=<?= $row["id"] ?>">
                    <div>
                        <div class="image" style="background-image: url(data:image/jpg;charset:utf8;base64,<?= base64_encode($row["productImg"]); ?>)"></div>
                        <p><?= $row["productName"] ?></p>
                    </div>
                </a>
            <?php } ?>
        </div>

    <!-- 登入區塊 -->
    <div id="login">
        <div id="loginInput">
            <div id="image"></div>
            <div id="text">
                <form action="" method="POST">
                    <label for="userName">帳號</label>
                    <input type="text" name="userName" id="userName">
                    <label for="userPassword">密碼</label>
                    <input type="password" name="userPassword" id="userPassword">
                    <input type="submit" value="送出" id="submit" name="submit">
                    <a href="create.php">會員註冊</a>
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