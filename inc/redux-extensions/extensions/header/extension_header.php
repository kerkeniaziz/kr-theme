<?php
/**
 * Redux Framework Header Extension
 * 
 * Custom field type for selecting headers from Header Builder
 * 
 * @package KR_Theme
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ReduxFramework_extension_Header' ) ) {

	class ReduxFramework_extension_Header extends ReduxFramework {

		protected $parent;
		protected $field_name = 'header';
		public $extension_url;
		public $extension_dir;
		public static $theInstance;

		/**
		 * Constructor
		 */
		public function __construct( $parent ) {
			$this->parent = $parent;
			
			if ( empty( $this->extension_dir ) ) {
				$this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
			}

			self::$theInstance = $this;

			// Hook to override field path
			add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array( &$this, 'overload_field_path' ) );
		}

		/**
		 * Get Instance
		 */
		public function getInstance() {
			return self::$theInstance;
		}

		/**
		 * Override Field Path
		 */
		public function overload_field_path( $field ) {
			return dirname( __FILE__ ) . '/' . $this->field_name . '/field_' . $this->field_name . '.php';
		}
	}
}
