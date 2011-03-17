/**
 * To Generate a More Bullet Points and adding to a UrlEncoded Json hidden field
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Tom Gallacher <tom.gallacher@clock.co.uk>
 * @version 1.0
 */
(function($) {
	$.fn.addBulletPoints = function(options) {

		var defaults = {
				buttonValue: "Add",
				hiddenFieldName: "BulletPoints"
		};

		var options = $.extend(defaults, options);
		var formElement = $(this);
		formElement.find("input[value=" + options.buttonValue + "]").click(onSubmitClick);
		var saveButtonElement = formElement.find("input[value=\"Save\"]").live("click", onSave);
		var hiddenField = formElement.find("input[name=" + options.hiddenFieldName + "]");

		function onSubmitClick() {
			var buttonElement = formElement.find("input[value=" + options.buttonValue + "]");
			createField(buttonElement);
			removeButton(buttonElement);
			return false;
		}

		function onSave() {
			jsonString = "[";
			$("input.bullet-point").each(function(index) {
				jsonString += "\"" + $(this).val() + "\"";
				if ($("input.bullet-point").length != (index+1)) {
					jsonString += ", ";
				}
			});
			jsonString += "]";
			hiddenField.val(escape(jsonString));
		}

		function createField(buttonElement) {
			labelContainer = $($("<label>")[0]);
			inputContainer = $($("<input>")[0]);
			inputContainer.attr("type", "text");
			inputContainer.addClass("textbox wide bullet-point");
			strongContainer = $($("<strong>")[0]);
			numberOfBulletPoints = $(formElement.find("strong:contains('Bullet')")).length +1;
			strongContainer.html("Bullet Point " + numberOfBulletPoints);
			labelContainer.html(strongContainer);
			labelContainer.append(inputContainer);
			var buttonElementCreated = $($("<input>")[0]);
			buttonElementCreated.attr("type", "submit");
			buttonElementCreated.attr("name", "Add");
			buttonElementCreated.val("Add");
			buttonElementCreated.addClass("button");
			buttonElementCreated.click(onSubmitClick)
			labelContainer.append(buttonElementCreated);
			buttonElement.closest("label").parent().append(labelContainer);
		}

		function removeButton(buttonElement) {
			buttonElement.detach();
		}

		function addToHiddenInput(tag) {
			hiddenField.val(hiddenField.val() + tag + "\n");
		}
	}
})(jQuery);