<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if ( !is_home() ): ?>
	<div class="container">
	  <h1>
	  	<a href="<?php echo home_url(); ?>/">
	  		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-500x200.png" alt="ロゴ" class="img-fluid">
	  	</a>
	  </h1>
	</div>
<?php endif; ?>