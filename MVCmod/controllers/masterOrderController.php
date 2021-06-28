<?php

require_once './models/masterOrderModel.php';

class masterOrderC {
    public $result;

    public function __construct(){
        $this->result = new masterOrderM();
    }

    // 顯示所有訂單
    public function orderShow(){
        $list = $this->result->orderList();
        $show ="";

        foreach($list as $key=>$value){
            $name = "name" . $value[0];
            $submit = "submit" . $value[0];
            $detail = $this->detail($value[0]);

            if(isset($value[3])){
                $delivery = "已送達";
                $button = "";
            }else{
                $delivery = "未送達";
                $button = "<input type='submit' value='送出' name='$submit'>";
            }

            $one = <<<only
            <tr>
            <td>$value[0]<input type="text" name="$name" id="id" value="$value[0]"></td>
            <td>$value[1]</td>
            <td>$value[2]</td>
            <td>$value[4]</td>
            <td>$detail</td>
            <td>$delivery</td>
            <td style="width: 200px">
                $button
            </td>
            <tr>
            only;

            if($_POST["$submit"]){
                $this->result->updateOrder($value[0]);
            }

            $show .= $one;
        }
        return $show;
    }

    public function detail($value){
        $detail = $this->result->detailGet($value);
        $get = "";

        foreach($detail as $key=>$value){
            $once = "<p> $value[0] X $value[1] </p><br>";
            $get .= $once;
        }

        return $get;
    }

}

?>