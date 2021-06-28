<?php

require_once './models/masterLoginModel.php';

class masterLoginC {
    public $result;

    public function __construct(){
        $this->result = new masterLoginM();
    }

}

?>