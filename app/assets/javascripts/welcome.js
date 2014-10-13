var create_unverified_user_path = '/create_unverified_user';
var verify_path = '/verify';

$(document).ready(function() {
	console.log('executing');
	$('#create_unverified_user_form').submit(function (e) {
		console.log('test');
		e.preventDefault();
		$.ajax({
			type: 'POST',
			    url: create_unverified_user_path,
			    data: $(this).serialize(),
			    success: function (data) {
			    console.log('success');
			    console.log(data);
			},
			    error: function (xhr, status, error) {
			    console.log('error');
			},
			    async: true
			    }); 
	    });
});

