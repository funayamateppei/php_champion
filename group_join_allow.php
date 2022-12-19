<?php

// var_dump($_GET['user_id']);
// var_dump($_GET['group_id']);
// exit();

require_once('./functions/connect_db.php');

session_start();

// -------------------------------------------------------------------------

// group_tableにリクエストユーザーを入れるためにグループ名を取得
$sql = 'SELECT * FROM group_table WHERE id = :group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();
$groupInfo = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($groupInfo);
// exit();

// ユーザーをgroup_tableに追加
$sql = 'INSERT INTO group_table (id, user_id, group_name, admission_year, address, created_at) VALUES (NULL, :user_id, :group_name, :admission_year, :address, now())';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_GET['user_id'], PDO::PARAM_INT);
$stmt->bindValue(':group_name', $groupInfo['group_name'], PDO::PARAM_STR);
$stmt->bindValue(':admission_year', $groupInfo['admission_year'], PDO::PARAM_INT);
$stmt->bindValue(':address', $groupInfo['address'], PDO::PARAM_STR);
$stmt->execute();


// group_join_request_tableから追加したユーザーを消去する
$sql = 'DELETE FROM group_join_request_table WHERE user_id = :user_id AND group_id = :group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_GET['user_id'], PDO::PARAM_INT);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();

header("Location:./question.php?group_id={$_GET['group_id']}");

?>