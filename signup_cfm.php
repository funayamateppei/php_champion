<?php

// DB接続
require_once('./functions/connect_db.php');

session_start();

// パスワードと確認用パスワードのバリデーション
if ($_POST['password'] !== $_POST['cfmpassword']) {
  echo ('パスワードと確認用パスワードが一致しません。');
  return false;
}
//メールアドレスのバリデーション
if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  echo '入力された値が不正です。';
  return false;
}
// パスワードのバリデーション
// 半角英数字をそれぞれ１文字含んだ8文字~15文字で入力させる
if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,15}+\z/i', $_POST['password'])) {
  // passwordのハッシュ化はなぜするのか？readmeにリンク記載
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
} else {
  echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上15文字以内で設定してください。';
  return false;
}


// 入力したメアドと一致するデータベース内のメールアドレスを取得
// 同じメールアドレスを保存させないために！
$stmt = $pdo->prepare("SELECT email from user_table where email = ?");
$stmt->execute([$email]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//データベース内のメールアドレスと重複していない場合、登録する。
if (!isset($row['email'])) {
  $sql = "INSERT INTO user_table (id, email, password, created_at, updated_at) value(NULL, :email, :password, now(), now())";
  $stmt = $pdo->prepare($sql);
  // バインド変数を設定
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);
  $stmt->bindValue(':password', $password, PDO::PARAM_STR);
  // SQL実行（実行に失敗すると `sql error ...` が出力される）
  try {
    $status = $stmt->execute();
    session_regenerate_id(true); //session_idを新しく生成し、置き換える
    $_SESSION['session_id'] = session_id();
    $_SESSION['email'] = $_POST['email'];
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }

  // 登録が完了したらユーザー情報登録画面へ
  header('Location:./user_info.php');
} else {

?>
  <!-- メールアドレスがすでに登録してあったら下記htmlを表示 -->
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="style.css">

  <body id="log_body">
    <main class="main_log">
      <p>既に登録されたメールアドレスです</p>
      <button id='btn'>ログインページへ</button>
    </main>

    <script>
      const btn = document.getElementById('btn');
      btn.addEventListener('click', () => {
        location.href = './login.php';
      })
    </script>
  </body>
<?php
  return false;
}
?>