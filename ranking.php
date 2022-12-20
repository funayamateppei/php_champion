<?php

// var_dump($_GET['group_id]);

require_once('./functions/connect_db.php');

$sql = 'SELECT id, is_answered_user_id, question_id, group_id FROM answer_table LEFT OUTER JOIN (SELECT id, question, gender, self_analysis FROM question_table) AS question_table2 ON answer_table.question_id = question_table2.id WHERE group_id = :group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>