<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
<?php
if (!$event) {
	echo '<h3 class="text-center">Event not found!</h3>';
} else {
?>
	<div class="event-header">
		<div class="inner">
			<h1><?php echo $event['team1'];?> - <?php echo $event['team2'];?><span class="sr-only"> | Best odds comparison</span></h1>
			<hr>
			<h2><?php echo $event['league'];?> - <?php echo $event['country'];?></h2>
			<p><i class="fa fa-fw fa-clock-o"></i> <?php if ($event['date'] != date('Y-m-d')) { echo date('d M Y', strtotime($event['date'])) . ' '; } echo date('H:i', strtotime($event['time']));?></p>
			<p class="sr-only"><?php echo $event['team1'];?> takes on <?php echo $event['team2'];?> in <?php echo $event['league'];?> on <?php echo date('Y-m-d', strtotime($event['time']));?> at <?php echo date('H:i', strtotime($event['time']));?>. Get the best betting odds for <?php echo $event['team1'];?> vs. <?php echo $event['team2'];?> only at <?php echo $settings['site_name'] . ' ' . $settings['country_name'];?>
		</div>
	</div>
	<div id="odds-container">
		<div id="loader"><h4 class="text-center"><i>Loading the odds ...</i></h4><br><img src="/images/loader.gif" alt="Loading" class="center-block"><br></div>
	</div>
	<div class="grey-bg text-center row">
		<div class="col-sm-6">
			<a 
			href="http://www.facebook.com/sharer.php?u=<?php echo $this->data['settings']['abs_url'];?>/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(2));?>" 
			title="Share on Facebook" 
			class="facebook-share" 
			target="_blank">
				<i class="fa fa-lg fa-facebook"></i> Share on Facebook
			</a>
		</div>
		<div class="col-sm-6">
			<a 
			href="https://twitter.com/intent/tweet?original_referer=<?php echo $this->data['settings']['abs_url'];?>/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(2));?>&tw_p=tweetbutton&url=<?php echo $this->data['settings']['abs_url'];?>/event/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(2));?>" 
			title="Share on Twitter" 
			class="twitter-share" 
			target="_blank">
				<i class="fa fa-lg fa-twitter" target="_blank"></i> Share on Twitter
			</a>
		</div>
	</div>
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
