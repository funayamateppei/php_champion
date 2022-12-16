<?php

// var_dump($_POST['email']);
// exit();
session_start();

// DB接続
require_once('./functions/connect_db.php');

// 入力されているか確認
if ($_POST['email'] === '' || $_POST['password'] === '') {
  echo '入力してください。';
}

// メールアドレスのバリデーション
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  echo '入力された値が不正です。';
  return false;
}

// SQL作成実行取得
$stmt = $pdo->prepare('SELECT * FROM user_table WHERE email = :email');
$stmt->bindParam(':email', $_POST['email']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($row);
// exit();

//emailがDB内に存在しているか確認
if (!isset($row['email'])) {
  echo 'このメールアドレスは登録されていません。';
  return false;
}
//パスワード確認後sessionにメールアドレスとidとusernameを渡す
// password_verify ハッシュ化されたパスワードと入力されたパスワード比較
// ↑readmeファイルにサイトリンクあり
if (password_verify($_POST['password'], $row['password'])) {
  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['session_id'] = session_id();
  $_SESSION['email'] = $row['email'];
  $_SESSION['id'] = $row['id'];
  $_SESSION['username'] = $row['username'];
} else {
  echo 'パスワードが間違っています。';
  return false;
}

header('Location:./home.php');
