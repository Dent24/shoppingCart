<?php

require_once './models/database.php';
session_start();

class masterMemberM extends database{

    public $member;

    public function __construct(){
        if(!isset($_SESSION['mid'])){
            header("location: ./hello");
            exit();
        }

        $mid = $_SESSION["mid"];
        $search = self::query("SELECT userName, grade FROM webMaster WHERE id = $mid");
        $this->member = $search;
    }

    // 抓取所有會員資料
    public function memberList(){
        $search = self::query("SELECT * FROM member");
        return $search;
    }

    // 新增黑名單標記
    public function blackMember($value){
        if($member[0]['grade'] < 2){
            $blackIt = self::query("UPDATE member SET black = 1 WHERE id = $value");
        }
        header("location: ./masterMember");
    }

    // 移除黑名單標記
    public function whiteMember($value){
        if($member[0]['grade'] < 2){
            $blackIt = self::query("UPDATE member SET black = 0 WHERE id = $value");
        }
        header("location: ./masterMember");
    }

}

?>