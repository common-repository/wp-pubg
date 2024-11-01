<?php

namespace WP_PUBG\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initializes the class
     */
    function __construct() {
        add_shortcode( 'wp-pubg', [ $this, 'render_shortcode' ] );
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_shortcode( $atts, $content = '' ) {
        wp_enqueue_script( 'wp-pubg-frontend-script' );
        wp_enqueue_style( 'wp-pubg-frontend-style' );

        $template = __DIR__ . '/views/shortcode.php';
                
        if ( file_exists( $template ) ) {
            ob_start();

            global $wpdb;
            $results=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}pubg_settings");

            if(count($results)>0){
                $api=esc_attr($results[0]->api);
                $region=esc_attr($results[0]->region);
                $username=esc_attr($results[0]->username);
                $platform=esc_attr($results[0]->platform);
            }
            else{
                $api=0;
                $region=0;
                $username=0;
                $platform=0;
            }

            //base url
            $base_url="https://api.pubg.com/";

            //get last season
            $last_season=$this->get_last_season_id($platform,$api);

            if($last_season != null){
                //get player id 
                $player_id=$this->get_player_id($region,$username,$api);

                //set body
                $body=1;

                if($player_id != null){

                    //set body
                    $body=1;

                    //get player rank 
                    $url=$base_url."shards/".$platform."/players/".$player_id."/seasons/".$last_season."/ranked";
                    $http_data=$this->http_headers('GET',$api);
                    $get_player_rank=wp_remote_request( $url, $http_data );

                    //Check for success
                    if(!is_wp_error($get_player_rank) && ($get_player_rank['response']['code'] == 200)) {
                        
                        //set body
                        $body=1;

                        $player_rank_body = json_decode(wp_remote_retrieve_body( $get_player_rank ));
                    
                        $squad_fpp='squad-fpp';
                        
                        $game_stat=$player_rank_body->data->attributes->rankedGameModeStats;

                        $squad_check=property_exists($game_stat, 'squad');
                        if($squad_check == true){
                            $player_squad_stat=$player_rank_body->data->attributes->rankedGameModeStats->squad;

                            //for normal
                            $player_tier=$player_squad_stat->currentTier->tier;
                            $player_subtier=$player_squad_stat->currentTier->subTier;
                            $player_rank_point=$player_squad_stat->currentRankPoint;
                            $player_games=$player_squad_stat->roundsPlayed;
                            $player_top10_ratio=$player_squad_stat->top10Ratio;
                            $player_win_ratio=$player_squad_stat->winRatio;
                            $player_kda=$player_squad_stat->kda;
                            $player_kdr=$player_squad_stat->kdr;
                            $player_most_kills=$player_squad_stat->roundMostKills;

                            $player_rank_image=$this->get_rank_image($player_tier,$player_subtier);

                        }
                        else{
                            //for normal
                            $player_tier=0;
                            $player_subtier=0;
                            $player_rank_point=0;
                            $player_games=0;
                            $player_top10_ratio=0;
                            $player_win_ratio=0;
                            $player_kda=0;
                            $player_kdr=0;
                            $player_most_kills=0;
                            $player_rank_image=WP_PUBG_ASSETS.'/img/default.png';
                        }

                        $squad_fpp_check=property_exists($game_stat, $squad_fpp);

                        if($squad_fpp_check == true){
                            $player_squad_fpp_stat=$player_rank_body->data->attributes->rankedGameModeStats->$squad_fpp;

                            //for squad fpp
                            $player_fpp_tier=$player_squad_fpp_stat->currentTier->tier;
                            $player_fpp_subtier=$player_squad_fpp_stat->currentTier->subTier;
                            $player_fpp_rank_point=$player_squad_fpp_stat->currentRankPoint;
                            $player_fpp_games=$player_squad_fpp_stat->roundsPlayed;
                            $player_fpp_top10_ratio=$player_squad_fpp_stat->top10Ratio;
                            $player_fpp_win_ratio=$player_squad_fpp_stat->winRatio;
                            $player_fpp_kda=$player_squad_fpp_stat->kda;
                            $player_fpp_kdr=$player_squad_fpp_stat->kdr;
                            $player_fpp_most_kills=$player_squad_fpp_stat->roundMostKills;

                            $player_fpp_rank_image=$this->get_rank_image($player_fpp_tier,$player_fpp_subtier);

                        }
                        else{
                            //for squad fpp
                            $player_fpp_tier=0;
                            $player_fpp_subtier=0;
                            $player_fpp_rank_point=0;
                            $player_fpp_games=0;
                            $player_fpp_top10_ratio=0;
                            $player_fpp_win_ratio=0;
                            $player_fpp_kda=0;
                            $player_fpp_kdr=0;
                            $player_fpp_most_kills=0;
                            $player_fpp_rank_image=WP_PUBG_ASSETS.'/img/default.png';
                        }
                        

                    }
                    else {
                        $body=0;
                    }
                }
                else{
                    $body=0;
                }
            }
            else{
                $body=0;
            }            
            
            include $template;
            $data = ob_get_contents();
            ob_end_clean();
            return $data;
        }
        
    }

    protected function get_last_season_id($platform,$api){

        //base url
        $base_url="https://api.pubg.com/";

        //get last season
        $season_url=$base_url."shards/".$platform."/seasons";

        $http_data_season=$this->http_headers('GET',$api);
        $get_seasons=wp_remote_request( $season_url, $http_data_season );

        //Check for success
        if(!is_wp_error($get_seasons) && ($get_seasons['response']['code'] == 200)) {
            $season_body = json_decode(wp_remote_retrieve_body($get_seasons));

            $seasons=$season_body->data;
           
            $last_season=$seasons[count($seasons)-1]->id;

            return $last_season;
        }
        else {
            return null;
        }

    }

    protected function get_player_id($region,$username,$api){
        //base url
        $base_url="https://api.pubg.com/";

        $player_url=$base_url."shards/".$region."/players?filter[playerNames]=".$username;
        $http_data=$this->http_headers('GET',$api);
        $get_player=wp_remote_request( $player_url, $http_data );

        //Check for success
        if(!is_wp_error($get_player) && ($get_player['response']['code'] == 200)) {
            $player_body = json_decode(wp_remote_retrieve_body( $get_player ));
            $player_id=$player_body->data[0]->id;

            return $player_id;
        }
        else {
            return null;
        }
    }

    protected function http_headers($method,$api){
        $http_data=array(
            'method'=>$method,
            'headers'=>array( 
                'Authorization'=> 'Bearer '.$api,
                'Accept'=> 'application/vnd.api+json',
            ),

        );

        return $http_data;
    }

    protected function get_rank_image($tier,$subtier){
        
        $base_url=WP_PUBG_ASSETS.'/img/pubg-img/';
        if($tier=='Master'){
            $url=$base_url."Master-min.png";
        }
        else if($tier=='Unranked'){
            $url=$base_url."Unranked-min.png";
        }
        else{
            $url=$base_url."$tier-$subtier-min.png";
        }
        return $url;
    }
}
