<?php
require_once './controllers/masterLoginController.php';
$test = new masterLoginC();
$test->result->login();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三點半 管理</title>
    <link rel="stylesheet" href="CSS/masterLoginStyle.css">
</head>
<body>

    <!-- 登入表格 -->
    <form action="" method="post">
        <table>
            <tr>
                <th colspan="2">管理員登入</th>
            </tr>
            <tr>
                <td class="labelText">帳號:</td>
                <td><input type="text" name="masterName" id="masterName" required></td>
            </tr>
            <tr>
                <td class="labelText">密碼:</td>
                <td><input type="password" name="masterPassword" id="masterPassword" required></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="登入" name="submit"></td>
            </tr>
        </table>
    </form>
</body>
</html>