<?php
/**
 * Interface to determine if component is treatable as an admin component
 *
 * @package    Doonoyz
 * @subpackage library/admin
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

interface Twinmusic_Admin_Component_Interface {

	/**
	 * Retrieve all competencies available
	 *
	 * @return Array Array containing informations
	 */
	static public function getList();

	/**
	 * Get competence Name
	 *
	 * @return string
	 */
	public function getName();
	
	/**
	 * Set competence Name
	 *
	 * @param string $value New name
	 */
	public function setName($value);
	
	/**
	 * Set competence Active state
	 *
	 * @param bool $value active state
	 */
	public function setActive($value = true);
	
	/**
	 * Save the updates
	 */
	public function commit();
	
	/**
	 * Delete Competence
	 *
	 */
	public function delete();
	
	/**
	 * Replace componenent with this/these
	 *
	 * @param Array[int] $array Array of component Id to replace component with
	 *
	 * @return bool Success of the operation
	 */
	public function replaceWith($array);
}
