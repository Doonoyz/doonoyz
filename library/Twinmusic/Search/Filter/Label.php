<?php
/**
 * Contain this label
 *
 * @package    Doonoyz
 * @subpackage library/search/label
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Twinmusic_Search_Filter_Label extends Twinmusic_Search_Filter {
	/**
	 * Filter engine
	 *
	 * @param Array $result Results to filter
	 * @return Array Filtered results
	 */
	public function run($results) {
		foreach ( $results as $index => $infos ) {
			$bool = ($infos ['LABEL_ID'] == $this->_value);
			if ($this->getNot () ? $bool : ! $bool) {
				unset ( $results [$index] );
			}
		}
		return ($results);
	}
}
