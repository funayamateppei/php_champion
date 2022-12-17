<?php

// var_dump($_GET);
// exit();

$groupName = $_GET['groupName'];
$address = $_GET['address'];
$admission = $_GET['admission'];

require_once('./functions/connect_db.php');
if ($groupName !== '' && $address !== '' && $admission !== '') {
  $sql = 'SELECT * FROM group_table WHERE group_name LIKE :group_name AND address = :address AND admission_year = :admission_year';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':group_name', "%{$groupName}%", PDO::PARAM_STR);
  $stmt->bindValue(':address',$address , PDO::PARAM_STR);
  $stmt->bindValue(':admission_year',$admission , PDO::PARAM_INT);
} else if ($groupName !== '' && $address !== '') {
  $sql = 'SELECT * FROM group_table WHERE group_name LIKE :group_name AND address = :address';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':group_name', "%{$groupName}%", PDO::PARAM_STR);
  $stmt->bindValue(':address', $address, PDO::PARAM_STR);
} else if ($groupName !== '') {
  $sql = 'SELECT * FROM group_table WHERE group_name LIKE :group_name';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':group_name', "%{$groupName}%", PDO::PARAM_STR);
}
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($row);

?>