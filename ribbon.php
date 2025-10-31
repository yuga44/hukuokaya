<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title></title>
    <link rel="stylesheet" href="css/mainpage.css" />
  </head>

  <body>
    <!-- ナビゲーションバー -->
    <?php
    echo '
    <nav class="navigation-rail">
      <div class="nav-item">
        <a href="mainpage.php">
        <img src="img/icon-3.svg" alt="メインページ" />
        <span>メインページ</span>
        </a>
      </div>
      <div class="nav-item">
        <a href="account-info.php">
        <img src="img/icon-8.svg" alt="マイページ" />
        <span>マイページ</span>
        </a>
      </div>
      <div class="nav-item">
        <a href="cart-list.php">
        <img src="img/icon-8.svg" alt="カート" />
        <span>カート</span>
        </a>
      </div>
      <div class="nav-item">
        <a href="listing.php">
        <img src="img/icon-8.svg" alt="出品" />
        <span>出品</span>
        </a>
      </div>
    </nav>
    '
    ?>