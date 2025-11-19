<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ</title>
  <link rel="stylesheet" href="mypage.css">
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
  <a href="mainpage.php" class="back">←</a>
  <button class="cancel">×</button>
  <h1>マイページ</h1>

  <!--------------------ここまでテンプレ------------------------>

  <div class="content">
    <div class="mypage-item">
      <a href="purchase-history.php">購入履歴</a>
    </div>
    <div class="mypage-item">
      <a href="favorite.php">お気に入り</a>
    </div>
    <div class="mypage-item">
      <a href="account-info.php">アカウント情報</a>
    </div>
    <div class="mypage-item">
      <a href="listing.php">出品</a>
    </div>
    <div class="mypage-item">
      <a href="listing-completed.php">出品一覧</a>
    </div>
  </div>
</body>
</html>
