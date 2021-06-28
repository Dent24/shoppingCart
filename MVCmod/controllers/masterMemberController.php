<?php

require_once './models/masterMemberModel.php';

class masterMemberC {
    public $result;

    public function __construct(){
        $this->result = new masterMemberM();
    }

    // 顯示所有會員
    public function memberShow(){
        $list = $this->result->memberList();
        $show = "";

        foreach($list as $key=>$value){
            $nameId = "id" . $value[0];
            $set = "set" . $value[0];
            $clear = "clear" . $value[0];

            $one = <<<only
            <tr>
                <td>$value[0] <input type="text" name="$nameId" id="id" value="$value[0]"></td>
                <td>$value[1]</td>
                <td>$value[4]</td>
                <td>$value[5]</td>
            only;

            if($value[7] == 1){
                $black = <<<black
                <td>
                <span>O</span>
                <input type="submit" value="取消" name="$clear">
                </td>
                </tr>
                black;

                $one .= $black;
            }else{
                $black = <<<black
                <td>
                <span>X</span>
                <input type="submit" value="設立" name="$set">
                </td>
                </tr>
                black;

                $one .= $black;
            }

            // 針對各列會員執行動作
            if(isset($_POST["$set"])){
                $this->result->blackMember($value[0]);
            }

            if(isset($_POST["$clear"])){
                $this->result->whiteMember($value[0]);
            }

            $show .= $one;
        }
        return $show;
    }

}

?>