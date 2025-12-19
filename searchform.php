<?php
/**
 * Search Form Template
 *
 * @package KR_Theme
 * @since 1.0.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html__( 'Search for:', 'kr-theme' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr__( 'Search...', 'kr-theme' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="search-submit"><span><?php echo esc_html__( 'Search', 'kr-theme' ); ?></span></button>
</form>
