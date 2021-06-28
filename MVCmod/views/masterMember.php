<?php
require_once './controllers/masterMemberController.php';
$test = new masterMemberC();
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
    <!-- 管理端各頁面連結 -->
    <nav>
        <div id="box">
            <h4>管理員: <?= $test->result->member[0]['userName'] ?></h4>
            <a href="./master">商品列表</a>
            <a href="#">會員列表</a>
            <a href="./masterOrder">訂單管理</a>
            <a href="./masterPost">報表統計</a>
            <div></div>
        </div>
    </nav>

    <!-- 會員管理列表 -->
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

            <?= $test->memberShow(); ?>
        </table>
    </form>
    
</body>
</html>