<?php
require 'db-connect.php';
session_start();
require 'ribbon.php';


// 未ログインなら止める
if (!isset($_SESSION['member_id'])) {
    exit("ログインしてください。");
}

$member_id = $_SESSION['member_id'];

// 現在のユーザー情報取得
$sql = $pdo->prepare("SELECT * FROM member WHERE member_id = ?");
$sql->execute([$member_id]);
$user = $sql->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("ユーザー情報が見つかりません。");
}

// 更新処理（POST）
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name        = $_POST['name'] ?? '';
    $namekana    = $_POST['namekana'] ?? '';
    $mailaddress = $_POST['email'] ?? '';
    $tel         = $_POST['tel'] ?? '';
    $login_id    = $_POST['login_id'] ?? '';
    $password    = $_POST['password'] ?? '';
    $confirm_pw  = $_POST['password_confirm'] ?? '';
    $postalcode  = $_POST['postal'] ?? '';
    $address     = $_POST['address'] ?? '';

    // パスワード確認
    if (!empty($password) && $password !== $confirm_pw) {
        $error = "パスワードが一致しません。";
    } else {

        // 重複チェック（ログインID）
        $check = $pdo->prepare("SELECT 1 FROM member WHERE login_id = ? AND member_id != ?");
        $check->execute([$login_id, $member_id]);
        if ($check->fetch()) {
            $error = "このログインIDは既に使われています。";
        }

        // 重複チェック（メール）
        if (empty($error)) {
            $check = $pdo->prepare("SELECT 1 FROM member WHERE mailaddress = ? AND member_id != ?");
            $check->execute([$mailaddress, $member_id]);
            if ($check->fetch()) {
                $error = "このメールアドレスは既に登録されています。";
            }
        }

        // 重複チェック（電話）
        if (empty($error)) {
            $check = $pdo->prepare("SELECT 1 FROM member WHERE tel = ? AND member_id != ?");
            $check->execute([$tel, $member_id]);
            if ($check->fetch()) {
                $error = "この電話番号は既に登録されています。";
            }
        }

        // 更新
        if (empty($error)) {

            $sql_str = "
                UPDATE member
                SET name = ?, namekana = ?, postalcode = ?, address = ?,
                    mailaddress = ?, tel = ?, login_id = ?
            ";

            $params = [
                $name, $namekana, $postalcode, $address,
                $mailaddress, $tel, $login_id
            ];

            if (!empty($password)) {
                $sql_str .= ", password = ?";
                $params[] = $password;
            }

            $sql_str .= " WHERE member_id = ?";
            $params[] = $member_id;

            $update = $pdo->prepare($sql_str);
            $update->execute($params);

            header("Location: account-info.php?updated=1");
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
<title>会員情報編集</title>
<link rel="stylesheet" href="css/edit.css">
</head>
<body>

<div class="container">

    <!-- ★ h2 と ← ボタンを横並びにするエリア -->
    <div class="title-area">
        <a href="account-info.php" class="back-btn">←</a>
        <h2>会員情報編集</h2>
    </div>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="" method="post">

        <div class="row">
            <div class="form-group">
                <label>名前</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label>ふりがな</label>
                <input type="text" name="namekana" value="<?= htmlspecialchars($user['namekana']) ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>ログインID</label>
            <input type="text" name="login_id" value="<?= htmlspecialchars($user['login_id']) ?>" required>
        </div>

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="text" name="email" value="<?= htmlspecialchars($user['mailaddress']) ?>" required>
        </div>

        <div class="form-group">
            <label>電話番号</label>
            <input type="tel" name="tel" value="<?= htmlspecialchars($user['tel']) ?>" required>
        </div>

        <div class="form-group">
            <label>パスワード（変更する場合のみ入力）</label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label>パスワード再確認</label>
            <input type="password" name="password_confirm">
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="postal" value="<?= htmlspecialchars($user['postalcode']) ?>">
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" value="<?= htmlspecialchars($user['address']) ?>">
        </div>

        <button type="submit">更新する</button>
    </form>
</div>

</body>
</html>
