<?php
/**
 * Interface Contactfilter
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
interface Twinmusic_Contactfilter_Interface {
	/**
	 * Function to filter the value
	 *
	 * @param string $value Value to filter
	 *
	 * @return string Value filtered
	 */
	public function run($value);
}