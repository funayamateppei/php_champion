<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="./signup.css">
  <link href="https://fonts.googleapis.com/earlyaccess/kokoro.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
          <button id="passBtn1" class="Btnfa-sharp fa-solid fa-eye"></button>
        </div>
        <div>
          <label for="cfmpassword">Confirm Password</label>
          <input name="cfmpassword" type="password" id="cfmpassword" />
          <button id="passBtn2" class="Btnfa-sharp fa-solid fa-eye"></button>
        </div>
        <button class="formBtn">SIGN UP</button>
      </form>
    </fieldset>
    <div class="link">
      <p>Already have an account?</p>
      <a href="./login.php" class="signUp">SIGN IN</a>
    </div>

  </div>

  <script>
    const pass = document.getElementById('password');
    const cfmPass = document.getElementById('cfmpassword');
    const passBtn1 = document.getElementById('passBtn1');
    const passBtn2 = document.getElementById('passBtn2');

    passBtn1.addEventListener('click', (e) => {
      e.preventDefault();
      if (pass.type === 'text') {
        pass.type = "password";
        passBtn1.className = "fa-sharp fa-solid fa-eye";
      } else {
        pass.type = "text";
        passBtn1.className = "fa-sharp fa-solid fa-eye-slash";
      }
    })

    passBtn2.addEventListener('click', (e) => {
      e.preventDefault();
      if (cfmPass.type === 'text') {
        cfmPass.type = "password";
        passBtn2.className = "fa-sharp fa-solid fa-eye";
      } else {
        cfmPass.type = "text";
        passBtn2.className = "fa-sharp fa-solid fa-eye-slash";
      }
    })
  </script>
</body>

</html>