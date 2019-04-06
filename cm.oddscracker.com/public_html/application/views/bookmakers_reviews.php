<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
<?php
if (!isset($bookmaker)) {
?>
	<h1 class="page-title"><?php echo $settings['site_name'] . ' ' . $settings['country_name']; ?> - Avis de bookmakers</h1>
<?php
	foreach ($bookmakers as $key => $value) {
?>
	<div itemscope itemtype="http://schema.org/Review">
	<a href="/bookmakers/reviews/<?php echo $value['Slug'];?>" title="Read our review for <?php echo $value['Name'];?>">
		<div class="row bookmaker">
			<div class="col-sm-2 col-xs-2">
				<br><span class="sr-only">Rang: </span><?php echo $value['SortOrder'];?>
			</div>
			<div class="col-sm-4 col-xs-4">
				<img src="/uploads/<?php echo $value['Logo'];?>" itemprop="image" class="img img-responsive center-block bookmaker-logo" alt="<?php if (!empty($value['LogoAlt'])) { echo $value['LogoAlt']; } else { echo $value['Name']; } ?>" title="<?php echo $value['Name'];?>">
			</div>
			<div class="col-sm-4 col-xs-6">
				<div itemprop="name"><?php echo $value['Name'];?></div>
				<span itemprop="url" class="hidden"><?php echo $value['Link'];?></span>
				<div itemprop="reviewRating" itemscope itemtype="http://schema.org/AggregateRating">
					Évaluation: <span itemprop="ratingValue"><?php echo $value['Rating'];?></span><span class="hidden">sur </span>
				</div>
			</div>
		</div>
	</a>
	</div>
	<?php
	}
} else {
	if ($this->session->flashdata('error')) {
		echo '<br><p class="alert alert-danger">' . $this->session->flashdata('error') . '</p>';
	} else {
?>
	<div itemscope itemtype="http://schema.org/Review">
	<meta itemprop="itemReviewed" content="<?php echo $bookmaker['Name']; ?>"/>
	<meta itemprop="author" content="Oddscracker.com"/>

	<?php if (!empty($bookmaker['Cover']) && file_exists(FCPATH . '/uploads/' . $bookmaker['Cover'])) { ?>
		<img src="/uploads/<?php echo $bookmaker['Cover'];?>" class="img img-responsive center-block bookie-cover" alt="<?php if (!empty($bookmaker['CoverAlt'])) { echo $bookmaker['CoverAlt']; } else { echo $bookmaker['Name']; } ?>" title="<?php echo $bookmaker['Name'];?>">
	<?php } ?>

	<div id="rating-wrapper">
		<div class="rating-col">
			<a href="#" data-rating="0" data-bookmaker="<?php echo $bookmaker['BookmakerID'];?>" class="rating-thumb" title="Dislike <?php echo $bookmaker['Name']; ?>"><i class="fa fa-lg fa-thumbs-down text-danger"></i></a>&nbsp;<span id="dislikes_count">&nbsp;<?php echo $bookmaker['dislikes'];?></span>
		</div>
		<div class="rating-col">
			<a href="#" data-rating="1" data-bookmaker="<?php echo $bookmaker['BookmakerID'];?>" class="rating-thumb" title="Like <?php echo $bookmaker['Name']; ?>"><i class="fa fa-lg fa-thumbs-up text-success"></i></a>&nbsp;<span id="likes_count">&nbsp;<?php echo $bookmaker['likes'];?></span>
		</div>
	</div>
	<h1 class="page-title"><span class="sr-only"><?php echo $settings['site_name'] . ' ' . $settings['country_name']; ?> évaluation de </span><span itemprop="name"><?php echo $bookmaker['Name'];?></span></h1>
	<div class="row">
		<div class="title">À propos de <?php echo $bookmaker['Name'];?></div>
		<p class="text-justify" itemprop="about"><?php echo nl2br($bookmaker['About']);?></p>
	</div>
	<div class="title"><?php echo $bookmaker['Name'];?> évaluations</div>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Facilité d'utilisation</div>
			<div class="col-xs-8">
				<div style="background-color:red;height:24px;width:100%">
					<div style="background-color:#59AE1A;height:24px;width:<?php echo ($bookmaker['RatingUse']*10);?>%"><span class="pull-right" style="color:#FFFFFF;"><?php echo ($bookmaker['RatingUse']*10);?>%&nbsp;</span></div>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-4">Jeux</div>
			<div class="col-xs-8">
				<div style="background-color:red;height:24px;width:100%">
					<div style="background-color:#59AE1A;height:24px;width:<?php echo ($bookmaker['RatingGames']*10);?>%"><span class="pull-right" style="color:#FFFFFF;"><?php echo ($bookmaker['RatingGames']*10);?>%&nbsp;</span></div>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-4">Bonus</div>
			<div class="col-xs-8">
				<div style="background-color:red;height:24px;width:100%">
					<div style="background-color:#59AE1A;height:24px;width:<?php echo ($bookmaker['RatingBonus']*10);?>%"><span class="pull-right" style="color:#FFFFFF;"><?php echo ($bookmaker['RatingBonus']*10);?>%&nbsp;</span></div>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-4">Retraits</div>
			<div class="col-xs-8">
				<div style="background-color:red;height:24px;width:100%">
					<div style="background-color:#59AE1A;height:24px;width:<?php echo ($bookmaker['RatingWithdraw']*10);?>%"><span class="pull-right" style="color:#FFFFFF;"><?php echo ($bookmaker['RatingWithdraw']*10);?>%&nbsp;</span></div>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-4">Service Clients</div>
			<div class="col-xs-8">
				<div style="background-color:red;height:24px;width:100%">
					<div style="background-color:#59AE1A;height:24px;width:<?php echo ($bookmaker['RatingService']*10);?>%"><span class="pull-right" style="color:#FFFFFF;"><?php echo ($bookmaker['RatingService']*10);?>%&nbsp;</span></div>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-4">Expérience mobile</div>
			<div class="col-xs-8">
				<div style="background-color:red;height:24px;width:100%">
					<div style="background-color:#59AE1A;height:24px;width:<?php echo ($bookmaker['RatingMobile']*10);?>%"><span class="pull-right" style="color:#FFFFFF;"><?php echo ($bookmaker['RatingMobile']*10);?>%&nbsp;</span></div>
				</div>
			</div>
		</div>
		<br>
		<div class="row overall-rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/AggregateRating">
			<div class="col-xs-4">Note globale (<?php echo $bookmaker['Rating'];?>)</div>
			<span itemprop="ratingValue" class="sr-only"><?php echo $bookmaker['Rating'];?></span><span class="sr-only"> sur</span><span itemprop="bestRating" class="sr-only">10</span><span class="sr-only"> basé sur</span><span itemprop="ratingCount" class="sr-only"><?php echo $bookmaker['likes']+$bookmaker['dislikes'];?></span><span class="sr-only"> évaluations de l'utilisateur</span>
			<div class="col-xs-8">
				<div style="background-color:red;height:24px;width:100%">
					<div style="background-color:#555753;height:24px;width:<?php echo ($bookmaker['Rating']*10);?>%"><span class="pull-right" style="color:#FFFFFF;"><?php echo ($bookmaker['Rating']*10);?>%&nbsp;</span></div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="title">Dépôts, paiements et retraits</div>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Dépôts</div>
			<div class="col-xs-8 break-word">
				<strong><?php echo $bookmaker['Deposits'];?></strong>
			</div>
		</div>
	</div>
	<br>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Retraits</div>
			<div class="col-xs-8 break-word">
				<strong><?php echo $bookmaker['Withdrawals'];?></strong>
			</div>
		</div>
	</div>
	<br>
	<div class="title">Plus d'informations</div>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Licence</div>
			<div class="col-xs-8 break-word">
				<strong><?php echo $bookmaker['Licensed'];?></strong>
			</div>
		</div>
	</div>
	<br>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Restrictions de pays</div>
			<div class="col-xs-8 break-word">
				<?php if (!empty($bookmaker['RestrictedCountries'])) { echo $bookmaker['RestrictedCountries'];} else { echo '<i class="fa fa-2x fa-check-circle text-success"></i>';}?>
			</div>
		</div>
	</div>
	<br>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Software</div>
			<div class="col-xs-8 break-word">
				<strong><?php echo $bookmaker['Software'];?></strong>
			</div>
		</div>
	</div>
	<br>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Casino download</div>
			<div class="col-xs-8">
				<?php if ($bookmaker['Casino'] > 0) { echo '<i class="fa fa-2x fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-2x fa-times-circle text-danger"></i>';}?>
			</div>
		</div>
	</div>
	<br>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Parier sur mobile</div>
			<div class="col-xs-8">
				<?php if ($bookmaker['MobileBetting'] > 0) { echo '<i class="fa fa-2x fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-2x fa-times-circle text-danger"></i>';}?>
			</div>
		</div>
	</div>
	<br>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Parier par SMS</div>
			<div class="col-xs-8">
				<?php if ($bookmaker['SmsBetting'] > 0) { echo '<i class="fa fa-2x fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-2x fa-times-circle text-danger"></i>';}?>
			</div>
		</div>
	</div>
	<br>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Paris en direct</div>
			<div class="col-xs-8">
				<?php if ($bookmaker['LiveBetting'] > 0) { echo '<i class="fa fa-2x fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-2x fa-times-circle text-danger"></i>';}?>
			</div>
		</div>
	</div>
	<br>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Assistance par chat en direct</div>
			<div class="col-xs-8">
				<?php if ($bookmaker['Livechat'] > 0) { echo '<i class="fa fa-2x fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-2x fa-times-circle text-danger"></i>';}?>
			</div>
		</div>
	</div>
	<br>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Bonus</div>
			<div class="col-xs-8">
				<?php if ($bookmaker['Bonuses'] > 0) { echo '<i class="fa fa-2x fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-2x fa-times-circle text-danger"></i>';}?>
			</div>
		</div>
	</div>
	<br>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Programmes de référence</div>
			<div class="col-xs-8">
				<?php if ($bookmaker['Referrals'] > 0) { echo '<i class="fa fa-2x fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-2x fa-times-circle text-danger"></i>';}?>
			</div>
		</div>
	</div>
	<br>
	<div class="row bookmaker-section">
		<div class="row">
			<div class="col-xs-4">Jackpots</div>
			<div class="col-xs-8">
				<?php if ($bookmaker['Jackpots'] > 0) { echo '<i class="fa fa-2x fa-check-circle text-success"></i>';} else { echo '<i class="fa fa-2x fa-times-circle text-danger"></i>';}?>
			</div>
		</div>
	</div>
	<br>
	<div class="row text-justify" itemprop="description">
		<?php echo nl2br($bookmaker['Description']);?>
	</div>
	<br>
	</div>
	<div class="grey-bg text-center row">
		<div class="col-sm-6">
			<a 
			href="http://www.facebook.com/sharer.php?u=<?php echo $this->data['settings']['abs_url'];?>/bookmakers/reviews/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(3));?>" 
			title="Share on Facebook" 
			class="facebook-share" 
			target="_blank">
				<i class="fa fa-lg fa-facebook"></i> Partager sur Facebook
			</a>
		</div>
		<div class="col-sm-6">
			<a 
			href="https://twitter.com/intent/tweet?original_referer=<?php echo $this->data['settings']['abs_url'];?>/bookmakers/reviews/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(3));?>&tw_p=tweetbutton&url=<?php echo $this->data['settings']['abs_url'];?>/bookmakers/reviews/<?php echo preg_replace('/[^a-zA-Z0-9\-]/', '', $this->uri->segment(3));?>" 
			title="Share on Twitter" 
			class="twitter-share" 
			target="_blank">
				<i class="fa fa-lg fa-twitter" target="_blank"></i> Partager sur Twitter
			</a>
		</div>
	</div>
<?php
	}
}
?>
</div>
