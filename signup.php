<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="./signup.css">
  <link href="https://fonts.googleapis.com/earlyaccess/kokoro.css" rel="stylesheet">
  <title>Document</title>
</head>

<body>
  <h1>Create an account</h1>
  <div id="signin">

    <fieldset>
      <form action="./signup_cfm.php" method="POST">
        <div>
          <label for="email">E-mail</label>
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
        <button class="login">SIGN UP</button>
      </form>
    </fieldset>
    <div class="link">
      <p>Already have an account?</p>
      <a href="./login.php" class="signUp">SIGN IN</a>
    </div>

  </div>
</body>

</html>