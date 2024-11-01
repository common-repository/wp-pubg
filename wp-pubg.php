<?php
/**
 * Plugin Name: wp pubg
 * Description: A plugin for showing pubg stats
 * Plugin URI: https://srxwebdesign.com
 * Author: srx webdesign
 * Author URI: https://srxwebdesign.com
 * Version: 1.0.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class WP_PUBG {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0.0';

    /**
     * Class construcotr
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes a singleton instance
     *
     * @return \WP_PUBG
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'WP_PUBG_VERSION', self::version );
        define( 'WP_PUBG_FILE', __FILE__ );
        define( 'WP_PUBG_PATH', __DIR__ );
        define( 'WP_PUBG_URL', plugins_url( '', WP_PUBG_FILE ) );
        define( 'WP_PUBG_ASSETS', WP_PUBG_URL . '/assets' );
        define( 'WP_PUBG_PLUGIN_DIR', plugin_basename( __FILE__ ) );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new WP_PUBG\Assets();

        if ( is_admin() ) {
            new WP_PUBG\Admin();
        } else {
            new WP_PUBG\Frontend();
        }

    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new WP_PUBG\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 *
 * @return \WP_PUBG
 */
function wp_pubg() {
    return WP_PUBG::init();
}

// kick-off the plugin
wp_pubg();
