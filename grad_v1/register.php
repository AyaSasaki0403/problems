<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

var_dump($_POST); // POSTデータを表示して確認


//1. POSTデータ取得
$username   = $_POST['username'] ?? null;
$gender  = $_POST['gender'] ?? null;
$birthday = $_POST['birthday'] ?? null;
$email    = $_POST['email'] ?? null;
$password    = $_POST['password'] ?? null;

if (!$username || !$gender || !$birthday || !$email || !$password) {
    exit('必要な項目が入力されていません');
}

// genderの値を整数に変換
switch ($gender) {
    case 'male':
        $gender = 1;
        break;
    case 'female':
        $gender = 2;
        break;
    case 'no-answer':
        $gender = 0;
        break;
    default:
        exit('不正な性別の値が入力されました');
}

echo "送信された性別: " . $gender;

//2. DB接続します
require_once('funcs.php');
$pdo = db_conn();

// 追加箇所↓
if ($pdo === false) {
    exit('データベース接続に失敗しました');
}

// パスワードをハッシュ化
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

//３．データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO register(username, gender, birthday, email, password, registered_date, updated_date)
VALUES(:username, :gender, :birthday, :email, :password, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)');
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':gender', $gender, PDO::PARAM_INT);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);  // **Use the hashed password**
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    $errorInfo = $stmt->errorInfo();
    exit("SQLエラー: " . $errorInfo[2]); // SQLエラーメッセージを表示
} else {
    // Retrieve the last inserted ID and store it in the session
    $register_id = $pdo->lastInsertId();
    $_SESSION['user_id'] = $register_id; // Store user_id in the session

    $_SESSION['user'] = [
        'username' => $username,
        'gender'     => $gender,
        'birthday'   => $birthday,
        'email'      => $email
    ];

    // 追加箇所
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    // ↑ここまで追加
    header('Location: mypage.html'); // **Corrected path to mypage.html**
    exit();
}

?>