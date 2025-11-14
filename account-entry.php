<?php
require 'db-connect.php';
session_start();

// フォーム送信時の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name       = $_POST['name'] ?? '';
    $namekana   = $_POST['namekana'] ?? '';
    $email      = $_POST['postalcode'] ?? '';
    $tel        = $_POST['address'] ?? '';
    $password   = $_POST['mailaddress'] ?? '';
    $confirm_pw = $_POST['password_confirm'] ?? '';
    $postal     = $_POST['postal'] ?? '';
    $address    = $_POST['address'] ?? '';

    // パスワード一致チェック
    if ($password !== $confirm_pw) {
        $error = "パスワードが一致しません。";
    } else {

        // メール or 電話番号重複チェック
        $check = $pdo->prepare("SELECT * FROM member WHERE mail = ? OR tel = ?");
        $check->execute([$email, $tel]);

        if ($check->fetch()) {
            $error = "メールアドレスまたは電話番号がすでに登録されています。";
        } else {

            // パスワードをハッシュ化
            $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

            // DBへ INSERT
            $sql = $pdo->prepare("
                INSERT INTO member (name, namekana, postalcode, address, mailaddress, tel, login_id, password)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $sql->execute([
                $name,
                $namekana,
                $email,
                $tel,
                $hashed_pw,
                $postal,
                $address
            ]);

            // 登録成功 → ログインページに移動
            header("Location: Login.php?register=success");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>アカウント登録</title>
<link rel="stylesheet" href="css/entry.css">
</head>
<body>

<div class="container">
    <h2>アカウント登録</h2>

    <!-- エラーメッセージ表示 -->
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <div class="row">
            <div class="form-group">
                <label for="sei">名前</label>
                <input type="text" id="name" name="name" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="seikana">ふりがな</label>
                <input type="text" id="namekana" name="namekana" required>
            </div>
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="text" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="tel">電話番号</label>
            <input type="tel" id="tel" name="tel" required>
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirm">パスワード再確認</label>
            <input type="password" id="password_confirm" name="password_confirm" required>
        </div>

        <div class="form-group">
            <label for="postal">郵便番号</label>
            <input type="text" id="postal" name="postal">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address">
        </div>

        <button type="submit">新規作成</button>
    </form>
</div>

</body>
</html>
