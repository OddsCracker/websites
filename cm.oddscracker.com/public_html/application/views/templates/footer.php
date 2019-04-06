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
						<img src="/images/oddscracker-logo.png" class="img img-responsive center-block" alt="<?php echo $settings['default_title'];?>">
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
							<li><a href="/about" title="À propos de nous">À propos de nous</a></li>
							<li><a href="/contact" title="Contactez nous">Contactez nous</a></li>
							<li><a href="/privacy" title="Politique de confidentialité">Politique de confidentialité</a></li>
							<li><a href="/terms" title="Termes et conditions">Termes et conditions</a></li>
							<li><a href="/help" title="Utile">Utile</a></li>
						</ul>
					</div>
					<div class="col-sm-2 col-xs-6">
						<h3 class="footer-section-title">
							<a href="/bookmakers">Bookmakers</a>
						</h3>
						<ul class="footer-links">
							<?php
							$i = 1;
							foreach ($bookmakers as $key => $value) {
							?>
							<li<?php if ($i > 5) { echo ' class="hidexs"'; } ?>><a href="/bookmakers/reviews/<?php echo $value['Slug'];?>" title="<?php echo $value['Name'];?>"><?php echo $value['Name'];?></a></li>
							<?php
								$i++;
							}
							?>
							<li class="hidesm"><a href="/bookmakers" title="Afficher tous">Afficher tous</a></li>
						</ul>
					</div>
					<div class="col-sm-2 col-xs-6">
						<h3 class="footer-section-title">
							<a href="#" onclick="return false;">Plus</a>
						</h3>
						<ul class="footer-links">
							<li><a href="/archives" title="Les Archives">Les Archives</a></li>
							<li><a href="/news" title="Nouvelles">Nouvelles</a></li>
							<li><a href="/contact" title="Contactez Nous">Contactez Nous</a></li>
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
						<h3 class="text-center">Votre solution de comparaison de cotes de paris sportifs!</h3>
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
									<input id="login-password" type="password" name="Password" required="required" placeholder="Mot de passe" autocomplete="off">
									<br><br>
									<input type="checkbox" name="rememberme"> Rester connecté
									<input type="submit" class="btn btn-lg btn-login" value="S'identifier">
								</form>
							</div>
							<div class="col-sm-1"></div>
						</div>
						<br>
						<div class="row text-center">
							<div class="col-sm-1"></div>
							<div class="col-sm-10 text-center">
								<a href="/login/facebook/<?php echo urlencode($_SERVER['REQUEST_URI']);?>" class="btn btn-lg btn-facebook"><i class="fa fa-fw fa-facebook"></i> S'identifier avec Facebook</a>
								&nbsp;
								<a href="/login/google/<?php echo urlencode($_SERVER['REQUEST_URI']);?>" class="btn btn-lg btn-google"><i class="fa fa-fw fa-google-plus"></i> S'identifier avec Google</a>
							</div>
							<div class="col-sm-1"></div>
						</div>
						<div class="row">
							<div class="col-sm-1"></div>
							<div class="col-sm-10 text-center">
								Pas de compte? <a href="/register" class="btn btn-login">S'inscrire</a><br> maintenant!
							</div>
							<div class="col-sm-1"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
