<?php
/**
 * セッションスタート
 */
session_start();

/**
 * セッションにフォームデータがあれば代入して無ければ空配列を代入
 */
$post = isset($_SESSION['form']) ? $_SESSION['form'] : [];

/**
 * 元のセッションはもう必要ないのでクリアする
 */
$_SESSION = array();

/**
 * セッション内の各フォームデータを変数として初期化
 */
$year      = isset($post['selectYear']) ? $post['selectYear'] : "";
$month     = isset($post['selectMonth']) ? $post['selectMonth'] : "";
$day       = isset($post['selectDay']) ? $post['selectDay'] : "";
$thisDay   = $year . "年" . $month . "月" . $day . "日";
$title     = isset($post['plan']) ? $post['plan'] : "";
$startTime = isset($post['startTime']) ? $post['startTime'] : "";
$endTime   = isset($post['endTime']) ? $post['endTime'] : "";
$name      = isset($post['name']) ? $post['name'] : "";
$email     = isset($post['email']) ? $post['email'] : "";
$memo      = isset($post['memo']) ? $post['memo'] : "";
$memo      = nl2br($memo);
require_once 'functions.php';
require_once 'header.php';
?>
<section class="thanks">
  <div class="container text-center">
    <h2 class="mb-4">登録しました</h2>
    <div class="card">
      <div class="card-header bg-wine">登録内容</div>
      <div class="card-body">
        <table class="thanks table table-borderess">
          <tr>
            <th>日時</th><td><?php echo $thisDay; ?> <?php echo $startTime; ?>～<?php echo $endTime; ?></td>
          </tr>
          <tr>
            <th>メニュー</th><td><?php echo $title; ?></td>
          </tr>
          <tr>
            <th>お名前</th><td><?php echo $name; ?></td>
          </tr>
          <tr>
            <th>メールアドレス</th><td><?php echo $email; ?></td>
          </tr>
          <tr>
            <th>備考</th><td><?php echo $memo; ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="mt-5">
      <a href="index.php" class="btn btn-secondary">予約テーブルに戻る</a>
    </div>
  </div>
</section>

<?php require_once 'footer.php'; ?>