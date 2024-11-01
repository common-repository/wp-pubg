<div class="wrap">
    <h1><?php _e( 'Settings', 'wp-pubg' ); ?></h1>

    <?php if ( isset( $_GET['settings-updated'] ) ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Settings saved successfully!', 'wp-pubg' ); ?></p>
        </div>
    <?php } ?>
   
    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row<?php echo $this->has_error( 'api' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="api"><?php _e( 'PUBG API', 'wp-pubg' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="api" id="api" class="regular-text" value="<?php echo $api;?>">
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'region' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="region"><?php _e( 'Region', 'wp-pubg' ); ?></label>
                    </th>
                    <td>
                        <select name="region" id="region">
                            <option value="pc-as" <?php selected( $region, 'pc-as' ); ?>>pc-as</option>
                            <option value="pc-eu" <?php selected( $region, 'pc-eu' ); ?>>pc-eu</option>
                            <option value="pc-jp" <?php selected( $region, 'pc-jp' ); ?>>pc-jp</option>
                            <option value="pc-krjp" <?php selected( $region, 'pc-krjp' ); ?>>pc-krjp</option>
                            <option value="pc-kakao" <?php selected( $region, 'pc-kakao' ); ?>>pc-kakao</option>
                            <option value="pc-na" <?php selected( $region, 'pc-na' ); ?>>pc-na</option>
                            <option value="pc-oc" <?php selected( $region, 'pc-oc' ); ?>>pc-oc</option>
                            <option value="pc-ru" <?php selected( $region, 'pc-ru' ); ?>>pc-ru</option>
                            <option value="pc-sa" <?php selected( $region, 'pc-sa' ); ?>>pc-sa</option>
                            <option value="pc-sea" <?php selected( $region, 'pc-sea' ); ?>>pc-sea</option>
                            <option value="psn-as" <?php selected( $region, 'psn-as' ); ?>>psn-as</option>
                            <option value="psn-eu" <?php selected( $region, 'psn-eu' ); ?>>psn-eu</option>
                            <option value="psn-na" <?php selected( $region, 'psn-na' ); ?>>psn-na</option>
                            <option value="psn-oc" <?php selected( $region, 'psn-oc' ); ?>>psn-oc</option>
                            <option value="xbox-as" <?php selected( $region, 'xbox-as' ); ?>>xbox-as</option>
                            <option value="xbox-eu" <?php selected( $region, 'xbox-eu' ); ?>>xbox-eu</option>
                            <option value="xbox-na" <?php selected( $region, 'xbox-na' ); ?>>xbox-na</option>
                            <option value="xbox-oc" <?php selected( $region, 'xbox-oc' ); ?>>xbox-oc</option>
                            <option value="xbox-sa" <?php selected( $region, 'xbox-sa' ); ?>>xbox-sa</option>
                        </select>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'platform' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="platform"><?php _e( 'Platform', 'wp-pubg' ); ?></label>
                    </th>
                    <td>
                        <select name="platform" id="platform">
                            <option value="steam" <?php selected( $platform, 'steam' ); ?>>steam</option>
                            <option value="psn" <?php selected( $platform, 'psn' ); ?>>psn</option>
                            <option value="stadia" <?php selected( $platform, 'stadia' ); ?>>stadia</option>
                            <option value="xbox" <?php selected( $platform, 'xbox' ); ?>>xbox</option>
                            <option value="kakao" <?php selected( $platform, 'kakao' ); ?>>kakao</option>
                        </select>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'region' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="username"><?php _e( 'Username', 'wp-pubg' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="username" id="username" class="regular-text" value="<?php echo $username;?>">
                    </td>
                </tr>
            </tbody>
        </table>

        <?php  wp_nonce_field( 'wp-pubg-settings-nonce' ); ?>                    
        
        <?php submit_button( __( 'Save settings', 'wp-pubg' ), 'primary', 'submit_settings' ); ?>
    </form>

    <p>Use <button>[wp-pubg]</button> to show the stat</p>
</div>
