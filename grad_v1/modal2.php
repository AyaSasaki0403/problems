<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// セッションが開始されているか確認
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'funcs.php';
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'fail', 'message' => 'User not logged in. セッションID: ' . session_id()]);
    exit();
} 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = $_SESSION['user_id'];

    $pdo = db_conn();
    if (!$pdo) {
        echo json_encode(['status' => 'fail', 'message' => 'データベース接続に失敗しました']);
        exit();
    }

    $stmt = $pdo->prepare('SELECT * FROM memory WHERE user_id = :user_id ORDER BY regiDate DESC');
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status === false) {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['status' => 'fail', 'message' => "SQLエラー: " . $errorInfo[2]]);
        exit();
    }

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $data]);
    exit();
}


// POSTリクエストの場合、データを登録する
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

// Retrieve form data
    $regiDate = $_POST['regiDate'];
    $place = $_POST['place'];
    $withWho = $_POST['withWho'];
    $publish = $_POST['publish'];
    $memo = $_POST['memo'];
    $image = '';

// Handle file upload if an image is provided
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
    $uploads_file = $_FILES['image']['tmp_name'];
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $new_name = uniqid() . '.' . $extension;
    $image_path = 'upload/' . $new_name;

    if (move_uploaded_file($uploads_file, $image_path)){
        $image = $image_path;
    } else {
        echo json_encode(['status' => 'fail', 'message' => '画像ファイルのアップロードに失敗しました']);
        exit();
    }
}

$pdo = db_conn();

// Insert data into the database
$stmt = $pdo->prepare('INSERT INTO memory (user_id, image, regiDate, place, withWho, publish, memo, created_at)
VALUES (:user_id, :image, :regiDate, :place, :withWho, :publish, :memo, NOW());');
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':image', $image, PDO::PARAM_STR);  // Uploaded file path
$stmt->bindValue(':regiDate', $regiDate, PDO::PARAM_STR);
$stmt->bindValue(':place', $place, PDO::PARAM_STR);
$stmt->bindValue(':withWho', $withWho, PDO::PARAM_STR);
$stmt->bindValue(':publish', $publish, PDO::PARAM_INT);  // 1 or 0
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);  // Memo to be saved
$status = $stmt->execute();

// Handle the result of the insert operation
if ($status === false) {
    $errorInfo = $stmt->errorInfo();
    echo json_encode(['status' => 'fail', 'message' => "SQLエラー: " . $errorInfo[2]]);
    exit();
} else {
    echo json_encode(['status' => 'success', 'message' => 'データが正常に登録されました。']);
    exit();
}
}

?>