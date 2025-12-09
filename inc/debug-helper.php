<?php
/**
 * KR Theme Debug Helper
 * 
 * Comprehensive debugging and error tracking system
 * for both KR Theme and KR Toolkit compatibility issues.
 *
 * @package KR_Theme
 * @since 1.2.5
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KR Debug Helper Class
 * 
 * Provides debugging tools, error tracking, and system diagnostics
 */
class KR_Debug_Helper {
    
    private static $debug_log = array();
    private static $performance_markers = array();
    
    /**
     * Initialize debug helper
     */
    public static function init() {
        if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
            return;
        }
        
        // Add debug actions
        add_action( 'wp_footer', array( __CLASS__, 'output_debug_info' ) );
        add_action( 'admin_footer', array( __CLASS__, 'output_debug_info' ) );
        add_action( 'wp_ajax_kr_get_debug_report', array( __CLASS__, 'ajax_get_debug_report' ) );
        
        // Start performance tracking
        self::start_performance_tracking();
    }
    
    /**
     * Log debug message with context
     */
    public static function log( $message, $context = 'general', $level = 'info' ) {
        if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
            return;
        }
        
        $log_entry = array(
            'timestamp' => microtime( true ),
            'message' => $message,
            'context' => $context,
            'level' => $level,
            'memory' => memory_get_usage( true ),
            'backtrace' => wp_debug_backtrace_summary()
        );
        
        self::$debug_log[] = $log_entry;
        
        // Also log to WordPress error log
        error_log( sprintf( 
            'KR Debug [%s][%s]: %s', 
            strtoupper( $level ), 
            $context, 
            $message 
        ) );
    }
    
    /**
     * Log performance marker
     */
    public static function mark_performance( $marker_name, $description = '' ) {
        if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
            return;
        }
        
        self::$performance_markers[ $marker_name ] = array(
            'timestamp' => microtime( true ),
            'memory' => memory_get_usage( true ),
            'description' => $description
        );
    }
    
    /**
     * Get system compatibility report
     */
    public static function get_system_report() {
        global $wp_version, $wpdb;
        
        // Get theme info
        $theme = wp_get_theme();
        $parent_theme = $theme->parent();
        
        // Get plugin info
        $active_plugins = get_option( 'active_plugins', array() );
        $all_plugins = get_plugins();
        
        // Get server info
        $upload_dir = wp_upload_dir();
        
        $report = array(
            'timestamp' => current_time( 'Y-m-d H:i:s T' ),
            'site_info' => array(
                'site_url' => site_url(),
                'home_url' => home_url(),
                'wp_version' => $wp_version,
                'is_multisite' => is_multisite(),
                'language' => get_locale(),
                'timezone' => wp_timezone_string(),
            ),
            'theme_info' => array(
                'name' => $theme->get( 'Name' ),
                'version' => $theme->get( 'Version' ),
                'template' => $theme->get_template(),
                'stylesheet' => $theme->get_stylesheet(),
                'parent_theme' => $parent_theme ? $parent_theme->get( 'Name' ) : 'None',
                'theme_root' => get_theme_root(),
            ),
            'server_info' => array(
                'php_version' => PHP_VERSION,
                'php_sapi' => php_sapi_name(),
                'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
                'memory_limit' => ini_get( 'memory_limit' ),
                'max_execution_time' => ini_get( 'max_execution_time' ),
                'upload_max_filesize' => ini_get( 'upload_max_filesize' ),
                'post_max_size' => ini_get( 'post_max_size' ),
                'max_input_vars' => ini_get( 'max_input_vars' ),
                'memory_usage' => size_format( memory_get_usage( true ) ),
                'memory_peak' => size_format( memory_get_peak_usage( true ) ),
            ),
            'database_info' => array(
                'version' => $wpdb->db_version(),
                'charset' => $wpdb->charset,
                'collate' => $wpdb->collate,
                'prefix' => $wpdb->prefix,
            ),
            'filesystem_info' => array(
                'wp_upload_dir' => $upload_dir['basedir'],
                'wp_upload_url' => $upload_dir['baseurl'],
                'wp_content_dir' => WP_CONTENT_DIR,
                'wp_content_url' => WP_CONTENT_URL,
                'theme_dir_writable' => is_writable( get_template_directory() ),
                'upload_dir_writable' => is_writable( $upload_dir['basedir'] ),
            ),
            'plugin_info' => array(
                'active_plugins_count' => count( $active_plugins ),
                'total_plugins_count' => count( $all_plugins ),
                'active_plugins' => array(),
                'kr_toolkit_active' => false,
                'kr_toolkit_version' => 'Not installed',
            ),
            'extensions_info' => array(
                'curl' => extension_loaded( 'curl' ),
                'json' => extension_loaded( 'json' ),
                'mbstring' => extension_loaded( 'mbstring' ),
                'openssl' => extension_loaded( 'openssl' ),
                'zip' => extension_loaded( 'zip' ),
                'xml' => extension_loaded( 'xml' ),
                'simplexml' => extension_loaded( 'simplexml' ),
                'dom' => extension_loaded( 'dom' ),
            ),
            'constants_info' => array(
                'WP_DEBUG' => defined( 'WP_DEBUG' ) && WP_DEBUG,
                'WP_DEBUG_LOG' => defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG,
                'WP_DEBUG_DISPLAY' => defined( 'WP_DEBUG_DISPLAY' ) && WP_DEBUG_DISPLAY,
                'SCRIPT_DEBUG' => defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG,
                'WP_CACHE' => defined( 'WP_CACHE' ) && WP_CACHE,
                'CONCATENATE_SCRIPTS' => defined( 'CONCATENATE_SCRIPTS' ) && CONCATENATE_SCRIPTS,
            ),
        );
        
        // Add active plugins details
        foreach ( $active_plugins as $plugin_file ) {
            if ( isset( $all_plugins[ $plugin_file ] ) ) {
                $plugin_data = $all_plugins[ $plugin_file ];
                $report['plugin_info']['active_plugins'][] = array(
                    'name' => $plugin_data['Name'],
                    'version' => $plugin_data['Version'],
                    'file' => $plugin_file,
                );
                
                // Check for KR Toolkit
                if ( strpos( $plugin_file, 'kr-toolkit' ) !== false ) {
                    $report['plugin_info']['kr_toolkit_active'] = true;
                    $report['plugin_info']['kr_toolkit_version'] = $plugin_data['Version'];
                }
            }
        }
        
        // Add compatibility checks
        if ( class_exists( 'KR_Theme_Compatibility' ) ) {
            $theme_compatibility = KR_Theme_Compatibility::get_compatibility_report();
            $report['theme_compatibility'] = $theme_compatibility;
        }
        
        if ( class_exists( 'KR_Toolkit_Compatibility' ) ) {
            $plugin_compatibility = KR_Toolkit_Compatibility::get_compatibility_report();
            $report['plugin_compatibility'] = $plugin_compatibility;
        }
        
        // Add debug log
        $report['debug_log'] = self::$debug_log;
        $report['performance_markers'] = self::$performance_markers;
        
        return $report;
    }
    
    /**
     * Start performance tracking
     */
    private static function start_performance_tracking() {
        self::mark_performance( 'theme_init', 'Theme initialization started' );
        
        add_action( 'wp_loaded', function() {
            self::mark_performance( 'wp_loaded', 'WordPress fully loaded' );
        });
        
        add_action( 'wp_head', function() {
            self::mark_performance( 'wp_head_start', 'wp_head action started' );
        }, 1 );
        
        add_action( 'wp_head', function() {
            self::mark_performance( 'wp_head_end', 'wp_head action completed' );
        }, 999 );
        
        add_action( 'wp_footer', function() {
            self::mark_performance( 'wp_footer', 'Footer rendering started' );
        }, 1 );
    }
    
    /**
     * Output debug info in HTML comments (only for admins)
     */
    public static function output_debug_info() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        
        $performance_summary = self::get_performance_summary();
        
        echo "\n<!-- KR Debug Info -->\n";
        echo "<!-- Memory Usage: " . size_format( memory_get_usage( true ) ) . " -->\n";
        echo "<!-- Memory Peak: " . size_format( memory_get_peak_usage( true ) ) . " -->\n";
        echo "<!-- Debug Log Entries: " . count( self::$debug_log ) . " -->\n";
        echo "<!-- Performance Markers: " . count( self::$performance_markers ) . " -->\n";
        
        if ( ! empty( $performance_summary ) ) {
            echo "<!-- Performance Summary: " . esc_html( wp_json_encode( $performance_summary ) ) . " -->\n";
        }
        
        echo "<!-- End KR Debug Info -->\n";
    }
    
    /**
     * Get performance summary
     */
    private static function get_performance_summary() {
        if ( empty( self::$performance_markers ) ) {
            return array();
        }
        
        $markers = self::$performance_markers;
        $summary = array();
        
        $first_marker = reset( $markers );
        $last_marker = end( $markers );
        
        $summary['total_time'] = round( ( $last_marker['timestamp'] - $first_marker['timestamp'] ) * 1000, 2 ) . 'ms';
        $summary['memory_increase'] = size_format( $last_marker['memory'] - $first_marker['memory'] );
        $summary['markers_count'] = count( $markers );
        
        return $summary;
    }
    
    /**
     * AJAX handler for debug report
     */
    public static function ajax_get_debug_report() {
        // Verify nonce and permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Insufficient permissions' );
        }
        
        check_ajax_referer( 'kr_debug_nonce', 'nonce' );
        
        $report = self::get_system_report();
        
        wp_send_json_success( $report );
    }
    
    /**
     * Export debug report as downloadable file
     */
    public static function export_debug_report() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return false;
        }
        
        $report = self::get_system_report();
        $filename = 'kr-debug-report-' . date( 'Y-m-d-H-i-s' ) . '.json';
        
        header( 'Content-Type: application/json' );
        header( 'Content-Disposition: attachment; filename=' . $filename );
        header( 'Content-Length: ' . strlen( wp_json_encode( $report, JSON_PRETTY_PRINT ) ) );
        
        echo wp_json_encode( $report, JSON_PRETTY_PRINT );
        exit;
    }
    
    /**
     * Check for common issues and provide solutions
     */
    public static function get_common_issues_check() {
        $issues = array();
        
        // Check memory limit
        $memory_limit = wp_convert_hr_to_bytes( ini_get( 'memory_limit' ) );
        if ( $memory_limit < 64 * 1024 * 1024 && $memory_limit > 0 ) {
            $issues[] = array(
                'type' => 'memory_limit',
                'severity' => 'warning',
                'message' => 'Memory limit is below 64MB',
                'solution' => 'Increase memory_limit in php.ini or contact hosting provider'
            );
        }
        
        // Check PHP version
        if ( version_compare( PHP_VERSION, '7.4', '<' ) ) {
            $issues[] = array(
                'type' => 'php_version',
                'severity' => 'error',
                'message' => 'PHP version is below 7.4',
                'solution' => 'Update PHP to version 7.4 or higher'
            );
        }
        
        // Check WordPress version
        global $wp_version;
        if ( version_compare( $wp_version, '6.0', '<' ) ) {
            $issues[] = array(
                'type' => 'wp_version',
                'severity' => 'warning',
                'message' => 'WordPress version is below 6.0',
                'solution' => 'Update WordPress to the latest version'
            );
        }
        
        // Check file permissions
        $upload_dir = wp_upload_dir();
        if ( ! is_writable( $upload_dir['basedir'] ) ) {
            $issues[] = array(
                'type' => 'file_permissions',
                'severity' => 'error',
                'message' => 'Uploads directory is not writable',
                'solution' => 'Set correct file permissions (755 for directories, 644 for files)'
            );
        }
        
        // Check required extensions
        $required_extensions = array( 'json', 'mbstring', 'openssl', 'curl' );
        foreach ( $required_extensions as $extension ) {
            if ( ! extension_loaded( $extension ) ) {
                $issues[] = array(
                    'type' => 'missing_extension',
                    'severity' => 'error',
                    'message' => "Required PHP extension '{$extension}' is not loaded",
                    'solution' => "Install and enable the {$extension} PHP extension"
                );
            }
        }
        
        return $issues;
    }
    
    /**
     * Add debug menu to admin bar (for admins only)
     */
    public static function add_debug_admin_bar_menu( $wp_admin_bar ) {
        if ( ! current_user_can( 'manage_options' ) || ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
            return;
        }
        
        $issues = self::get_common_issues_check();
        $error_count = count( array_filter( $issues, function( $issue ) {
            return $issue['severity'] === 'error';
        } ) );
        
        $title = 'KR Debug';
        if ( $error_count > 0 ) {
            $title .= ' (' . $error_count . ' errors)';
        }
        
        $wp_admin_bar->add_node( array(
            'id' => 'kr-debug',
            'title' => $title,
            'href' => admin_url( 'admin.php?page=kr-debug' ),
            'meta' => array(
                'class' => $error_count > 0 ? 'kr-debug-errors' : 'kr-debug-ok',
            ),
        ) );
        
        // Add submenu items
        $wp_admin_bar->add_node( array(
            'parent' => 'kr-debug',
            'id' => 'kr-debug-report',
            'title' => 'System Report',
            'href' => admin_url( 'admin.php?page=kr-debug&tab=report' ),
        ) );
        
        $wp_admin_bar->add_node( array(
            'parent' => 'kr-debug',
            'id' => 'kr-debug-performance',
            'title' => 'Performance',
            'href' => admin_url( 'admin.php?page=kr-debug&tab=performance' ),
        ) );
        
        if ( $error_count > 0 ) {
            $wp_admin_bar->add_node( array(
                'parent' => 'kr-debug',
                'id' => 'kr-debug-issues',
                'title' => 'Issues (' . $error_count . ')',
                'href' => admin_url( 'admin.php?page=kr-debug&tab=issues' ),
            ) );
        }
    }
}

// Initialize debug helper if WP_DEBUG is enabled
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    KR_Debug_Helper::init();
    add_action( 'admin_bar_menu', array( 'KR_Debug_Helper', 'add_debug_admin_bar_menu' ), 999 );
}