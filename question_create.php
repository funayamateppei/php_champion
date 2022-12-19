<?php

require_once('./functions/connect_db.php');

$sql = 'SELECT * FROM question_table WHERE id = :number';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':number', $_GET['number']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($row);

?>