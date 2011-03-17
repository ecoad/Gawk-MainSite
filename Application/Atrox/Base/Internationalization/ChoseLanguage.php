<?php
/**
 * @package Base
 * @subpackage Internationalization
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 */

/**
 * Include Data.php so that DataControl can be extended.
 */
require_once("Atrox/Core/Data/Data.php");
 
/**
 * Controls the languages the application can be viewed in.
 * @author David Folan (Clock Ltd) {@link mailto:david.folan@clock.co.uk david.folan@clock.co.uk }
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 * @package Base
 * @subpackage Internationalization
 */
class ChosenLanguageControl extends DataControl {

	var $table = "ChosenLanguage";
	var $key = "Id";
	var $sequence = "ChosenLanguage_Id_seq";
	var $defaultOrder = "LanguageCode";
	
	function init() {
		$this->fieldMeta["Id"] = new FieldMeta(
			"Id", "", FM_TYPE_INTEGER, null, FM_STORE_NEVER, false);

		$this->fieldMeta["LanguageCode"] = new FieldMeta(
			"Language Code", "", FM_TYPE_STRING, 255, FM_STORE_ALWAYS, false);
			
		$this->fieldMeta["Description"] = new FieldMeta(
			"Language Description", "", FM_TYPE_STRING, 255, FM_STORE_ALWAYS, false);				
	}	
}