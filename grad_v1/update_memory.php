<?php
session_start();
require_once 'funcs.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'fail', 'message' => 'User not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $memory_id = $_POST['id'];
    $regiDate = $_POST['regiDate'];
    $place = $_POST['place'];
    $withWho = $_POST['withWho'];
    $publish = $_POST['publish'];
    $memo = $_POST['memo'];
    $image = '';

    // 画像のアップロード処理
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploads_file = $_FILES['image']['tmp_name'];
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_name = uniqid() . '.' . $extension;
        $image_path = 'upload/' . $new_name;

        if (move_uploaded_file($uploads_file, $image_path)) {
            $image = $image_path;
        }
    }

    $pdo = db_conn();
    $stmt = $pdo->prepare('UPDATE memory SET regiDate = :regiDate, place = :place, withWho = :withWho, publish = :publish, memo = :memo, image = IF(:image = "", image, :image), updated_at = NOW() WHERE id = :id AND user_id = :user_id');
    $stmt->bindValue(':regiDate', $regiDate, PDO::PARAM_STR);
    $stmt->bindValue(':place', $place, PDO::PARAM_STR);
    $stmt->bindValue(':withWho', $withWho, PDO::PARAM_STR);
    $stmt->bindValue(':publish', $publish, PDO::PARAM_INT);
    $stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
    $stmt->bindValue(':image', $image, PDO::PARAM_STR);
    $stmt->bindValue(':id', $memory_id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status === false) {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['status' => 'fail', 'message' => "SQLエラー: " . $errorInfo[2]]);
        exit();
    }

    echo json_encode(['status' => 'success', 'message' => 'データが更新されました']);
    exit();
}
?>