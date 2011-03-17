<?php
/**
 * @package Core
 * @subpackage Graphic
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 */

/**
 * Color control
 * @author Paul Serby {@link mailto:paul.serby@clock.co.uk paul.serby@clock.co.uk }
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 * @package Core
 * @subpackage Graphic
 */

class ColorControl {
	
	function getRgbFromHex($colorHex) {
		sscanf($colorHex, "%2x%2x%2x", $red, $green, $blue);
		return (object)array("red" => $red, "green" => $green, "blue" => $blue);
	}
	
	function isHexColor($hexColor) {
		if (!$hexColor) {
			return false;
		}
		if (!mb_ereg("#{0,1}[A-Fa-f0-9]{6}", $hexColor)) {
			return false;
		}
		$hexColor = mb_substr($hexColor, -6, 6);
		return $hexColor;
	} 
}