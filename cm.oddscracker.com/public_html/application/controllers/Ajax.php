<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function check_login_status(){
		if (!get_cookie('_user_')) {
			$res['status'] = 'error';
			$res['msg'] = 'Vous devez vous connecter pour accéder à cette ressource.';
			header('Content-type:application/json');
			echo json_encode($res);
		}
	}

	public function index(){
		$res['status'] = 'success';
		$res['msg'] = 'Rien à faire ici, merci de votre intérêt.';
		header('Content-type:application/json');
		echo json_encode($res);
	}
	
	public function register(){
		$errors = $this->FrontModel->check_user_registration_form($this->input->post());
		if (!$errors) {
			$res['status'] = 'success';
			$res['msg'] = 'Merci de votre inscription<br>Nous avons envoyé un email d\'activation à votre email.<br>Vérifiez également les dossiers de courrier indésirable.<br>Utilisez les instructions que vous avez reçues dans votre courrier électronique pour activer votre compte..';
		} else {
			$res['status'] = 'error';
			$res['msg'] = $errors;
		}
		header('Content-type:application/json');
		echo json_encode($res);
	}
	
	public function login(){
		$errors = $this->FrontModel->check_user_login_form($this->input->post());
		if (!$errors) {
			$res['status'] = 'success';
			$res['msg'] = 'Connexion réussie, vous redirigeant vers votre page de profil ...';
		} else {
			$res['status'] = 'error';
			$res['msg'] = $errors;
		}
		header('Content-type:application/json');
		echo json_encode($res);
	}
	
	public function dismiss_info_strip(){
		$expire = time()+30*86400;
		setcookie('__dismiss_info_strip', md5(time()), $expire, '/', $_SERVER['SERVER_NAME'], ini_get('session.cookie_secure'), 1);
		return true;
	}
	
	public function contact(){
		$errors = $this->FrontModel->submit_contact_form($this->input->post());
		if (!$errors) {
			$res['status'] = 'success';
			$res['msg'] = 'Merci pour votre message, nous vous recontacterons!';
		} else {
			$res['status'] = 'error';
			$res['msg'] = $errors;
		}
		header('Content-type:application/json');
		echo json_encode($res);
	}
	
	public function rate(){
		$rating = $this->FrontModel->add_rating($this->input->post());
		if (!$rating) {
			$res['status'] = 'error';
			$res['msg'] = 'Adresse IP a déjà soumis une évaluation!';
		} else {
			$res['status'] = 'success';
			$res['msg'] = $rating;
		}
		header('Content-type:application/json');
		echo json_encode($res);
	}
	
	public function subscribe(){
		$subscribed = $this->FrontModel->add_subscription($this->input->post());
		if (!$subscribed) {
			$res['status'] = 'error';
			$res['msg'] = 'Vous êtes déjà inscrit à notre newsletter!';
		} else {
			$res['status'] = 'success';
			$res['msg'] = 'Merci de votre abonnement!';
		}
		header('Content-type:application/json');
		echo json_encode($res);
	}
	
	public function facebook_login(){
		$errors = $this->FrontModel->check_facebook_login($this->input->post());
		if (!$errors) {
			$res['status'] = 'success';
			$res['msg'] = 'Vous vous êtes connecté avec succès en utilisant votre compte Facebook!';
		} else {
			$res['status'] = 'error';
			$res['msg'] = $errors;
		}
		header('Content-type:application/json');
		echo json_encode($res);
	}

	public function google_login(){
		$errors = $this->FrontModel->check_google_login($this->input->post());
		if (!$errors) {
			$res['status'] = 'success';
			$res['msg'] = 'Vous vous êtes connecté avec succès en utilisant votre compte Google!';
		} else {
			$res['status'] = 'error';
			$res['msg'] = $errors;
		}
		header('Content-type:application/json');
		echo json_encode($res);
	}
	
	public function logout(){
		setcookie('_user_', '', (time()-86400*30), '/', $_SERVER['SERVER_NAME'], ini_get('session.cookie_secure'), 1);
		$res['status'] = 'success';
		$res['msg'] = 'Logged out';
		header('Content-type:application/json');
		echo json_encode($res);
	}
	
	public function get_odds($event_id){
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
		$start = microtime(true);
		$market_labels = array('1x2'=>'1x2 chances', 'dc'=>'Double Chance', 'ou25'=>'Over/Under 2.5');
		$bookies = $this->FrontModel->get_bookies();
		$event = $this->FrontModel->get_event($event_id);
		$markets = $this->FrontModel->get_markets($event_id);
		$odds = $this->FrontModel->get_odds($event_id);
		$urls = $this->FrontModel->get_event_urls($event_id);
		if (!$odds) {
			echo '
			<h3 class="text-center">Cotes non disponibles!</h3>
			';
		} else {
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
				</ul>
			</div>
			';
			foreach ($markets as $market) {
				$bets = $odds['markets'][$market][min(array_keys($odds['markets'][$market]))];
				echo '
				<div id="' . $market . '" class="odds-container"'; if ($market != '1x2') { echo ' style="display:none;"';} echo '>
					<li class="row-header row">
						<div class="row-title text-center">
							<div class="col-sm-6">
								'; if (isset($market_labels[$market])) { echo $market_labels[$market]; } else { echo $market; } echo '
							</div>
							<div class="col-sm-6 hidexs">
								Bonus
							</div>
						</div>
						';
						if (count($bets) <= 3) {
							$unique_bkeys = array();
							foreach ($bets as $bkey => $bvalue) {
								echo '<div class="market-title">';
								if ($bkey == '1') { echo $event['team1'];} elseif ($bkey == '1/1') { echo $event['team1'] . '/' . $event['team1']; } elseif ($bkey == '1x' || $bkey == '1/x') { echo $event['team1'] . '/Draw'; } elseif ($bkey == '2') { echo $event['team2']; } elseif ($bkey == '2/2') { echo $event['team2'] . '/' . $event['team2']; } elseif ($bkey == '12' || $bkey == '1/2') { echo $event['team1'] . '/' . $event['team2']; } elseif ($bkey == 'x') { echo 'Draw'; } elseif ($bkey == 'x/x') { echo 'Draw/Draw'; } elseif ($bkey == '2x' || $bkey == '2/x') { echo $event['team2'] . '/Draw'; } elseif ($bkey == 'x/1') { echo 'Draw/' . $event['team1']; } elseif ($bkey == 'x/2') { echo 'Draw/' . $event['team2']; } elseif ($bkey == 'x2') { echo 'Draw/' . $event['team2']; } elseif ($bkey == '2/1') { echo $event['team2'] . '/' . $event['team1']; } else { echo $bkey; }
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
							foreach ($bets as $bkey => $bvalue) {
								if (strstr($bvalue, ':{')) {
									$bvalues = unserialize($bvalue);
									$bkeys = array_keys($bvalues);
									foreach ($bkeys as $xk => $yk) {
										if (!in_array($yk, $unique_bkeys)) {
											array_push($unique_bkeys, $yk);
										}
									}
								}
							}
							foreach ($unique_bkeys as $uk => $uv) {
								echo '<div class="market-title pull-right">' . $uv . '</div>';
							}
						}
						echo '
					</li>
					';
					if (count($bets) <= 3) {
/*************************** bets with at most 3 options (1x2, double chance, over/under, both teams to score, etc.) **********************************/
						foreach ($odds['markets'][$market] as $bookmaker => $bet) {
							if ($bookies[$bookmaker]['DisplayOdds'] == 0 && !get_cookie('_user_')) {
								echo '
								<li class="single-row">
									<div class="row-title">
										<div class="col-sm-6">
											<a href="'; if (strstr($urls[$market][$bookmaker], '?')) { echo $urls[$market][$bookmaker] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $urls[$market][$bookmaker] . '?utm_source=oddscracker&utm_medium=affiliate'; } echo '" rel="nofollow" target="_blank" title="Bet on ' . $event['team1'] . ' vs. ' . $event['team2'] . ' at ' . $bookies[$bookmaker]['Name'] . '">
												<div class="bookie-logo" style="background-image:url(/uploads/' . $bookies[$bookmaker]['Logo'] . ');"></div>
											</a>
										</div>
										<div class="col-sm-6 text-center">'; if (!empty($bookies[$bookmaker]['Bonus'])) { echo '<a href="'; if (strstr($urls[$market][$bookmaker], '?')) { echo $urls[$market][$bookmaker] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $urls[$market][$bookmaker] . '?utm_source=oddscracker&utm_medium=affiliate'; } echo '" rel="nofollow" target="_blank" title="' . $bookies[$bookmaker]['Bonus'] . ' bonus when you join ' . $bookies[$bookmaker]['Name'] . '" class="bonus">' . $bookies[$bookmaker]['Bonus'] . '<span class="hidesm"> bonus</span></a>'; } echo '</div>
									</div>
									<div class="text-center"><a href="#" title="Login" data-toggle="modal" data-target="#login_modal">Connectez-vous pour afficher les cotes!</a></div>
								</li>
								';
							} else {
								echo '
								<li class="single-row">
									<div class="row-title">
										<div class="col-sm-6">
											<a href="'; if (strstr($urls[$market][$bookmaker], '?')) { echo $urls[$market][$bookmaker] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $urls[$market][$bookmaker] . '?utm_source=oddscracker&utm_medium=affiliate'; } echo '" rel="nofollow" target="_blank" title="Bet on ' . $event['team1'] . ' vs. ' . $event['team2'] . ' at ' . $bookies[$bookmaker]['Name'] . '">
												<div class="bookie-logo" style="background-image:url(/uploads/' . $bookies[$bookmaker]['Logo'] . ');"></div>
											</a>
										</div>
										<div class="col-sm-6 text-center">'; if (!empty($bookies[$bookmaker]['Bonus'])) { echo '<a href="'; if (strstr($urls[$market][$bookmaker], '?')) { echo $urls[$market][$bookmaker] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $urls[$market][$bookmaker] . '?utm_source=oddscracker&utm_medium=affiliate'; } echo '" rel="nofollow" target="_blank" title="' . $bookies[$bookmaker]['Bonus'] . ' bonus when you join ' . $bookies[$bookmaker]['Name'] . '" class="bonus">' . $bookies[$bookmaker]['Bonus'] . '<span class="hidesm"> bonus</span></a>'; } echo '</div>
									</div>
									';
									foreach ($bet as $okey => $ovalue) {
										echo '<div class="odds-cell"><a href="'; if (strstr($urls[$market][$bookmaker], '?')) { echo $urls[$market][$bookmaker] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $urls[$market][$bookmaker] . '?utm_source=oddscracker&utm_medium=affiliate'; } echo '" class="blink'; if ($odds['stats'][$market]['high'][$okey] == $ovalue) { echo ' Plus haut'; } echo '" title="' . $ovalue . ' at ' . $bookies[$bookmaker]['Name'] . '" rel="nofollow" target="_blank">' . $ovalue . '</a></div>';
									}
									echo '
								</li>
								';
							}
						}
						echo '
						<li class="single-row Plus haut">
							<div class="row-title"><i class="fa fa-fw fa-signal text-success"></i> Plus haut</div>
							';
							foreach ($odds['stats'][$market]['high'] as $key => $value) {
								echo '<div class="odds-cell">' . $value . '</div>';
							}
							echo '
						</li>
						<li class="single-row avg">
							<div class="row-title"><i class="fa fa-fw fa-code text-success"></i> Moyenne</div>
							';
							foreach ($odds['stats'][$market]['avg'] as $key => $value) {
								echo '<div class="odds-cell">' . round(floatval($value), 2) . '</div>';
							}
							echo '
						</li>
						';
					} else {
/************************* bets with more than 3 options (correct score, etc.) **********************/
						foreach ($odds['stats'][$market]['high'] as $key => $value) {
							echo '
							<li class="single-row">
								<div class="row-title"><a href="#' . preg_replace('/[^a-zA-Z0-9\-]/', '_', $market . $key) . '" data-toggle="collapse" class="collapse-odds">' . $key . '</a></div>
								<div class="compare-odds-cell"><a href="#' . preg_replace('/[^a-zA-Z0-9\-]/', '_', $market . $key) . '" data-toggle="collapse" class="collapse-odds">Compare(' . count($odds['markets'][$market]) . ')</a></div>
								<div class="odds-cell pull-right"><a href="#' . preg_replace('/[^a-zA-Z0-9\-]/', '_', $market . $key) . '" data-toggle="collapse" class="collapse-odds">' . round(floatval($value), 2) . '</a></div>
							</li>
							<div id="' . preg_replace('/[^a-zA-Z0-9\-]/', '_', $market . $key) . '" class="collapse">
							';
							foreach ($odds['markets'][$market] as $bookmaker => $bet) {
								if ($bookies[$bookmaker]['DisplayOdds'] == 0 && !get_cookie('_user_')) {
									foreach ($bet as $okey => $ovalue) {
										if ($okey == $key) {
											echo '
											<li class="single-row">
												<div class="row-title">
													<div class="col-sm-6">
														<a href="'; if (strstr($urls[$market][$bookmaker], '?')) { echo $urls[$market][$bookmaker] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $urls[$market][$bookmaker] . '?utm_source=oddscracker&utm_medium=affiliate'; } echo '" rel="nofollow" target="_blank" title="Bet on ' . $event['team1'] . ' vs. ' . $event['team2'] . ' at ' . $bookies[$bookmaker]['Name'] . '">
															<div class="bookie-logo" style="background-image:url(/uploads/' . $bookies[$bookmaker]['Logo'] . ');"></div>
														</a>
													</div>
													<div class="col-sm-6 text-center">'; if (!empty($bookies[$bookmaker]['Bonus'])) { echo '<a href="'; if (strstr($urls[$market][$bookmaker], '?')) { echo $urls[$market][$bookmaker] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $urls[$market][$bookmaker] . '?utm_source=oddscracker&utm_medium=affiliate'; } echo '" rel="nofollow" target="_blank" title="' . $bookies[$bookmaker]['Bonus'] . ' bonus when you join ' . $bookies[$bookmaker]['Name'] . '" class="bonus">' . $bookies[$bookmaker]['Bonus'] . '<span class="hidesm"> bonus</span></a>'; } echo '</div>
												</div>
												<div class="pull-right"><a href="#" title="Login" data-toggle="modal" data-target="#login_modal">Connectez-vous pour afficher les cotes!</a></div>
											</li>
											';
										}
									}
								} else {
									foreach ($bet as $okey => $ovalue) {
										if ($okey == $key) {
											echo '
											<li class="single-row">
												<div class="row-title">
													<div class="col-sm-6">
														<a href="'; if (strstr($urls[$market][$bookmaker], '?')) { echo $urls[$market][$bookmaker] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $urls[$market][$bookmaker] . '?utm_source=oddscracker&utm_medium=affiliate'; } echo '" rel="nofollow" target="_blank" title="Bet on ' . $event['team1'] . ' vs. ' . $event['team2'] . ' at ' . $bookies[$bookmaker]['Name'] . '">
															<div class="bookie-logo" style="background-image:url(/uploads/' . $bookies[$bookmaker]['Logo'] . ');"></div>
														</a>
													</div>
													<div class="col-sm-6 text-center">'; if (!empty($bookies[$bookmaker]['Bonus'])) { echo '<a href="'; if (strstr($urls[$market][$bookmaker], '?')) { echo $urls[$market][$bookmaker] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $urls[$market][$bookmaker] . '?utm_source=oddscracker&utm_medium=affiliate'; } echo '" rel="nofollow" target="_blank" title="' . $bookies[$bookmaker]['Bonus'] . ' bonus when you join ' . $bookies[$bookmaker]['Name'] . '" class="bonus">' . $bookies[$bookmaker]['Bonus'] . '<span class="hidesm"> bonus</span></a>'; } echo '</div>
												</div>
												<div class="odds-cell pull-right"><a href="'; if (strstr($urls[$market][$bookmaker], '?')) { echo $urls[$market][$bookmaker] . '&utm_source=oddscracker&utm_medium=affiliate'; } else { echo $urls[$market][$bookmaker] . '?utm_source=oddscracker&utm_medium=affiliate'; } echo '" class="blink'; if ($odds['stats'][$market]['high'][$okey] == $ovalue) { echo ' Plus haut'; } echo '" title="' . $ovalue . ' at ' . $bookies[$bookmaker]['Name'] . '" rel="nofollow" target="_blank">' . $ovalue . '</a></div>
											</li>
											';
										}
									}
								}
							}
							echo '
								<li class="single-row Plus haut">
									<div class="row-title"><i class="fa fa-fw fa-signal text-success"></i> Plus haut</div><div class="odds-cell pull-right">' . $odds['stats'][$market]['high'][$key] . '</div>
								</li>
								<li class="single-row avg">
									<div class="row-title"><i class="fa fa-fw fa-code text-success"></i> Moyenne</div><div class="odds-cell pull-right">' . round(floatval($odds['stats'][$market]['avg'][$key]), 2) . '</div>
								</li>
							</div>
							';
						}
					}
					echo '
				</div>
				';
			}
		}
		$end = microtime(true);
		echo '<br><small><i>Cotes générées en ' . round(($end-$start), 3) . ' secondes</i></small>';
		endif;
	}
	
	public function search(){
		$search_term = htmlspecialchars($this->input->post('team'));
		$results = $this->FrontModel->search_team($search_term);
		if (!$results) {
			echo 'Aucun résultat!';
		} else {
			echo '<ul class="list-group">';
			foreach ($results as $key => $value) {
				echo '<li class="list-group-item"><a href="/event/' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($value['team2']))) . '-' . $key . '">' . str_ireplace($search_term, '<font style="color:red;">' . ucfirst($search_term) . '</font>', $value['team1']) . ' - ' . str_ireplace($search_term, '<font style="color:red;">' . ucfirst($search_term) . '</font>', $value['team2']) . ' - ' . date('d M H:i', strtotime($value['time'])) . '</a></li>';
			}
			echo '</ul>';
		}
	}

}
