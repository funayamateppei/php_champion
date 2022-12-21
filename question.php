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
      <li>{$v['last_name']} {$v['first_name']} {$requestDay}</li>
      <li><a href='./group_join_allow.php?user_id={$v['user_id']}&group_id={$v['group_id']}'>許可</a> 
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/earlyaccess/kokoro.css" rel="stylesheet">
  <link rel="stylesheet" href="./question.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
</head>

<body>
  <div class="body">
    <header>
      <h2><?= $groupInfo['group_name'] ?></h2>
      <h2><?= $groupInfo['admission_year'] . '年' ?></h2>
    </header>

    <div id="display">
      <div id="question">
        <!-- クエスチョン表示 -->
      </div>
      <div id="questionMember">
        <!-- 選択肢表示 -->
      </div>
    </div>
    <button id="memberBtn">メンバー一覧</button>
  </div>



  <div id="groupSelect">
    <a href="./group_select.php" class="fa-solid fa-people-roof"></a>
  </div>

  <div id="myPage">
    <a href="./myPage.php?group_id=<?=$_GET['group_id']?>">マイページへ</a>
  </div>

  <div id="groupRanking">
    <a href="./ranking.php?group_id=<?= $_GET['group_id'] ?>" class="fa-solid fa-crown"></a>
  </div>





  <div id="memberList">
    <span id="closeBtn" class="fa-solid fa-circle-xmark"></span>
    <div id="member">
      <h2>メンバー</h2>
      <ul>
        <?= $groupMember ?>
      </ul>
    </div>
    <div id="requestMember">
      <h2>リクエスト中ユーザー</h2>
      <ul>
        <?= $requestUser ?>
      </ul>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <script>
    // メンバー一覧表示機能
    $('#memberBtn').on('click', () => {
      $('.body').hide();
      $('#memberList').fadeIn();
    })

    $('#closeBtn').on('click', () => {
      $('.body').fadeIn();
      $('#memberList').fadeOut();
    })

    // クエスチョンの個数を取得
    const questionArray = <?= $questionJS ?>;
    console.log(questionArray);

    // グループの参加者を取得
    const groupArray = <?= $group_array ?>;
    console.log(groupArray);

    window.onload = () => {
      const randomNumber = Math.floor(Math.random() * questionArray.length);
      console.log(randomNumber);
      if (questionArray[randomNumber].gender === 2) {
        // すべての人間で選択肢
        let strQuestion = `<h3>${questionArray[randomNumber].question}</h3>`;
        $('#question').html(strQuestion);
        const member = [];
        const memberId = [];
        for (let i = 0; member.length < 4; i++) {
          const random = Math.floor(Math.random() * groupArray.length);
          if (memberId.indexOf(groupArray[random].id) === -1) {
            memberId.push(groupArray[random].id);
            member.push(groupArray[random]);
          }
        }
        console.log(member);
        let strMember = [];
        member.map((x) => {
          strMember.push(`
          <a href='./answer_create.php?answered_id=${x.user_id}&question_id=${questionArray[randomNumber].id}&group_id=<?= $_GET['group_id'] ?>'>${x.last_name} ${x.first_name}</a>
          `);
        })
        console.log(strMember);
        $('#questionMember').html(strMember);
      } else if (questionArray[randomNumber].gender === 1) {
        // 女のみで選択肢
        let str = `<h3>${questionArray[randomNumber].question}</h3>`;
        $('#question').html(str);
        // 女だけの配列を作成
        const womanArray = [];
        groupArray.map((x, i) => {
          if (x.gender === 1) {
            womanArray.push(x);
          }
        })
        console.log(womanArray);
        const member = [];
        const memberId = [];
        for (let i = 0; member.length < 4; i++) {
          const random = Math.floor(Math.random() * womanArray.length);
          if (memberId.indexOf(womanArray[random].id) === -1) {
            memberId.push(womanArray[random].id);
            member.push(womanArray[random]);
          }
        }
        console.log(member);
        let strMember = [];
        member.map((x) => {
          strMember.push(`
          <a href='./answer_create.php?answered_id=${x.user_id}&question_id=${questionArray[randomNumber].id}&group_id=<?= $_GET['group_id'] ?>'>${x.last_name} ${x.first_name}</a>
          `);
        })
        console.log(strMember);
        $('#questionMember').html(strMember);
      } else if (questionArray[randomNumber].gender === 0) {
        // 男のみで選択肢
        let str = `<h3>${questionArray[randomNumber].question}</h3>`;
        $('#question').html(str);
        // 男だけの配列を作成
        const manArray = [];
        groupArray.map((x, i) => {
          if (x.gender === 0) {
            manArray.push(x);
          }
        })
        console.log(manArray);
        const member = [];
        const memberId = [];
        for (let i = 0; member.length < 4; i++) {
          const random = Math.floor(Math.random() * manArray.length);
          if (memberId.indexOf(manArray[random].id) === -1) {
            memberId.push(manArray[random].id);
            member.push(manArray[random]);
          }
        }
        console.log(member);
        let strMember = [];
        member.map((x) => {
          strMember.push(`
          <a href='./answer_create.php?answered_id=${x.user_id}&question_id=${questionArray[randomNumber].id}&group_id=<?= $_GET['group_id'] ?>'>${x.last_name} ${x.first_name}</a>
          `);
        })
        console.log(strMember);
        $('#questionMember').html(strMember);
      }
    }
  </script>
</body>

</html>