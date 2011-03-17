/**
 * To Generate a Time Dropdown with start and end time, generate a datePicker and a hidden value for submitting as a
 * Time Stamp
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Tom Gallacher <tom.gallacher@clock.co.uk>
 * @version 1.0
 * @options startHour, endHour, dateValue, dateTabIndex, timeTabIndex, dbDateTime, submitName
 */

(function($) {
	$.fn.dateTimePicker = function(options) {
		/**
		 * These are the default options that will be used
		 * Can be overridden
		 */
		var defaults = {
			startHour : 0,
			endHour : 23,
			timeValue : "09:00",
			timeTabIndex : "",
			dateTabIndex : ""
		};

		var options = $.extend(defaults, options);
		var hours = [];
		return this.each(function() {
			var dateContainerElement;
			var timeDropdownElement;
			var dateTimePickerElement = $(this);

			initialise();

			function initialise() {

				dateContainerElement = $($("<span>")[0]).addClass("date-control");
				dateTimePickerElement.append(dateContainerElement);
				createTimeDropdown();
				createDatePickerElement();
				createHiddenInput();
				setHiddenValue();
			}

			/**
			 * Creates a <select> in the dom, generates start and end hours
			 * and appends the element to the perent container
			 */
			function createTimeDropdown() {
				timeDropdownElement = $($("<select>")[0]);

				for ( var i = options.startHour; i <= options.endHour; i++) {
					hours.push(i);
				}

				timeDropdownElement.addClass("time-dropdown listbox default");
				timeDropdownElement.attr("tabIndex", options.timeTabIndex);
				generateTimeOption(null, "");
				dateContainerElement.append(timeDropdownElement);
				$.each(hours, generateHours);

				timeDropdownElement.change(onTimeDropdownChange);
			}

			/**
			 * Generates hours and time for use in Generating <select> options
			 */
			function generateHours(index, hour) {
				hour = hour < 10 ? "0" + hour : hour;
				var timeArray = [];
				timeArray.push(hour + ":" + "00");
				timeArray.push(hour + ":" + "15");
				timeArray.push(hour + ":" + "30");
				timeArray.push(hour + ":" + "45");
				$.each(timeArray, generateTimeOption);
			}

			/**
			 * Generates Options for <select>
			 */
			function generateTimeOption(index, time) {
				timeValue = time;
				option = $($("<option>")[0]);
				option.attr("value", timeValue = timeValue != "" ? " " + timeValue + ":00" : timeValue);
				option.html(time);
				option.attr("selected", time == options.timeValue);
				timeDropdownElement.append(option);
			}

			/**
			 * Creates a datepicker element and appends it to the perent element
			 */
			function createDatePickerElement(dateValue, dateTabIndex) {

				datePickerElement = $($("<input>")[0]);
				datePickerElement.attr("type", "text");
				datePickerElement.addClass("date-picker textbox");
				datePickerElement.attr("value", options.dateValueFormatted);
				datePickerElement.attr("tabindex", options.dateTabIndex);
				dateContainerElement.append(datePickerElement);
				createDatePicker();
				datePickerElement.change(onDateChange);
			}

			/**
			 * Assigns the datepicker to the Datepicker element
			 */
			function createDatePicker(){
				var altDatePicker = $($("<input>")[0]).addClass("alt-date-picker");
				altDatePicker.attr("type", "hidden");
				altDatePicker.attr("value", options.dateValue);
				dateContainerElement.append(altDatePicker);
				dateTimePickerElement.find("input.date-picker").datepicker( {
					dateFormat : "dd M yy",
					altField : ".alt-date-picker",
					altFormat : "yy-mm-dd"
				});
			}

			/**
			 * Creates a hidden input which is to populated with date time stamp
			 */
			function createHiddenInput(hiddenValue, name) {
				hiddenInput = $($("<input>")[0]).addClass("hidden-date");
				hiddenInput.attr("type", "hidden");
				hiddenInput.attr("value", options.dbDateTime);
				hiddenInput.attr("name", options.name);
				dateContainerElement.append(hiddenInput);
			}

			/**
			 * sets the hidden value
			 */
			function setHiddenValue() {
				var dateFormat = dateTimePickerElement.find("input.alt-date-picker").val()
				var timeStamp = dateFormat + dateTimePickerElement.find("select.time-dropdown").val();
				dateTimePickerElement.find("input.hidden-date").val(timeStamp);
			}

			function setTime() {

			}

			/**
			 * Events
			 */

			function onTimeDropdownChange() {
				setHiddenValue();
				onChange();
			}

			function onDateChange() {
				setHiddenValue();
				onChange();
			}

			function updateHiddenField() {

			}

			/**
			 * This can be overriden to all this picker to work with other components.
			 */
			function onChange() {

			}

		});
	};
})(jQuery);