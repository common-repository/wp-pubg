<div class="wrap">
  <button onclick="openRank('Solo_FPP')">Solo FPP</button>
  <button onclick="openRank('Squad_FPP')">Squad FPP</button>
</div>

<?php 
function twoDecimal($number){
    return number_format((float)$number, 2, '.', '');
}
?>
<div class="card">
    <div class="container6">
        <div id="Solo_FPP" class="type">
            <h4><?php echo $username;?></h4>
            
            <?php if ($body != 0) {?>
                <img class="rank-img" src="<?php echo $player_rank_image;?>">
                <h5><?php echo $player_tier ;?></h5>
                <p><strong>Rankpoint </strong><?php echo $player_rank_point ;?></p>
                <p><strong>Total Game </strong><?php echo $player_games ;?></p>
                <p><strong>Top10 ratio </strong><?php echo twoDecimal($player_top10_ratio*100) ;?> %</p>
                <p><strong>Win Ratio </strong><?php echo twoDecimal($player_win_ratio*100) ;?> %</p>
                <p><strong>KDA </strong><?php echo twoDecimal($player_kda) ;?></p>
                <p><strong>KDR </strong><?php echo twoDecimal($player_kdr) ;?></p>
                <p><strong>Most kills </strong><?php echo $player_most_kills ;?></p>
            <?php
                }
                else{
                    echo "No data found";  
                }   
            ?>
            
        </div>
    </div>

    <div class="container6">
        <div id="Squad_FPP" class="type" style="display: none;">
            <h4><?php echo $username;?></h4>
           
            <?php if ($body != 0) {?>
                <img class="rank-img" src="<?php echo $player_fpp_rank_image;?>">
                <h5><?php echo $player_fpp_tier ;?></h5>
                <p><strong>Rankpoint </strong><?php echo $player_fpp_rank_point ;?></p>
                <p><strong>Total Game </strong><?php echo $player_fpp_games ;?></p>
                <p><strong>Top10 ratio </strong><?php echo twoDecimal($player_fpp_top10_ratio*100) ;?> %</p>
                <p><strong>Win Ratio </strong><?php echo twoDecimal($player_fpp_win_ratio*100) ;?> %</p>
                <p><strong>KDA </strong><?php echo twoDecimal($player_fpp_kda) ;?></p>
                <p><strong>KDR </strong><?php echo twoDecimal($player_fpp_kdr) ;?></p>
                <p><strong>Most kills </strong><?php echo $player_fpp_most_kills ;?></p>
            <?php
                }
                else{
                    echo "No data found";  
                }   
            ?>
            
        </div>
    </div>
</div>
