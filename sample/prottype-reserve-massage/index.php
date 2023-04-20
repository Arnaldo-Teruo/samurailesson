<?php get_header(); ?>

<section class="index">
	<div class="container">
    <div class="bannerIndex">
    	<a href="<?php echo home_url(); ?>/timetable/">
    		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/bannar-reserve.png" alt="ご予約はこちらから">
    	</a>
    </div>
    <div class="text-center mt-5">
    	<a href="<?php echo home_url(); ?>/schedule/" class="btn btn-secondary">カレンダータイプへ</a>
    </div>
	</div>
</section>

<?php get_footer(); ?>