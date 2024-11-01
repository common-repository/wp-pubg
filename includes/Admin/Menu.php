<?php

namespace WP_PUBG\Admin;

/**
 * The Menu handler class
 */
class Menu {

    public $settings;
   
    /**
     * Initialize the class
     */
    function __construct( $settings) {
        $this->settings = $settings;
        $plugin = WP_PUBG_PLUGIN_DIR; 

        add_action( 'admin_menu', [ $this, 'admin_menu' ] );

        add_filter("plugin_action_links_$plugin", array($this, 'setting_links'));
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() {
        $parent_slug = 'wp-pubg-settings';
        $capability = 'manage_options';

        $plugin_logo=WP_PUBG_ASSETS.'/img/logo.png';

        $hook = add_menu_page( __( 'WP PUBG', 'wp-pubg' ), __( 'WP PUBG', 'wp-pubg' ), $capability, $parent_slug, [ $this->settings, 'settings_page' ], $plugin_logo );
        add_submenu_page( $parent_slug, __( 'Settings', 'wp-pubg' ), __( 'Settings', 'wp-pubg' ), $capability, $parent_slug, [ $this->settings, 'settings_page' ] );
        
    }

    /**
     * Show settings links
     */
    function setting_links($links){
        $setting_link='<a href="admin.php?page=wp-pubg-settings">Settings</a>';
        array_push($links,$setting_link);
        return $links;
    }


}
