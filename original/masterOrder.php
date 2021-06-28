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
    $searchOrder = <<<searchorder
    SELECT mo.id, orderDate, orderTime, delivery, userName  FROM memberOrder mo 
    JOIN member m ON m.id = mo.memberId
    ORDER BY orderDate DESC;
    searchorder;
    $orderList = mysqli_query($link, $searchOrder);
}

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三點半 管理</title>
    <link rel="stylesheet" href="CSS/masterOrderStyle.css">
</head>
<body>
    <nav>
        <div id="box">
            <h4>管理員: <?= $master["userName"] ?></h4>
            <a href="master.php">商品列表</a>
            <a href="masterMember.php">會員列表</a>
            <a href="#">訂單管理</a>
            <a href="masterPost.php">報表統計</a>
            <div></div>
        </div>
    </nav>

    <form action="" method="post" id="allOrder">
        <table>
            <tr>
                <td colspan="7" id="tableName">訂單列表</td>
            </tr>
            <tr>
                <th>編號</th>
                <th>送達日期</th>
                <th>訂購時間</th>
                <th>訂購人</th>
                <th>內容</th>
                <th>狀態</th>
                <th>送達</th>
            </tr>

            <?php while($order = mysqli_fetch_assoc($orderList)) { ?>
                <tr>
                    <td><?= $order["id"] ?> <input type="text" name="<?= "name".$order["id"] ?>" id="id" value="<?= $order["id"] ?>"></td>
                    <td><?= $order["orderDate"] ?></td>
                    <td><?= $order["orderTime"] ?></td>
                    <td><?= $order["userName"] ?></td>

                    <?php
                        $orderId = $order["id"];
                        $searchOD = <<<searchod
                        SELECT productName, demand
                        FROM orderDetail od
                        JOIN (SELECT productName, productId FROM oldProduct GROUP BY productId, productName) p ON p.productId = od.productId
                        WHERE orderId = $orderId;
                        searchod;
                        $resultOD = mysqli_query($link, $searchOD);
                    ?>
                    <td>
                        <?php while($od = mysqli_fetch_assoc($resultOD)) { ?>
                            <p><?= $od["productName"] . "X" . $od["demand"] ?></p><br>
                        <?php } ?>
                    </td>


                    <td><?= (isset($order["delivery"])) ? "已送達" : "未配送" ?></td>
                    <td style="width: 200px">
                        <input type="submit" value="送出" name="<?php $submit = "submit".$order["id"]; echo $submit; ?>">
                    </td>
                </tr>
            <?php 
                if(isset($_POST["$submit"])){
                    $updateOrder = "UPDATE memberOrder SET delivery = 1 WHERE id = $orderId";
                    mysqli_query($link, $updateOrder);
                    header("location: masterOrder.php");
                }
                } 
            ?>

            <!-- <tr>
                <td>1 <input type="text" name="id" id="id" value="1"></td>
                <td>2020-08-27</td>
                <td>Dent0204</td>
                <td>...</td>
                <td>未配送</td>
                <td style="width: 200px">
                    <input type="button" value="送出">
                </td>
            </tr> -->
        </table>
    </form>
    
</body>
</html>