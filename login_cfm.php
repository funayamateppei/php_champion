<?php

// var_dump($_POST);
// exit();
session_start();

// DB接続
require_once('./functions/connect_db.php');

// メールアドレスのバリデーション
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  $error = '入力された値が不正です。';
  header("./login_miss.php?error={$error}");
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
  $error = 'このメールアドレスは登録されていません。';
  header("./login_miss.php?error={$error}");
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
  $error = 'パスワードが間違っています。';
  header("./login_miss.php?error={$error}");
}

