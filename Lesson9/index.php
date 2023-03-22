<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <title>Lesson9</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .red {
      color: red;
    }
  </style>
</head>
<body>
<div class="container">
  <h1>Lesson9</h1>
  <?php
    $arr = ["aaa", "bbb", "ccc"];
    // echo "test"
    // echo "test2"
    $my_name = '侍一郎';
    // $my-name = '侍一郎';
    echo "私の名前は{$my_name}です。";
    echo "<br>";
    echo '私の名前は<span class="red">' . $my_name . "</span>です。";
    echo "<br>";
    echo '私の名前は' . '<span class=\'red\'>' . $my_name . "</span>です。";
    echo "<br>";

    // 配列に値を代入する
    $user_names = ['侍太郎', '侍一郎', '侍二郎', '侍三郎', '侍四郎'];

    // 配列の値を出力する
    echo $user_names[0]; // 文字列の出力
    echo "<br>";
    print $user_names[0]; // 文字列の出力
    echo "<br>";
    echo "<pre>";
    print_r($user_names); // 基本的には何でも出力できる
    echo "</pre>";
    var_dump($user_names); // 基本的には何でも出力できる

  ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>