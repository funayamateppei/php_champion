<?php

// var_dump($_GET['group_id']);
// exit();

session_start();

require_once('./functions/connect_db.php');

// 申請中のグループは参加リクエストを送れないようにする
$sql = 'SELECT COUNT(*) FROM group_join_request_table WHERE user_id = :user_id AND group_id = :group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();
$count = $stmt->fetchColumn();

// var_dump($count);
// exit();

// もし見つからなかったらグループ参加リクエスト申請実行
if ($count === 0) {
$sql = 'INSERT INTO group_join_request_table (id, user_id, group_id, created_at) VALUES (NULL, :user_id, :group_id, now())';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();
}

header('Location:./group_select.php');

?>