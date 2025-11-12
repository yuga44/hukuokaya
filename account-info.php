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
  <button class="back">←</button>
  <button class="cancel">×</button>
  <h1>アカウント情報</h1>
<!-- ここまでテンプレ -->

  <!-- メインコンテンツ -->
  <div class="content">
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
      <div><?= htmlspecialchars($user['password']) ?></div>

    </div>

    <div class="accountinfo-item">
      <div>住所</div>
      <div><?= htmlspecialchars($user['address']) ?></div>
    </div>

    <button class="account-info-button">アカウント設定</button>
  </div>
</body>
</html>
