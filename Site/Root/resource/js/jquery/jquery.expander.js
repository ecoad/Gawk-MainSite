/**
 *	Makes Divs expandable when toggle switch is clicked.
 *
 * @copyright Clock Limited 2010
 * @license http://opensource.org/licenses/bsd-license.php New BSD License
 * @author Ben Hutton <ben.hutton@clock.co.uk>
 * @version 1.0
 * @param {String} toggleSwitch Defines the class for the element containing toggle switch. Defaults to "expander-switch".
 * @param {String} panelToExpand Defines the class for the element containing the content. Defaults to "expander-panel".
 * @param {Boolean} upDefault Defines if the content panel should be shown or hidden when the page loads. Defaults to true.
 */

(function($) {
	$.fn.makeExpander = function(toggleSwitch, panelToExpand, upDefault){

		var expanderElement = $(this);
		var expanderPanel = panelToExpand;
		var expanderSwitch = toggleSwitch;
		var expanderUpDefault = upDefault;

		if(!toggleSwitch){
			expanderSwitch = "expander-switch";
		}
		if(!panelToExpand){
			expanderPanel = "expander-panel";
		}
		if(expanderUpDefault == undefined){
			expanderUpDefault = true;
		}

		if(expanderUpDefault){
			expanderElement.children("." + expanderSwitch).children("span").hide();
			expanderElement.children("div." + expanderPanel).hide();
		} else {
			expanderElement.children("." + expanderSwitch).children("strong").hide();
		}

		expanderElement.children("." + expanderSwitch).css({'cursor':'pointer'});
		function onClick(event){
			$expanderDiv = $(this);
			$expanderDiv.parents(expanderElement).children("div." + expanderPanel).slideToggle('slow');
			$expanderDiv.children("strong").toggle();
			$expanderDiv.children("span").toggle();
		}

		return this.each(function() {
			$(this).find("." + expanderSwitch).click(onClick);
		});
	};
})(jQuery);