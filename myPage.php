<?php

// var_dump($_GET['group_id']);

session_start();

require_once('./functions/connect_db.php');

$sql = 'SELECT * FROM answer_table 
  LEFT OUTER JOIN (SELECT id, question, gender, self_analysis FROM question_table) 
  AS question_table2 ON answer_table.question_id = question_table2.id 
  WHERE is_answered_user_id = :id
  ORDER BY answer_table.question_id ASC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

$data = json_encode($row);

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
  <div class="backLink"><a href="./question.php?group_id=<?= $_GET['group_id'] ?>" class="fa-solid fa-circle-arrow-left"></a></div>

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

  <div class="logoutBtn"><a id="logout" href='./logout.php'>LOGOUT</a></div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>
    const data = <?= $data ?>;
    console.log(data);

    const filter = data.filter((x, i, self) => self.findIndex(
      (dataElement) => dataElement.id === x.id) === i)
    console.log(filter.length);
    // 問題の数の配列が入った連想配列を作成
    const array = [];
    for (let i = 0; i < filter.length; i++) {
      array.push([]);
    }
    console.log(array);
    // phpから取得したデータでidが一致しなくなるまでひとつの配列に入れていく（質問の種類で配列でまとめる）
    // 連想配列分まわして、phpから取得した配列をmapでふりわける
    // phpから取得した配列をまわして、array配列になおしたら'hoge'に書き換える 条件分岐で質問毎に配列になおした
    array.map((x, i) => {
      data.map((value, index) => {
        if ((x.length === 0 || x[0].id === value.id) && value !== 'hoge') {
          array[i].push(value);
          data.splice(index, 1, 'hoge');
        }
      })
    })
    console.log(array);
    // ユーザー毎の配列のlengthで多い順にソートをかける（降順）
    array.sort(function(a, b) {
      return (a.length > b.length) ? -1 : 1; //降順の並び替え
    });
    console.log(array);

    // 自己分析の配列とその他の配列を作成する
    const selfAnalysis = [];
    const analysis = [];
    array.map((x, i) => {
      if (x[0].self_analysis === 1) {
        selfAnalysis.push(`
          <div class="item">
            <h3>${x[0].question}</h3>
            <p>${x.length}票</p>
          </div>
        `)
      } else if (x[0].self_analysis === 0) {
        analysis.push(`
          <div class="item">
            <h3>${x[0].question}</h3>
            <p>${x.length}票</p>
          </div>
        `)
      }
    })
    $('#selfDisplay').html(selfAnalysis);
    $('#rankingDisplay').html(analysis);
  </script>
</body>

</html>