<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="center-col" class="col-sm-6">
	<meta name="google-signin-scope" content="profile email">
	<meta name="google-signin-client_id" content="<?php echo $this->data['settings']['google_client_id'];?>">
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<br><br>
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
			<div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
			<br><br>
			<div id="google_login_response"></div>
		</div>
		<div class="col-sm-3"></div>
	</div>
	<script>
	var redirect = "<?php echo urldecode($this->uri->segment(3));?>";
	function onSignIn(googleUser) {
		var profile = googleUser.getBasicProfile();
		var id_token = googleUser.getAuthResponse().id_token;
		console.log("ID Token: " + id_token);
		var first_name = profile.getGivenName();
		var last_name = profile.getFamilyName();
		var email = profile.getEmail();
		$.post('/ajax/google_login', {Email:email, FirstName:first_name, LastName:last_name}, function(login_response){
			if (login_response.status == 'error') {
				$('#google_login_response').addClass('alert alert-danger');
				$('#google_login_response').html(login_response.msg);
			} else {
				window.location.href = redirect;
			}
		});
	};
	</script>
</div>
