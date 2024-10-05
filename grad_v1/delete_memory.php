<?php
// セッションの開始
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'funcs.php';
header('Content-Type: application/json');

// ユーザーがログインしているか確認
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'fail', 'message' => 'User not logged in']);
    exit();
}

// POSTリクエストからIDを取得
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(['status' => 'fail', 'message' => 'IDが指定されていません']);
    exit();
}

$id = intval($_POST['id']); // 確実に整数に変換

// データベース接続
$pdo = db_conn();

// 指定されたIDのデータを削除
$stmt = $pdo->prepare('DELETE FROM memory WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status === false) {
    $errorInfo = $stmt->errorInfo();
    echo json_encode(['status' => 'fail', 'message' => "SQLエラー: " . $errorInfo[2]]);
    exit();
}

echo json_encode(['status' => 'success', 'message' => 'データが削除されました']);
exit();
?>