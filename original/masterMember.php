<?php

session_start();
require_once("connect.php");

if(!isset($_SESSION["mid"])){
    header("location: index.php");
    exit();
}else{
    $mid = $_SESSION["mid"];
    $searchSession = "SELECT userName, grade FROM webMaster WHERE id = $mid";
    $result = mysqli_query($link, $searchSession);
    $master = mysqli_fetch_assoc($result);
    $serachMem = "SELECT * FROM member";
    $memberList = mysqli_query($link, $serachMem);
}

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三點半 管理</title>
    <link rel="stylesheet" href="CSS/masterMemberStyle.css">
</head>
<body>
    <nav>
        <div id="box">
            <h4>管理員: <?= $master["userName"] ?></h4>
            <a href="master.php">商品列表</a>
            <a href="#">會員列表</a>
            <a href="masterOrder.php">訂單管理</a>
            <a href="masterPost.php">報表統計</a>
            <div></div>
        </div>
    </nav>

    <form action="" method="post" id="allProduct">
        <table>
            <tr>
                <td colspan="5" id="tableName">會員列表</td>
            </tr>
            <tr>
                <th>編號</th>
                <th>會員帳號</th>
                <th>電子信箱</th>
                <th>聯絡電話</th>
                <th>黑名單</th>
            </tr>

            <?php while($member = mysqli_fetch_assoc($memberList)) { ?>
                <tr>
                    <td><?= $member["id"] ?> <input type="text" name="<?= "id" . $member["id"] ?>" id="id" value="<?= $member["id"] ?>"></td>
                    <td><?= $member["userName"] ?></td>
                    <td><?= $member["email"] ?></td>
                    <td><?= $member["phone"] ?></td>
                    <td style="width: 200px">
                        <?php if(!isset($member["black"])){ ?>
                        <span>X</span>
                        <input type="submit" value="設立" name="<?php $set = "set".$member["id"]; echo $set; ?>">
                        <?php }else{ ?>
                        <span>O</span>
                        <input type="submit" value="取消" name="<?php $cancel = "cancel".$member["id"]; echo $cancel; ?>">
                        <?php } ?>
                    </td>
                </tr>
            <?php 
                if(isset($_POST["$set"])){
                    $memberId = $member["id"];
                    $updateBlack = "UPDATE member SET black = 1 WHERE id = $memberId";
                    
                    if($master["grade"] < 2){
                        mysqli_query($link, $updateBlack);
                    }
                    header("location: masterMember.php");
                }
                } 
            ?>
            
            <!-- <tr>
                <td>1 <input type="text" name="id" id="id" value="1"></td>
                <td>Dent0204</td>
                <td>abc@mail.com</td>
                <td>0912345678</td>
                <td style="width: 200px">
                    <span>X</span>
                    <input type="submit" value="設立">
                </td>
            </tr> -->
        </table>
    </form>
    
</body>
</html>