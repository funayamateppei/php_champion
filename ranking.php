<?php

// var_dump($_GET['group_id]);

require_once('./functions/connect_db.php');

// グループ名を取得
$sql = 'SELECT * FROM group_table WHERE id = :group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();
$groupInfo = $stmt->fetch(PDO::FETCH_ASSOC);


// 回答を取得（グループでの回答を全て→質問内容JOIN→ユーザー情報JOIN）
$sql = 'SELECT * FROM answer_table 
  LEFT JOIN (SELECT id, question, gender, self_analysis FROM question_table) AS question_table2 ON answer_table.question_id = question_table2.id 
  LEFT JOIN (SELECT user_id, first_name, last_name FROM user_info_table) AS user_info_table2 ON answer_table.is_answered_user_id = user_info_table2.user_id 
  WHERE group_id = :group_id
  ORDER BY question_table2.id ASC, is_answered_user_id ASC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':group_id', $_GET['group_id'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($row);
// echo '</pre>';

$result = json_encode($row);

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

  <div id="back">
    <a href="./question.php?group_id=<?=$_GET['group_id']?>">戻る</a>
  </div>

  <div id="rank">
    <h2>ランキング</h2>
    <div id="table">
      <!-- tableでランキングを追加 -->
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>
    // 回答結果を全てphpから取得
    const result = <?= $result ?>;
    const result2 = <?= $result ?>;
    const result3 = <?= $result ?>;
    console.log(result3);

    // 回答結果がまとまった配列を 質問毎で配列にまとめる 質問毎でも答えられた人でまたまとめる 上位3人を表示
    // グループで回答された質問の数でフィルターし、質問の数を取得
    // https://www.white-space.work/merge-the-duplicated-array-object-using-javascript/
    const filter = result.filter((x, i, self) => self.findIndex(
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
      result.map((value, index) => {
        if ((x.length === 0 || x[0].id === value.id) && value !== 'hoge') {
          array[i].push(value);
          result.splice(index, 1, 'hoge');
        }
      })
    })
    console.log(array);
    // 質問毎でユーザーでまとめる→そのlengthでsortし、ランキング３位まで表示する
    // 質問数の配列を作成
    const lastArr = [];
    for (let i = 0; i < filter.length; i++) {
      lastArr.push([]);
    }
    console.log(lastArr);
    // // 質問数の中に回答されたユーザー数分の配列を作成
    // // 配列を作るために質問毎の回答されたユーザー数を取得
    array.map((x, i) => {
      const filterCount = x.filter((value, index, arr) => arr.findIndex(
        (data) => data.is_answered_user_id === value.is_answered_user_id) === index)
      console.log(filterCount.length);
      for (let index = 0; index < filterCount.length; index++) {
        lastArr[i].push([]);
      }
    })
    // console.log(lastArr);
    // // データを追加していく
    lastArr.map((x, i) => {
      x.map((value, index) => {
        result2.map((v1, I) => {
          if ((value.length === 0 || (value[0].is_answered_user_id === v1.is_answered_user_id && value[0].id === v1.id)) && v1 !== 'hoge') {
            x[index].push(v1);
            result2.splice(I, 1, 'hoge');
            // console.log(result);
          }
        })
      })
    })
    console.log(lastArr);

    // ユーザー毎の配列のlengthで多い順にソートをかける（降順）
    lastArr.map((x, i) => {
      x.sort(function(a, b) {
        return (a.length > b.length) ? -1 : 1; //降順の並び替え
      });
    })
    console.log(lastArr);
    // lastArrを使ってランキングを表示していく
    let rank = [];
    lastArr.map((x, i) => {
      if (x.length >= 3) {
        rank.push(`
          <div class="item">
          <h2>${x[0][0].question}</h2>
          <p>１位 ${x[0][0].last_name} ${x[0][0].first_name} ${x[0].length}票</p>
          <p>２位 ${x[1][0].last_name} ${x[1][0].first_name} ${x[1].length}票</p>
          <p>３位 ${x[2][0].last_name} ${x[2][0].first_name} ${x[2].length}票</p>
          </div>
        `);
      } else if (x.length === 2) {
        rank.push(`
          <div class="item">
          <h2>${x[0][0].question}</h2>
          <p>１位 ${x[0][0].last_name} ${x[0][0].first_name} ${x[0].length}票</p>
          <p>２位 ${x[1][0].last_name} ${x[1][0].first_name} ${x[1].length}票</p>
          </div>
        `);
      } else if (x.length === 1) {
        rank.push(`
          <div class="item">
          <h2>${x[0][0].question}</h2>
          <p>１位 ${x[0][0].last_name} ${x[0][0].first_name} ${x[0].length}票</p>
          </div>
        `);
      }
    })
    $('#table').html(rank);
  </script>
</body>

</html>