<!-- グループ作成ファイル -->

<?php

// var_dump($_POST);
// exit();

session_start();

require_once('./functions/connect_db.php');

$groupName = $_POST['groupNameCreate'];
$admission = $_POST['admissionYearCreate'];
$address = $_POST['addressCreate'];

// すでに作成しようとしているグループが存在する場合は
// 作成させないように検索をかける
$sql = 'SELECT COUNT(*) FROM group_table WHERE group_name = :group_name AND admission_year = :admission_year AND address = :address';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':group_name', $groupName, PDO::PARAM_STR);
$stmt->bindValue(':admission_year', $admission, PDO::PARAM_INT);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->execute();
$count = $stmt->fetchColumn();

// var_dump($count);
// exit();

// 同じグループがなければグループを作成する
if ($count === 0) {
  $sql = 'INSERT INTO group_table (id, group_name, admission_year, address, created_at) VALUES (NULL, :group_name, :admission_year, :address, now())';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':group_name', $groupName, PDO::PARAM_STR);
  $stmt->bindValue(':admission_year', $admission, PDO::PARAM_INT);
  $stmt->bindValue(':address', $address, PDO::PARAM_STR);
  $stmt->execute();

  $sql = 'SELECT * FROM group_table WHERE group_name = :group_name AND admission_year = :admission_year AND address = :address';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':group_name', $groupName, PDO::PARAM_STR);
  $stmt->bindValue(':admission_year', $admission, PDO::PARAM_INT);
  $stmt->bindValue(':address', $address, PDO::PARAM_STR);
  $stmt->execute();
  $id = $stmt->fetch(PDO::FETCH_ASSOC);

  // var_dump($id);
  // exit();

  $sql = 'INSERT INTO group_join_table (id, user_id, group_id, created_at) VALUES (NULL, :user_id, :group_id, now())';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
  $stmt->bindValue(':group_id', $id['id'], PDO::PARAM_INT);
  $stmt->execute();
} else {
  echo 'すでにグループが存在します。';
  echo '<a href="./group_select.php">戻る</a>';
  return false;
}

header('Location:./group_select.php');

?>