<?php

class database {

    // 設定資料庫連線項目
    public static $host = "localhost";
    public static $dbname = "pid";
    public static $userName = "root";
    public static $password = "root";

    private static function con() {
  
      $pdo = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbname . ';charset=utf8', self::$userName, self::$password);
      $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    }
  
    public static function query($query, $params = array()) {
      $stmt = self::con()->prepare($query);
      $stmt->execute($params);
      $data = $stmt->fetchAll();
      return $data;
    }
  
}

?>