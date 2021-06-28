<?php

require_once("connect.php");
session_start();

$searchTop = <<<searchtop
SELECT p.id, productImg, productName,
(SELECT SUM(demand) FROM orderDetail WHERE productId = (SELECT p.id)) demand 
FROM product p
ORDER BY demand DESC LIMIT 3
searchtop;
$resultTop = mysqli_query($link, $searchTop);

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
        }
    }

}

if(isset($_GET["logout"])){
    unset($_SESSION["uid"]);
    header("location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三點半</title>
    <link rel="stylesheet" href="./CSS/indexStyle.css">

</head>
<body>

    <!-- 導覽列 -->
    <nav>
        <div id="box">

            <!--  本頁面各連結 -->
            <div id="link">
                <a href="#">三點半</a>
                <a href="#about">關於我們</a>
                <a href="product.php">熱門商品</a>
                <a href="#contact">聯絡我們</a>
            </div>
            <div></div>
            <div id="member">
                <?php if(isset($_SESSION["uid"])) { ?>
                    <div id="moreA">
                        <a href="member.php">會員中心</a>
                        &nbsp;
                        <a href="buyBus.php">購物車</a>
                        <a href="index.php?logout=1">登出</a>
                    </div>
                <?php } else { ?>
                    <a id="loginOpen">登入</a>
                <?php } ?>
            </div>

        </div>

        <!-- 手機版漢堡區域 -->
        <div id="burger">
            <a href=""><img src="burger.png" alt=""></a>
            <a href="#">三點半</a>
            <a href="#about">關於我們</a>
            <a href="product.php">熱門商品</a>
            <a href="#contact">聯絡我們</a>
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

    <!-- 關於我們 -->
    <section id="about">
        <h1>關於我們</h1>
        <div id="image"></div>
        <div id="text">
            <h5>三點半 3.PI</h5>
            <p>
                一個完整的派就是一個圓, 而一個圓也就是一個PI<br>
                而PI也代表著3點, 正如我們的出爐時間<br>
                為完美的午茶, 點綴完美的句點
            </p>
        </div>
    </section>

    <!-- 熱門產品 -->
    <h1 id="productText">熱門產品</h1>

    <section id="product">

        <?php while($top = mysqli_fetch_assoc($resultTop)){ ?>
            <div class="products" style="background-image: url(data:image/jpg;charset:utf8;base64,<?= base64_encode($top["productImg"]); ?>)">
                <div class="name"><?= $top["productName"] ?></div>
            </div>
        <?php } ?>

        <!-- <div class="products">
            <div class="name">巫女們的宴會</div>
        </div>
        <div class="products">
            <div class="name">少女的酸甜</div>
        </div>
        <div class="products">
            <div class="name">梵谷的星空</div>
        </div> -->

        <div id="link">
            <a href="product.php">MORE _______</a>
        </div>
    </section>

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

    <!-- 測試區域 -->

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