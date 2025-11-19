<?php
session_start();
 
if (!isset($_SESSION['member_id'])) {
    // ログインしていなければリダイレクト
    header('Location: Login.php?error=not_logged_in');
    exit;
}
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
  <!-- ナビゲーションバー -->
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

  <!-- タイトル・ボタン -->
  <button class="back"><a href="./mypage.php">←</a></button>
  <h1>アカウント情報</h1>
  <!--ここまでテンプレ-->

<div class="content"><!---ここにコンテンツ-->
  <div class="accountinfo-item">
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

  <button class="account-info-button">
  <a href = "accout-edit.php">
    アカウント設定
  </a></button>

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
