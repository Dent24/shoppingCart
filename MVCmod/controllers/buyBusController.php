<?php

require_once './models/buyBusModel.php';
session_start();

class buyBusC {
    public $result;

    public function __construct(){
        $this->result = new buyBusM();
    }

    // 顯示此次購物清單
    public function buyList(){
        $arrayNeed = $_SESSION["productNeed"];
        $list = "";
        $i = 1;

        foreach($arrayNeed as $key => $value){
            
            foreach($value as $productId => $need){
                $search = $this->result->searchIt($productId);
                $image = base64_encode($search[0]['productImg']);
                $name = $search[0]['productName'];
                $price = $search[0]['price'];

                $detailId = "detail" . $i;
                $priceId = "price" . $i;
                $needId = "need" . $i;
                $tophpId = "tophp" . $i;
                $totalId = "total" . $i;
                $add = "add" . $i;
                $cut = "cut" . $i;
                $del = "del" . $i;

                $showIt = <<<showit
                <div class="detail" id="$detailId">
                    <div class="image" style="background-image: url(data:image/jpg;charset:utf8;base64,$image)"></div>
                    <div class="text">
                        <h1>$name</h1>
                        <p>
                            定價: <span id="$priceId">$price</span> <br>
                            數量: <span id="$needId" class="need">$need</span> <br>
                            <input type="text" name="$needId" id="$tophpId" style="display: none;" value="">
                            小記: <span id="$totalId" class="need">0</span>
                        </p>
                    </div>
                    <div class="btnGroup">
                        <a class="btn" id="$add">+</a>
                        <a class="btn" id="$cut">-</a>
                        <a class="btn" id="$del">x</a>
                    </div>
                </div>
                showit;

                $i++;
                $list .= $showIt;
            }
        }
        return $list;
    }

}

?>