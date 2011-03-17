<?php
/**
 * @package Core
 * @subpackage Data
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 */

/**
 * @author Paul Serby {@link mailto:paul.serby@clock.co.uk paul.serby@clock.co.uk }
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 * @package Core
 * @subpackage Data
 */
class ManyToMany {
	var $table = null;
	var $control = null;
	var $linkTable = null;
	var $pKey = null;
	var $fKey = null;

	function ManyToMany($table, $linkTable, $pKey, $fKey, $control) {
		$this->control = $control;
		if ($table == null) {
			trigger_error("Table name is empty. ",E_USER_ERROR);
		}
		$this->table = $table;
		$this->linkTable = $linkTable;
		$this->pKey = $pKey;
		$this->fKey = $fKey;
	}
}