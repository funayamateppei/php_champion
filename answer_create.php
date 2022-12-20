<?php

// var_dump($_GET);
// exit();

session_start();

require_once('./functions/connect_db.php');

$sql = 'SELECT COUNT(id) FROM answer_table WHERE answer_user_id = :answer_user_id AND is_answered_user_id = :is_answered_user_id AND question_id = :question_id AND group_id = :group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':answer_user_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->bindValue(':is_answered_user_id', $_GET['answered_id'], PDO::PARAM_INT);
$stmt->bindValue(':question_id', $_GET['question_id'], PDO::PARAM_INT);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();
$count = $stmt->fetchColumn();

// var_dump($count);
// exit();

if ($count === 0) {
  $sql = 'INSERT INTO answer_table (id, answer_user_id, is_answered_user_id, question_id, group_id, created_at) VALUES (NULL, :answer_user_id, :is_answered_user_id, :question_id, :group_id, now())';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':answer_user_id', $_SESSION['id'], PDO::PARAM_INT);
  $stmt->bindValue(':is_answered_user_id', $_GET['answered_id'], PDO::PARAM_INT);
  $stmt->bindValue(':question_id', $_GET['question_id'], PDO::PARAM_INT);
  $stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
  $stmt->execute();
}

header("Location:./question.php?group_id={$_GET['group_id']}");

?>