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
}

$nowTime = date("Y-m-d");

if(isset($_POST["oneD"])){
    $serachOne = <<<serachone
    SELECT * FROM product;
    serachone;
    $resultOne = mysqli_query($link, $serachOne);
}

if(isset($_POST["senD"])){
    $serachOne = <<<serachone
    SELECT * FROM product;
    serachone;
    $resultOne = mysqli_query($link, $serachOne);
}

if(isset($_POST["oneM"])){
    $serachOne = <<<serachone
    SELECT * FROM product;
    serachone;
    $resultOne = mysqli_query($link, $serachOne);
}

if(isset($_POST["choose"])){
    $date1 = $_POST["date1"];
    $date2 = $_POST["date2"];
    if($date1 < $date2){
        $bigDate = $date2;
        $smlDate = $date1;
    }else{
        $bigDate = $date1;
        $smlDate = $date2;
    }
    
    $serachOne = <<<serachone
    SELECT * FROM product;
    serachone;
    $resultOne = mysqli_query($link, $serachOne);
}

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三點半 管理</title>
    <link rel="stylesheet" href="CSS/masterPortStyle.css">
</head>
<body>

    <nav>
        <div id="box">
            <h4>管理員: <?= $master["userName"] ?></h4>
            <a href="master.php">商品列表</a>
            <a href="masterMember.php">會員列表</a>
            <a href="masterOrder.php">訂單管理</a>
            <a href="#">報表統計</a>
            <div></div>
        </div>
    </nav>

    <form action="" method="post" id="chooseTime">
        <input type="submit" value="一天內" name="oneD">
        <input type="submit" value="七天內" name="senD">
        <input type="submit" value="一個月內" name="oneM">

        <div id="date">
            <input type="date" name="date1" id="date1">
            ~
            <input type="date" name="date2" id="date2" value="<?= $nowTime ?>">
            <input type="submit" value="送出" name="choose">
        </div>
    </form>

    <table>
        <tr>
            <th>商品名稱</th>
            <th>販售量</th>
            <th>現在庫存量</th>
            <th>定價</th>
            <th>單項營收</th>
        </tr>

        <?php if(isset($_POST["oneD"])){
            $income = 0;
            $oneIncome = 0;
            while($one = mysqli_fetch_assoc($resultOne)){ ?>
                <tr>
                    <td><?= $one["productName"] ?></td>

                    <?php 
                        $oneId = $one["id"];
                        $sall = <<<sallserach
                        SELECT SUM(demand) demand FROM product p
                        JOIN orderDetail od ON od.productId = p.id
                        JOIN memberOrder mo ON od.orderId = mo.id
                        WHERE DATEDIFF(NOW(), orderTime) < 1 AND p.id = $oneId
                        sallserach;
                        $sallResult = mysqli_query($link, $sall);
                        $sallIt = mysqli_fetch_assoc($sallResult);
                        if(isset($sallIt["demand"])){
                            $sallDemand = $sallIt["demand"];
                        }else{
                            $sallDemand = 0;
                        }
                        $oneIncome = $sallDemand*$one["price"];
                        $income += $oneIncome;
                    ?>
                    <td><?= $sallDemand?></td>
                    <td><?= $one["inStock"] ?></td>
                    <td><?= $one["price"] ?></td>
                    <td><?= $oneIncome ?></td>
                </tr>
        <?php } 
        }?>

        <?php if(isset($_POST["senD"])){
            $income = 0;
            $oneIncome = 0;
            while($one = mysqli_fetch_assoc($resultOne)){ ?>
                <tr>
                    <td><?= $one["productName"] ?></td>

                    <?php 
                        $oneId = $one["id"];
                        $sall = <<<sallserach
                        SELECT SUM(demand) demand FROM product p
                        JOIN orderDetail od ON od.productId = p.id
                        JOIN memberOrder mo ON od.orderId = mo.id
                        WHERE DATEDIFF(NOW(), orderTime) < 7 AND p.id = $oneId
                        sallserach;
                        $sallResult = mysqli_query($link, $sall);
                        $sallIt = mysqli_fetch_assoc($sallResult);
                        if(isset($sallIt["demand"])){
                            $sallDemand = $sallIt["demand"];
                        }else{
                            $sallDemand = 0;
                        }
                        $oneIncome = $sallDemand*$one["price"];
                        $income += $oneIncome;
                    ?>
                    <td><?= $sallDemand?></td>
                    <td><?= $one["inStock"] ?></td>
                    <td><?= $one["price"] ?></td>
                    <td><?= $oneIncome ?></td>
                </tr>
        <?php } 
        }?>

        <?php if(isset($_POST["oneM"])){
            $income = 0;
            $oneIncome = 0;
            while($one = mysqli_fetch_assoc($resultOne)){ ?>
                <tr>
                    <td><?= $one["productName"] ?></td>

                    <?php 
                        $oneId = $one["id"];
                        $sall = <<<sallserach
                        SELECT SUM(demand) demand FROM product p
                        JOIN orderDetail od ON od.productId = p.id
                        JOIN memberOrder mo ON od.orderId = mo.id
                        WHERE DATEDIFF(NOW(), orderTime) < 30 AND p.id = $oneId
                        sallserach;
                        $sallResult = mysqli_query($link, $sall);
                        $sallIt = mysqli_fetch_assoc($sallResult);
                        if(isset($sallIt["demand"])){
                            $sallDemand = $sallIt["demand"];
                        }else{
                            $sallDemand = 0;
                        }
                        $oneIncome = $sallDemand*$one["price"];
                        $income += $oneIncome;
                    ?>
                    <td><?= $sallDemand?></td>
                    <td><?= $one["inStock"] ?></td>
                    <td><?= $one["price"] ?></td>
                    <td><?= $oneIncome ?></td>
                </tr>
        <?php } 
        }?>

        <?php if(isset($_POST["choose"])){
            $income = 0;
            $oneIncome = 0;
            while($one = mysqli_fetch_assoc($resultOne)){ ?>
                <tr>
                    <td><?= $one["productName"] ?></td>

                    <?php 
                        $oneId = $one["id"];
                        $sall = <<<sallserach
                        SELECT SUM(demand) demand FROM product p
                        JOIN orderDetail od ON od.productId = p.id
                        JOIN memberOrder mo ON od.orderId = mo.id
                        WHERE orderTime <= '$bigDate' AND orderTime >= '$smlDate' AND p.id = $oneId
                        sallserach;
                        $sallResult = mysqli_query($link, $sall);
                        $sallIt = mysqli_fetch_assoc($sallResult);
                        if(isset($sallIt["demand"])){
                            $sallDemand = $sallIt["demand"];
                        }else{
                            $sallDemand = 0;
                        }
                        $oneIncome = $sallDemand*$one["price"];
                        $income += $oneIncome;
                    ?>
                    <td><?= $sallDemand?></td>
                    <td><?= $one["inStock"] ?></td>
                    <td><?= $one["price"] ?></td>
                    <td><?= $oneIncome ?></td>
                </tr>
        <?php } 
        }?>
    </table>
    
    <h1>總營收: <?= $income ?></h1>

    <div id="image">
        <?php 
        if(isset($_POST["oneD"])) {
            require_once './img/oneday.php';
        } 

        if(isset($_POST["senD"])) { 
            require_once './img/senday.php';
        }

        if(isset($_POST["oneM"])) { 
            require_once './img/onemonth.php';
        }
        ?>
    </div>
</body>
</html>