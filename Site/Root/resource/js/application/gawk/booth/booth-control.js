var BoothControl = function(apiLocation) {
	var competitionForm = $("form"), emailAddressInput = $("input[name=EmailAddress]"),
	emailAddressSubmit = $("input[name=Submit]"), emailAddressErrorElement = $("div.invalid-email-address");

	function init() {
		addEventListeners();
	}

	function addEventListeners() {
		competitionForm.submit(onCompetitionFormSubmit);
	}

	function onCompetitionFormSubmit(event) {
		if (validateEmail(emailAddressInput.val())) {
			competitionForm.submit(function(){}); // Prevent double submit
		} else {
			emailAddressErrorElement.show();
			event.preventDefault();
		}
	}

	function validateEmail(elementValue){
		var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		return emailPattern.test(elementValue);
	}

	init();
};