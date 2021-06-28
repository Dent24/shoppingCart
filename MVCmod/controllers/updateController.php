<?php

require_once './models/updateModel.php';

class updateC {
    public $result;
    public $member;

    public function __construct(){
        $this->result = new updateM();
        $this->form();
    }

    // 顯示此使用者各項資訊
    public function form(){
        $get = $this->result->searchMember();
        foreach($get as $key=>$value){
            $this->member = $value;
        }
    }

}

?>