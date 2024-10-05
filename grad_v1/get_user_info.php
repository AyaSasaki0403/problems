<?php
session_start();

header('Content-Type: application/json');

if (isset($_SESSION['user'])) {
    echo json_encode(['status' => 'success','username' => $_SESSION['user']['username']]);
} else {
    echo json_encode(['status' => 'fail', 'message' => 'User not logged in']);
}
?>