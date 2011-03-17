<?php
/**
 * @package Base
 * @subpackage News
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 */

/**
 * Include Data.php so that DataControl can be extended.
 */
require_once("Atrox/Core/Data/Data.php");

/**
 *
 * @author Paul Serby {@link mailto:paul.serby@clock.co.uk paul.serby@clock.co.uk }
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 * @package Base
 * @subpackage News
 */
class NewsCategoryControl extends DataControl {
	var $table = "NewsCategory";
	var $key = "Id";
	var $sequence = "NewsCategory_Id_seq";
	var $defaultOrder = "Category";
	var $searchFields = array("Category");

	function init() {
		$this->fieldMeta["Id"] = new FieldMeta(
			"Id", "", FM_TYPE_INTEGER, null, FM_STORE_NEVER, false);

		$this->fieldMeta["Category"] = new FieldMeta(
			"Category", "", FM_TYPE_STRING, 50, FM_STORE_ALWAYS, false);

		$this->fieldMeta["ImageId"] = new FieldMeta(
			"Image Id", "", FM_TYPE_BINARY, null, FM_STORE_ALWAYS, true);
	}
}