<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page['MetaTitle'];?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?php echo $page['MetaDescription'];?>">
		<meta property="twitter:card" content="summary">
		<meta property="twitter:site" content="@<?php echo $settings['site_name']; ?>">
		<meta property="og:url" content="<?php if (isset($_SERVER['HTTPS'])) { echo 'https://'; } else { echo 'http://'; } echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
		<meta property="og:type" content="website">
		<?php if (isset($page['og:title'])) { echo '<meta property="og:title" content="' . $page['og:title'] . '">' . "\n"; } ?>
		<?php if (isset($page['og:description'])) { echo '<meta property="og:description" content="' . $page['og:description'] . '">' . "\n"; } ?>
		<meta property="og:image" content="<?php if (isset($page['og:image'])) { echo $page['og:image']; } else { echo $settings['abs_url'] . '/images/goal.jpeg'; } ?>">
		<meta property="fb:app_id" content="<?php echo $settings['facebook_app_id']; ?>">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<meta name="google-site-verification" content="O63f1XP37UvhixgUJg7YZzXDd3IrKZLu7KvodRvgXvI">
		<link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
		<link rel="manifest" href="/images/site.webmanifest">
		<link rel="mask-icon" href="/images/safari-pinned-tab.svg" color="#5bbad5">
		<link rel="shortcut icon" href="/images/favicon.ico">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="msapplication-config" content="/images/browserconfig.xml">
		<meta name="theme-color" content="#ffffff">
		<link rel="sitemap" type="application/xml" title="Sitemap" href="<?php echo $settings['abs_url'];?>/sitemap">
		<link rel="alternate" href="<?php echo $settings['abs_url'];?>">
		<style type="text/css">
<?php
echo str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/css/bootstrap.css'));
echo str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/css/font-awesome.css'));
echo str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/css/bootstrap-datepicker.css'));
echo str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/css/style.css'));
?>
		</style>
		<script type="text/javascript">
<?php
include_once FCPATH . '/js/jquery.min.js';
include_once FCPATH . '/js/bootstrap.min.js';
?>
		</script>
		<?php echo $settings['gtag_js']; ?>
	</head>
	<body>
		<?php echo $settings['gtag_nojs']; ?>
		<nav id="topnav" class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="/" title="<?php echo $settings['default_title'];?>"><img src="/images/oddscracker-logo.png" class="img-logo"></a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<?php include_once dirname(__FILE__) . '/country_selector.php'; ?>
						<li class="hidesm dropdown">
							<a href="/" class="dropdown-toggle" title="Today's matches">Today's matches</a>
							<ul class="dropdown-menu">
							<?php
							foreach ($leagues as $league_key => $league) {
								if ($league['EventCount'] > 0) {
								?>
								<li>
									<a href="/events/<?php echo $league['Slug'];?>" title="<?php echo $league['Name'];?>">
										<?php echo $league['Name'];?>&nbsp;<span class="badge"><?php echo $league['EventCount'];?></span>
									</a>
								</li>
								<?php
								}
							}
							?>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-toggle" href="#">Bookmakers</a>
							<ul class="dropdown-menu">
								<li><a href="/bookmakers/reviews" title="Rankings &amp; Reviews">Rankings &amp; Reviews</a></li>
								<li><a href="/bookmakers/comparison" title="Features Comparison">Features Comparison</a></li>
							</ul>
						</li>
						<li><a href="/jackpots" title="Jackpots">Jackpots</a></li>
						<li><a href="/archives" title="Archives">Archives</a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" href="#" onclick="return false;">Leagues</a>
							<ul class="dropdown-menu">
								<?php foreach ($leagues as $key => $value) { echo '<li><a href="/events/' . $value['Slug'] . '" title="' . $value['Name'] . ' events"><img src="' . $value['CountryFlag'] . '" alt="' . $value['Name'] . '"> '; echo $value['Name']; if ($value['EventCount']>0) { echo '&nbsp;&nbsp;<span class="badge">' . $value['EventCount'] . '</span>'; } echo '</a></li>';} ?>
							</ul>
						</li>
						<li><a href="/news" title="News">News</a></li>
						<li><a href="/contact" title="Contact Us">Contact</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php
						if (!get_cookie('_user_')) {
						?>
						<li><a href="#" id="login-btn" title="Login"><i class="fa fa-fw fa-unlock"></i> Login</a></li>
						<li><a href="/register" title="Register"><i class="fa fa-fw fa-sign-in"></i> Signup</a></li>
						<?php
						} else {
						?>
						<li><a href="/account" title="Account"><i class="fa fa-fw fa-user"></i> My Profile</a></li>
						<li><a href="#" id="logout-btn" title="Logout"><i class="fa fa-fw fa-lock"></i> Logout</a></li>
						<?php
						}
						?>
					</ul>
				</div>
			</div>
		</nav>
		<?php if (!get_cookie('__dismiss_info_strip')): ?>
		<div id="info-strip">
			<a href="#" id="close-info-strip" class="pull-right" title="FAQ"><i class="fa fa-fw fa-times"></i></a>
			<h4 class="text-center"><a href="/faq" title="FAQ">Click here to learn how to win more using this website</a></h4>
		</div>
		<?php endif; ?>
		<div class="page-header">
			<div class="container-fluid row">
				<div class="col-sm-6">
					<div id="subscribe-wrapper">
						<!-- AWeber Web Form Generator 3.0.1 -->
						<form method="post" class="form form-horizontal" accept-charset="UTF-8" action="https://www.aweber.com/scripts/addlead.pl">
							<div style="display: none;">
								<input type="hidden" name="meta_web_form_id" value="287051609" />
								<input type="hidden" name="meta_split_id" value="" />
								<input type="hidden" name="listname" value="awlist5138276" />
								<input type="hidden" name="redirect" value="https://ke.oddscracker.com/subscribe/success" id="redirect_6e655f8db7aef7a557e47c7ee11215bf" />
								<input type="hidden" name="meta_redirect_onlist" value="https://ke.oddscracker.com/subscribe/subscribed" />
								<input type="hidden" name="meta_adtracking" value="Oddscracker_Kenya_Subscribe_Form" />
								<input type="hidden" name="meta_message" value="1" />
								<input type="hidden" name="meta_required" value="email" />
								<input type="hidden" name="meta_tooltip" value="" />
							</div>
							<h4 class="text-center">Subscribe to get the best betting odds daily</h4>
							<div class="form-group row">
								<div class="col-sm-6">
									<input class="form-control" id="awf_field-100301137" type="text" name="email" value="" tabindex="500" onfocus=" if (this.value == '') { this.value = ''; }" onblur="if (this.value == '') { this.value='';} " placeholder="Your email">
								</div>
								<div class="col-sm-6">
									<input name="submit" class="btn btn-subscribe" type="submit" value="Submit" tabindex="501">
								</div>
							</div>
							<p class="text-center">We respect your <a title="Privacy Policy" href="https://www.aweber.com/permission.htm" target="_blank" rel="nofollow">email privacy</a> - <a href="https://www.aweber.com" title="AWeber Email Marketing" target="_blank" rel="nofollow">Powered by AWeber Email Marketing</a></p>
						</form>
						<!-- /AWeber Web Form Generator 3.0.1 -->
					</div>
				</div>
				<div class="col-sm-2"></div>
				<div class="col-sm-4">
					<div class="event-search">
						<form id="event-search-form" class="form" method="post" onsubmit="return false;">
							<div class="input-group event-search-group">
								<input type="text" name="search" class="form-control event-search-input" placeholder="Search team" autocomplete="off">
								<div class="input-group-btn">
									<button class="btn btn-default btn-event-search" type="submit">
										<i class="fa fa-fw fa-search"></i>
									</button>
								</div>
							</div>
						</form>
						<div id="team_search_result"></div>
					</div>
				</div>
			</div>
		</div>
		<div id="main-content-bg">
			<div id="main-content">
				<div class="row">
