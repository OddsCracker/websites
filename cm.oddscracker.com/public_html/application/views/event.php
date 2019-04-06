<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
<?php
if (!$event) {
	echo '<h3 class="text-center">Événement non trouvé!</h3>';
} else {
?>
	<div class="event-header">
		<div class="inner">
			<h1><?php echo $event['team1'];?> - <?php echo $event['team2'];?><span class="sr-only"> | Meilleure comparaison de cotes de paris sportifs</span></h1>
			<hr>
			<h2><?php echo $event['league'];?> - <?php echo $event['country'];?></h2>
			<p><i class="fa fa-fw fa-clock-o"></i> <?php if ($event['date'] != date('Y-m-d')) { echo date('d M Y', strtotime($event['date'])) . ' '; } echo date('H:i', strtotime($event['time']));?></p>
			<p class="sr-only"><?php echo $event['team1'];?> joue contre <?php echo $event['team2'];?> in <?php echo $event['league'];?> en <?php echo date('Y-m-d', strtotime($event['time']));?> à <?php echo date('H:i', strtotime($event['time']));?>. Obtenez les meilleures cotes de pari pour <?php echo $event['team1'];?> contre <?php echo $event['team2'];?> seulement à <?php echo $settings['site_name'] . ' ' . $settings['country_name'];?></p>
		</div>
	</div>
	<div id="odds-container">
		<div id="loader"><h4 class="text-center"><i>Les cotes des paris sportifs sont en cours de chargement ...</i></h4><br><img src="/images/loader.gif" alt="Loading" class="center-block"><br></div>
	</div>
	<div class="grey-bg text-center row">
		<div class="col-sm-6">
			<a 
			href="http://www.facebook.com/sharer.php?u=<?php echo $this->data['settings']['abs_url'];?>/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(2));?>" 
			title="Share on Facebook" 
			class="facebook-share" 
			target="_blank">
				<i class="fa fa-lg fa-facebook"></i> Partager sur Facebook
			</a>
		</div>
		<div class="col-sm-6">
			<a 
			href="https://twitter.com/intent/tweet?original_referer=<?php echo $this->data['settings']['abs_url'];?>/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(2));?>&tw_p=tweetbutton&url=<?php echo $this->data['settings']['abs_url'];?>/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(2));?>" 
			title="Share on Twitter" 
			class="twitter-share" 
			target="_blank">
				<i class="fa fa-lg fa-twitter" target="_blank"></i> Partager sur Twitter
			</a>
		</div>
	</div>
	<table>
		<tr>
		<?php if ($event['previous']) { echo '<td>Match précédent: <a href="/event/' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($event['previous']['team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($event['previous']['team2']))) . '-' . $event['previous']['id'] . '" title="' . $event['previous']['team1'] . ' vs. ' . $event['previous']['team2'] . '">' . $event['previous']['team1'] . ' vs. ' . $event['previous']['team2'] . '</a></td>'; } ?>
		<?php if ($event['next']) { echo '<td>/</td><td>Prochain match: <a href="/event/' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($event['next']['team1']))) . '-' . preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower($event['next']['team2']))) . '-' . $event['next']['id'] . '" title="' . $event['next']['team1'] . ' vs. ' . $event['next']['team2'] . '">' . $event['next']['team1'] . ' vs. ' . $event['next']['team2'] . '</td>'; } ?>
		</tr>
	</table>
	<script type="text/javascript">
		$(document).ajaxStart(function(){
			$('#loader').css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$('#loader').css("display", "none");
		});
	</script>
	<?php
	echo '<script type="text/javascript">';
	$explode = explode('-', $this->uri->segment(2));
	$event_id = $explode[max(array_keys($explode))];
	echo '$(document).ready(function(){ $.post("/ajax/get_odds/' . $event_id . '", function(response){ $("#odds-container").html(response);})});';
	echo '</script>';
	?>
<?php
}
?>
</div>
