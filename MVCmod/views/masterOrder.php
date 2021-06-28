<?php
require_once './controllers/masterOrderController.php';
$test = new masterOrderC();
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
    <!-- 管理端各頁面連結 -->
    <nav>
        <div id="box">
            <h4>管理員: <?= $test->result->member[0]['userName'] ?></h4>
            <a href="./master">商品列表</a>
            <a href="./masterMember">會員列表</a>
            <a href="#">訂單管理</a>
            <a href="./masterPost">報表統計</a>
            <div></div>
        </div>
    </nav>

    <!-- 訂單管理列表 -->
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

            <?= $test->orderShow() ?>
        </table>
    </form>
    
</body>
</html>