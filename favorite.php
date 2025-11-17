<?php
session_start();

// ★ ログインしているユーザーIDがセッションにある前提
if (!isset($_SESSION['user_id'])) {
  // 未ログインならログインページへ飛ばしてもOK
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];

// DB接続（例：MySQL + PDO）
$dsn = 'mysql:host=localhost;dbname=your_dbname;charset=utf8mb4';
$db_user = 'db_user';
$db_pass = 'db_password';

try {
  $pdo = new PDO($dsn, $db_user, $db_pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  ]);

  // ★ ログイン中ユーザーのお気に入りだけ取得
  $stmt = $pdo->prepare('SELECT item_name, item_img FROM favorites WHERE user_id = :user_id');
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  $stmt->execute();
  $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo 'DBエラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
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
    <a href="main.php" class="nav-item">
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
              <img src="<?php echo htmlspecialchars($item['item_img'], ENT_QUOTES, 'UTF-8'); ?>"
                   alt="<?php echo htmlspecialchars($item['item_name'], ENT_QUOTES, 'UTF-8'); ?>">
              <p><?php echo htmlspecialchars($item['item_name'], ENT_QUOTES, 'UTF-8'); ?></p>

              <!-- 削除ボタン（確認→即削除＋サーバー送信） -->
              <button
                type="button"
                class="remove-btn"
                data-item-name="<?php echo htmlspecialchars($item['item_name'], ENT_QUOTES, 'UTF-8'); ?>"
                data-action="remove_favorite.php">
                削除
              </button>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll(".remove-btn").forEach(button => {
        button.addEventListener("click", async e => {
          const card = e.target.closest(".item-card");
          const itemName = button.dataset.itemName;
          const action = button.dataset.action;

          if (!confirm("削除しますか？")) return;

          // 画面から即削除
          card.remove();

          // サーバーにも削除リクエスト送信
          try {
            const formData = new FormData();
            formData.append("item_name", itemName);

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
