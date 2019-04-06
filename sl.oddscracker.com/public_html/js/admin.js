$(document).on('click', '.confirm', function(event){
	event.preventDefault();
	var url = $(this).attr('href');
	var confirmation = window.confirm('This will permanently delete the selected record! Are you sure you want to continue?');
	if (confirmation === true) {
		window.location.href = url;
	}
});
$(document).ready(function(){
	$('#analytics_table').dataTable({
		"order": [[ 0, 'desc' ]],
		"pageLength": 500,
		"lengthMenu": [ [100, 250, 500, -1], [100, 250, 500, "All"] ]
	});
	$('#pages_table').dataTable({
		"order": [[ 0, 'desc' ]],
		"pageLength": 500,
		"lengthMenu": [ [100, 250, 500, -1], [100, 250, 500, "All"] ]
	});
	$('#bookmakers_table').dataTable({
		"order": [[ 0, 'desc' ]],
		"pageLength": 500,
		"lengthMenu": [ [100, 250, 500, -1], [100, 250, 500, "All"] ]
	});
	$('#users_table').dataTable({
		"order": [[ 0, 'desc' ]],
		"pageLength": 500,
		"lengthMenu": [ [100, 250, 500, -1], [100, 250, 500, "All"] ]
	});
	$('#messages_table').dataTable({
		"order": [[ 0, 'desc' ]],
		"pageLength": 500,
		"lengthMenu": [ [100, 250, 500, -1], [100, 250, 500, "All"] ]
	});
	$('#subscriptions_table').dataTable({
		"order": [[ 0, 'desc' ]],
		"pageLength": 500,
		"lengthMenu": [ [100, 250, 500, -1], [100, 250, 500, "All"] ]
	});
	$('#leagues_table').dataTable({
		"order": [[ 3, 'asc' ]],
		"pageLength": 500,
		"lengthMenu": [ [100, 250, 500, -1], [100, 250, 500, "All"] ]
	});
	$('#bans_table').dataTable({
		"order": [[ 0, 'desc' ]],
		"pageLength": 500,
		"lengthMenu": [ [100, 250, 500, -1], [100, 250, 500, "All"] ]
	});
});

$(document).on('click', '#send_newsletter_btn', function(event){
	event.preventDefault();
	$('#newsletter_modal').modal();
});
$(document).on('click', '.ban-btn', function(event){
	event.preventDefault();
	var ip_address = $(this).attr('data-ip');
	$.post('/admin/block_ip/'+ip_address, function(response){
		$('a[data-ip="'+ip_address+'"]').removeClass('ban-btn');
		$('a[data-ip="'+ip_address+'"]').html('<br>'+response);
		$('a[data-ip="'+ip_address+'"]').attr('onclick', 'return false;');
	});
});
