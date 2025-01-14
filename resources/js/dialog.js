
var $dialog;

(function() {

	$dialog = {

		confirm: function(message, callback) {

			return bootbox.dialog({
				title: "Atenção!",
				message: message,
				buttons: {
					cancel: { label: "Cancelar", className: "btn-light" },
				    confirm: { label: "Ok", className: "btn-primary", callback: callback }
				}
			});
		},

		alert: function(message, title = null) {

			return bootbox.alert({
                title: title ? title : "Atenção!",
                size: 'large',
				message: message
			});
		},

	};

})();
