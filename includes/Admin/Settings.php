<?php

namespace WP_PUBG\Admin;

use WP_PUBG\Traits\Form_Error;

/**
 * Settings Handler class
 */
class Settings {

    use Form_Error;

    /**
     * Settings page handler
     *
     * @return void
     */
    public function settings_page() {
        
        global $wpdb;  
        $results = $wpdb->get_results ( "SELECT * FROM {$wpdb->prefix}pubg_settings" );

        if(count($results)>0){
            $api=esc_attr($results[0]->api);
            $region=esc_attr($results[0]->region);
            $username=esc_attr($results[0]->username);
            $platform=esc_attr($results[0]->platform);
        }
        else{
            $api='';
            $region='';
            $username='';
            $platform='';
        }

        $template = __DIR__ . '/views/settings.php';
                
        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Handle the form
     *
     * @return void
     */
    public function form_handler() {
        if ( ! isset( $_POST['submit_settings'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'wp-pubg-settings-nonce' ) ) {
            wp_die( 'Are you cheating?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you cheating?' );
        }

        $api    = isset( $_POST['api'] ) ? sanitize_text_field( $_POST['api'] ) : '';
        $region = isset( $_POST['region'] ) ? sanitize_text_field( $_POST['region'] ) : '';
        $username = isset( $_POST['username'] ) ? sanitize_text_field( $_POST['username'] ) : '';
        $platform = isset( $_POST['platform'] ) ? sanitize_text_field( $_POST['platform'] ) : '';


        if ( ! empty( $this->errors ) ) {
            return;
        }

        $args = [
            'api'    => $api,
            'region'   => $region,
            'username'   => $username,
            'platform'   => $platform,
        ];

        
        $insert_id = wp_pubg_insert_settings( $args );

        if ( is_wp_error( $insert_id ) ) {
            wp_die( $insert_id->get_error_message() );
        }

        
        $redirected_to = admin_url( 'admin.php?page=wp-pubg-settings&settings-updated=true');

        wp_redirect( $redirected_to );
        exit;
    }

    
}
