<?php
require_once './controllers/masterController.php';
$test = new masterC();
$test->result->newPro();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三點半 管理</title>
    <link rel="stylesheet" href="CSS/masterStyle.css">
</head>
<body>
    <!-- 管理端各頁面連結 -->
    <nav>
        <div id="box">
            <h4>管理員: <?= $test->result->member[0]['userName'] ?></h4>
            <a href="#">商品列表</a>
            <a href="./masterMember">會員列表</a>
            <a href="./masterOrder">訂單管理</a>
            <a href="./masterPost">報表統計</a>
            <div></div>
        </div>
    </nav>

    <!-- 商品管理列表 -->
    <form action="" method="post" id="allProduct">
        <table>
            <tr>
                <td colspan="6" id="tableName">商品列表</td>
            </tr>
            <tr>
                <th>編號</th>
                <th>照片</th>
                <th>品名</th>
                <th>定價</th>
                <th>庫存</th>
                <th>修改／刪除</th>
            </tr>

            <?= $test->listPro() ?>
        </table>
    </form>

    <!-- 新增商品表格 -->
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td colspan="5" id="tableName">新增商品</td>
            </tr>
            <tr>
                <th>品名</th>
                <th>定價</th>
                <th>庫存</th>
                <th>圖片</th>
                <th>確認</th>
            </tr>

            <tr>
                <td><input type="text" name="newProduct"></td>
                <td><input type="text" name="newPrice"></td>
                <td><input type="text" name="newStock"></td>
                <td><input type="file" name="image"></td>
                <td style="width: 200px">
                    <input type="submit" value="新增" name="new">
                </td>
            </tr>
        </table>
    </form>
    
</body>
</html>