<?php

// var_dump($_GET['group_id']);

session_start();

require_once('./functions/connect_db.php');

$sql = 'SELECT * FROM answer_table 
  LEFT OUTER JOIN (SELECT id, question, gender, self_analysis FROM question_table) 
  AS question_table2 ON answer_table.question_id = question_table2.id 
  WHERE is_answered_user_id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

var_dump($row);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/earlyaccess/kokoro.css" rel="stylesheet">
  <link rel="stylesheet" href="./myPage.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
</head>

<body>
  <h1>マイページ</h1>
  <a href="./question.php?group_id=<?= $_GET['group_id'] ?>" class="fa-solid fa-circle-arrow-left"></a>

  <div id="selfAnalysis">
    <h2>〜自己分析関連〜</h2>
    <div id="selfDisplay">
      <!-- 自己分析関連表示 -->
    </div>
  </div>

  <div id="ranking">
    <h2>〜その他〜</h2>
    <div id="rankingDisplay">
      <!-- その他表示 -->
    </div>
  </div>

  <a id="logout" href='./logout.php'>LOGOUT</a>
</body>

</html>