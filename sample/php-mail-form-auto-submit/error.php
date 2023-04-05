<?php
/**
 * セッションスタート
 */
session_start();


/**
 * 万が一、エラー用のセッションが設定されていない場合はトップへリダイレクト
 */
if( !isset($_SESSION['error']) ){
  header('Location: index.php');
  exit;
}


/**
 * セッションからエラーを $error に代入
 */
$error = $_SESSION['error'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>エラーページ</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
</head>
<body>

<div class="container">
  <h1 class="alert alert-danger">エラー発生！</h1>

  <div class="row">
    <div class="col-md-6 offset-md-3">
      <h2>エラー内容</h2>
      <div class="py-4 text-danger"><?php echo $error; ?></div>
      <a href="index.php" class="btn btn-secondary mr-4">戻る</a>
    </div><!-- /.col -->
  </div><!-- /.row -->

</div><!-- /.container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>