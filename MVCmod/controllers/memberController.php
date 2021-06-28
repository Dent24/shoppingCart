<?php

require_once './models/memberModel.php';
session_start();

class memberC {
    public $result;

    public function __construct(){
        $this->result = new memberM();
    }

    public function showList(){
        $list = $this->result->detail();
        $show = "";
        foreach($list as $key=>$value){
            $oid = $value[0];
            $oDate = $value[1];
            $oTime = $value[2];

            $demandList = $this->demand($oid, $oTime);

            $showDetail = <<<showdetail
            <div class="history">
                <h3>訂購日期: $oTime</h3>
                <h3>送達日期: $oDate</h3>
                $demandList
                <hr>
            </div>
            showdetail;

            $show .= $showDetail;
        }

        return $show;
    }

    public function demand($oid, $oTime){
        $orderDetail = $this->result->listDetail($oid);
        $showList = "";

        $total = 0;
        foreach($orderDetail as $key=>$value){
            $pid = $value[0];
            $product = $this->result->searchPro($pid, $oTime);
            $total += $product[0]['price'] * $value[1];
            $name = $product[0]['productName'];
            $price = $product[0]['price'];

            $showList .= "$name : $price X $value[1] <br>"; 
        }

        return "<p>$showList</p> <h3>Total: $total</h3>";
    }
}

?>