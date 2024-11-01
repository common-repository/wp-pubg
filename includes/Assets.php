<?php

namespace WP_PUBG;

/**
 * Assets handlers class
 */
class Assets {

    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function get_scripts() {
        return [
            'wp-pubg-frontend-script' => [
                'src'     => WP_PUBG_ASSETS . '/js/frontend.js',
                'version' => filemtime( WP_PUBG_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            
        ];
    }

    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles() {
        return [
            'wp-pubg-frontend-style' => [
                'src'     => WP_PUBG_ASSETS . '/css/frontend.css',
                'version' => filemtime( WP_PUBG_PATH . '/assets/css/frontend.css' )
            ],
           
        ];
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets() {
        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;

            wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }

        wp_localize_script( 'wp-pubg-admin-script', 'wp_pubg_object', [
            'nonce' => wp_create_nonce( 'wp-pubg-admin-nonce' ),
            'confirm' => __( 'Are you sure?', 'wp-pubg' ),
            'error' => __( 'Something went wrong', 'wp-pubg' ),
        ] );
    }
}
