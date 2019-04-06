<!DOCTYPE html>
<html>
	<head>
		<title>Admin</title>
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<style type="text/css">
<?php
echo str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/css/bootstrap.css'));
echo str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/css/font-awesome.css'));
echo str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/css/datatables.min.css'));
echo str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/css/admin.css'));
?>
		</style>
		<script type="text/javascript">
<?php
include_once FCPATH . '/js/jquery.min.js';
include_once FCPATH . '/js/bootstrap.min.js';
include_once FCPATH . '/js/datatables.min.js';
echo "\n\n\n\n" . str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/js/admin.js'));
?>
		</script>
	</head>
	<body>
	<?php
	if (get_cookie('_admin_')){
	?>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li><a href="/admin/" title="Home">Admin</a></li>
						<li><a href="/admin/settings" title="Settings">Settings</a></li>
						<li><a href="/admin/bans" title="bans">Bans</a></li>
						<li><a href="/admin/bookmakers" title="Bookmakers">Bookmakers</a></li>
						<li><a href="/admin/campaigns" title="Campaigns">Campaigns</a></li>
						<li><a href="/admin/leagues" title="Leagues">Leagues</a></li>
						<li><a href="/admin/users" title="Users">Users</a></li>
						<li><a href="/admin/pages" title="Pages">Pages</a></li>
						<li><a href="/admin/messages" title="Messages">Messages</a></li>
						<li><a href="/admin/parse_news_feeds" title="Update News">Update news</a></li>
						<li><a href="/admin/newsletter" title="Newsletter subscriptions">Newsletter</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="/admin/edit"><i class="fa fa-fw fa-edit"></i> Edit login</a></li>
						<li><a href="/admin/logout"><i class="fa fa-fw fa-lock"></i> Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
	<?php
	}
	?>
