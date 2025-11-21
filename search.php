<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>検索ページ</title>
  <link rel="stylesheet" href="css/search.css">
</head>

<body>
    <!-- アプリバー -->
    <header class="app-bar">
      <div class="headline">ふくおかや</div>
        <div class="trailing-icons">
          <a href="kensaku.php">
            <img src="img/click_scam.jpg" alt="検索" />検索
          </a>
          <a href="Login.php">
            <img src="img/icon-7.svg" alt="ログイン" />
          </a>
        </div>
      </div>
    </header>

    <!-- ナビゲーションバー -->
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

  <!-- 検索フォーム -->
  <div class="content"> 
    <h1>商品検索</h1>
    <form method="GET" action="">
        <input type="search" name="q" placeholder="キーワードを入力..." value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="category" value="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>">
        <button type="submit">検索</button>
    </form>

    <!-- メニュー -->
    <div class="menu-buttons">
      <form method="GET" action="">
        <input type="hidden" name="q" value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>">
        <button name="category" value="category">カテゴリ</button>
        <button name="category" value="brand">ブランド</button>
        <button name="category" value="new">新着順</button>
        <button name="category" value="popular">人気順</button>
      </form>
    </div>
  </div>

<footer class="footer">
  <ul class="footer__links">
        <li><a href="">ルール</a></li>
        <li><a href="">利用規約</a></li>
        <li><a href="">特定商取引法</a></li>
        <li><a href="">プライバシー</a></li>
        <li><a href="">著作権 (DMCA)</a></li>
        <li><a href="">サーバー状態</a></li>
        <li><a href="">免責事項</a></li>
  </ul>
</footer>
</body>
</html>
