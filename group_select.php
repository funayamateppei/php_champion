<?php

session_start();

require_once('./functions/connect_db.php');

// 参加中のグループを取得
$sql = 'SELECT * FROM group_join_table LEFT OUTER JOIN (SELECT * FROM group_table) AS group_table2 ON group_join_table.group_id = group_table2.id WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

$group = '';
if (count($row) !== 0) {
  foreach ($row as $v) {
    $group .= "
    <div class='item'>
      <p>{$v['group_name']}</p>
      <p>{$v['admission_year']}年 {$v['address']}</p>
      <a href='./question.php?group_id={$v['id']}'>入室</a>
    </div>
  ";
  }
}

// 参加リクエスト許可待ち情報を取得
$sql = 'SELECT * FROM group_join_request_table LEFT OUTER JOIN (SELECT * FROM group_table) AS group_table2 ON group_join_request_table.group_id = group_table2.id WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($result);
// echo '</pre>';

$requestGroup = '';
if (count($result) !== 0) {
  foreach ($result as $x) {
    $requestGroup .= "
      <div class='item'>
        <p>{$x['group_name']}</p>
        <p>{$x['admission_year']}年 {$x['address']}</p>
        <a href='./group_join_cancel.php?group_id={$x['group_id']}'>取消</a>
      </div>
    ";
  }
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/earlyaccess/kokoro.css" rel="stylesheet">
  <link rel="stylesheet" href="./group_select.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
</head>

<body>

  <div id="body">
    <!-- 所属しているグループを表示 -->
    <div id="myGroup">
      <h2>所属グループ一覧</h2>
      <?= $group ?>
    </div>
    <hr>
    <!-- 参加リクエスト申請中のグループを表示 -->
    <div id="requestGroup">
      <h2>参加リクエスト中一覧</h2>
      <?= $requestGroup ?>
    </div>
    <hr>
    <!-- グループ検索フォーム -->
    <div id="searchForm">
      <button id="createBtn" class="fa-solid fa-plus"></button>
      <h2>グループ検索</h2>
      <form action="group_search.php" method="POST">
        <div class="flex">
          <div class='column'>
            <label for="admissionYear">グループ参加年度</label>
            <select id="admissionYear" name="admissionYear">
              <!-- 年数をJSで表示 -->
            </select>
          </div>
          <div class='column'>
            <label for="address">都道府県名</label>
            <select name="address" id="address">
              <option value="" selected>未選択</option>
              <option value="北海道">北海道</option>
              <option value="青森県">青森県</option>
              <option value="岩手県">岩手県</option>
              <option value="宮城県">宮城県</option>
              <option value="秋田県">秋田県</option>
              <option value="山形県">山形県</option>
              <option value="福島県">福島県</option>
              <option value="茨城県">茨城県</option>
              <option value="栃木県">栃木県</option>
              <option value="群馬県">群馬県</option>
              <option value="埼玉県">埼玉県</option>
              <option value="千葉県">千葉県</option>
              <option value="東京都">東京都</option>
              <option value="神奈川県">神奈川県</option>
              <option value="新潟県">新潟県</option>
              <option value="富山県">富山県</option>
              <option value="石川県">石川県</option>
              <option value="福井県">福井県</option>
              <option value="山梨県">山梨県</option>
              <option value="長野県">長野県</option>
              <option value="岐阜県">岐阜県</option>
              <option value="静岡県">静岡県</option>
              <option value="愛知県">愛知県</option>
              <option value="三重県">三重県</option>
              <option value="滋賀県">滋賀県</option>
              <option value="京都府">京都府</option>
              <option value="大阪府">大阪府</option>
              <option value="兵庫県">兵庫県</option>
              <option value="奈良県">奈良県</option>
              <option value="和歌山県">和歌山県</option>
              <option value="鳥取県">鳥取県</option>
              <option value="島根県">島根県</option>
              <option value="岡山県">岡山県</option>
              <option value="広島県">広島県</option>
              <option value="山口県">山口県</option>
              <option value="徳島県">徳島県</option>
              <option value="香川県">香川県</option>
              <option value="愛媛県">愛媛県</option>
              <option value="高知県">高知県</option>
              <option value="福岡県">福岡県</option>
              <option value="佐賀県">佐賀県</option>
              <option value="長崎県">長崎県</option>
              <option value="熊本県">熊本県</option>
              <option value="大分県">大分県</option>
              <option value="宮崎県">宮崎県</option>
              <option value="鹿児島県">鹿児島県</option>
              <option value="沖縄県">沖縄県</option>
            </select>
          </div>
        </div>
        <div class='column'>
          <label for="groupName">グループ名</label>
          <input id="groupName" type="text" name="groupName">
        </div>
      </form>
    </div>
    <div id="searchGroup">
      <!-- 検索にひっかかったグループを表示 -->
    </div>
  </div>

  <!-- ハンバーガーメニューでグループ作成フォーム表示 -->
  <div id="createForm">
    <div class="span">
      <h2>グループ作成</h2>
      <span id="closeBtn" class="fa-solid fa-circle-xmark"></span>
    </div>
    <form action="group_create.php" method="POST">

      <div class="flex">
        <div class="column">
          <label for="admissionYearCreate">グループ参加年度</label>
          <select id="admissionYearCreate" name="admissionYearCreate">
            <!-- 年数をJSで表示 -->
          </select>
        </div>

        <div class="column">
          <label for="addressCreate">都道府県名</label>
          <select name="addressCreate" id="addressCreate">
            <option value="" selected>未選択</option>
            <option value="北海道">北海道</option>
            <option value="青森県">青森県</option>
            <option value="岩手県">岩手県</option>
            <option value="宮城県">宮城県</option>
            <option value="秋田県">秋田県</option>
            <option value="山形県">山形県</option>
            <option value="福島県">福島県</option>
            <option value="茨城県">茨城県</option>
            <option value="栃木県">栃木県</option>
            <option value="群馬県">群馬県</option>
            <option value="埼玉県">埼玉県</option>
            <option value="千葉県">千葉県</option>
            <option value="東京都">東京都</option>
            <option value="神奈川県">神奈川県</option>
            <option value="新潟県">新潟県</option>
            <option value="富山県">富山県</option>
            <option value="石川県">石川県</option>
            <option value="福井県">福井県</option>
            <option value="山梨県">山梨県</option>
            <option value="長野県">長野県</option>
            <option value="岐阜県">岐阜県</option>
            <option value="静岡県">静岡県</option>
            <option value="愛知県">愛知県</option>
            <option value="三重県">三重県</option>
            <option value="滋賀県">滋賀県</option>
            <option value="京都府">京都府</option>
            <option value="大阪府">大阪府</option>
            <option value="兵庫県">兵庫県</option>
            <option value="奈良県">奈良県</option>
            <option value="和歌山県">和歌山県</option>
            <option value="鳥取県">鳥取県</option>
            <option value="島根県">島根県</option>
            <option value="岡山県">岡山県</option>
            <option value="広島県">広島県</option>
            <option value="山口県">山口県</option>
            <option value="徳島県">徳島県</option>
            <option value="香川県">香川県</option>
            <option value="愛媛県">愛媛県</option>
            <option value="高知県">高知県</option>
            <option value="福岡県">福岡県</option>
            <option value="佐賀県">佐賀県</option>
            <option value="長崎県">長崎県</option>
            <option value="熊本県">熊本県</option>
            <option value="大分県">大分県</option>
            <option value="宮崎県">宮崎県</option>
            <option value="鹿児島県">鹿児島県</option>
            <option value="沖縄県">沖縄県</option>
          </select>
        </div>
      </div>

      <div class="column">
        <label for="groupNameCreate">グループ名</label>
        <input id="groupNameCreate" type="text" name="groupNameCreate">
      </div>
      <div class="btn"><button>作成</button></div>
    </form>
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <script>
    // グループリアルタイム検索 axios
    $('#groupName').on('keyup', function(e) {
      if (e.target.value !== '') {
        // console.log(e.target.value);
        const address = $('#address').val();
        const admission = $('#admissionYear').val();
        const url = `./group_search.php?groupName=${e.target.value}&address=${address}&admission=${admission}`;
        axios.get(url)
          .then((response) => {
            console.log(response.data);
            const array = [];
            response.data.map((v) => {
              array.push(`
                <div class="item">
                  <p>${v.group_name}</p>
                  <p>${v.admission_year}年 ${v.address}</p>
                  <a class='requestLink' href='./group_join_request.php?group_id=${v.id}'>参加リクエスト申請</a>
                </div>
              `);
            })
            $('#searchGroup').html(array);
          }).catch((error) => {
            console.log(error);
          })
      } else {
        // 文字削除で空白になったときはすべて削除
        $('#searchGroup').empty();
      }
    });


    // 年度のselect option 作成 js (検索フォーム)
    let year = document.getElementById("admissionYear");
    const date = new Date();
    const thisYear = date.getFullYear();
    for (let i = 1930; i <= thisYear; i++) {
      let option = document.createElement("option");
      option.setAttribute("value", i);
      option.innerHTML = i + "年";
      year.appendChild(option);
    }
    let option1 = document.createElement("option");
    option1.setAttribute("value", "");
    option1.innerHTML = "";
    year.appendChild(option1);
    option1.setAttribute("selected", true); // selectedの属性を付与


    // 年度のselect option 作成 js (グループ作成フォーム)
    let yearCreate = document.getElementById("admissionYearCreate");
    for (let i = 1930; i <= thisYear; i++) {
      let option = document.createElement("option");
      option.setAttribute("value", i);
      option.innerHTML = i + "年";
      yearCreate.appendChild(option);
    }
    let option2 = document.createElement("option");
    option2.setAttribute("value", "");
    option2.innerHTML = "";
    yearCreate.appendChild(option2);
    option2.setAttribute("selected", true); // selectedの属性を付与

    // 作成フォーム フェードイン
    $('#createBtn').on('click', () => {
      $('#body').hide();
      $('#createForm').fadeIn();
    })

    // 作成フォーム フェードアウト
    $('#closeBtn').on('click', () => {
      $('#createForm').fadeOut();
      $('#body').fadeIn();
    })
  </script>
</body>

</html>