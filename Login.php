<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
  <link rel="stylesheet" href="css/Login-style.css">
  <link rel="stylesheet" href="css/template.css">
</head>
<body>
  <nav class="navigation-rail">
      <div class="nav-item">
        <a href="mainpage.php">
          <img src="img/click_scam.jpg" alt="メインページ" />
        </a>
        <span>メインページ</span>
      </div>
      <div class="nav-item">
        <a href="mypage.php">
          <img src="img/click_scam.jpg" alt="マイページ" />
        </a>
        <span>マイページ</span>
      </div>
      <div class="nav-item">
        <a href="cart-list.php">
          <img src="img/click_scam.jpg" alt="カート" />
        </a>
        <span>カート</span>
      </div>
      <div class="nav-item">
        <a href="listing.php">
          <img src="img/click_scam.jpg" alt="出品" />
        </a>
        <span>出品</span>
      </div>
    </nav>
  <div class="login-container">
    <header>
      <span class="back">←</span>
      <h1>ログイン</h1>
      <span class="close">×</span>
    </header>

    <!-- ログインフォーム -->
    <form action="login-check.php" method="post">
      <input type="text" name="login_id" placeholder="ログインID" required>
      <input type="password" name="password" placeholder="パスワード" required>

      <!-- エラーメッセージ表示エリア -->
      <?php if (isset($_GET['error'])): ?>
        <p class="error-message">
          <?php
            if ($_GET['error'] === 'empty') {
              echo 'ログインIDとパスワードを入力してください。';
            } elseif ($_GET['error'] === 'invalid') {
              echo 'ログインIDまたはパスワードが間違っています。';
            } elseif ($_GET['error'] === 'db') {
              echo 'データベース接続エラーが発生しました。';
            }
          ?>
        </p>
      <?php endif; ?>

      <button type="button" class="sub-btn" onclick="location.href='register.php'">
        アカウントをお持ちでない方
      </button>
      <button type="submit" class="login-btn">ログイン</button>
    </form>
  </div>
</body>
</html>
