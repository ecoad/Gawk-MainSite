/**
 * Adds a formatting toolbar to the given collection of textareas and
 * Input controls with a type of Text
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Paul Serby <paul.serby@clock.co.uk>
 * @version 1.0
 */
(function($) {
	$.fn.toolbar = function(options) {

		return this.each(function() {

			var defaultButtons =
				[
				{
					description: "<strong>B</strong>",
					className: "strong",
					action: onStrongClick
				},
				{
					description: "<em><strong>i</strong></em>",
					className: "emphasized",
					action: onEmphasizedClick
				},
				{
					description: "<strong>H2</strong>",
					className: "h2",
					action: onH2Click
				},
				{
					description: "<strong>H3</strong>",
					className: "h3",
					action: onH3Click
				},
				{
					description: "<strong>H4</strong>",
					className: "h4",
					action: onH4Click
				},
				{
					description: "<strong>H5</strong>",
					className: "h5",
					action: onH5Click
				},
				{
					description: "*",
					className: "bullet",
					action: onBulletClick
				},
				{
					description: "#",
					className: "numbered-bullet",
					action: onNumberedBulletClick
				},
				{
					description: "href",
					className: "link",
					action: onLinkClick
				},
				{
					description: "Image",
					className: "image",
					action: onImageClick
				}
			];

			function onStrongClick() {
				$.fn.toolbar.markup(textarea, "''", "''");
			}

			function onEmphasizedClick() {
				$.fn.toolbar.markup(textarea, "'''", "'''");
			}

			function onH2Click() {
				$.fn.toolbar.markup(textarea, "==", "==");
			}

			function onH3Click() {
				$.fn.toolbar.markup(textarea, "===", "===");
			}

			function onH4Click() {
				$.fn.toolbar.markup(textarea, "====", "====");
			}

			function onH5Click() {
				$.fn.toolbar.markup(textarea, "=====", "=====");
			}

			function onBulletClick() {
				$.fn.toolbar.markup(textarea, "* ", "");
			}

			function onNumberedBulletClick() {
				$.fn.toolbar.markup(textarea, "# ", "");
			}

			function onLinkClick() {
				var url = prompt("Enter the URL you wish to link to:");
				if (url) {
					$.fn.toolbar.markup(textarea, "[[" + url + " ", "]]", "[[" + url);
				}
			}
			function onImageClick() {
				var url = prompt("Enter URL of the image:");
				if (url) {
					$.fn.toolbar.markup(textarea, "[[image:" + url + "]]", "");
				}
			}

			var toolbarElement,
				textarea,
				caretPosition = 0,
				selection = "";

			var config = {
				buttons: defaultButtons
			};

			if (options) {
				$.extend(config, options);
			}

			function addButton(button) {
				var buttonElement = $("<span>")
					.html(button.description)
					.addClass(button.className)
					.click(function() {
						button.action(textarea);
					}
				);

				toolbarElement.append(buttonElement);
			}

			function addToolbar(textareaControl) {
				toolbarElement = $("<div>").addClass("toolbar-toolbar");
				textareaControl.before(toolbarElement);

				$(config.buttons).each(function(index, value) {
					addButton(value);
				});
			}
			textarea = $(this)[0];
			addToolbar($(this));
		});
	};

	$.fn.toolbar.markup = function(textarea, prefix, postfix, altPrefix) {

		var scrollPosition = textarea.scrollTop;
		textarea.focus();
		var ie4 = document.all;
		var ns4 = document.layers;
		var ns6 = document.getElementById && !document.all;
		if (textarea) {
			if (ns6) {
				var selectionStart = textarea.selectionStart;
				var selectionEnd = textarea.selectionEnd;
				selectedText = textarea.value.substring(selectionStart,selectionEnd);
				if ((altPrefix != undefined) && (selectedText.length == 0)) {
					prefix = altPrefix;
				}
				textarea.value = textarea.value.substring(0, selectionStart) + prefix + selectedText +postfix + textarea.value.substring(selectionEnd);
				textarea.setSelectionRange(selectionStart + prefix.length, selectionStart + prefix.length + selectedText.length);
			} else if (ns4) {
				textarea.value += prefix + "<Type Here>" + postfix;
				textarea.setSelectionRange(textarea.value.length-postfix.length-11,textarea.value.length-postfix.length, textarea.value.length-postfix.length);
			} else if (ie4) {
				if (document.selection != null) {
					tr = document.selection.createRange();
					tr.text = prefix+tr.text+postfix;
					tr.select();
				} else {
					textarea.value += prefix + postfix;
				}
			}
		}
		textarea.focus();
		textarea.scrollTop = scrollPosition;
	};

})(jQuery);