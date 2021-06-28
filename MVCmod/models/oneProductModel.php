<?php

require_once './models/database.php';
session_start();

class oneProductM extends database{

    public function __construct(){
        if(!isset($_SESSION["productNeed"])){
            $_SESSION["productNeed"] = array();
        }

        if(!isset($_GET["productId"])){
            header("location: ./product");
            exit();
        }
    }

    // 抓取指定商品資料
    public function showPro(){
        $productId = $_GET["productId"];
        $search = self::query("SELECT * FROM `product` WHERE id = $productId");
        return $search;
    }

    // 加入至購物車
    public function add(){
        if(isset($_POST["submit"])){
            $product = $this->showPro();
            $checkstock = $product[0]['inStock'] - $_POST["need"];

            if($_POST["need"] <= 0){
                return "請添購至少一個";
            }else if($checkstock >= 0){
                $productId = $_GET["productId"];
                $arrayNeed[$productId] = $_POST["need"];
                array_push($_SESSION["productNeed"], $arrayNeed);
            }else{
                return "庫存量不足";
            }
        }
    }

}

?>