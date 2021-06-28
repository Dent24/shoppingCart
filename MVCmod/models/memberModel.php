<?php

require_once './models/database.php';
session_start();

class memberM extends database{

    public function __construct(){
        if(!isset($_SESSION['uid'])){
            header("location: ./hello");
            exit();
        }
    }

    public function member(){
        $uid = $_SESSION["uid"];
        $search = self::query("SELECT userName FROM member WHERE id = $uid");
        return $search[0]['userName'];
    }

    public function detail(){
        $uid = $_SESSION["uid"];
        $search = self::query("SELECT id, orderDate, orderTime FROM memberOrder WHERE memberId = $uid ORDER BY orderTime DESC");
        return $search;
    }

    public function listDetail($oid){
        $orderDetail = <<<searchorderdetail
            SELECT p.id, SUM(demand) demand
            FROM orderDetail od
            JOIN oldProduct p ON p.id = od.productId
            WHERE orderId = $oid 
            GROUP BY p.id;
            searchorderdetail;
        $result = self::query($orderDetail);
        return $result;
    }

    public function searchPro($pid, $oTime){
        $search = self::query("SELECT productName, price FROM oldProduct WHERE productId = $pid AND changeTime <= '$oTime' ORDER BY changeTime DESC LIMIT 1");
        return $search;
    }

}

?>