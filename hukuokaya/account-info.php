<?php
session_start();
 
if (!isset($_SESSION['member_id'])) {
    // ログインしていなければリダイレクト
    header('Location: Login.php?error=not_logged_in');
    exit;
}

// 外部ファイルからデータベース接続情報とPDO接続を取得
require_once 'db-connect.php'; 


try {
    // db-connect.php で $pdo が定義されていることを利用する
    // $pdo = new PDO(...) の部分は db-connect.php が実行するため不要

    // ログイン中の会員IDを取得
    $member_id = $_SESSION['member_id'];
    
    // 会員情報テーブルからユーザー情報を取得
    $stmt = $pdo->prepare(
        "SELECT name, mailaddress, tel, password, address FROM member WHERE member_id = :member_id"
    );
    $stmt->execute([':member_id' => $member_id]);
    $user = $stmt->fetch();

    // ユーザー情報が取得できなかった場合はエラーとして扱う
    if (!$user) {
        // セッションをクリアしてログインページへリダイレクト
        session_destroy();
        header('Location: Login.php?error=user_not_found');
        exit;
    }

} catch (PDOException $e) {
    // クエリ実行エラー (db-connect.phpで接続エラーは捕捉済み)
    echo "データベースエラー: " . $e->getMessage();
    exit;
}

// ------------------------------------------------------------------
// 【修正】ここまで
// ------------------------------------------------------------------

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>テンプレートページ</title>
  <link rel="stylesheet" href="css/account-info.css">
</head>
<body>
  <nav class="navigation-rail">
    <div class="nav-item">
      <img src="img/icon-cart.svg" alt="カート">
      <span>カート</span>
    </div>
    <div class="nav-item">
      <img src="img/icon-home.svg" alt="メインページ">
      <span>メインページ</span>
    </div>
    <div class="nav-item">
      <img src="img/icon-user.svg" alt="マイページ">
      <span>マイページ</span>
    </div>
    <div class="nav-item">
      <img src="img/icon-upload.svg" alt="出品">
      <span>出品</span>
    </div>
  </nav>

  <button class="back"><a href="./mypage.php">←</a></button>
  <h1>アカウント情報</h1>
  <div class="content"><div class="accountinfo-item">
    <div>名前</div>
    <div><?= htmlspecialchars($user['name']) ?></div>
  </div>

  <div class="accountinfo-item">
    <div>メールアドレス</div>
    <div><?= htmlspecialchars($user['mailaddress']) ?></div>
  </div>

  <div class="accountinfo-item">
    <div>電話番号</div>
    <div><?= htmlspecialchars($user['tel']) ?></div>
  </div>

  <div class="accountinfo-item">
    <div>パスワード</div>
    <div>
      <span id="password-mask">********</span>
      <span id="password-real" style="display:none;">
        <?= htmlspecialchars($user['password']) ?>
      </span>
      <button id="show-pass" type="button" style="border:none;background:none;cursor:pointer;">👁</button>
    </div>
  </div>

  <div class="accountinfo-item">
    <div>住所</div>
    <div><?= htmlspecialchars($user['address']) ?></div>
  </div>

  <button class="account-info-button">アカウント設定</button>

  <script>
    const showBtn = document.getElementById('show-pass');
    const passMask = document.getElementById('password-mask');
    const passReal = document.getElementById('password-real');

    // 👁 ボタンを押している間だけパスワード表示
    showBtn.addEventListener('mousedown', () => {
      passMask.style.display = 'none';
      passReal.style.display = 'inline';
    });
    showBtn.addEventListener('mouseup', () => {
      passMask.style.display = 'inline';
      passReal.style.display = 'none';
    });
    // 指を外に出した場合も安全に戻す
    showBtn.addEventListener('mouseleave', () => {
      passMask.style.display = 'inline';
      passReal.style.display = 'none';
    });
  </script>
</div>