<?php
/**
 * Contain this competence
 *
 * @package    Doonoyz
 * @subpackage library/search/filter
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Twinmusic_Search_Filter_Competence extends Twinmusic_Search_Filter {
	/**
	 * Filter engine
	 *
	 * @param Array $result Results to filter
	 * @return Array Filtered results
	 */
	public function run($results) {
		foreach ( $results as $index => $infos ) {
			$found = false;
			foreach ( $infos ['USERS'] as $userId => $userInfo ) {
				if (isset ( $userInfo ['COMPETENCIES'] [$this->_value] )) {
					$found = true;
				}
			}
			if ($this->getNot () ? $found : ! $found) {
				unset ( $results [$index] );
			}
		}
		return ($results);
	}
}
