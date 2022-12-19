<?php

// var_dump($_GET['group_id']);
// exit();

session_start();

require_once('./functions/connect_db.php');

// グループの情報を取得
$sql = 'SELECT * FROM group_table WHERE id = :group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();
$groupInfo = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($groupInfo);
// exit();

// グループ参加済みのユーザーを取得
$sql = 'SELECT * FROM group_join_table LEFT OUTER JOIN (SELECT * FROM user_info_table) AS user_info_table2 ON group_join_table.user_id = user_info_table2.user_id WHERE group_id = :group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($row);
// echo '</pre>';
// exit();

// グループ参加済のメンバーを表示する
$groupMember = '';
if (count($row) !== 0) {
  foreach ($row as $v) {
    $groupMember .= "
    <li>{$v['last_name']} {$v['first_name']}</li>
    ";
  }
}

// 参加リクエスト申請中のユーザーを取得
$sql = 'SELECT * FROM group_join_request_table LEFT OUTER JOIN (SELECT id, user_id, first_name, last_name, image_path, gender FROM user_info_table) AS request_user_info_table ON group_join_request_table.user_id = request_user_info_table.user_id WHERE group_id = :group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();
$requestUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($requestUsers);
// echo '<pre>';
// exit();

// 参加リクエスト中ユーザー表示
$requestUser = '';
if (count($requestUsers) !== 0) {
  foreach ($requestUsers as $v) {
    $requestDay = date("Y年m月d日", strtotime($v['created_at']));
    $requestUser .= "
      <li>{$v['last_name']} {$v['first_name']} {$requestDay} 
      <a href='./group_join_allow.php?user_id={$v['user_id']}&group_id={$v['group_id']}'>許可</a> 
      <a href='./group_join_delete.php?user_id={$v['user_id']}&group_id={$v['group_id']}'>拒否</a></li>
    ";
  }
}

// 質問の数をJSに送る（ランダムの数を作るため）
$sql = 'SELECT * FROM question_table';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$question = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($count);

$questionJS = json_encode($question);


// ユーザーを取得した中から4人ランダムで表示して
// 質問に答えさせるためにJSにデータを送る
$group_array = json_encode($row);

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
  <header>
    <h1><?= $groupInfo['group_name'] . ' ' . $groupInfo['admission_year'] . '年' ?></h1>
  </header>

  <div id="groupSelect">
    <a href="./group_select.php">グループ選択画面</a>
  </div>

  <div id="myPage">
    <a href="./myPage.php">マイページへ</a>
  </div>

  <div id="member">
    <p>メンバー</p>
    <ul>
      <?= $groupMember ?>
    </ul>
  </div>

  <div id="requestMember">
    <p>リクエスト中ユーザー</p>
    <ul>
      <?= $requestUser ?>
    </ul>
  </div>

  <div id="display">
    <div id="question">
      <!-- クエスチョン表示 -->
    </div>
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <script>
    // クエスチョンの個数を取得
    let questionArray = <?= $questionJS ?>;
    console.log(questionArray);

    // グループの参加者を取得
    let groupArray = <?php echo $group_array; ?>;
    console.log(groupArray);

    
  </script>
</body>

</html>