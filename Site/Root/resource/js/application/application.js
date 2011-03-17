var ApplicationControl = Class.create();

//TODO: Update the application javascript to work with jQuery - Ben
ApplicationControl.prototype = {
  initialize: function() {
  },

  confirmDelete: function() {
  	var answer = confirm("Delete selected items?");
		if (answer) {
			document.form.submit();
		}
  },

  toggleTags: function(checkBox, className) {
		elements = $A(document.getElementsByClassName(className));

		if (checkBox.checked) {
			elements.each(function(item) {
				Element.extend(item);
				item.show();
			});
		} else {
			elements.each(function(item) {
				Element.extend(item);
				item.hide();
			});
		}
	}
}