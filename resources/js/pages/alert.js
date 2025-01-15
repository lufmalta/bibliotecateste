/**
 * Javascript do helper "Alert"
 */

var closeAlert = function($elem) {

	setTimeout(function() {

		$elem.removeClass('fadeInDown').addClass('fadeOutUp');

		setTimeout(function() {
			$elem.remove();
		}, 500);

	}, 8000);


}

var $alert;

(function() {

	$('.alert:not(.sticky)').each(function() {
		closeAlert($(this));
	});

	var toggle = function(type, message, $alertContainer) {

		var $container = $alertContainer || $('.alert-container').first();

		var html =
		'<div class="alert alert-'+type+' animated fadeInDown">\
			' + message + '\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">\
		    	<span aria-hidden="true">&times;</span>\
		    </button>\
		</div>';

		var $elem = $(html);

		closeAlert($elem);
		$container.append($elem);
	}

	$alert = {

		success: function(message, $alertContainer) {
			toggle('success', message, $alertContainer);
		},

		info: function(message, $alertContainer) {
			toggle('info', message, $alertContainer);
		},

		error: function(message, $alertContainer) {
			toggle('danger', message, $alertContainer);
		},

		warning: function(message, $alertContainer) {
			toggle('warning', message, $alertContainer);
		}
	};

})();
