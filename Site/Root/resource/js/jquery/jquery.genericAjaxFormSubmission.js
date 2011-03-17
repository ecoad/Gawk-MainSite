(function($) {
	$.fn.genericAjaxFormSubmission = function(options) {

		var defaults = {
				onError : function() {},
				onSuccess : function() {},
				onButtonClose : function() {},
				onComplete : function() {}
			};

		var options = $.extend(defaults, options);

		var formElement = $(this);

		formElement.find("input[value=" + options.buttonValue + "]").click(onSubmitClick);

		function onSubmitClick() {
			formArrayElement = formElement.parents().filter("form");
			getServiceJson();
			return false;
		}

		function getServiceJson() {
			var data = formArrayElement.serializeArray();
			data.push({"name":"Action","value":options.action});
			jQuery.getJSON(options.serviceUrl,data,
				function(json) {
					if (json.success) {
						$("div.form-errors").hide();
						$(":input:not(input[type=submit]):not(input[type=hidden])").val("");
						options.onSuccess();
						$("#dialog").dialog({
							title: options.dialogTitle,
							resizable: false,
							draggable: false,
							modal: true,
							buttons: {
								"Close": function() {
									options.onButtonClose();
									$(this).dialog("close");
								}
							}
						});
					} else {
						$(":input:not(input[type=submit]):not(input[type=hidden])").parent().find("p").remove();
						jQuery.each(json.errors, function(key, error) {
							var html = "";
							var formLabel = $(":input[name=" + key + "]").parent();
							if(!formLabel.find("p").length) {
								var errorMessage = $($("<p>")[0]);
							} else {
								var errorMessage = formLabel.filter("p");
							}
							if ($(this).find(":input").is(".medium")) {
								errorMessage.addClass("medium");
							} else if ($(this).find(":input").is(".wide")) {
								errorMessage.addClass("wide");
							}
							errorMessage.addClass("input-error form-errors");
							errorMessage.html(error);
							formLabel.prepend(errorMessage);
						});
						options.onError();
						$("div.form-errors").show();
					}
				}
			);
			$(":input:not(input[type=submit]):not(input[type=hidden])").parent().find("p").remove();
			options.onComplete();
		}
	};
})(jQuery);