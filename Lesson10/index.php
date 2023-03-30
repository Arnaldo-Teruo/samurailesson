<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <title>Lesson10</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <h1>Lesson10</h1>

    <p>
      <?php
      // グローバル変数を定義する
      $user_name = '侍花子';

      function show_user_name()
      {
        // ローカル変数を定義する
        $user_name = '侍太郎';

        // ローカルスコープの範囲内でローカル変数を使う
        echo $user_name . '<br>';
      }

      show_user_name();

      // グローバルスコープの範囲内でグローバル変数を使う
      echo $user_name;
      ?>
    </p>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>