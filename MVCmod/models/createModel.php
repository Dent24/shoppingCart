<?php

require_once './models/database.php';

class createM extends database{

    public $nameToC;
    public $truthToC;
    public $mailToC;
    public $phoneToC;

    public function searchAll(){
        $search = self::query("SELECT userName, truthName, phone, email FROM member");
        return $search;
    }

    // 建立帳號
    public function create(){
        if(isset($_POST["submit"])){
            
            if(isset($_POST["check"])){
                $userName = $_POST["newName"];
                $userPassword = $_POST["newPassword"];
                $truthName = $_POST["truthName"];
                $phone = $_POST["phone"];
                $email = $_POST["email"];
                $address = $_POST["address"];
                $userPassword = sha1($userPassword);

                $check = $this->check($userName, $truthName, $email, $phone);

                if($check == 0){
                    $addMember = <<<createIn
                    INSERT INTO `member`(`userName`, `userPassword`, `truthName`, `email`, `phone`, `userAddress`) 
                    VALUES ('$userName','$userPassword','$truthName','$email','$phone','$address');
                    createIn;
                    $add = self::query($addMember);

                    header("location: ./hello");
                    exit();
                }
            }

        }
    }

    // 判斷各項資料是否重複
    public function check($v1, $v2, $v3, $v4){
        $c1 = $this->checkName($v1);
        $c2 = $this->checkTruth($v2);
        $c3 = $this->checkMail($v3);
        $c4 = $this->checkPhone($v4);

        return $c1+$c2+$c3+$c4;
    }

    // 用戶名
    public function checkName($name){
        $get = $this->searchAll();
        foreach($get as $key=>$value){
            if($name == $value[0]){
                $this->nameToC = 1;
                return 1;
            }
        }
    }

    // 真實姓名
    public function checkTruth($truth){
        $get = $this->searchAll();
        foreach($get as $key=>$value){
            if($truth == $value[1]){
                $this->truthToC = 1;
                return 1;
            }
        }
    }

    // 電子信箱
    public function checkMail($mail){
        $get = $this->searchAll();
        foreach($get as $key=>$value){
            if($mail == $value[3]){
                $this->mailToC = 1;
                return 1;
            }
        }
    }

    // 手機號碼
    public function checkPhone($phone){
        $get = $this->searchAll();
        foreach($get as $key=>$value){
            if($phone == $value[2]){
                $this->phoneToC = 1;
                return 1;
            }
        }
    }

}

?>