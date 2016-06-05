<?php
/**
 * search only groups
 *
 * @package    Doonoyz
 * @subpackage library/search/filter
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Twinmusic_Search_Filter_Group extends Twinmusic_Search_Filter {
	/**
	 * Filter engine
	 *
	 * @param Array $result Results to filter
	 * @return Array Filtered results
	 */
	public function run($results) {
		foreach ( $results as $index => $infos ) {
			$bool = (count ( $infos ['USERS'] ) > 1);
			if ($this->getNot () ? $bool : ! $bool) {
				unset ( $results [$index] );
			}
		}
		return ($results);
	}
}
