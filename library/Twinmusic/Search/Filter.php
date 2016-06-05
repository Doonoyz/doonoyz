<?php
/**
 * Filter template class
 *
 * @package    Doonoyz
 * @subpackage library/search
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

abstract class Twinmusic_Search_Filter {
	/**
	 * Value of the filter
	 *
	 * @var string
	 */
	protected $_value = '';
	/**
	 * Negative value (filter the negative of what it must filter)
	 *
	 * @var bool
	 */
	private $_not = false;

	/**
	 * Filter engine, must be redifined in the filter
	 *
	 * @param Array $results Results to be filtered
	 */
	abstract public function run($results);

	/**
	 * Get the filter value
	 *
	 * @return string
	 */
	public function getValue() {
		return ($this->_value);
	}

	/**
	 * Define if the filter is negative
	 *
	 * @param bool $bool true to set the filter negative
	 */
	public function setNot($bool = true) {
		$this->_not = ($bool) ? true : false;
	}

	/**
	 * Check if the filter is negative
	 *
	 * @return bool True if it is negative
	 */
	public function getNot() {
		return ($this->_not);
	}

	/**
	 * Set special parameters of the filter
	 *
	 * @param Array $params Special parametres of the filter
	 */
	public function setSpecial($params = Array()) {
	}

	/**
	 * Set the value of the filter
	 *
	 * @param string $value value of the filter
	 */
	public function setValue($value) {
		if (!strlen($value)) {
			$value = ' ';
		}
		$this->_value = $value;
	}

	/**
	 * Factory to create filter
	 *
	 * @param string $filter Type of the filter
	 * 
	 * @throws Exception
	 *
	 * @return Twinmusic_Search_Filter Instance of the requested filter
	 */
	static public function factory($filter) {
		$array = explode ( '_', $filter );
		foreach ( $array as $key => $value ) {
			$array [$key] = ucfirst ( strtolower ( $value ) );
		}
		$filterName = implode ( '_', $array );
		$object = "Twinmusic_Search_Filter_" . $filterName;
		
		if (! class_exists ($object)) {
			throw new Exception ( sprintf ( t_( "Filter %s doesn't exist", $filter ) ) );
		}
		$element = new $object ( );
		return ($element);
	}
}
