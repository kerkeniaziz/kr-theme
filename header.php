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

<!-- KR Header Builder Support -->
<header id="masthead" class="site-header">
	<?php 
		// Check if header builder is available and has a default header
		if ( class_exists( 'KR_Header_Footer_Builder' ) ) {
			$header_id = KR_Header_Footer_Builder::get_default_header_id();
			if ( $header_id ) {
				// Display custom header from builder
				echo wp_kses_post( KR_Header_Footer_Builder::get_header( $header_id ) );
			} else {
				// Fallback to default theme header
				kr_theme_default_header();
			}
		} else {
			// Fallback if builder not available
			kr_theme_default_header();
		}
	?>
</header><!-- #masthead -->

<?php kr_theme_after_header(); ?>
