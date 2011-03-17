<?php
/**
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 * @package Core
 */

/**
 * @copyright Clock Limited 2010
 * @author Paul Serby {@link mailto:paul.serby@clock.co.uk paul.serby@clock.co.uk }
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 * @package Core
 */
class  Registry {
	/**
	 * Store for all the registry settings
	 * @var Array
	 */
	var $registry;
	
	/**
	 * Gets a value from the Registry
	 * @author Paul Serby {@link mailto:paul.serby@clock.co.uk paul.serby@clock.co.uk }
	 * @param String $location Where to get the value from 
	 * @return String The value stored in the give registry location
	 */
	function get($location, $defaultValue = null) {
		if (isset($this->registry[$location])) {
			return $this->registry[$location];
		}
		return $defaultValue;
	}
	
	/**
	 * Sets a value in the Registry
	 * @author Paul Serby {@link mailto:paul.serby@clock.co.uk paul.serby@clock.co.uk }
	 * @param String $location Where to store the value from 
	 * @param String $value What to store
	 * @return String The value stored in the give registry location
	 */
	function set($location, $value) {
		return $this->registry[$location] = $value;
	}		
}