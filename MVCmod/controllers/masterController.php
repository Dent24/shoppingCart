<?php

require_once './models/masterModel.php';

class masterC {
    public $result;

    public function __construct(){
        $this->result = new masterM();
    }

    // 顯示管理商品列表
    public function listPro(){
        $product = $this->result->searchPro();

        $list = "";
        foreach($product as $key=>$value){
            $image = base64_encode($value[3]);
            $productId = "id" . $value[0];
            $productName = "product" . $value[0];
            $price = "price" . $value[0];
            $stock = "stock" . $value[0];

            $update = "update" . $value[0];
            $delete = "delete" . $value[0];

            $one = <<<only
            <tr>
                <td>$value[0]<input type="text" name="$productId" value="$value[0]" class="id"></td>
                <td class="imgIn"><div class="imgBg" style="background-image: url(data:image/jpg;charset:utf8;base64,$image)"></div></td>
                <td><input type="text" name="$productName" value="$value[1]"></td>
                <td><input type="text" name="$price" value="$value[2]"></td>
                <td><input type="text" name="$stock" value="$value[4]"></td>
                <td style="width: 200px">
                    <input type="submit" value="修改" name="$update">
                    <input type="submit" value="刪除" name="$delete">
                </td>
            <tr>
            only;

            // 針對各列資料有不同動作
            if(isset($_POST["$update"])){
                $productName = $_POST["$productName"];
                $price = $_POST["$price"];
                $stock = $_POST["$stock"];
                $this->result->update($value[0], $productName, $price, $stock);
            }

            if(isset($_POST["$delete"])){
                $this->result->delete($value[0]);
            }

            $list .= $one;
        }
        return $list;
    }

}

?>