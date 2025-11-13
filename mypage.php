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
  <button class="back">←</button>
  <button class="cancel">×</button>
  <h1>マイページ</h1>
  <!--------------------ここまでテンプレ------------------------>

  <div class="content"><!---ここにコンテンツ-------->
    <div class="mypage-item">
      <div>ポイント残高</div>
    </div>
    <div class="mypage-item">
      <div>注文履歴
      <a href="listing.php"></a>
      </div>
    </div>
    <div class="mypage-item">
      <div>お気に入り
      <a href="favorite.php"></a>
      </div>
    </div>
    <div class="mypage-item">
      <div>アカウント情報
        <a href="accout-info.php"></a>
      </div>
    </div>
    <div class="mypage-item">
      <div>出品
        <a href="listing.php"></a>
      </div>
    </div>
  </div>
</body>
</html>
