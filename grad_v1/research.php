<?php

session_start();

var_dump($_POST); // POSTデータを表示して確認

//1. POSTデータ取得
$food   = $_POST['food'] ?? null;
$drink  = $_POST['drink'] ?? null;
$who = $_POST['who'] ?? null;
$frequency = $_POST['frequency'] ?? null;
$importance  = $_POST['importance'] ?? null;
$mind  = $_POST['mind'] ?? null;


if (!$food || !$drink || !$who || !$frequency || !$importance || !$mind) {
    exit('必要な項目が入力されていません');
}

$food_mapped = [];
if (is_array($food)) {
    foreach ($food as $f) {
        switch ($f) {
            case '日本食':
                $food_mapped[] = 1;
                break;
            case '中華':
                $food_mapped[] = 2;
                break;
            case '韓国料理':
                $food_mapped[] = 3;
                break;
            case 'その他アジアン料理':
                $food_mapped[] = 4;
                break;
            case 'イタリアン':
                $food_mapped[] = 5;
                break;
            case 'フレンチ':
                $food_mapped[] = 6;
                break;
            case 'メキシコ料理':
                $food_mapped[] = 7;
                break;
            case 'その他':
                $food_mapped[] = 8;
                break;
            default:
                $food_mapped[] = 0; // デフォルト値
        }
    }
}

// 「その他」が選ばれ、自由回答がある場合
if (in_array(8, $food_mapped) && !empty($other_food)) {
    $food_mapped[] = $other_food;  // 自由回答を追加
}

// $food_mappedに変換された値が含まれています
var_dump($food_mapped);

$drink_mapped = [];
if (is_array($drink)) {
    foreach ($drink as $f) {
        switch ($f) {
            case 'ビール':
                $drink_mapped[] = 1;
                break;
            case '日本酒':
                $drink_mapped[] = 2;
                break;
            case '焼酎':
                $drink_mapped[] = 3;
                break;
            case 'ウィスキー':
                $drink_mapped[] = 4;
                break;
            case 'サワー':
                $drink_mapped[] = 5;
                break;
            case 'カクテル':
                $drink_mapped[] = 6;
                break;
            case 'その他ハードリカー':
                $drink_mapped[] = 7;
                break;
            case 'その他':
                $drink_mapped[] = 8;
                break;
            default:
                $drink_mapped[] = 0; // デフォルト値
        }
    }
}

// 「その他」が選ばれ、自由回答がある場合
if (in_array(8, $drink_mapped) && !empty($other_drink)) {
    $drink_mapped[] = $other_drink;  // 自由回答を追加
}

// $drink_mappedに変換された値が含まれています
var_dump($drink_mapped);

$who_mapped = [];
if (is_array($drink)) {
    foreach ($drink as $f) {
        switch ($f) {
            case '友人・知人':
                $who_mapped[] = 1;
                break;
            case '仕事仲間':
                $who_mapped[] = 2;
                break;
            case 'クライアント・お客様':
                $who_mapped[] = 3;
                break;
            case '趣味仲間':
                $who_mapped[] = 4;
                break;
            case '家族':
                $who_mapped[] = 5;
                break;
            case '彼氏・彼女':
                $who_mapped[] = 6;
                break;
            case '一人':
                $who_mapped[] = 7;
                break;
            case 'その他':
                $who_mapped[] = 8;
                break;
            default:
                $who_mapped[] = 0; // デフォルト値
        }
    }
}

// 「その他」が選ばれ、自由回答がある場合
if (in_array(8, $who_mapped) && !empty($other_who)) {
    $who_mapped[] = $other_who;  // 自由回答を追加
}

// $who_mappedに変換された値が含まれています
var_dump($who_mapped);


$importance_mapped = [];
if (is_array($importance)) {
    foreach ($importance as $f) {
        switch ($f) {
            case '価格帯':
                $importance_mapped[] = 1;
                break;
            case '立地':
                $importance_mapped[] = 2;
                break;
            case '人気度':
                $importance_mapped[] = 3;
                break;
            case 'お店の雰囲気':
                $importance_mapped[] = 4;
                break;
            case '料理のおいしさ':
                $importance_mapped[] = 5;
                break;
            case 'ドリンクのおいしさ・評価':
                $importance_mapped[] = 6;
                break;
            case '食材の鮮度':
                $importance_mapped[] = 7;
                break;
            case '地元の人からの評価':
                $importance_mapped[] = 8;
                break;
            case '系列店がある・複数店舗を持っている':
                $importance_mapped[] = 9;
                break;
            case 'その他':
                $importance_mapped[] = 10;
                break;
            default:
                $importance_mapped[] = 0; // デフォルト値
        }
    }
}

// 「その他」が選ばれ、自由回答がある場合
if (in_array(10, $importance_mapped) && !empty($other_importance)) {
    $importance_mapped[] = $other_importance;  // 自由回答を追加
}

// $importance_mappedに変換された値が含まれています
var_dump($importance_mapped);

$mind_mapped = [];
if (is_array($mind)) {
    foreach ($mind as $f) {
        switch ($f) {
            case '地元の人が多く利用しているお店に行きたい':
                $mind_mapped[] = 1;
                break;
            case '雑誌などに載っているお店に行きたい':
                $mind_mapped[] = 2;
                break;
            case 'スタッフがフレンドリーなお店に行きたい':
                $mind_mapped[] = 3;
                break;
            case 'スタッフがきちんと距離感を保ってくれるお店に行きたい':
                $mind_mapped[] = 4;
                break;
            case '食材にこだわりを持っているお店に行きたい':
                $mind_mapped[] = 5;
                break;
            case 'インテリアデザインにこだわりを持っているお店に行きたい':
                $mind_mapped[] = 6;
                break;
            case 'その他':
                $mind_mapped[] = 7;
                break;
            default:
                $mind_mapped[] = 0; // デフォルト値
        }
    }
}

// 「その他」が選ばれ、自由回答がある場合
if (in_array(7, $mind_mapped) && !empty($other_mind)) {
    $mind_mapped[] = $other_mind;  // 自由回答を追加
}

// $mind_mappedに変換された値が含まれています
var_dump($mind_mapped);


//2. DB接続します
require_once('funcs.php');
$pdo = db_conn();

// 追加箇所↓
if ($pdo === false) {
    exit('データベース接続に失敗しました');
}

//３．データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO favorites(food, drink, who, frequency, importance, mind)
VALUES(:food, :drink, :who, :frequency, :importance, mind)');
$stmt->bindValue(':food', $food, PDO::PARAM_INT);
$stmt->bindValue(':drink', $drink, PDO::PARAM_INT);
$stmt->bindValue(':who', $who, PDO::PARAM_INT);
$stmt->bindValue(':frequency', $frequency, PDO::PARAM_INT);
$stmt->bindValue(':importance', $importance, PDO::PARAM_INT);
$stmt->bindValue(':mind', $mind, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    $errorInfo = $stmt->errorInfo();
    exit("SQLエラー: " . $errorInfo[2]); // SQLエラーメッセージを表示
} else {
    $_SESSION['favorites'] = [
        'food' => $food,
        'drink' => $drink,
        'who' => $who,
        'frequency' => $frequency,
        'importance' => $importance,
        'mind'      => $mind,
    ];

    header('Location: /gs_code/grad_v1/mypage.html'); // **Corrected path to mypage.html**
    exit();
}

?>