<?php

session_start();
require_once("connect.php");

$arrayNeed = $_SESSION["productNeed"];
$memberId = $_SESSION["uid"];

if(isset($_POST["submit"])){
    $nowtime = $_POST["time"];
    $orderTime = date("Y-m-d H:i:s");
    $addOrder = <<<addorder
    INSERT INTO memberOrder (memberId, orderDate, orderTime)
    VALUES ($memberId, '$nowtime', '$orderTime');
    addorder;
    mysqli_query($link, $addOrder);

    $searchOrder = "SELECT id FROM memberOrder WHERE orderTime = '$orderTime' AND memberId = $memberId";
    $result = mysqli_query($link, $searchOrder);
    $thisOrder = mysqli_fetch_assoc($result);
    $thisId = $thisOrder["id"];

    $i = 1;
    foreach($arrayNeed as $key => $value){
        foreach($value as $productId => $need){
            $demand = $_POST["need$i"];
            // echo $demand;
            if($demand > 0){
                $addDetail = <<<adddetail
                INSERT INTO orderDetail (orderId, productId, demand)
                VALUES ($thisId, $productId, $demand);
                adddetail;

                $searchProduct = <<<sp
                SELECT inStock FROM product WHERE id = $productId;
                sp;
                $resultPro = mysqli_query($link, $searchProduct);
                $rowPro = mysqli_fetch_assoc($resultPro);
                $nowStock = $rowPro["inStock"] - $demand;
                $updateProduct = <<<up
                UPDATE product SET inStock = $nowStock where id = $productId;
                up;
                // echo $updateProduct;
                // exit();
                // echo $addDetail;
                // exit();
                mysqli_query($link, $addDetail);
                mysqli_query($link, $updateProduct);
            }
            $i++;
        }
    }

    unset($_SESSION["productNeed"]);
    header("location: index.php");
    exit();
    
}

if(isset($_POST["cancel"])){
    unset($_SESSION["productNeed"]);
    header("location: index.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>?????????</title>

    <link rel="stylesheet" href="./CSS/buyBusStyle.css">

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

    <!-- ????????????
    <div id="test">
        
         foreach($arrayNeed as $key => $value){
            foreach($value as $productId => $need){
                echo $productId . $need;
            }
        } 

        count($arrayNeed) 
        
    </div> -->

    <!-- ????????? -->
    <form action="" method="post" id="buyBus">
        <?php
        $i = 1;
        foreach($arrayNeed as $key => $value){
            
            foreach($value as $productId => $need){ 
                $search = "SELECT * FROM product WHERE id = $productId";
                $result = mysqli_query($link, $search);
                $row = mysqli_fetch_assoc($result);
                ?>
                

                <div class="detail" id="<?= "detail$i" ?>">
                    <div class="image" style="background-image: url(data:image/jpg;charset:utf8;base64,<?= base64_encode($row["productImg"]); ?>)"></div>
                    <div class="text">
                        <h1><?= $row["productName"] ?></h1>
                        <p>
                            ??????: <span id="<?= "price$i" ?>"><?= $row["price"] ?></span> <br>
                            ??????: <span id="<?= "need$i" ?>" class="need"><?= $need ?></span> <br>
                            <input type="text" name="<?= "need$i" ?>" id="<?= "tophp$i" ?>" style="display: none;" value="">
                            ??????: <span id="<?= "total$i" ?>" class="need">0</span>
                        </p>
                    </div>
                    <div class="btnGroup">
                        <a class="btn" id="<?= "add$i" ?>">+</a>
                        <a class="btn" id="<?= "cut$i" ?>">-</a>
                        <a class="btn" id="<?= "del$i" ?>">x</a>
                    </div>
                </div>
                
        <?php  
                $i++;
            }
        }
        ?>


        <!-- <div class="detail" id="detail1">
            <div class="image" style="background-image: url(CSS/product3.jpg)"></div>
            <div class="text">
                <h1>???????????????</h1>
                <p>
                    ??????: <span id="price1">200</span> <br>
                    ??????: <span id="need1" class="need">1</span>
                </p>
            </div>
            <div class="btnGroup">
                <a class="btn" id="add1">+</a>
                <a class="btn" id="cut1">-</a>
                <a class="btn" id="del1">x</a>
            </div>
        </div>

        <div class="detail" id="detail2">
            <div class="image" style="background-image: url(CSS/product2.jpg)"></div>
            <div class="text">
                <h1>??????????????????</h1>
                <p>
                    ??????: <span id="price2">220</span> <br>
                    ??????: <span id="need2" class="need">3</span>
                </p>
            </div>
            <div class="btnGroup">
                <a class="btn" id="add2">+</a>
                <a class="btn" id="cut2">-</a>
                <a class="btn" id="del2">x</a>
            </div>
        </div> -->

        <div id="line"> </div>

        <div id="totalPrice">
            <h1>??????: <span id="getTotal">0</span></h1>
        </div>

        <label for="time" id="timeText">??????????????????</label>
        <input type="date" name="time" id="time">

        <div id="subGroup">
            <input type="submit" value="????????????" id="submit" name="submit">
            <input type="submit" value="????????????" id="cancel" name="cancel">
        </div>
    </form>

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
        $(document).ready(function(){
            function totalPrice (number, price){
                var total = number * price;
                return total;
            }

            var totalA = 0;

            <?php for($i = 1; $i <= count($arrayNeed); $i++) { ?>
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

            // var need1 = $("#need1").text();
            // var price1 = $("#price1").text();
            // var total1 = totalPrice(need1, price1);
            // $("#total1").text(total1);
            // $("#add1").on("click", function (){
            //     need1++;
            //     $("#need1").text(need1);
            //     total1 = totalPrice(need1, price1);
            //     totalA = total1 + total2;
            //     $("#getTotal").text(totalA);
            //     $("#total1").text(total1);
            // });

            // $("#cut1").on("click", function (){
            //     if(need1 > 1){
            //         need1--;
            //         $("#need1").text(need1);
            //         total1 = totalPrice(need1, price1);
            //         totalA = total1 + total2;
            //         $("#getTotal").text(totalA);
            //         $("#total1").text(total1);
            //     };
            // });

            // $("#del1").on("click",function (){
            //     $("#detail1").hide();
            //     need1 = 0;
            //     total1 = totalPrice(need1, price1);
            //     totalA = total1 + total2;
            //     $("#getTotal").text(totalA);
            // });

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