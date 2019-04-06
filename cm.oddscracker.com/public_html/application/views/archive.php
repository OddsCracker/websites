<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<?php
	if (isset($archive)) {
	?>
	<div class="event-header">
		<div class="inner">
			<h1><?php echo $archive['event']['country'];?> - <?php echo $archive['event']['league'];?></h1>
			<hr>
			<h2><?php echo $archive['event']['team1'];?> - <?php echo $archive['event']['team2'];?><br><small><?php echo date('d M Y', strtotime($archive['event']['time']));?> <i class="fa fa-fw fa-clock-o"></i> <?php echo date('H:i', strtotime($archive['event']['time']));?></small></h2>
			<h3>Comparaison des meilleures cotes</h3>
		</div>
	</div>
	<?php
		$market_labels = array('1x2'=>'1x2 chances', 'dc'=>'Double Chance', 'cs'=>'Correct Score', 'bts'=>'Both Teams to Score', 'ou'=>'Over/Under', 'oe'=>'Odd/Even', 'tg'=>'Total Goals', 'ht-ft'=>'Half Time/Full Time', 'ht-cs'=>'Half Time Correct Score', 'fh-1x2'=>'First Half 1x2', 'eh'=>'Handicap');
		$markets = array();
		foreach ($archive['markets'] as $key => $value) {
			array_push($markets, $key);
		}
		echo '
		<div class="odds-tab">
			<ul>
		';
			$i = 0;
			foreach ($markets as $key => $value) {
				if ($i <= 3) {
					echo '<li class="market-tab" data-market="' . $value . '"'; if ($value == '1x2') { echo ' class="active"';} echo '>'; if (isset($market_labels[$value])) { echo $market_labels[$value]; } else { echo $value; } echo '</li>';
				} else {
					echo '<li data-market="' . $value . '" class="hidesm market-tab'; if ($value == '1x2') { echo ' active'; } echo '">'; if (isset($market_labels[$value])) { echo $market_labels[$value]; } else { echo $value; } echo '</li>';
				}
				$i++;
			}
		echo '
				<li class="dropdown hidexs pull-right">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Plus de paris <i class="fa fa-lg fa-angle-down"></i></a>
					<ul class="dropdown-menu">
					';
					$i = 0;
					foreach ($markets as $key => $value) {
						if ($i > 3) {
							echo '<li class="market-tab" data-market="' . $value . '">'; if (isset($market_labels[$value])) { echo $market_labels[$value]; } else { echo $value; } echo '</li>';
						}
						$i++;
					}
					echo '
					</ul>
				</li>
			</ul>
		</div>
		';
		foreach ($markets as $market) {
			$bets = $archive['markets'][$market][min(array_keys($archive['markets'][$market]))];
			echo '
			<div id="' . $market . '" class="odds-container"'; if ($market != '1x2') { echo ' style="display:none;"';} echo '>
				<li class="row-header row">
					<div class="row-title text-center">'; if (isset($market_labels[$market])) { echo $market_labels[$market]; } else { echo $market; } echo '</div>
					';
					if (count($bets) <= 3) {
						$unique_bkeys = array();
						foreach ($bets as $bkey => $bvalue) {
							echo '<div class="market-title">';
							if ($bkey == '1') { echo $archive['event']['team1'];} elseif ($bkey == '1/1') { echo $archive['event']['team1'] . '/' . $archive['event']['team1']; } elseif ($bkey == '1x' || $bkey == '1/x') { echo $archive['event']['team1'] . '/Draw'; } elseif ($bkey == '2') { echo $archive['event']['team2']; } elseif ($bkey == '2/2') { echo $archive['event']['team2'] . '/' . $archive['event']['team2']; } elseif ($bkey == '12' || $bkey == '1/2') { echo $archive['event']['team1'] . '/' . $archive['event']['team2']; } elseif ($bkey == 'x') { echo 'Draw'; } elseif ($bkey == 'x/x') { echo 'Draw/Draw'; } elseif ($bkey == '2x' || $bkey == '2/x') { echo $archive['event']['team2'] . '/Draw'; } elseif ($bkey == 'x/1') { echo 'Draw/' . $archive['event']['team1']; } elseif ($bkey == 'x/2') { echo 'Draw/' . $archive['event']['team2']; } elseif ($bkey == 'x2') { echo 'Draw/' . $archive['event']['team2']; } elseif ($bkey == '2/1') { echo $archive['event']['team2'] . '/' . $archive['event']['team1']; } else { echo $bkey; }
							echo '</div>';
						}
						if (count($unique_bkeys) > 0) {
							foreach ($unique_bkeys as $uk => $uv) {
								echo '<div class="market-title">' . $uv . '</div>';
							}
						}
					} else {
						echo '<div class="market-title">&nbsp;</div>';
						$unique_bkeys = array();
						foreach ($unique_bkeys as $uk => $uv) {
							echo '<div class="market-title pull-right">' . $uv . '</div>';
						}
					}
					echo '
				</li>
				';
				if (count($bets) <= 3) {
				/* bets with at most 3 options */
					foreach ($archive['markets'][$market] as $bookmaker => $bet) {
						echo '
						<li class="single-row">
							<div class="row-title"><div class="bookie-logo" style="background-image:url(/uploads/' . $bookies[$bookmaker]['Logo'] . ');"></div></div>
							';
							foreach ($bet as $okey => $ovalue) {
								echo '<div class="odds-cell">' . $ovalue . '</div>';
							}
							echo '
						</li>
						';
					}
				} else {
				/* bets with more than 3 options */
					foreach ($archive['markets'] as $key => $value) {
						echo '
						<li class="single-row">
							<div class="row-title"><a href="#' . preg_replace('/[^a-zA-Z0-9\-]/', '_', $market . $key) . '" data-toggle="collapse" class="collapse-odds">' . $key . '</a></div>
							<div class="compare-odds-cell"><a href="#' . preg_replace('/[^a-zA-Z0-9\-]/', '_', $market . $key) . '" data-toggle="collapse" class="collapse-odds">Compare(' . count($archive['markets'][$market]) . ')</a></div>
							';
							echo '<div class="odds-cell pull-right"><a href="#' . preg_replace('/[^a-zA-Z0-9\-]/', '_', $market . $key) . '" data-toggle="collapse" class="collapse-odds">' . round(floatval($value), 2) . '</a></div>';
						echo '
						</li>
						<div id="' . preg_replace('/[^a-zA-Z0-9\-]/', '_', $market . $key) . '" class="collapse">
						';
						foreach ($archive['markets'][$market] as $bookmaker => $bet) {
							foreach ($bet as $okey => $ovalue) {
								if ($okey == $key) {
									echo '
										<li class="single-row">
											<div class="row-title"><div class="bookie-logo" style="background-image:url(/uploads/' . $bookies[$bookmaker]['Logo'] . ');"></div></div><div class="odds-cell pull-right">' . $ovalue . '</div>
										</li>
										';
								}
							}
						}
						echo '
						</div>
						';
					}
				}
				echo '
			</div>
			';
		}
		?>
	<div class="grey-bg text-center row">
		<div class="col-sm-6">
			<a 
			href="http://www.facebook.com/sharer.php?u=<?php echo $this->data['settings']['abs_url'];?>/archive/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(2));?>" 
			title="Share on Facebook" 
			class="facebook-share" 
			rel="nofollow" 
			target="_blank">
				<i class="fa fa-lg fa-facebook"></i> Partager sur Facebook
			</a>
		</div>
		<div class="col-sm-6">
			<a 
			href="https://twitter.com/intent/tweet?original_referer=<?php echo $this->data['settings']['abs_url'];?>/archive/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(2));?>&tw_p=tweetbutton&url=<?php echo $this->data['settings']['abs_url'];?>/archive/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(2));?>" 
			title="Share on Twitter" 
			class="twitter-share" 
			rel="nofollow" 
			target="_blank">
				<i class="fa fa-lg fa-twitter" target="_blank"></i> Partager sur Twitter
			</a>
		</div>
	</div>
	<?php
	} else {
	?>
	<h3 class="text-center">Arrive bientôt ...</h3>
	<?php
	}
	?>
</div>
