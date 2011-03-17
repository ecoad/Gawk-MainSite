(function($) {
	$.fn.addTag = function(options) {

		var defaults = {
				load: false
		};

		var options = $.extend(defaults, options);
		var formElement = $(this);
		formElement.find(":input[value=" + options.buttonValue + "]").click(onSubmitClick);
		var hiddenField = formElement.find(":input[name=Tags]");
		var tags = [];

		if (hiddenField.val() != "") {
			tags = $.trim(hiddenField.val()).split("\n");
		}

		if (options.load) {
			updateTagButtons();
		}

		function onSubmitClick() {
			var tag = formElement.find(":input[name='TagField']").val();
			if (tag != "") {
				if (tag != formElement.find("span.tag-name").html()) {
					tags.push(tag);
					updateTagButtons();
					updateHiddenInput();
				}
			}
			clearTextField();
			return false;
		}

		function onDelete() {
			var newTag = $(this).parent().find("span.tag-name").html();

			tags = $.grep(tags, function(tag) {
				return tag != newTag;
			});

			updateHiddenInput();
			updateTagButtons();
		}

		function updateTagButtons() {
			var tagList = $(".tag-list").html("");

			$(tags).each(function(index, tag) {
				if (tag != "") {
					if (tag != $("span.tag-name").html()) {
						var listItem = $("<li>");

						var tagNameContainer = $("<span>").addClass("tag-name");
						tagNameContainer.html(tag);

						listItem.append(tagNameContainer);

						var spanButton = $("<span>").addClass("micro-button");
						spanButton.append($("<strong>").attr("title", "Remove Tag").html("x"));
						spanButton.click(onDelete);

						listItem.append(spanButton);
						$(".tag-list").append(listItem);
					}
				}
			});

		}

		function updateHiddenInput() {
			hiddenField.val(tags.join("\n") + "\n");
		}

		function clearTextField() {
			formElement.find(":input[name='TagField']").val("");
		}
	};
})(jQuery);