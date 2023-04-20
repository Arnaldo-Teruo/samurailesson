<?php get_header(); ?>
<div class="container">
	<h1 class="text-center">エラーが発生しました</h1>
	<h2 class="text-center">以下のトラブルがありえます</h2>
	<ul>
		<li>管理者へのメール送信エラー</li>
		<li>お客様へのメール送信エラー</li>
		<li>予約登録エラー</li>
		<li>不正送信</li>
	</ul>
  <div class="text-center mt-5">
  	<a href="<?php echo home_url(); ?>/" class="btn btn-danger">最初に戻る</a>
  </div>
</div>
<?php get_footer(); ?>