<?php

require_once './models/database.php';
session_start();

class masterPostM extends database{

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

    // 抓取所有歷史紀錄上的產品編號
    public function product(){
        $search = self::query("SELECT productId FROM oldProduct GROUP BY productId");
        return $search;
    }

    // 抓取所有符合天數內訂單記錄
    public function detail($day){
        $search = self::query("SELECT * FROM memberOrder WHERE DATEDIFF(NOW(), orderTime) < $day");
        return $search;
    }

    // 抓取所有符合範圍內的訂單記錄
    public function detailChoose($smlDate, $bigDate){
        $search = self::query("SELECT * FROM memberOrder WHERE orderTime <= '$bigDate' AND orderTime >= '$smlDate'");
        return $search;
    }

    // 抓取個訂單的所需要產品編號, 總需求, 以及訂單送出當下的產品價格
    public function orderDetail($oid){
        $search = <<<searchIt
        SELECT od.productId, demand,
        (SELECT price FROM oldProduct WHERE productId = (SELECT od.productId) AND changeTime = (SELECT ops.changeTime)) price
        FROM memberOrder mo
        JOIN orderDetail od ON od.orderId = mo.id
        JOIN (SELECT op.productId, max(changeTime) changeTime FROM oldProduct op
            JOIN orderDetail od ON od.productId = op.productId
            JOIN memberOrder mo ON mo.id = od.orderId
            WHERE mo.id = $oid AND changeTime < orderTime
            GROUP BY op.productId) ops ON ops.productId = od.productId
        WHERE mo.id = $oid
        searchIt;
        $searchIt = self::query($search);

        return $searchIt;
    }

    // 抓取所有歷史紀錄裡的產品名稱
    public function oldProduct(){
        $search = self::query("SELECT productName FROM oldProduct GROUP BY productName");
        return $search;
    }

    // 抓取所有歷史紀錄裡有相同產品名稱的產品編號
    public function sameName($pnm){
        $search = self::query("SELECT productId FROM oldProduct WHERE productName = '$pnm'");
        return $search;
    }

    // 抓取該產品現在的價格以及庫存
    public function productNow($pid){
        $search = self::query("SELECT price, inStock FROM product WHERE id = $pid");
        return $search;
    }
}

?>