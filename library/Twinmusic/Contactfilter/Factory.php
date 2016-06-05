<?php
/**
 * Factory of Contactfilter
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
final class Twinmusic_Contactfilter_Factory {
	/**
	 * Constructor, do not use !
	 */
	public function __construct() {
		throw new Twinmusic_Contactfilter_Exception('Can not create factory, must use ::run instead!');
	}
	
	/**
	 * Clone, do not use !
	 */
	public function __clone() {
		throw new Twinmusic_Contactfilter_Exception('Can not create factory, must use ::run instead!');
	}
	
	/**
	 * sleep, do not use !
	 */
	public function __sleep() {
		throw new Twinmusic_Contactfilter_Exception('Can not create factory, must use ::run instead!');
	}
	
	/**
	 * wake up, do not use !
	 */
	public function __wakeup() {
		throw new Twinmusic_Contactfilter_Exception('Can not create factory, must use ::run instead!');
	}
	
	/**
	 * Run the requested filter
	 *
	 * @param string $name  Name of the filter to use
	 * @param string $value Value to filter
	 *
	 * @return string Value filtered
	 *
	 * @throws Twinmusic_Contactfilter_Exception
	 */
	static public function run($name, $value) {
		$name = ucfirst ( strtolower ( trim ( $name ) ) );
		if ( empty ( $name ) ) {
			return $value;
		}
		$object = 'Twinmusic_Contactfilter_Filter_' . $name;
		if ( ! class_exists ( $object ) ) {
			throw new Twinmusic_Contactfilter_Exception('Filter does not exists!');
		}
		$instance = new $object;
		if ( ! ( $instance instanceof Twinmusic_Contactfilter_Interface ) ) {
			throw new Twinmusic_Contactfilter_Exception('Filter must implements Twinmusic_Contactfilter_Interface!');
		}
		return ( $instance->run( $value ) );
	}
}