<?php
// セッションの開始
session_start();
require_once 'funcs.php';
header('Content-Type: application/json');

$pdo = db_conn();

// ユーザーがログインしているか確認
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'fail', 'message' => 'User not logged in']);
    exit();
}

// GETリクエストからIDを取得
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['status' => 'fail', 'message' => 'IDが指定されていません']);
    exit();
}

$id = $_GET['id'];

// データ取得
$stmt = $pdo->prepare('SELECT * FROM memory WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status === false) {
    $errorInfo = $stmt->errorInfo();
    echo json_encode(['status' => 'fail', 'message' => "SQLエラー: " . $errorInfo[2]]);
    exit();
}

// データを取得
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// データが存在しない場合
if (!$data) {
    echo json_encode(['status' => 'fail', 'message' => '指定されたIDのデータが見つかりません']);
    exit();
}

// 正常なレスポンス
echo json_encode(['status' => 'success', 'data' => $data]);
exit();
?>