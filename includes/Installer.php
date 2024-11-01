<?php

namespace WP_PUBG;

/**
 * Installer class
 */
class Installer {

    /**
     * Run the installer
     *
     * @return void
     */
    public function run() {
        $this->add_version();
        $this->create_tables();
    }

    /**
     * Add time and version on DB
     */
    public function add_version() {
        $installed = get_option( 'wp_pubg_installed' );

        if ( ! $installed ) {
            update_option( 'wp_pubg_installed', time() );
        }

        update_option( 'wp_pubg_version', WP_PUBG_VERSION );
    }

    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}pubg_settings` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `api` varchar(1200) NOT NULL DEFAULT '',
          `region` varchar(255) NOT NULL DEFAULT '',
          `username` varchar(255) NOT NULL DEFAULT '',
          `platform` varchar(255) NOT NULL DEFAULT '',
          `created_at` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) $charset_collate";

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
    }
}
