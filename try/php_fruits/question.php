<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>フルーツ課題 PHP編</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
  <style>
    body { padding: 3rem 0; }
    .help:before { content: "ヒント：" }
    .card:not(:last-child) { margin-bottom: 2rem; }
    .green { color: green; background-color: #c3ffc3; }
    .pink { color: pink; background-color: #ee7c90; }
    .orange { color: orange; background-color: #ffe2ad; }
    .red { color: white; background-color: red; }
    .yellow { color: yellow; background-color: #d9d909; }
  </style>
</head>
<body>

<div class="container">
  
  <h1 class="alert alert-danger">フルーツ課題 PHP編</h1>

  <?php
    $fruits = ['メロン', 'りんご', 'みかん', 'いちご', 'バナナ'];
    $colors = ['green', 'pink', 'orange', 'red', 'yellow'];
    $number = rand(0, 4); // PHPのランダム関数を使っている
  ?>

  <div class="card">
    <div class="card-header">
      <i class="fas fa-hand-point-right"></i>
      $fruits からループ処理で横並びにフルーツ達を表示してみよう！
    </div>
    <div class="card-body">
      <p>フルーツ達は</p>
      <ul class="list-group  list-group-horizontal">
        <li class="list-group-item"></li>
      </ul>
    </div>
    <div class="card-footer">
      <div class="help">
        liタグを ループ処理しよう
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <i class="fas fa-hand-point-right"></i>
      上記の .card-body のソースコードをここの .card-body にコピーして、変数 $colors を利用してフルーツたちに色をつけよう！
    </div>
    <div class="card-body"></div>
    <div class="card-footer">
      <div class="help">
        $fruits のキーを利用すれば $colors と $fruits を連動させることができるよ
      </div>
    </div>
  </div>

<div class="card">
    <div class="card-header">
      <i class="fas fa-hand-point-right"></i>
      メロンの確率を多くして、バナナの確率を下げよう！
    </div>
    <div class="card-body">
      <p>トムの好きなフルーツがボタンを押すとランダムに決まるよ</p>
      <div class="d-flex align-items-center">
        <form action="#" method="post">
          <div class="mr-5">
            <button type="submit" class="btn btn-primary">ボタン</button>
          </div>
        </form>
        <div>
          <b><?php echo $fruits[$number]; ?></b>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <div class="help">
        配列の調整だけでも可能だけど、PHPの if文 や switch でも可能だよ
      </div>
    </div>
  </div>

</div>

<!-- jQuery、Popper.js、Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>