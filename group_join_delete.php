<?php

// var_dump($_GET['user_id']);
// var_dump($_GET['group_id']);
// exit();



require_once('./functions/connect_db.php');

// group_join_request_tableからユーザーを消去する
$sql = 'DELETE FROM group_join_request_table WHERE user_id = :user_id AND group_id = :group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_GET['user_id'], PDO::PARAM_INT);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();

header("Location:./question.php?group_id={$_GET['group_id']}");

?>