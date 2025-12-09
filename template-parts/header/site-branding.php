<?php
/**
 * Template part for displaying site branding
 *
 * @package KR_Theme
 * @since 1.0.0
 */

?>

<div class="site-branding">
	<?php
	if ( has_custom_logo() ) :
		the_custom_logo();
	else :
		?>
		<div class="site-identity">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif; ?>

			<?php
			$kr_description = get_bloginfo( 'description', 'display' );
			if ( $kr_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $kr_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div>
		<?php
	endif;
	?>
</div><!-- .site-branding -->
