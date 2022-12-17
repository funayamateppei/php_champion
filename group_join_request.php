<?php

// var_dump($_GET['group_id']);
// exit();

require_once('./functions/connect_db.php');

$sql = 'INSERT INTO group_join_request_table (id, user_id, group_id, created_at) VALUES (NULL, :user_id, :group_id, now())';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();

header('Location:./group_select.php');

?>