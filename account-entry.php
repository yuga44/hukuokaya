<?php
require 'db-connect.php';
session_start();
require 'ribbon.php';

// フォーム送信時の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // フォーム入力を受け取る
    $name        = $_POST['name'] ?? '';
    $namekana    = $_POST['namekana'] ?? '';
    $mailaddress = $_POST['email'] ?? '';
    $tel         = $_POST['tel'] ?? '';
    $login_id    = $_POST['login_id'] ?? '';   // ← 追加
    $password    = $_POST['password'] ?? '';
    $confirm_pw  = $_POST['password_confirm'] ?? '';
    $postalcode  = $_POST['postal'] ?? '';
    $address     = $_POST['address'] ?? '';

    // パスワード一致チェック
    if ($password !== $confirm_pw) {
        $error = "パスワードが一致しません。";
    } else {

        // login_id OR mailaddress OR tel の重複チェック
        $check = $pdo->prepare("
            SELECT * FROM member 
            WHERE login_id = ? OR mailaddress = ? OR tel = ?
        ");
        $check->execute([$login_id, $mailaddress, $tel]);

        if ($check->fetch()) {
            $error = "ID・メールアドレス・電話番号のいずれかが既に登録されています。";
        } else {

            // パスワードをハッシュ化
            $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

            // INSERT（完全一致）
            $sql = $pdo->prepare("
                INSERT INTO member 
                (name, namekana, postalcode, address, mailaddress, tel, login_id, password)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $sql->execute([
                $name,
                $namekana,
                $postalcode,
                $address,
                $mailaddress,
                $tel,
                $login_id,
                $hashed_pw
            ]);

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

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="" method="post">

        <div class="row">
            <div class="form-group">
                <label>名前</label>
                <input type="text" name="name" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label>ふりがな</label>
                <input type="text" name="namekana" required>
            </div>
        </div>

        <div class="form-group">
            <label>ログインID</label>
            <input type="text" name="login_id" required> <!-- ★追加 -->
        </div>

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="text" name="email" required>
        </div>

        <div class="form-group">
            <label>電話番号</label>
            <input type="tel" name="tel" required>
        </div>

        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>パスワード再確認</label>
            <input type="password" name="password_confirm" required>
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="postal">
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address">
        </div>

        <button type="submit">新規作成</button>
    </form>
</div>

</body>
</html>
