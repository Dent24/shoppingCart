<?php

require_once './models/database.php';
session_start();

class buyBusM extends database{

    public function __construct(){
        if(!isset($_SESSION['uid'])){
            header("location: ./hello");
            exit();
        }

        if(!isset($_SESSION['productNeed'])){
            header("location: ./product");
            exit();
        }
    }

    // 抓取該商品資訊
    public function searchIt($value){
        $search = self::query("SELECT id, productName, price, productImg, inStock FROM product WHERE id = $value");
        return $search;
    }

    // 購物車內容新增至資料庫
    public function addToDB(){
        $arrayNeed = $_SESSION["productNeed"];
        $memberId = $_SESSION["uid"];
        if(isset($_POST["submit"])){
            $nowtime = $_POST["time"];
            $orderTime = date("Y-m-d H:i:s");
            $threeDay = date("Y-m-d", strtotime($today."+3 day"));

            if($nowtime < $threeDay){
                return 1;
            }

            // 先新增訂單
            $addOrder = <<<addorder
            INSERT INTO memberOrder (memberId, orderDate, orderTime)
            VALUES ($memberId, '$nowtime', '$orderTime');
            addorder;
            $addIt = self::query($addOrder);
        
            // 搜尋此次交易訂單編號
            $searchOrder = self::query("SELECT id FROM memberOrder WHERE orderTime = '$orderTime' AND memberId = $memberId");
            $thisId = $searchOrder[0]["id"];
        
            // 逐項加入至訂單明細
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
                        $addIt = self::query($addDetail);
        
                        $searchProduct = self::query("SELECT inStock FROM product WHERE id = $productId");
                        $nowStock = $searchProduct[0]["inStock"] - $demand;
                        $updateProduct = self::query("UPDATE product SET inStock = $nowStock where id = $productId;");
                    }
                    $i++;
                }
            }
        
            unset($_SESSION["productNeed"]);
            header("location: ./hello");
            exit();
            
        }
    }

    // 取消訂單
    public function back(){
        if(isset($_POST["cancel"])){
            unset($_SESSION["productNeed"]);
            header("location: ./hello");
            exit();
        }
    }
}

?>
