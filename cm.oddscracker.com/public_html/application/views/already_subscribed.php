<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<h2 class="page-title">Abonnez-vous à notre newsletter</h2>
	<br>
	<h4>Déjà inscrit, merci!</h4>
	<div class="row">
		<p>Merci, mais votre email existe déjà dans notre liste d'abonnement.</p>
		<p>Vous serez redirigé vers la page d'accueil Oddscracker dans 3 secondes.</p>
		<p>Cliquez <a href="/">ici</a> si vous n'êtes pas dirigé.</p>
		<meta http-equiv="refresh" content="3,url=<?php echo $settings['abs_url']; ?>">
		<hr>
		<p class="text-center">
			<a href="http://www.aweber.com/antispam.htm" target="_blank">Politique de non spam</a>&nbsp;&amp;&nbsp;
			<a href="http://www.aweber.com/permission.htm" target="_blank">Politique de confidentialité</a>
		</p>
	</div>
</div>
