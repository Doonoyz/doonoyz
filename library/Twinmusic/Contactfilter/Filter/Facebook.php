<?php
/**
 * Facebook filter
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Contactfilter_Filter_Facebook implements Twinmusic_Contactfilter_Interface {
	/**
	 * Function to filter the value
	 *
	 * @param string $value Value to filter
	 *
	 * @return string Value filtered
	 */
	public function run($value) {
		//check if the domain is set. If it is, retrieve the pseudo value
		if ( preg_match ('/.*^(facebook\.com)/', $value, $match ) ) {
			$value = 'http://www.facebook.com/' . $value;
		}
		return ($value);
	}
}