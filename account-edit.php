<?php
require 'db-connect.php';
session_start();

// 未ログインなら止める
if (!isset($_SESSION['member_id'])) {
    exit("ログインしてください。");
}

$member_id = $_SESSION['member_id'];

// -------------------------
// ① 現在のユーザー情報を取得
// -------------------------
$sql = $pdo->prepare("SELECT * FROM member WHERE member_id = ?");
$sql->execute([$member_id]);
$user = $sql->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("ユーザー情報が見つかりません。");
}

// -------------------------
// ② 更新処理（POST時）
// -------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // フォーム値
    $name        = $_POST['name'] ?? '';
    $namekana    = $_POST['namekana'] ?? '';
    $mailaddress = $_POST['email'] ?? '';
    $tel         = $_POST['tel'] ?? '';
    $login_id    = $_POST['login_id'] ?? '';
    $password    = $_POST['password'] ?? '';
    $confirm_pw  = $_POST['password_confirm'] ?? '';
    $postalcode  = $_POST['postal'] ?? '';
    $address     = $_POST['address'] ?? '';

    // ★パスワード一致チェック
    if (!empty($password) && $password !== $confirm_pw)) {
        $error = "パスワードが一致しません。";
    } else {

        // ★重複チェック（自分以外のユーザーを対象）
        $check = $pdo->prepare("
            SELECT * FROM member
            WHERE (login_id = ? OR mailaddress = ? OR tel = ?)
              AND member_id != ?
        ");
        $check->execute([$login_id, $mailaddress, $tel, $member_id]);

        if ($check->fetch()) {
            $error = "同じログインID・メールアドレス・電話番号のユーザーが存在します。";
        } else {

            // パスワードは入力された場合のみ更新
            $update_sql = "
                UPDATE member
                   SET name = ?, namekana = ?, postalcode = ?, address = ?,
                       mailaddress = ?, tel = ?, login_id = ?
            ";

            $params = [
                $name, $namekana, $postalcode, $address,
                $mailaddress, $tel, $login_id
            ];

            if (!empty($password)) {
                $update_sql .= ", password = ?";
                $params[] = $password;  // ← 平文で保存
            }

            $update_sql .= " WHERE member_id = ?";
            $params[] = $member_id;

            $stmt = $pdo->prepare($update_sql);
            $stmt->execute($params);

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
<link rel="stylesheet" href="css/entry.css">
</head>
<body>

<div class="container">
    <h2>会員情報編集</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="" method="post">

        <div class="row">
            <div class="form-group">
                <label>名前</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label>ふりがな</label>
                <input type="text" id="namekana" name="namekana" value="<?= htmlspecialchars($user['namekana']) ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>ログインID</label>
            <input type="text" id="login_id" name="login_id" value="<?= htmlspecialchars($user['login_id']) ?>" required>
        </div>

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="text" id="email" name="email" value="<?= htmlspecialchars($user['mailaddress']) ?>" required>
        </div>
        
        <div class="form-group">
            <label>電話番号</label>
            <input type="tel" id="tel" name="tel" value="<?= htmlspecialchars($user['tel']) ?>" required>
        </div>

        <div class="form-group">
            <label>パスワード（変更する場合のみ入力）</label>
            <input type="password" id="password" name="password">
        </div>

        <div class="form-group">
            <label>パスワード再確認</label>
            <input type="password" id="password_confirm" name="password_confirm">
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" id="postal" name="postal" value="<?= htmlspecialchars($user['postalcode']) ?>">
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>">
        </div>

        <button type="submit">更新する</button>
    </form>
</div>

</body>
</html>
