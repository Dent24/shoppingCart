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
    <title>?????????</title>

    <link rel="stylesheet" href="./CSS/createStyle.css">

</head>
<body>

    <!-- ????????? -->
    <nav>
        <div id="box">

            <!--  ?????????????????? -->
            <div id="link">
                <a href="index.php">?????????</a>
                <a href="index.php#about">????????????</a>
                <a href="product.php">????????????</a>
                <a href="index.php#contact">????????????</a>
            </div>
            <div></div>
            <div id="member">
                <?php if(isset($_SESSION["uid"])) { ?>
                    <a href="member.php">????????????</a>
                    &nbsp;
                    <a href="buyBus.php">?????????</a>
                    <a href="index.php?logout=1">??????</a>
                <?php } else { ?>
                    <a id="loginOpen">??????</a>
                <?php } ?>
            </div>

        </div>

        <!-- ????????????????????? -->
        <div id="burger">
            <a href=""><img src="burger.png" alt=""></a>
            <a href="index.php">?????????</a>
            <a href="index.php#about">????????????</a>
            <a href="product.php">????????????</a>
            <a href="index.php#contact">????????????</a>
            <?php if(isset($_SESSION["uid"])) { ?>
                <div id="moreA">
                    <a href="member.php">????????????</a>
                    <a href="buyBus.php">?????????</a>
                    <a href="index.php?logout=1">??????</a>
                </div>
            <?php } else { ?>
                <a id="loginOpen">??????</a>
            <?php } ?>
        </div>
    </nav>

    <!-- ????????? -->
    <div id="banner"></div>

    <!-- ???????????? -->
    <div id="formTitle">????????????</div>
    <form action="" method="post" id="create">
        <label for="newName">??????</label>
        <input type="text" name="newName" id="newName" placeholder="?????????8~15?????????????????????" pattern="\w{8,15}" required>
        <p><?= ($repeatName == 1)? "???????????????" : "" ?></p>
        <label for="newPassword">??????</label>
        <input type="password" name="newPassword" id="newPassword" placeholder="?????????8~15?????????????????????" pattern="\w{8,15}" required>
        <label for="truthName">??????</label>
        <input type="text" name="truthName" id="truthName" required>
        <p><?= ($repeatTruth == 1)? "???????????????" : "" ?></p>
        <label for="phone">??????</label>
        <input type="text" name="phone" id="phone" placeholder="??????: 0912345678" pattern="\d{10}" required>
        <p><?= ($repeatPhone == 1)? "???????????????" : "" ?></p>
        <label for="email">????????????</label>
        <input type="text" name="email" id="email" pattern="\w+([.-]\w+)*@\w+([.]\w+)+" required>
        <p><?= ($repeatMail == 1)? "???????????????" : "" ?></p>
        <label for="address">??????</label>
        <input type="text" name="address" id="address" required>
        
        <input type="checkbox" name="check" id="check" value="1">
        <label for="check">????????????????????????????????????</label>

        <div id="btnGroup">
            <input type="submit" value="??????" class="button" name="submit">
            <input type="reset" value="??????" class="button">
        </div>
    </form>

    <!-- ???????????? -->
    <div id="login">
        <div id="loginInput">
            <div id="image"></div>
            <div id="text">
                <form action="" method="POST" id="loginForm">
                    <label for="userName">??????</label>
                    <input type="text" name="userName" id="userName">
                    <label for="userPassword">??????</label>
                    <input type="password" name="userPassword" id="userPassword">
                    <input type="submit" value="??????" id="submit" name="submit1">
                    <a href="create.php">????????????</a>
                </form>
                <button id="close">X</button>
                <!-- <div id="close"></div> -->
            </div>
        </div>
    </div>

    <!-- ???????????? -->
    <footer>
        <div id="contact">
            <div id="logo">
                <h2>?????????</h2>
            </div>
            <div id="content">
                <p>
                    ??????: ???????????????????????????20???<br>
                    ????????????: (04)4536782
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