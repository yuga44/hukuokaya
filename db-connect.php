<?php
const SERVER = 'mysql326.phy.lolipop.lan';
const DBNAME = 'LAA1607626-hukuokaya';
const USER = 'LAA1607626';
const PASS = 'seniority';

$connect = 'mysql:host=' . SERVER . ';dbname=' . DBNAME . ';charset=utf8mb4';

try {
    // PDOで接続を作成
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // 接続エラー時の処理
    exit('データベース接続失敗: ' . $e->getMessage());
}
?>