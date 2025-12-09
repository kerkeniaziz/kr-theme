<?php
/**
 * KR Elementor Compatibility
 * 
 * Handles Elementor integration following Astra's proven patterns
 *
 * @package KR_Theme
 * @since 1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'KR_Elementor' ) ) {

	/**
	 * KR_Elementor class
	 */
	final class KR_Elementor {

		/**
		 * Instance
		 */
		private static $instance = null;

		/**
		 * Get Instance
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		private function __construct() {
			$this->init_hooks();
		}

		/**
		 * Initialize hooks
		 */
		private function init_hooks() {
			// Register Elementor locations
			add_action( 'elementor/theme/register_locations', array( $this, 'register_locations' ) );
			
			// Elementor content width
			add_filter( 'elementor/page/content_width', array( $this, 'content_width' ) );
			
			// Canvas template
			add_filter( 'template_include', array( $this, 'canvas_template' ), 999 );
			
			// Body classes
			add_filter( 'body_class', array( $this, 'body_classes' ) );
			
			// Remove theme CSS on Elementor canvas
			add_action( 'wp_enqueue_scripts', array( $this, 'canvas_styles' ), 999 );
			
			// Register Elementor widgets
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
			
			// Add theme colors to Elementor
			add_action( 'elementor/init', array( $this, 'add_theme_colors' ) );
		}

		/**
		 * Register theme locations for Elementor Pro
		 */
		public function register_locations( $elementor_theme_manager ) {
			$elementor_theme_manager->register_location(
				'header',
				array(
					'hook'         => 'kr_header',
					'remove_hooks' => array( 'kr_header_markup' ),
				)
			);

			$elementor_theme_manager->register_location(
				'footer',
				array(
					'hook'         => 'kr_footer',
					'remove_hooks' => array( 'kr_footer_markup' ),
				)
			);
		}

		/**
		 * Set Elementor content width
		 */
		public function content_width() {
			$container_width = get_theme_mod( 'container_width', 1200 );
			return $container_width;
		}

		/**
		 * Elementor Canvas template
		 */
		public function canvas_template( $template ) {
			if ( ! class_exists( 'Elementor\Plugin' ) ) {
				return $template;
			}

			$elementor_page = get_post_meta( get_the_ID(), '_elementor_edit_mode', true );
			$page_template = get_page_template_slug();

			if ( 'elementor_canvas' === $page_template && $elementor_page ) {
				$template = locate_template( array( 'elementor-canvas.php' ) );
				
				if ( ! $template ) {
					$template = $this->get_canvas_template();
				}
			}

			return $template;
		}

		/**
		 * Get Elementor canvas template content
		 */
		private function get_canvas_template() {
			$canvas_template = KR_THEME_DIR . '/templates/elementor-canvas.php';
			
			if ( ! file_exists( $canvas_template ) ) {
				// Create inline canvas template
				return $this->create_inline_canvas_template();
			}
			
			return $canvas_template;
		}

		/**
		 * Create inline canvas template
		 */
		private function create_inline_canvas_template() {
			return '<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( "charset" ); ?>">
	<?php if ( ! current_theme_supports( "title-tag" ) ) : ?>
		<title><?php echo wp_get_document_title(); ?></title>
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<main id="main" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="page-content">
					<?php the_content(); ?>
				</div>
			<?php endwhile; ?>
		</main>
	</div>
	<?php wp_footer(); ?>
</body>
</html>';
		}

		/**
		 * Add Elementor body classes
		 */
		public function body_classes( $classes ) {
			if ( ! class_exists( 'Elementor\Plugin' ) ) {
				return $classes;
			}

			$page_id = get_the_ID();
			
			if ( ! $page_id ) {
				return $classes;
			}

			// Check if page is built with Elementor
			if ( \Elementor\Plugin::$instance->documents->get( $page_id )->is_built_with_elementor() ) {
				$classes[] = 'elementor-page';
			}

			// Elementor preview mode
			if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
				$classes[] = 'elementor-preview-mode';
			}

			// Elementor canvas template
			$page_template = get_page_template_slug( $page_id );
			if ( 'elementor_canvas' === $page_template ) {
				$classes[] = 'elementor-template-canvas';
				$classes[] = 'page-template-elementor_canvas';
			}

			return $classes;
		}

		/**
		 * Remove theme styles on Elementor canvas
		 */
		public function canvas_styles() {
			if ( ! class_exists( 'Elementor\Plugin' ) ) {
				return;
			}

			$page_template = get_page_template_slug();
			
			if ( 'elementor_canvas' === $page_template ) {
				// Remove theme CSS on canvas pages
				wp_dequeue_style( 'kr-theme-style' );
				
				// Add minimal canvas CSS
				wp_add_inline_style( 'elementor-frontend', '
					body.elementor-template-canvas { margin: 0; padding: 0; }
					.elementor-template-canvas .site { margin: 0; }
					.elementor-template-canvas .site-main { margin: 0; padding: 0; }
				' );
			}
		}

		/**
		 * Register custom Elementor widgets
		 */
		public function register_widgets( $widgets_manager ) {
			// Add custom widgets here if needed
			// Example:
			// require_once KR_THEME_DIR . '/inc/elementor-widgets/class-kr-widget.php';
			// $widgets_manager->register_widget_type( new KR_Widget() );
		}

		/**
		 * Add theme colors to Elementor
		 */
		public function add_theme_colors() {
			if ( ! class_exists( 'Elementor\Core\Kits\Documents\Tabs\Global_Colors' ) ) {
				return;
			}

			// Get theme colors
			$primary_color = get_theme_mod( 'primary_color', '#3b82f6' );
			$text_color = get_theme_mod( 'text_color', '#374151' );
			$link_color = get_theme_mod( 'link_color', '#3b82f6' );

			// Add to Elementor global colors
			add_filter( 'elementor/kits/global_colors', function( $global_colors ) use ( $primary_color, $text_color, $link_color ) {
				$global_colors['kr_primary'] = array(
					'title' => __( 'KR Primary', 'kr-theme' ),
					'color' => $primary_color,
				);
				
				$global_colors['kr_text'] = array(
					'title' => __( 'KR Text', 'kr-theme' ),
					'color' => $text_color,
				);
				
				$global_colors['kr_accent'] = array(
					'title' => __( 'KR Accent', 'kr-theme' ),
					'color' => $link_color,
				);

				return $global_colors;
			} );
		}

		/**
		 * Get Elementor page settings
		 */
		public static function get_page_settings( $page_id = null ) {
			if ( ! class_exists( 'Elementor\Plugin' ) ) {
				return array();
			}

			if ( ! $page_id ) {
				$page_id = get_the_ID();
			}

			$document = \Elementor\Plugin::$instance->documents->get( $page_id );
			
			if ( ! $document ) {
				return array();
			}

			return $document->get_settings();
		}

		/**
		 * Check if Elementor is active and page is built with it
		 */
		public static function is_elementor_page( $page_id = null ) {
			if ( ! class_exists( 'Elementor\Plugin' ) ) {
				return false;
			}

			if ( ! $page_id ) {
				$page_id = get_the_ID();
			}

			if ( ! $page_id ) {
				return false;
			}

			return \Elementor\Plugin::$instance->documents->get( $page_id )->is_built_with_elementor();
		}

		/**
		 * Get Elementor content
		 */
		public static function get_content( $page_id = null ) {
			if ( ! self::is_elementor_page( $page_id ) ) {
				return '';
			}

			if ( ! $page_id ) {
				$page_id = get_the_ID();
			}

			return \Elementor\Plugin::$instance->frontend->get_builder_content( $page_id, true );
		}
	}
}