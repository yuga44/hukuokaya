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
    <title>出品</title>
    <link rel="stylesheet" href="css/template.css">
    <link rel="stylesheet" href="css/listing.css">
</head>
<body>
    <!-- ナビゲーション -->
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

    <section class="main">
        <!-- バナー -->
        <div class="topbar">
        <a href="mypage.php"><button class="back-btn">←</button></a>
        <h1 class="title">出品</h1>
        </div>

        <div class="content">

            <?php
              $categories = ["ジャケット", "パンツ", "ビジネスバッグ", "シャツ", "ビジネスカジュアル", "アクセサリー"];
            ?>

            <form action="shopping-complete.php" method="post" enctype="multipart/form-data">
                <div class="uploder">
                  <div class="placeholder">画像を追加
                    <input type="file" name="image_file">
                  </div>
                </div>
                <input class="input" type="text" name="product_name" placeholder="商品名を入力">
                <select name="category">
                    <option value="">カテゴリーを選択</option>
                    <?php foreach ($categories as $category): ?>
                      <option value="<?= htmlspecialchars($category) ?>">
                      <?= htmlspecialchars($category) ?>
                      </option>
                    <?php endforeach; ?>
                </select>
                <input class="input" type="number" name="price" placeholder="￥ 値段を入力">
                <textarea name="description" placeholder="商品の説明"></textarea>
                <button type="submit" class="submit">出品する</button>
            </form>
        </div>
    </section>
</body>
</html>