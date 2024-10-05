<?php

function h($str){

    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function db_conn(){
    try {
        $db_name = 'birdies';    //データベース名
        $db_id   = 'root';      //アカウント名
        $db_pw   = '';      //パスワード
        $db_host = 'localhost'; //DBホスト
        $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
        return $pdo;
    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }

}

// function db_conn(){
//     try {
//         $db_name = 'burdies_graduation';    //データベース名
//         $db_id   = 'burdies';      //アカウント名
//         $db_pw   = 'grad2024';      //パスワード
//         $db_host = 'mysql3101.db.sakura.ne.jp'; //DBホスト
//         $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
//         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
//         return $pdo;
//     } catch (PDOException $e) {
//         exit('DB Connection Error:' . $e->getMessage());
//     }
// }

function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
}

function redirect($file_name){
    header('Location: ' . $file_name);
    exit();
}

?>