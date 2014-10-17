var create_unverified_user_path = '/create_unverified_user';
var verify_path = '/verify';
var google_oauth_path = '/auth/google_oauth2';

$(document).ready(function() {

	$('#create_unverified_user_form').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			    url: create_unverified_user_path,
			    data: $(this).serialize(),
			    success: function (data) {
			    	toggleModal();
			    	beginTimer();
			},
			    error: function (xhr, status, error) {
			},
			    async: true
			    }); 
	    });

	$('#verify_form').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			    url: verify_path,
			    data: $(this).serialize(),
			    success: function (data) {
			    	window.location.replace('/auth/google_oauth2');
			},
			    error: function (xhr, status, error) {
			},
			    async: true
			    }); 
	    });

	function toggleModal() {
		var $overlay = $('#overlay');
		var $modal = $('#modal');
		$overlay.css('visibility', $overlay.css('visiblity') == 'visible' ? 'hidden' : 'visible' );
		$modal.css('visibility', $overlay.css('visiblity') == 'visible' ? 'hidden' : 'visible' );
	}

	var tid;

	function beginTimer() {
		clearInterval(tid);
		var $timer = $('#timer');
		var current_time = 120;
		$timer.html(current_time);
		tid = setInterval(function () {
			current_time = current_time - 1;
			$timer.html(current_time);
			if ( current_time == 0 ) {
				clearInterval(tid)
			}
		},1000);
	}

});

