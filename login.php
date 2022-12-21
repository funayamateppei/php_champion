<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="./login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <button id="passBtn" class="Btnfa-sharp fa-solid fa-eye"></button>
        <!-- <i class="fa-sharp fa-solid fa-eye-slash"></i> -->
      </div>
      <button class="formBtn">SIGN IN</button>
    </form>
  </fieldset>
  <div class="link">
    <p>Dont’t have an account?</p>
    <a href="./signup.php">SIGN UP</a>
  </div>

  <script>
    const pass = document.getElementById('password');
    const passBtn = document.getElementById('passBtn');

    passBtn.addEventListener('click', (e) => {
      e.preventDefault();
      if (pass.type === 'text') {
        pass.type = "password";
        passBtn.className = "fa-sharp fa-solid fa-eye";
      } else {
        pass.type = "text";
        passBtn.className = "fa-sharp fa-solid fa-eye-slash";
      }
    })
  </script>
</body>

</html>