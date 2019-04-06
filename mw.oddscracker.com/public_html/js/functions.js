/* bootstrap tooltip trigger */
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	$('table[class="grid with-centered-columns hover"]').addClass('table table-bordered');
	if ($('#info-strip').length > 0) {
		var info_strip_height = $('#info-strip').height();
		$('#topnav').css('margin-top', info_strip_height+'px');
	} else {
		$('#topnav').css('margin-top', '0px');
	}
});
/* registration form submission */
$(document).on('submit', '#register-form', function(event){
	event.preventDefault();
	var form_data = $(this).serialize();
	$('#register_wait_alert').css('display', 'block');
	$.post('/ajax/register', form_data, function(response){
		if (response.status == 'error') {
			$('#form_error').addClass('alert alert-danger');
			$('#form_error').html(response.msg);
		} else {
			if (response.status == 'success'){
				$('#form_error').removeClass('alert alert-danger');
				$('#form_error').html('');
				$('#form_success').addClass('alert alert-success');
				$('#form_success').html(response.msg);
				$('#register-form').css('display', 'none');
			}
		}
	});
});
/* subscribe modal */
$(document).on('click', '#subscribe-btn', function(event){
	event.preventDefault();
	$('#newsletter_modal').modal();
});
$(document).on('click', '#close_newsletter_modal', function(event){
	event.preventDefault();
	$('#newsletter_modal').modal('hide');
});
$(document).on('submit', '#newsletter-subscribe-form', function(event){
	event.preventDefault();
	var form_data = $(this).serialize();
	$.post('/ajax/subscribe', form_data, function(response){
		if (response.status == 'error') {
			$('#subscribe_form_error').addClass('alert alert-danger');
			$('#subscribe_form_error').html(response.msg);
		} else {
			if (response.status == 'success'){
				$('#subscribe_form_error').removeClass('alert alert-danger');
				$('#subscribe_form_error').html('');
				$('#subscribe_form_success').addClass('alert alert-success');
				$('#subscribe_form_success').html(response.msg);
				$('#newsletter-subscribe-form').css('display', 'none');
				window.setTimeout(function(){
					$('#newsletter_modal').modal('hide');
				}, 2000);
			}
		}
	});
});
/* login modal */
$(document).on('click', '#login-btn', function(event){
	event.preventDefault();
	$('#login_modal').modal();
});
$(document).on('click', '#close_login_modal', function(event){
	event.preventDefault();
	$('#login_modal').modal('hide');
});
/* login form submission */
$(document).on('submit', '#login-form', function(event){
	event.preventDefault();
	var form_data = $(this).serialize();
	var redirect = $('input[name="redirect"]').val();
	$.post('/ajax/login', form_data, function(response){
		if (response.status == 'error') {
			$('#login_form_error').addClass('alert alert-danger');
			$('#login_form_error').html(response.msg);
		} else {
			if (response.status == 'success'){
				$('#login_form_error').removeClass('alert alert-danger');
				$('#login_form_error').html('');
				$('#login_form_success').addClass('alert alert-success');
				$('#login_form_success').html(response.msg);
				$('#login-form').css('display', 'none');
				window.setTimeout(function(){
					window.location.href = redirect;
				}, 2000);
			}
		}
	});
});
/* contact form submission */
$(document).on('submit', '#contact-form', function(event){
	event.preventDefault();
	var form_data = $(this).serialize();
	$.post('/ajax/contact', form_data, function(response){
		console.log(response);
		if (response.status == 'error') {
			$('#contact_form_error').addClass('alert alert-danger');
			$('#contact_form_error').html(response.msg);
		} else {
			if (response.status == 'success'){
				$('#contact_form_error').removeClass('alert alert-danger');
				$('#contact_form_error').html('');
				$('#contact_form_success').addClass('alert alert-success');
				$('#contact_form_success').html(response.msg);
				$('#contact-form').css('display', 'none');
			}
		}
	});
});
/* rating */
$(document).on('click', '.rating-thumb', function(event){
	event.preventDefault();
	var rating = $(this).attr('data-rating');
	var bookmaker = $(this).attr('data-bookmaker');
	$.post('/ajax/rate', {rating:rating, bookmaker:bookmaker}, function(response){
		if (response.status == 'error') {
			$('#rating-wrapper').append('<span id="rating_error" class="alert alert-danger center-block" style="width:240px;">'+response.msg+'</span>');
			setTimeout(function(){
				$('#rating_error').remove();
			}, 2000);
		} else {
			if (rating == 0) {
				$('#dislikes_count').html(response.msg);
			} else {
				$('#likes_count').html(response.msg);
			}
		}
	})
});
/* logout btn */
$(document).on('click', '#logout-btn', function(event){
	event.preventDefault();
	$.get('/ajax/logout', function(response){
		window.location.href = '/';
	});
});
/* odds tab */
$(document).on('click', '.market-tab', function(){
	var market = $(this).attr('data-market');
	$('.market-tab').each(function(){
		$(this).removeClass('active');
	});
	$('.odds-container').each(function(){
		$(this).css('display', 'none');
	});
	$(this).addClass('active');
	$('#'+market).css('display', 'block');
});
$(document).on('click', '.collapse-odds', function(event){
	$('.collapse.in').collapse('hide');
	$('.collapse-odds').each(function(){
		$(this).parent().parent().removeClass('highlight');
	});
	$(this).parent().parent().addClass('highlight');
});
/* team search form */
$(document).on('keyup', 'input[name="search"]', function(event){
	var search_term = $(this).val();
	if (search_term.length > 2) {
		$.post('/ajax/search', {team:search_term}, function(response){
			$('#team_search_result').css('display', 'block');
			$('#team_search_result').html(response);
		});
	} else {
		$('#team_search_result').css('display', 'none');
		$('#team_search_result').html('');
	}
});
$(document).on('mouseleave', '.event-search', function(){
	$('input[name="search"]').val('');
	$('#team_search_result').html('');
	$('#team_search_result').css('display', 'none');
});
$(document).on('click', '#close-info-strip', function(event){
	event.preventDefault();
	$.get('/ajax/dismiss_info_strip', function(response){
		$('#info-strip').hide();
		$('#topnav').css('margin-top', '0px');
	});
});