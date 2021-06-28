<?php

session_start();
require_once("connect.php");
$repeat = 0;

if(isset($_POST["submit"])){
    $repeat = 0;
    
    if(isset($_POST["check"])){
        $userName = $_POST["newName"];
        $userPassword = $_POST["newPassword"];
        $truthName = $_POST["truthName"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $address = $_POST["address"];

        $userPassword = sha1($userPassword);

        $searchAll = "SELECT userName, truthName, phone, email FROM member";
        $resultAll = mysqli_query($link, $searchAll);

        while($rowAll = mysqli_fetch_assoc($resultAll)){
            if($userName == $rowAll['userName']){
                $repeatName = 1;
            }
            if($truthName == $rowAll['truthName']){
                $repeatTruth = 1;
            }
            if($email == $rowAll['email']){
                $repeatMail = 1;
            }
            if($phone == $rowAll['phone']){
                $repeatPhone = 1;
            }
        }
    
        $repeat = $repeatPhone + $repeatName + $repeatMail + $repeatTruth;

        if($repeat == 0){
            $addMember = <<<createIn
            INSERT INTO `member`(`userName`, `userPassword`, `truthName`, `email`, `phone`, `userAddress`) 
            VALUES ('$userName','$userPassword','$truthName','$email','$phone','$address');
            createIn;
            $result = mysqli_query($link, $addMember);
        
            header("location: index.php");
            exit();
        }
    }
    
};

if($_POST["submit1"]){

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

    <link rel="stylesheet" href="./CSS/createStyle.css">

</head>
<body>

    <!-- 導覽列 -->
    <nav>
        <div id="box">

            <!--  本頁面各連結 -->
            <div id="link">
                <a href="index.php">三點半</a>
                <a href="index.php#about">關於我們</a>
                <a href="product.php">熱門商品</a>
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
            <a href="product.php">熱門商品</a>
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

    <!-- 創建表格 -->
    <div id="formTitle">註冊會員</div>
    <form action="" method="post" id="create">
        <label for="newName">帳號</label>
        <input type="text" name="newName" id="newName" placeholder="請輸入8~15位的英文和數字" pattern="\w{8,15}" required>
        <p><?= ($repeatName == 1)? "帳號已使用" : "" ?></p>
        <label for="newPassword">密碼</label>
        <input type="password" name="newPassword" id="newPassword" placeholder="請輸入8~15位的英文和數字" pattern="\w{8,15}" required>
        <label for="truthName">本名</label>
        <input type="text" name="truthName" id="truthName" required>
        <p><?= ($repeatTruth == 1)? "此人已使用" : "" ?></p>
        <label for="phone">電話</label>
        <input type="text" name="phone" id="phone" placeholder="範例: 0912345678" pattern="\d{10}" required>
        <p><?= ($repeatPhone == 1)? "電話已使用" : "" ?></p>
        <label for="email">電子信箱</label>
        <input type="text" name="email" id="email" pattern="\w+([.-]\w+)*@\w+([.]\w+)+" required>
        <p><?= ($repeatMail == 1)? "信箱已使用" : "" ?></p>
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
                    <input type="submit" value="送出" id="submit" name="submit1">
                    <a href="create.php">會員註冊</a>
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