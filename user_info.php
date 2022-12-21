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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/earlyaccess/kokoro.css" rel="stylesheet">
  <link rel="stylesheet" href="./user_info.css">
  <title>Document</title>
</head>

<body>
  <h1>User Info Form</h1>

  <fieldset>
    <form action="./user_info_create.php" method="POST">

      <div class="div">
        <label for="lastName">苗字</label>
        <input id="lastName" class="input" type="text" name="lastName">
      </div>

      <div class="div">
        <label for="firstName">名前</label>
        <input id="firstName" class="input" type="text" name="firstName">
      </div>

      <div class="gender">
        <div>
          <input id="man" class="radio" type="radio" name="gender" value="0">
          <label class="label" for="man">男性</label>
        </div>

        <div>
          <input id="woman" class="radio" type="radio" name="gender" value="1">
          <label class="label" for="woman">女性</label>
        </div>
      </div>

      <button>登録</button>

    </form>
  </fieldset>
</body>

</html>