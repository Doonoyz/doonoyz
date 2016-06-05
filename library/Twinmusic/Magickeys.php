<?php
/**
 * Magic keys permit to store server side informations to be retrive later
 */
class Twinmusic_Magickeys {

	/**
	 * Entities to save
	 *
	 * @var entities
	 */
	static protected $_entities = array();
	/**
	 * Time to live of the entity
	 *
	 * @var Timeout
	 */
	protected $_timeout = 0;
	/**
	 * Datas to save
	 *
	 * @var Datas
	 */
	protected $_datas = array();
	
	/**
	 * Key of the instance
	 *
	 * @param string
	 */
	protected $_key = null;
	
	/**
	 * Singleton so, protected
	 */
	protected function __construct() {
	}
	
	/**
	 * Singleton so get the instance
	 *
	 * @param string $key Key of the instance
	 *
	 * @return Instance
	 */
	static public function getInstance($key) {
		self::_initKeys();
		if (!isset(self::$_entities[$key])) {
			$obj = new Twinmusic_Magickeys();
			$obj->setKey($key);
			$obj->setTimeout();
			self::$_entities[$key] = serialize($obj);
		}
		return (unserialize(self::$_entities[$key]));
	}
	
	/**
	 * Initialize all the instances
	 *
	 */
	static protected function _initKeys() {
		$cache = Zend_Registry::getInstance ()->cache;
		self::$_entities = $cache->load('magickeys');
		if (self::$_entities === false) {
			self::$_entities = array();
		}
		if (is_array(self::$_entities)) {
			foreach (self::$_entities as $id => $instance) {
				$obj = unserialize($instance);
				if ($obj->isExpired()) {
					unset(self::$_entities[$id]);
				}
				$obj = null;
			}
		}
		$cache->save(self::$_entities, 'magickeys');
	}
	
	/**
	 * Is it expired ?
	 *
	 * @return bool
	 */
	public function isExpired() {
		return (time() >= $this->_timeout);
	}
	
	/**
	 * Add seconds to timeout
	 *
	 * @param int $time Seconds to add
	 */
	public function setTimeout($time = 30) {
		$this->_timeout = time() + $time;
	}
	
	/**
	 * Save datas
	 *
	 * @param mixed $data Data to save
	 */
	public function setData($data) {
		$this->_datas = $data;
	}
	
	/**
	 * Define the key of the instance
	 *
	 * @param string $key Key of the instance
	 */
	public function setKey($key) {
		$this->_key = $key;
	}
	
	/**
	 * Get datas
	 *
	 * @return mixed
	 */
	public function getData() {
		return $this->_datas;
	}
	
	/**
	 * Retrieve the key of the instance
	 *
	 * @return string
	 */
	public function getKey() {
		return ($this->_key);
	}
	
	/**
	 * Save an instance into a key
	 *
	 * @param Twinmusic_Magickeys $obj Object to save
	 */
	static public function save(Twinmusic_Magickeys $obj) {
		self::_initKeys();
		self::$_entities[$obj->getKey()] = serialize($obj);
		$cache = Zend_Registry::getInstance ()->cache;
		$cache->save(self::$_entities, 'temp');
	}	
	/**
	 * Permit object (un)serializing
	 *
	 * return array Keys to serialize
	 */
	public function __sleep() {
		return array_keys( get_object_vars( $this ) );
	}
}