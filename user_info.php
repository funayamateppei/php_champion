<?php

require_once('./functions/connect_db.php');

session_start();

$sql = 'SELECT id FROM user_table WHERE email = :email';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $_SESSION['email'], PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['id'] = $row['id'];

// var_dump($row);
// exit();

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <fieldset>
    <legend>ユーザー情報登録</legend>
    <form action="./user_info_create.php" method="POST">

      <label for="lastName">苗字</label>
      <input id="lastName" class="input" type="text" name="lastName">

      <label for="firstName">名前</label>
      <input id="firstName" class="input" type="text" name="firstName">

      <input type="radio" name="gender" value="0">男性
      <input type="radio" name="gender" value="1">女性

      <button>登録</button>

    </form>
  </fieldset>
</body>

</html>