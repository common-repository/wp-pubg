<?php


/**
 * Insert settings
 *
 * @param  array  $args
 *
 * @return int|WP_Error
 */
function wp_pubg_insert_settings($args = [])
{
    global $wpdb;

    $defaults = [
        'api'       => '',
        'region'    => '',
        'platform'  => '',
        'username'  => '',
        'created_at' => current_time( 'mysql' ),
    ];

    $data = wp_parse_args( $args, $defaults );

    $results = $wpdb->get_results ( "SELECT * FROM {$wpdb->prefix}pubg_settings" );

    // update data
    if(count($results)>0){
        
        $updated = $wpdb->update(
            $wpdb->prefix . 'pubg_settings',
            $data,
            [ 'id' => $results[0]->id ],
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            ],
            [ '%d' ]
        );

        return $updated;
    }
    else{

        $inserted = $wpdb->insert(
            $wpdb->prefix . 'pubg_settings',
            $data,
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            ]
        );
    
        if ( ! $inserted ) {
            return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'wp-pubg' ) );
        }

        return $wpdb->insert_id;
    }

    
}
