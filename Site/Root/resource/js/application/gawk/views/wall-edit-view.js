function WallEditView() {
	var global = this, element = $("#wall-edit-view"),
	formErrors, formErrorsList, urlFriendlyInput, nameInput, descriptionInput, secureIdInput;

	function init() {
		assignEventListeners();
		formErrors = element.find(".form-errors");
		formErrorsList = formErrors.find("ul");
		urlFriendlyInput = element.find("input[name=UrlFriendly]");
		nameInput = element.find("input[name=Name]");
		secureIdInput = element.find("input[name=SecureId]");
		
		descriptionInput = element.find("textarea[name=Description]");
	}

	function resetView() {
		formErrors.hide();
	}

	function assignEventListeners() {
		$(document).bind("GawkUIAllHide", onHideView);
		$(document).bind("GawkUIWallEditShow", onShowView);

		element.find("form").submit(onFormSubmit);
		element.find("input[name=Delete]").click(onDeleteClick);
	}

	function onFormSubmit(event) {
		event.preventDefault();
		var wall = {
				name: nameInput.val(),
				description: descriptionInput.val(),
				url: urlFriendlyInput.val(),
				secureId: secureIdInput.val()
		};
		$(document).trigger("GawkModelSaveWall", [wall]);
		$(document).unbind("GawkModelSaveWallResponse", onSaveWallResponse);
		$(document).bind("GawkModelSaveWallResponse", onSaveWallResponse);
	}

	function onSaveWallResponse(event, response) {
		if (response.success) {
			window.location.pathname = response.wall.url;
		} else {
			formErrorsList.html("");
			for(var key in response.errors) {
				var li = $("<li>").html(response.errors[key]);
				formErrorsList.append(li);
			};
			formErrors.show();
		}
	}
	
	function onDeleteClick(event) {
		event.preventDefault();
		if (confirm("really delete this wall? there's no going back!")) {
			var wall = {
				url: urlFriendlyInput.val(),
				secureId: secureIdInput.val()
			};
			$(document).trigger("GawkModelDeleteWall", [wall]);
			$(document).unbind("GawkModelDeleteWallResponse", onDeleteWallResponse);
			$(document).bind("GawkModelDeleteWallResponse", onDeleteWallResponse);
		}
	}
	
	function onDeleteWallResponse(event, response) {
		if (response.success) {
			window.location = "/wall/";
		}
	}

	function onShowView(event, preferredUrlFriendly) {
		if (preferredUrlFriendly) {
			urlFriendlyInput.val(preferredUrlFriendly);
		}
		element.show();
	}

	function onHideView() {
		element.hide();
	}

	init();
}