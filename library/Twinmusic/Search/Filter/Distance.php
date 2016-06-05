<?php
/**
 * Filter distances
 *
 * @package    Doonoyz
 * @subpackage library/search/filter
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Twinmusic_Search_Filter_Distance extends Twinmusic_Search_Filter {
	/**
	 * Longitude set by the filter
	 *
	 * @var float
	 */
	private $_longitude = 0;
	/**
	 * Latitude set by the filter
	 *
	 * @var float
	 */
	private $_latitude = 0;

	/**
	 * Filter engine
	 *
	 * @param Array $result Results to filter
	 * @return Array Filtered results
	 */
	public function run($results) {
		$this->_value = ( int ) $this->_value;

		foreach ( $results as $index => $infos ) {
			if (!$infos ['GROUP_LOCATION_PROCESSED']) {
				unset ( $results [$index] );
				continue;
			}
			$groupLong = $infos ['GROUP_LONG'];
			$groupLat = $infos ['GROUP_LAT'];
			$distance = Twindoo_LocationService::distance ( $groupLat, $groupLong, $this->_latitude, $this->_longitude );
			$bool = ($distance <= $this->_value);
			if ($this->getNot () ? $bool : ! $bool) {
				unset ( $results [$index] );
			}
		}
		return ($results);
	}

	/**
	 * Set special params for the filter
	 *
	 * @param Array $params Array of special params
	 */
	public function setSpecial($params = Array()) {
        $params ['POSTAL'] = strlen($params ['POSTAL']) ? $params ['POSTAL'] : NULL;
        try {
			$infos = Twindoo_LocationService::getInfos ( $params ['CITY'], $params ['COUNTRY'], $params ['POSTAL']);
			$this->_longitude = $infos ['LONGITUDE'];
			$this->_latitude = $infos ['LATITUDE'];
		} catch (Exception $e) {
		}
	}
}
