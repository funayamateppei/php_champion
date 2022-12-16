<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div id="signin">
    <div class="form-title">Sign up</div>

    <form action="./signup_cfm.php" method="POST">
      <div>
        <label for="email">Email</label>
        <input name="email" type="email" id="email" autocomplete="off" />
      </div>
      <div>
        <label for="password">Password</label>
        <input name="password" type="password" id="password" />
      </div>
      <div>
        <label for="cfmpassword">Confirm Password</label>
        <input name="cfmpassword" type="password" id="cfmpassword" />
      </div>
      <a href="./login.php" class="signUp">Sign in</a>
      <button class="login">登録</button>
    </form>

  </div>
</body>

</html>