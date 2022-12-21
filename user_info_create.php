<?php

// var_dump($_POST);
// exit();

session_start();

require_once('./functions/connect_db.php');

if (!isset($_POST) || $_POST['firstName'] === '' || $_POST['lastName'] === '' || $_POST['gender'] === '') {
  echo '必須項目を入力してください。';
  return false;
}

  // ユーザー情報登録
  $sql = 'INSERT INTO user_info_table (id, user_id, first_name, last_name, image_path, gender, created_at, updated_at) VALUES (NULL, :user_id, :first_name, :last_name, NULL, :gender, now(), now())';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
  $stmt->bindValue(':first_name', $_POST['firstName'], PDO::PARAM_STR);
  $stmt->bindValue(':last_name', $_POST['lastName'], PDO::PARAM_STR);
  $stmt->bindValue(':gender', $_POST['gender'], PDO::PARAM_STR);
  $stmt->execute();

header('Location:./group_select.php');

?>