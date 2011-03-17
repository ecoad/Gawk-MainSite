<?php
/**
 * @package Core
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 */

/**
 * Include Data.php so that DataControl can be extended.
 */
require_once("Atrox/Core/Data/Data.php");

/**
 * @author Paul Serby (Clock Ltd) {@link mailto:paul.serby@clock.co.uk paul.serby@clock.co.uk }
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 * @package Core
 */
class DirectAdministrationControl {

	var $controllers = array();
		
	function addHandler($dataControl, $url) {
		$this->controllers[$dataControl->table] = $url;
	}
	
	
	function createEditController($dataEntity) {
		if (isset($this->controllers[$dataEntity->control->table])) {
			return str_replace("{ID}", $dataEntity->get($dataEntity->control->key), $this->controllers[$dataEntity->control->table]);		
		}
	}	
		
}