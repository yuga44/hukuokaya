<?php
session_start();
require 'db-connect.php';

// ★ ログインチェック（member_id がないときはログイン画面へ）
if (!isset($_SESSION['member_id'])) {
    header('Location: Login.php');
    exit;
}

$member_id = $_SESSION['member_id'];

try {
<<<<<<< HEAD
    // ★ ログイン中会員のお気に入りだけ取得
    // 例：favorite テーブルに (favorite_id, member_id, item_name, item_img) がある想定
    $sql = "SELECT favorite_id, item_name, item_img 
              FROM favorite 
             WHERE member_id = ?";
=======
    // ★ ログイン中会員のお気に入り＋商品情報を取得
    $sql = "
        SELECT 
            f.favorite_id,
            f.product_id,
            p.product_name,
            p.image
        FROM favorite AS f
        JOIN listing_product AS p
          ON f.product_id = p.product_id
        WHERE 
          f.member_id = ?
          AND f.favorite_flag = 1
    ";
>>>>>>> 1b141b08357df4299dfc0fcf8ac9e714d25110db
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$member_id]);
    $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
<<<<<<< HEAD
    echo 'データベースエラーが発生しました。';
=======
    echo 'データベースエラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
>>>>>>> 1b141b08357df4299dfc0fcf8ac9e714d25110db
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>お気に入り</title>
  <link rel="stylesheet" href="css/favorite.css">
</head>
<body>
  <!-- ナビゲーションバー -->
  <nav class="navigation-rail">
    <a href="mainpage.php" class="nav-item">
      <img src="img/icon-3.svg" alt="メインページ">
      <span>メインページ</span>
    </a>
    <a href="mypage.php" class="nav-item">
      <img src="img/icon-8.svg" alt="マイページ">
      <span>マイページ</span>
    </a>
    <a href="cart.php" class="nav-item">
      <img src="img/icon-8.svg" alt="カート">
      <span>カート</span>
    </a>
    <a href="sell.php" class="nav-item">
      <img src="img/icon-8.svg" alt="出品">
      <span>出品</span>
    </a>
  </nav>

  <main class="content">
    <!-- アプリバー -->
    <header class="app-bar">
      <div class="headline">お気に入り</div>
      <div class="trailing-icons">
        <img src="img/icon-2.svg" alt="検索">
        <img src="img/icon-7.svg" alt="設定">
      </div>
    </header>

    <!-- お気に入り商品一覧 -->
    <section class="section">
      <div class="section-header">
        <div class="title">お気に入りアイテム</div>
      </div>

      <div class="items">
        <?php if (empty($favorites)): ?>
          <p>お気に入りはまだありません。</p>
        <?php else: ?>
          <?php foreach ($favorites as $item): ?>
            <div class="item-card">
<<<<<<< HEAD
              <img src="<?php echo htmlspecialchars($item['item_img'], ENT_QUOTES, 'UTF-8'); ?>"
                   alt="<?php echo htmlspecialchars($item['item_name'], ENT_QUOTES, 'UTF-8'); ?>">
              <p><?php echo htmlspecialchars($item['item_name'], ENT_QUOTES, 'UTF-8'); ?></p>

              <!-- 削除ボタン：確認してそのまま削除 -->
=======
              <!-- 画像パス listing_product.image を使用 -->
              <?php if (!empty($item['image'])): ?>
                <img src="<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>"
                     alt="<?php echo htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8'); ?>">
              <?php else: ?>
                <div class="no-image">画像なし</div>
              <?php endif; ?>

              <p><?php echo htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8'); ?></p>

              <!-- 削除ボタン：確認してすぐ画面から消す＋DB更新 -->
>>>>>>> 1b141b08357df4299dfc0fcf8ac9e714d25110db
              <button
                type="button"
                class="remove-btn"
                data-favorite-id="<?php echo (int)$item['favorite_id']; ?>"
                data-action="remove_favorite.php"
              >
                削除
              </button>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <!-- JSで削除処理 -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll(".remove-btn").forEach(button => {
        button.addEventListener("click", async (e) => {
          const card = e.target.closest(".item-card");
          const favoriteId = button.dataset.favoriteId;
          const action = button.dataset.action;

          // 確認ダイアログ
          if (!confirm("削除しますか？")) return;

          // 画面から即削除
          card.remove();

          // サーバーにも削除リクエスト送信
          try {
            const formData = new FormData();
            formData.append("favorite_id", favoriteId);

            await fetch(action, {
              method: "POST",
              body: formData
            });
          } catch (err) {
            console.error("削除通信エラー:", err);
          }
        });
      });
    });
  </script>
</body>
</html>
