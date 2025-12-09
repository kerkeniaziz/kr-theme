<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'kr-theme' ); ?></a>

<?php kr_theme_before_header(); ?>

<header id="masthead" class="site-header">
	<div class="kr-container">
		<div class="header-inner">
			<?php get_template_part( 'template-parts/header/site-branding' ); ?>
			<?php get_template_part( 'template-parts/header/navigation' ); ?>
		</div>
	</div>
</header><!-- #masthead -->

<?php kr_theme_after_header(); ?>
