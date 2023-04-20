<?php
$my_nonce = wp_verify_nonce( $_POST['reservationField'], 'reservationAction' );
if (!$my_nonce){ header('Location: ' . home_url()); }
get_header();
$year = isset($_POST['selectYear']) ? $_POST['selectYear'] : "";
$month = isset($_POST['selectMonth']) ? $_POST['selectMonth'] : "";
$day = isset($_POST['selectDay']) ? $_POST['selectDay'] : "";
$thisDay = $year . "年" . $month . "月" . $day . "日"; 
$title = isset($_POST['plan']) ? $_POST['plan'] : "";
$name = isset($_POST['yourName']) ? $_POST['yourName'] : "";
$tel = isset($_POST['yourTel']) ? $_POST['yourTel'] : "";
$mail = isset($_POST['yourMail']) ? $_POST['yourMail'] : "";
$startTime = isset($_POST['startTime']) ? $_POST['startTime'] : "";
$endTime = isset($_POST['endTime']) ? $_POST['endTime'] : "";
$memo = isset($_POST['memo']) ? $_POST['memo'] : "";
$memo = nl2br($memo);
?>
<section class="thanks">
  <div class="container text-center">
    <h2 class="mb-4">ご予約情報を送信しました</h2>
    <p class="mb-4">担当者からの連絡を持って予約完了となりますので、<br class="d-inline d-sm-none" />しばらくお待ち下さい</p>
    <div class="card">
      <div class="card-header bg-wine">送信内容</div>
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
            <th>電話</th><td><?php echo $tel; ?></td>
          </tr>
          <tr>
            <th>メール</th><td><?php echo $mail; ?></td>
          </tr>
          <tr>
            <th>備考</th><td><?php echo $memo; ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="mt-5">
    	<a href="<?php echo home_url(); ?>/" class="btn btn-secondary">最初に戻る</a>
    </div>
  </div>
</section>

<script>localStorage.clear();</script>

<?php get_footer(); ?>