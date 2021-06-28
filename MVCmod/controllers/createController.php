<?php

require_once './models/createModel.php';

class createC {
    public $result;

    public function __construct(){
        $this->result = new createM();
    }

    // 判斷各項資料是否重複
    public function nameCheck(){
        if($this->result->nameToC == 1){
            return "<p>帳號已使用</p>";
        }
    }

    public function truthCheck(){
        if($this->result->truthToC == 1){
            return "<p>此人已註冊</p>";
        }
    }

    public function mailCheck(){
        if($this->result->mailToC == 1){
            return "<p>信箱已使用</p>";
        }
    }

    public function phoneCheck(){
        if($this->result->phoneToC == 1){
            return "<p>電話已使用</p>";
        }
    }

}

?>