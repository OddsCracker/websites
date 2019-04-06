<div id="right-col" class="col-sm-3">
	<div class="row">
		<div class="widget-title">Sports News</div>
		<div class="news">
		<br>
		<?php foreach ($latest_news as $key => $value) { ?>
			<a href="<?php echo $value['Url'];?>" title="<?php echo $value['Title'];?>" class="news-preview" rel="nofollow" target="_blank">
				<big><?php echo $value['Title'];?></big><br>
				<span class="help-block"><i class="fa fa-fw fa-clock-o"></i> <?php echo date('Y-m-d H:i', strtotime($value['DateTime']));?> | <i class="fa fa-fw fa-globe"></i> <?php echo $value['Source'];?></span>
			</a>
		<?php } ?>
		</div>
	</div>
</div>
