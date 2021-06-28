<?php

require_once './models/productModel.php';

class productC {
    public $result;

    public function __construct(){
        $this->result = new productM();
    }

    // 顯示商品清單
    public function listPro(){
        $list = "";
        foreach($this->result->searchPro() as $key=>$value){
            $id = $value[0];
            $image = base64_encode($value[1]);
            $name = $value[2];

            $oneBox = <<<onebox
            <a href="./oneProduct?productId=$id">
                <div>
                    <div class="image" style="background-image: url(data:image/jpg;charset:utf8;base64,$image)"></div>
                    <p>$name</p>
                </div>
            </a>
            onebox;

            $list .= $oneBox;
        }
        return $list;
    }
}

?>