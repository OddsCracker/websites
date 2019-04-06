<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<script type="text/javascript">
	var redirect = "<?php echo urldecode($this->uri->segment(3));?>";
	window.fbAsyncInit = function() {
		FB.init({
			appId : "<?php echo $this->data['settings']['facebook_app_id'];?>",
			cookie : true,
			xfbml : true,
			version : 'v2.8'
		});
		FB.Event.subscribe('auth.authResponseChange', function(response) { 
			console.log(response.status);
			if (response.status === 'connected') {
				testAPI();
			} else if (response.status === 'not_authorized') {
				FB.login();
			} else {
				FB.login();
			}
		});
	};
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "https://connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	function testAPI() {
		FB.api('/me', {fields: 'name, email'}, function(response) {
			console.log('Successful login for: ' + response.name);
			var name = response.name;
			var email = response.email;
			$.post('/ajax/facebook_login', {Email:email, Name:name}, function(login_response){
				if (login_response.status == 'error') {
					$('#facebook_login_response').addClass('alert alert-danger');
					$('#facebook_login_response').html(login_response.msg);
				} else {
					window.location.href = redirect;
				}
			});
		});
	}
	</script>
	<br><br>
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
			<div class="fb-login-button" data-max-rows="5" data-size="large" data-button-type="continue_with" data-show-faces="true" data-auto-logout-link="false" data-use-continue-as="true" data-scope="public_profile,email"></div>
			<div id="facebook_login_response"></div>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
