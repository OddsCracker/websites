<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
				</div><!-- ./row -->
			</div><!-- ./main-content -->
		</div><!-- ./main-content-bg -->
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-sm-4 col-xs-12 text-center">
						<div><img src="/images/oddscracker-logo.png" class="img img-responsive center-block" alt="<?php echo $settings['default_title'];?>"></div>
						<p class="copyright">
							Copyright &copy; 2016 - <?php echo date('Y');?> by<br>
							<a href="<?php echo $settings['abs_url'];?>" title="<?php echo $settings['default_title'];?>"><?php echo $settings['abs_url'];?></a>
						</p>
					</div>
					<div class="col-sm-2 col-xs-6">
						<div class="footer-section-title">
							<a href="<?php echo $settings['abs_url'];?>">Oddscracker</a>
						</div>
						<ul class="footer-links">
							<li><a href="/about" title="About Us">About Us</a></li>
							<li><a href="/contact" title="Contact Us">Contact Us</a></li>
							<li><a href="/privacy" title="Privacy Policy">Privacy Policy</a></li>
							<li><a href="/terms" title="Terms and Conditions">Terms and Conditions</a></li>
							<li><a href="/help" title="Help">Help</a></li>
						</ul>
					</div>
					<div class="col-sm-2 col-xs-6">
						<div class="footer-section-title">
							<a href="/bookmakers">Bookmakers</a>
						</div>
						<ul class="footer-links">
							<li><a href="/bookmakers/reviews" title="Bookmakers reviews">Bookmakers Reviews</a></li>
							<li><a href="/bookmakers/comparison" title="Bookmakers comparison">Bookmakers Comparison</a></li>
						</ul>
					</div>
					<div class="col-sm-2 col-xs-6">
						<div class="footer-section-title">
							<a href="#" onclick="return false;">More</a>
						</div>
						<ul class="footer-links">
							<li><a href="/archives" title="Archives">Archives</a></li>
							<li><a href="/news" title="News">News</a></li>
							<li><a href="/contact" title="Contact Us">Contact Us</a></li>
							<li><a href="<?php echo $settings['facebook_url'];?>" title="Facebook" target="_blank">Facebook</a></li>
							<li><a href="<?php echo $settings['twitter_url'];?>" title="Twitter" target="_blank">Twitter</a></li>
						</ul>
					</div>
				</div>
			</div>
		</footer>
		<script type="text/javascript">
<?php
echo str_replace(array("\r\n", "\t", "\n"), '', file_get_contents(FCPATH . '/js/functions.js'));
?>
		</script>
		<div id="login_modal" class="modal fade" role="dialog">
			<div class="modal-dialog login-modal-dialog">
				<div class="modal-content login-modal-content">
					<div class="modal-body">
						<a href="#" id="close_login_modal" title="Close"><i class="fa fa-lg fa-times-circle"></i></a>
						<img src="/images/oddscracker-logo.png" alt="OddsCracker" class="img img-responsive center-block">
						<h3 class="text-center">Your online betting odds comparison solution!</h3>
						<div class="row">
							<div class="col-sm-1"></div>
							<div class="col-sm-10">
								<p id="login_form_error"></p>
								<p id="login_form_success"></p>
								<form id="login-form" method="post">
									<?php if (get_cookie('csrf')) { echo '<input type="hidden" name="csrf" value="' . get_cookie('csrf') . '">' . "\n"; } ?>
									<input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI'];?>">
									<input id="login-email" type="text" name="Email" required="required" placeholder="E-mail" autocomplete="off">
									<br><br>
									<input id="login-password" type="password" name="Password" required="required" placeholder="Password" autocomplete="off">
									<br><br>
									<input type="checkbox" name="rememberme"> Keep me logged in
									<input type="submit" class="btn btn-lg btn-login" value="Login">
								</form>
							</div>
							<div class="col-sm-1"></div>
						</div>
						<br>
						<div class="row text-center">
							<div class="col-sm-1"></div>
							<div class="col-sm-10 text-center">
								<a href="/login/facebook/<?php echo urlencode($_SERVER['REQUEST_URI']);?>" class="btn btn-lg btn-facebook"><i class="fa fa-fw fa-facebook"></i> Login with Facebook</a>
								&nbsp;
								<a href="/login/google/<?php echo urlencode($_SERVER['REQUEST_URI']);?>" class="btn btn-lg btn-google"><i class="fa fa-fw fa-google-plus"></i> Login with Google</a>
							</div>
							<div class="col-sm-1"></div>
						</div>
						<div class="row">
							<div class="col-sm-1"></div>
							<div class="col-sm-10 text-center">
								No account? <a href="/register" class="btn btn-login">Sign up</a><br> now!
							</div>
							<div class="col-sm-1"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
