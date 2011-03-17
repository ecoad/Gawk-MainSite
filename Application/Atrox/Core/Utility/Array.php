<?php
/**
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 * @package Core
 * @subpackage Utility
 */

/**
 * Extra array functions
 * 
 * @author Paul Serby {@link mailto:paul.serby@clock.co.uk paul.serby@clock.co.uk }
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 * @package Core
 * @subpackage Utility
 */
class ArrayControl {
	/**
	 * Perform a binary search on the elements within an array
	 *
	 * @param Array $array Array to be searched
	 * @param mixed $element Element to be searched
	 * @return mixed The found element or false if the element is not found
	 */
	function binarySearch($array, $element) {
		$low = 0;
		$high = count($array) - 1;
		while ($low <= $high) { 
			$mid = floor(($low + $high) / 2);  
			if ($element == $array[$mid]) {
				return $array[$mid];
			}
			else {
				if ($element < $array[$mid]) {
					$high = $mid - 1;
				}
				else {
					$low = $mid + 1;
				}
			}
		}
		return false; 
	}
	
	/**
	 * Peform a binary search on the keys of an array
	 *
	 * @param Array $array Array to be searched
	 * @param mixed $element Element to be searched
	 * @return mixed The found element or false if the element is not found
	 */
	function binaryKeySearch($array, $element) {
		$arrayKeys = array_keys($array);
		$low = 0;
		$high = count($arrayKeys) - 1;
		while ($low <= $high) { 
			$mid = floor(($low + $high) / 2);  
			if ($element == $arrayKeys[$mid]) {
				return $array[$arrayKeys[$mid]];
			}
			else {
				if ($element < $arrayKeys[$mid]) {
					$high = $mid - 1;
				}
				else {
					$low = $mid + 1;
				}
			}
		}
		return false; 
	}


	/**
	 * Reorder the given array by the keys provided in order  
	 *
	 * @param array $list The list to order
	 * @param array $order An array containing a list of keys in the order you need them
	 * @return array The newly order array
	 */
	function customKeyOrder($list, $order) {
		$newList = array();
		foreach($order as $value) {
			if (isset($list[$value])) {
				$newList[$value] = $list[$value];
				unset($list[$value]);
			}
		}
		return $newList + $list;
	}
	
	/**
	 * Reorder the given array to it can be listed in columns  
	 *
	 * @param array $list The list to order
	 * @param integer $columns Numer of columns
	 * @return array The newly order array
	 */
	function reorderForColumns($list, $columns) {
		
		$length = sizeof($list);
		
		if (($length < 3) || ($columns < 1) || ($columns > $length)) {
			return $list;
		}
		
		$columnLength = ceil($length / $columns);
		$keys = array_keys($list);
		
		$newList = array();
		for ($i = 0; $i < $columnLength; $i++) {
			for ($c = 0; $c < $columns; $c++) {
				if (isset($keys[$columnLength * $c + $i])) {
					$newList[$keys[$columnLength * $c + $i]] = $list[$keys[$columnLength * $c + $i]];
				}
			}	
		}	
		
		return $newList;
	}
}