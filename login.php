<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Document</title>
</head>

<body>
  <!-- ログインフォーム -->
  <fieldset>
    <legend>Login</legend>
    <form action="./login_cfm.php" method="POST">
      <label for="email">Email</label>
      <input id="email" class="input" type="email">
      <label for="password">Password</label>
      <input id="password" class="input" type="password">
      <button>Login</button>
    </form>
  </fieldset>
  <p>登録がお済みではない方はこちら</p>
  <a href="./signup.php">Signup</a>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>

  </script>

</body>

</html>