var create_unverified_user_path = '/create_unverified_user';
var verify_path = '/verify';

$(document).ready(function() {

	$('#create_unverified_user_form').submit(function (e) {
		e.preventDefault();
		toggleModal();
		return; // testing
		$.ajax({
			type: 'POST',
			    url: create_unverified_user_path,
			    data: $(this).serialize(),
			    success: function (data) {
			    	// open modal and show pin
			    	// start timer
			    	// open another connection with server, waiting for verification
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
		beginTimer();
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
		},1000);
	}

});

