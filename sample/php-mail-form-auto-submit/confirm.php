<?php

/**
 * セッションスタート
 */
session_start();


/**
 * フォーム入力ページからのセッションデータが無い場合はフォーム入力ページにリダイレクト
 */
if (!isset($_SESSION['form'])) {
  header('Location: index.php');
  exit;
}


/**
 * セッション内のフォームデータを $post に代入
 */
$post = $_SESSION['form'];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>確認ページ</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
</head>

<body>
  <div class="container">

    <h1 class="alert alert-info">確認ページ</h1>

    <div class="row">
      <div class="col-md-6 offset-md-3">
        <table class="table">
          <tr>
            <th>お名前</th>
            <td><?php echo htmlspecialchars($post["yourName"]); ?></td>
          </tr>
          <tr>
            <th>メールアドレス</th>
            <td><?php echo htmlspecialchars($post["email"]); ?></td>
          </tr>
          <tr>
            <th>Memo</th>
            <td><?php echo nl2br(htmlspecialchars($post["memo"])); ?></td>
          </tr>
        </table>

        <form action="sendmail.php" method="post" class="d-flex justify-content-between">
          <a href="index.php" class="btn btn-secondary">戻る</a>
          <input type="submit" class="btn btn-primary" value="送信する">
        </form>

      </div><!-- /.col -->
    </div><!-- /.row -->
  
  </div><!-- /.container -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>