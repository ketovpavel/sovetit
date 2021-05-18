<!doctype html>
<html <?php language_attributes(); ?> <?php sovetit_the_html_classes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="format-detection" content="telephone=no"><?php 	// For Safari  ?>
	<meta http-equiv="x-rim-auto-match" content="none"><?php 	// For BlackBerry  ?>
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( is_front_page() ) : ?>
<?php // Front page ?>

<?php else: ?>
<?php // No Front page ?>

<?php endif; ?>