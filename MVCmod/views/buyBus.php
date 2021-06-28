<?php
require_once './controllers/buyBusController.php';
$test = new buyBusC();
$test->result->addToDB();
$test->result->back();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>三點半</title>

    <link rel="stylesheet" href="./CSS/buyBusStyle.css">

</head>
<body>

    <!-- 導覽列 -->
    <nav>
        <div id="box">

            <!--  本頁面各連結 -->
            <div id="link">
                <a href="./hello">三點半</a>
                <a href="./hello">關於我們</a>
                <a href="./product">熱門商品</a>
                <a href="./hello">聯絡我們</a>
            </div>
            <div></div>
            <div id="member">
            <a href="./member">會員中心</a>
            &nbsp;
            <a href="./buyBus">購物車</a>
            <a href="./hello?logout=1">登出</a>
            </div>

        </div>

        <!-- 手機版漢堡區域 -->
        <div id="burger">
            <a href=""><img src="burger.png" alt=""></a>
            <a href="./hello">三點半</a>
            <a href="./hello">關於我們</a>
            <a href="./product">熱門商品</a>
            <a href="./hello">聯絡我們</a>
            <a href="./member">會員中心</a>
            &nbsp;
            <a href="./buyBus">購物車</a>
            <a href="./hello?logout=1">登出</a>
        </div>
    </nav>

    <!-- 輪轉圖 -->
    <div id="banner"></div>

    <!-- 購物車 -->
    <form action="" method="post" id="buyBus">
        <?= $test->buyList() ?>

        <div id="line"> </div>

        <div id="totalPrice">
            <h1>總額: <span id="getTotal">0</span></h1>
        </div>

        <label for="time" id="timeText">希望送達日期</label>
        <input type="date" name="time" id="time">
        <p id="check"><?= ($test->result->addToDB() == 1)? "請選擇三天之後的日期" : "" ?></p>

        <div id="subGroup">
            <input type="submit" value="確認訂單" id="submit" name="submit">
            <input type="submit" value="取消訂單" id="cancel" name="cancel">
        </div>
    </form>

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
        $(document).ready(function(){
            // 計算單項總額
            function totalPrice (number, price){
                var total = number * price;
                return total;
            }

            // 本次購買總額
            var totalA = 0;

            // 針對各項購物車有增加, 減少和取消的效果
            <?php $arrayNeed= $_SESSION["productNeed"];
            for($i = 1; $i <= count($arrayNeed); $i++) { 
            ?>
                var <?= "need$i" ?> = $("<?= "#need$i" ?>").text();
                var <?= "price$i" ?> = $("<?= "#price$i" ?>").text();
                var <?= "total$i" ?> = totalPrice(<?= "need$i" ?>, <?= "price$i" ?>);
                var demand = $("<?= "#need$i" ?>").text();
                $("<?= "#tophp$i" ?>").val(demand);
                $("<?= "#total$i" ?>").text(<?= "total$i" ?>);
                $("<?= "#add$i" ?>").on("click", function (){
                    <?= "need$i" ?>++;
                    demand = <?= "need$i" ?>;
                    $("<?= "#tophp$i" ?>").val(demand);
                    $("<?= "#need$i" ?>").text(<?= "need$i" ?>);
                    <?= "total$i" ?> = totalPrice(<?= "need$i" ?>, <?= "price$i" ?>);
                    allTotal();
                    $("#getTotal").text(totalA);
                    $("<?= "#total$i" ?>").text(<?= "total$i" ?>);
                });

                $("<?= "#cut$i" ?>").on("click", function (){
                    if(<?= "need$i" ?> > 1){
                        <?= "need$i" ?>--;
                        demand = <?= "need$i" ?>;
                        $("<?= "#tophp$i" ?>").val(demand);
                        $("<?= "#need$i" ?>").text(<?= "need$i" ?>);
                        <?= "total$i" ?> = totalPrice(<?= "need$i" ?>, <?= "price$i" ?>);
                        allTotal();
                        $("#getTotal").text(totalA);
                        $("<?= "#total$i" ?>").text(<?= "total$i" ?>);
                    };
                });

                $("<?= "#del$i" ?>").on("click",function (){
                    $("<?= "#detail$i" ?>").hide();
                    <?= "need$i" ?> = 0;
                    demand = <?= "need$i" ?>;
                    $("<?= "#tophp$i" ?>").val(demand);
                    <?= "total$i" ?> = totalPrice(<?= "need$i" ?>, <?= "price$i" ?>);
                    allTotal();
                    $("#getTotal").text(totalA);
                });
            <?php } ?>

            function allTotal(){
                totalA = 0;
                <?php for($i = 1; $i <= count($arrayNeed); $i++) { ?>
                    totalA += <?= "total$i" ?>;
                <?php } ?>
            }
            allTotal();
            $("#getTotal").text(totalA);
        });
    </script>
</body>
</html>