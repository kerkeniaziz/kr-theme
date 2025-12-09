<?php
/**
 * KR Theme Functions
 *
 * @package KR_Theme
 * @author Aziz Kerkeni
 * @link https://www.kerkeniaziz.ovh/
 * @since 1.2.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ============================================
// SYSTEM COMPATIBILITY & ERROR HANDLING
// ============================================

/**
 * KR Theme Compatibility and Error Handler
 * 
 * Comprehensive system to check compatibility, handle errors,
 * and provide detailed logging for debugging purposes.
 */
class KR_Theme_Compatibility {
    
    private static $errors = array();
    private static $warnings = array();
    
    /**
     * Initialize compatibility checks
     */
    public static function init() {
        // Run all compatibility checks
        self::check_php_version();
        self::check_wordpress_version();
        self::check_required_functions();
        self::check_memory_limit();
        self::check_file_permissions();
        self::check_required_extensions();
        
        // Set up error handling
        if ( self::has_critical_errors() ) {
            add_action( 'admin_notices', array( __CLASS__, 'display_critical_errors' ) );
            add_action( 'wp_footer', array( __CLASS__, 'log_errors' ) );
        }
        
        if ( self::has_warnings() ) {
            add_action( 'admin_notices', array( __CLASS__, 'display_warnings' ) );
        }
        
        // Log all checks for debugging
        self::log_compatibility_check();
    }
    
    /**
     * Check PHP version compatibility
     */
    private static function check_php_version() {
        $required_php = '7.4';
        $current_php = PHP_VERSION;
        
        if ( version_compare( $current_php, $required_php, '<' ) ) {
            self::$errors[] = array(
                'type' => 'php_version',
                'message' => sprintf(
                    'KR Theme requires PHP %s or higher. Current version: %s',
                    $required_php,
                    $current_php
                ),
                'critical' => true
            );
        }
    }
    
    /**
     * Check WordPress version compatibility
     */
    private static function check_wordpress_version() {
        global $wp_version;
        $required_wp = '6.0';
        
        if ( version_compare( $wp_version, $required_wp, '<' ) ) {
            self::$errors[] = array(
                'type' => 'wp_version',
                'message' => sprintf(
                    'KR Theme requires WordPress %s or higher. Current version: %s',
                    $required_wp,
                    $wp_version
                ),
                'critical' => true
            );
        }
    }
    
    /**
     * Check required PHP functions
     */
    private static function check_required_functions() {
        $required_functions = array(
            'curl_init' => 'cURL extension for GitHub updates',
            'json_encode' => 'JSON extension for data processing',
            'file_get_contents' => 'File operations',
            'wp_remote_get' => 'WordPress HTTP API',
            'wp_filesystem' => 'WordPress Filesystem API'
        );
        
        foreach ( $required_functions as $function => $purpose ) {
            if ( ! function_exists( $function ) ) {
                self::$warnings[] = array(
                    'type' => 'missing_function',
                    'message' => sprintf(
                        'Function %s is not available. Required for: %s',
                        $function,
                        $purpose
                    ),
                    'critical' => false
                );
            }
        }
    }
    
    /**
     * Check memory limit
     */
    private static function check_memory_limit() {
        $memory_limit = wp_convert_hr_to_bytes( ini_get( 'memory_limit' ) );
        $required_memory = 64 * 1024 * 1024; // 64MB
        
        if ( $memory_limit < $required_memory && $memory_limit > 0 ) {
            self::$warnings[] = array(
                'type' => 'memory_limit',
                'message' => sprintf(
                    'Memory limit is %s. Recommended: 64MB or higher for optimal performance.',
                    size_format( $memory_limit )
                ),
                'critical' => false
            );
        }
    }
    
    /**
     * Check file permissions
     */
    private static function check_file_permissions() {
        $check_paths = array(
            get_template_directory() => 'Theme directory',
            wp_upload_dir()['basedir'] => 'Uploads directory'
        );
        
        foreach ( $check_paths as $path => $description ) {
            if ( ! is_readable( $path ) ) {
                self::$errors[] = array(
                    'type' => 'file_permissions',
                    'message' => sprintf(
                        '%s is not readable: %s',
                        $description,
                        $path
                    ),
                    'critical' => true
                );
            }
        }
    }
    
    /**
     * Check required PHP extensions
     */
    private static function check_required_extensions() {
        $required_extensions = array(
            'json' => 'JSON data processing',
            'mbstring' => 'Multibyte string handling',
            'openssl' => 'Secure connections for GitHub updates'
        );
        
        foreach ( $required_extensions as $extension => $purpose ) {
            if ( ! extension_loaded( $extension ) ) {
                self::$warnings[] = array(
                    'type' => 'missing_extension',
                    'message' => sprintf(
                        'PHP extension %s is not loaded. Required for: %s',
                        $extension,
                        $purpose
                    ),
                    'critical' => false
                );
            }
        }
    }
    
    /**
     * Check if there are critical errors
     */
    private static function has_critical_errors() {
        foreach ( self::$errors as $error ) {
            if ( $error['critical'] ) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Check if there are warnings
     */
    private static function has_warnings() {
        return ! empty( self::$warnings ) || ! empty( array_filter( self::$errors, function( $error ) {
            return ! $error['critical'];
        } ) );
    }
    
    /**
     * Display critical errors in admin
     */
    public static function display_critical_errors() {
        $critical_errors = array_filter( self::$errors, function( $error ) {
            return $error['critical'];
        } );
        
        if ( empty( $critical_errors ) ) {
            return;
        }
        
        echo '<div class="notice notice-error"><p><strong>KR Theme - Critical Errors:</strong></p><ul>';
        foreach ( $critical_errors as $error ) {
            echo '<li>' . esc_html( $error['message'] ) . '</li>';
        }
        echo '</ul><p>Please resolve these issues for proper theme functionality.</p></div>';
    }
    
    /**
     * Display warnings in admin
     */
    public static function display_warnings() {
        $warnings = self::$warnings;
        $non_critical_errors = array_filter( self::$errors, function( $error ) {
            return ! $error['critical'];
        } );
        
        $all_warnings = array_merge( $warnings, $non_critical_errors );
        
        if ( empty( $all_warnings ) ) {
            return;
        }
        
        echo '<div class="notice notice-warning"><p><strong>KR Theme - Recommendations:</strong></p><ul>';
        foreach ( $all_warnings as $warning ) {
            echo '<li>' . esc_html( $warning['message'] ) . '</li>';
        }
        echo '</ul><p>These are recommendations for optimal performance.</p></div>';
    }
    
    /**
     * Log compatibility check results
     */
    private static function log_compatibility_check() {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            $log_data = array(
                'timestamp' => current_time( 'Y-m-d H:i:s' ),
                'php_version' => PHP_VERSION,
                'wp_version' => get_bloginfo( 'version' ),
                'theme_version' => KR_THEME_VERSION,
                'errors' => self::$errors,
                'warnings' => self::$warnings,
                'memory_limit' => ini_get( 'memory_limit' ),
                'max_execution_time' => ini_get( 'max_execution_time' )
            );
            
            error_log( 'KR Theme Compatibility Check: ' . wp_json_encode( $log_data, JSON_PRETTY_PRINT ) );
        }
    }
    
    /**
     * Log errors to debug.log
     */
    public static function log_errors() {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG && ! empty( self::$errors ) ) {
            foreach ( self::$errors as $error ) {
                error_log( 'KR Theme Error [' . $error['type'] . ']: ' . $error['message'] );
            }
        }
    }
    
    /**
     * Get all compatibility issues for debugging
     */
    public static function get_compatibility_report() {
        return array(
            'errors' => self::$errors,
            'warnings' => self::$warnings,
            'system_info' => array(
                'php_version' => PHP_VERSION,
                'wp_version' => get_bloginfo( 'version' ),
                'theme_version' => KR_THEME_VERSION,
                'memory_limit' => ini_get( 'memory_limit' ),
                'upload_max_filesize' => ini_get( 'upload_max_filesize' ),
                'post_max_size' => ini_get( 'post_max_size' ),
                'max_execution_time' => ini_get( 'max_execution_time' )
            )
        );
    }
}

// Initialize compatibility checks
KR_Theme_Compatibility::init();

/**
 * Theme version and constants
 */
define( 'KR_THEME_VERSION', '1.2.6' );
define( 'KR_THEME_DIR', get_template_directory() );
define( 'KR_THEME_URI', get_template_directory_uri() );

// ============================================
// LOAD DEBUG HELPER (Development/Testing)
// ============================================

/**
 * Load debug helper for comprehensive error tracking and diagnostics
 * Only loads when WP_DEBUG is enabled
 */
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    kr_theme_safe_require( KR_THEME_DIR . '/inc/debug-helper.php', 'Debug Helper System' );
}

// ============================================
// SAFE FILE LOADING WITH ERROR HANDLING
// ============================================

/**
 * Safely load theme files with error handling
 */
function kr_theme_safe_require( $file_path, $description = '' ) {
    if ( ! file_exists( $file_path ) ) {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( "KR Theme: Missing file - {$description}: {$file_path}" );
        }
        return false;
    }
    
    try {
        require_once $file_path;
        return true;
    } catch ( Exception $e ) {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( "KR Theme: Error loading {$description}: " . $e->getMessage() );
        }
        return false;
    }
}

// ============================================
// GITHUB AUTO-UPDATE SYSTEM (Enhanced)
// ============================================

/**
 * Enhanced GitHub auto-update system with error handling
 */
function kr_theme_init_github_updater() {
    $updater_path = KR_THEME_DIR . '/includes/theme-update-checker/plugin-update-checker.php';
    
    if ( ! file_exists( $updater_path ) ) {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'KR Theme: Update checker library not found at: ' . $updater_path );
        }
        
        // Show admin notice about missing updater
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-info"><p>';
            echo '<strong>KR Theme:</strong> Auto-update system is not available. ';
            echo 'Please download the Plugin Update Checker library for automatic updates.';
            echo '</p></div>';
        });
        
        return false;
    }
    
    try {
        require_once $updater_path;
        
        if ( ! class_exists( 'YahnisElsts\PluginUpdateChecker\v5\PucFactory' ) ) {
            throw new Exception( 'PucFactory class not found' );
        }
        
        use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
        
        $kr_theme_update_checker = PucFactory::buildUpdateChecker(
            'https://github.com/kerkeniaziz/kr-theme',
            KR_THEME_DIR . '/style.css',
            'kr-theme'
        );
        
        $kr_theme_update_checker->setBranch('main');
        $kr_theme_update_checker->getVcsApi()->enableReleaseAssets();
        
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'KR Theme: GitHub updater initialized successfully' );
        }
        
        return true;
        
    } catch ( Exception $e ) {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'KR Theme: Failed to initialize GitHub updater: ' . $e->getMessage() );
        }
        return false;
    }
}

// Initialize GitHub updater
kr_theme_init_github_updater();

/**
 * Load theme files with enhanced error handling
 */
$theme_files = array(
    KR_THEME_DIR . '/inc/theme-setup.php' => 'Theme Setup',
    KR_THEME_DIR . '/inc/enqueue.php' => 'Asset Enqueue',
    KR_THEME_DIR . '/inc/hooks.php' => 'Custom Hooks',
    KR_THEME_DIR . '/inc/markup.php' => 'Markup Functions',
    KR_THEME_DIR . '/inc/customizer/customizer.php' => 'Customizer',
    KR_THEME_DIR . '/inc/structure/header.php' => 'Header Structure',
    KR_THEME_DIR . '/inc/structure/footer.php' => 'Footer Structure',
    KR_THEME_DIR . '/inc/structure/sidebar.php' => 'Sidebar Structure',
    KR_THEME_DIR . '/inc/structure/post.php' => 'Post Structure',
    KR_THEME_DIR . '/inc/structure/archive.php' => 'Archive Structure',
    KR_THEME_DIR . '/inc/compatibility/elementor.php' => 'Elementor Compatibility',
    KR_THEME_DIR . '/inc/compatibility/woocommerce.php' => 'WooCommerce Compatibility',
    KR_THEME_DIR . '/inc/compatibility/gutenberg.php' => 'Gutenberg Compatibility'
);

foreach ( $theme_files as $file_path => $description ) {
    kr_theme_safe_require( $file_path, $description );
}

/**
 * Initialize plugin installer with error handling
 */
if ( is_admin() ) {
    kr_theme_safe_require( KR_THEME_DIR . '/inc/plugin-installer.php', 'Plugin Installer' );
}
