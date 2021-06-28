<?php

require_once './models/database.php';
session_start();

class masterM extends database{

    public $member;

    public function __construct(){
        if(!isset($_SESSION['mid'])){
            header("location: ./hello");
            exit();
        }

        $mid = $_SESSION["mid"];
        $search = self::query("SELECT userName, grade FROM webMaster WHERE id = $mid");
        $this->member = $search;
    }

    // 抓取所有商品資訊
    public function searchPro(){
        $search = self::query("SELECT * FROM product");
        return $search;
    }

    // 更新商品資訊並且加入至歷史紀錄
    public function update($v1, $v2, $v3, $v4){
        $time = date("Y-m-d H:i:s");
        $update = self::query("UPDATE product SET productName = '$v2', price = $v3, inStock = $v4 WHERE id = $v1");
        $insert = self::query("INSERT INTO oldProduct (productId, productName, price, changeTime) VALUES ($v1, '$v2', $v3, '$time')");
        header("location: ./master");
    }

    // 刪除商品(歷史資料的不會刪除)
    public function delete($value){
        if($member[0]['grade'] < 3){
            $delete = self::query("DELETE FROM product WHERE id = $value");
            header("location: ./master");
        }
    }

    // 新增商品
    public function newPro(){
        if(isset($_POST["new"])){
            $newProduct = $_POST["newProduct"];
            $newPrice = $_POST["newPrice"];
            $newStock = $_POST["newStock"];
            if(!empty($_FILES["image"]["name"])) { 
                // Get file info 
                $fileName = basename($_FILES["image"]["name"]); 
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                 
                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg','gif'); 
                if(in_array($fileType, $allowTypes)){ 
                    $image = $_FILES['image']['tmp_name']; 
                    $imgContent = addslashes(file_get_contents($image));

                    $create = self::query("INSERT INTO product (productName, price, productImg, inStock) VALUES ('$newProduct', $newPrice,'$imgContent', $newStock)");
                    $search = self::query("SELECT id FROM product WHERE productName = '$newProduct'");

                    $time = date("Y-m-d H:i:s");
                    $productNew = $search[0]['id'];
                    $insertNew = self::query("INSERT INTO oldProduct (productId, productName, price, changeTime) VALUES ($productNew, '$newProduct', $newPrice, '$time')");
                }
            }
            header("location: ./master");
        }
    }
}

?>