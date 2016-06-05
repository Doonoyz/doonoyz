<?php
/**
 * Filter to check if group url like value
 *
 * @package    Doonoyz
 * @subpackage library/search/filter/group
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Twinmusic_Search_Filter_Group_Url extends Twinmusic_Search_Filter {
	/**
	 * Filter engine
	 *
	 * @param Array $result Results to filter
	 * @return Array Filtered results
	 */
	public function run($result) {
		foreach ( $result as $index => $infos ) {
			$bool = strstr ( Twindoo_Utile::removeAccent ( $infos ['GROUP_URL'] ), Twindoo_Utile::removeAccent ( $this->_value ) );
			if ($this->getNot () ? $bool : ! $bool) {
				unset ( $result [$index] );
			}
		}
		return ($result);
	}
}
