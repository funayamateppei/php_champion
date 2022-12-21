<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="./login.css">
  <title>Document</title>
</head>

<body>
  <!-- ログインフォーム -->
  <h1>Let’s get started</h1>
  <fieldset>
    <form action="./login_cfm.php" method="POST">
      <div>
        <label for="email">Email</label>
        <input id="email" class="input" type="email" name="email">
      </div>
      <div>
        <label for="password">Password</label>
        <input id="password" class="input" type="password" name="password">
      </div>
      <button>SIGN IN</button>
    </form>
  </fieldset>
  <div class="link">
    <p>Dont’t have an account?</p>
    <a href="./signup.php">SIGN UP</a>
  </div>
</body>

</html>