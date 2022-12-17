<?php

session_start();

require_once('./functions/connect_db.php');

$sql = 'DELETE FROM group_join_request_table WHERE user_id = :user_id AND group_id = :group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();

header('Location:./group_select.php');

?>