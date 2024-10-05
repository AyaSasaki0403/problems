<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// POSTデータ取得
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

require_once('funcs.php');
$pdo = db_conn();

if (!$email || !$password) {
    echo "<script>
        sessionStorage.setItem('error', '必要な項目が入力されていません');
        window.location.href = 'localhost/grad_v1/login_act.html';
    </script>";
    exit();
}

// データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM register WHERE email = :email');
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$status = $stmt->execute();

// SQL実行時にエラーがある場合STOP
if ($status === false) {
    sql_error($stmt);
}

// 抽出データを取得
$val = $stmt->fetch(PDO::FETCH_ASSOC);

// デバッグ情報を追加
if ($val === false) {
    echo "<script>
        sessionStorage.setItem('error', 'ユーザーが見つかりません');
        window.location.href = 'login_act.html';
    </script>";
    exit();
} else {
    // デバッグ情報の表示
    echo "デバッグ情報:<br>";
    echo "入力されたパスワード: $password<br>";
    echo "ハッシュ化されたパスワード: {$val['password']}<br>";
    echo "password_verify 結果: " . (password_verify($password, $val['password']) ? 'true' : 'false') . "<br>";
}

if (password_verify($password, $val['password'])) {
    // Set session ID correctly
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['user_id'] = $val['id'];  // Set the correct user_id from database
    $_SESSION['user'] = [
        'username' => $val['username'],
        'gender'   => $val['gender'],
        'birthday' => $val['birthday'],
        'email'    => $val['email']
    ];
    header('Location: mypage.html');
    exit();
} else {
    // Login失敗時
    echo "<script>
        sessionStorage.setItem('error', 'メールアドレスまたはパスワードが間違っています');
        window.location.href = 'login_act.html';
    </script>";
    exit();
}

?>