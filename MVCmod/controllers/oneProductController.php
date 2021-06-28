<?php

require_once './models/oneProductModel.php';

class oneProductC {
    public $result;

    public function __construct(){
        $this->result = new oneProductM();
    }

    // 顯示該商品內容
    public function product(){
        $getPro = $this->result->showPro();
        $image = base64_encode($getPro[0]['productImg']);
        $name = $getPro[0]['productName'];
        $price = $getPro[0]['price'];
        $stock = $getPro[0]['inStock'];

        $error = $this->result->add();

        $showIt = <<<showit
        <div id="image" style="background-image: url(data:image/jpg;charset:utf8;base64,$image)"></div>
        <form action="" method="post" id="choose">
            <h1>$name</h1>
            <h2>定價: $price</h2>
            <h2>庫存: $stock</h2>

            <div id="select">
                <div class="btn" id="cut">-</div>
                <input type="text" id="need" name="need" value="0">
                <div class="btn" id="sub">+</div>
            </div>

            <h2>$error</h2>

            <input type="submit" value="送出" name="submit" id="buyBus">
        </form>
        showit;

        return $showIt;
    }

}

?>