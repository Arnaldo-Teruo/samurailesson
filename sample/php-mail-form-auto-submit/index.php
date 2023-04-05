<?php

/**
 * セッションスタート
 */
session_start();


/**
 * セッションにフォームデータがあれば代入して無ければ空を代入
 */
$post = isset($_SESSION['form']) ? $_SESSION['form'] : "";


/**
 * セッション内の各フォームデータを変数として初期化
 */
$yourName = empty($post['yourName']) ? "" : $post['yourName'];
$email    = empty($post['email']) ? "" : $post['email'];
$memo     = empty($post['memo']) ? "" : $post['memo'];


/**
 * エラー内容を初期化
 */
$errors = [];


/**
 * POSTでアクセスがあったときの処理（POST じゃない場合は GET になっている）
 */
if ($_SERVER['REQUEST_METHOD'] === "POST") {


  /**
   * $_POST の中身を全てサニタイズして $post に入れている（セキュリティ対策）
   */
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

  /**
   * バリデーション処理をしてエラーを追加していく
   */

  $yourName = $post['yourName'];
  /**
   * 必須項目なので空チェック
   */
  if ($post['yourName'] === "") {
    $errors['yourName'] = "blank";
  }

  $email = $post['email'];
  /**
   * email形式かどうかのチェック
   */
  if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "email";
  }
  /**
   * 必須項目なので空チェック
   */
  if ($post['email'] === "") {
    $errors['email'] = "blank";
  }

  $memo = $post['memo'];
  /**
   * 必須項目なので空チェック
   */
  if ($post['memo'] === "") {
    $errors['memo'] = "blank";
  }


  /**
   * エラーがながなければ確認画面に飛ぶように
   */
  if (count($errors) === 0) {
    /**
     * 飛んだ先に入力データを送るためにセッションに入れ込む
     */
    $_SESSION['form'] = $post;
    header("Location: confirm.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>メールフォーム</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    
    <h1 class="alert alert-info">メールフォーム</h1>

    <div class="row">
      <div class="col-md-6 offset-md-3">

        <form action="" method="post" novalidate>

          <div class="form-group">
            <label for="yourName">お名前</label>
            <input type="text" class="form-control" id="yourName" name="yourName" value="<?php echo htmlspecialchars($yourName); ?>">
            <small class="form-text text-muted">フルネームをご記入ください</small>
            <?php if (isset($errors['yourName']) && $errors['yourName'] === "blank") { ?>
              <p class="errorMessage">お名前をご記入ください</p>
            <?php } ?>
          </div>

          <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <small class="form-text text-muted">メール形式の確認もしています</small>
            <?php if (isset($errors['email']) &&  $errors['email'] === "blank") { ?>
              <p class="errorMessage">メールアドレスをご記入ください</p>
            <?php } ?>
            <?php if (isset($errors['email']) &&  $errors['email'] === "email") { ?>
              <p class="errorMessage">メールアドレスの形式が違うようです</p>
            <?php } ?>
          </div>

          <div class="form-group">
            <label for="memo">内容</label>
            <textarea name="memo" id="memo" cols="30" rows="10" class="form-control"><?php echo htmlspecialchars($memo); ?></textarea>
            <?php if (isset($errors['memo']) &&  $errors['memo'] === "blank") { ?>
              <p class="errorMessage">内容をご記入ください</p>
            <?php } ?>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary">送信する</button>
          </div>

        </form>

      </div><!-- /.col -->
    </div><!-- /.row -->

  </div><!-- /.container -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>