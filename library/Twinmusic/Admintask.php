<?php
/**
 * Admin task manager
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Admintask {
	/**
	 * Task id
	 *
	 * @var int
	 */
	private $_id = 0;
	/**
	 * Message Id
	 *
	 * @var int
	 */
	private $_message_id = 0;
	/**
	 * Message arguments
	 *
	 * @var string
	 */
	private $_message_args = '';
	/**
	 * Component name task is about
	 *
	 * @var string
	 */
	private $_component_name = '';
	/**
	 * Component Id
	 *
	 * @var int
	 */
	private $_component_id = 0;
	/**
	 * Reporter user id
	 *
	 * @var int
	 */
	private $_reporter_id = 0;

	/**
	 * Association between human readable text and Code
	 *
	 * @var Array
	 */
	private $_definitions;

	/**
	 * Task to report a blog
	 *
	 */
	const REPORTBLOG = 1;
	/**
	 * Task to report a compo
	 *
	 */
	const REPORTCOMPO = 2;
	/**
	 * Task to alert new competence
	 *
	 */
	const NEWCOMPETENCE = 3;
	/**
	 * Task to alert new contact type
	 *
	 */
	const NEWCONTACTTYPE = 4;
	/**
	 * Task to alert new style
	 *
	 */
	const NEWSTYLE = 5;
	/**
	 * Task to alert new label
	 *
	 */
	const NEWLABEL = 6;

	/**
	 * Constructor
	 *
	 * @param int $id Task id
	 */
	public function __construct($id = 0) {
		$this->_setDefinitions ();
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_ADMINTASK WHERE TASK_ID = ?";
			$result = $db->fetchAll ( $sql , Array($id));
			if (count ( $result )) {
				$this->_id = $result [0] ['TASK_ID'];
				$this->_message_id = $result [0] ['TASK_MESSAGE_ID'];
				$this->_message_args = $result [0] ['TASK_MESSAGE_ARGS'];
				$this->_component_name = $result [0] ['TASK_COMPONENT_NAME'];
				$this->_component_id = $result [0] ['TASK_COMPONENT_ID'];
				$this->_reporter_id = $result [0] ['TASK_REPORTER_ID'];
			}
		}
	}

	/**
	 * Create a new task with its definition
	 *
	 * @param int $id Id of the task definition (see consts)
	 */
	public function setMessage($id) {
		if (isset ( $this->_definitions [$id] )) {
			$this->_message_id = $id;
		}
	}

	/**
	 * Set message values
	 *
	 * @param Array $args Array containing needed message values
	 */
	public function setMessageArgs($args) {
		if (!is_array ( $args )) {
			$argsTemp[] = $args;
			$args = $argsTemp;
		} else {
			foreach ($args as $key => $value) {
				$args[$key] = stripslashes($value);
			}
		}
		$this->_message_args = serialize ( $args );
	}

	/**
	 * Set the component name
	 *
	 * @param string $component Component name
	 */
	public function setComponentName($component) {
		$componentObj = "Twinmusic_" . ucfirst ( strtolower ( $component ) );
		try {
			$obj = new $componentObj ( );
			$this->_component_name = stripslashes ( $component );
		} catch ( Exception $e ) {
		}
	}

	/**
	 * Set the component Id
	 *
	 * @param int $id Component Id
	 */
	public function setComponentId($id) {
		if (is_numeric ( $id ) && $id > 0) {
			$this->_component_id = $id;
		}
	}

	/**
	 * Create the task
	 *
	 */
	public function commit() {
		$sql = "INSERT INTO DN_ADMINTASK SET ";
		$sql .= "TASK_MESSAGE_ID = ?,";
		$sql .= "TASK_MESSAGE_ARGS = ?,";
		$sql .= "TASK_COMPONENT_NAME = ?,";
		$sql .= "TASK_COMPONENT_ID = ?,";
		$sql .= "TASK_REPORTER_ID = ?";

		$values = Array ($this->_message_id, $this->_message_args, $this->_component_name, $this->_component_id, Twindoo_User::getCurrentUserId () );

		$db = Twindoo_Db::getDb ();
		if (is_numeric ( $this->_message_id ) && $this->_message_id > 0) {
			$db->query ( $sql, $values );
			$this->_id = $db->lastInsertId ();
		}
	}

	/**
	 * Assign human readble task to the task definition
	 *
	 */
	private function _setDefinitions() {
		$this->_definitions [self::REPORTBLOG] = t_( "The blog %s has been reported!" );
		$this->_definitions [self::REPORTCOMPO] = t_( "The composition %s has been reported!" );
		$this->_definitions [self::NEWCOMPETENCE] = t_( "The skill/ability %s has been added!" );
		$this->_definitions [self::NEWCONTACTTYPE] = t_( "The contact type %s has been added!" );
		$this->_definitions [self::NEWSTYLE] = t_( "The musical style %s has been added!" );
		$this->_definitions [self::NEWLABEL] = t_( "The label %s has been added!" );
	}

	/**
	 * Delete the current task
	 *
	 */
	public function delete() {
		if (is_numeric ( $this->_id ) && $this->_id > 0) {
			$sql = "DELETE FROM DN_ADMINTASK WHERE TASK_ID = ?";
			$db = Twindoo_Db::getDb ();
			$db->query ( $sql, Array ($this->_id ) );
		}
	}

	/**
	 * Get all admin tasks
	 *
	 * @return Array Array containing informations
	 */
	public function getTasks() {
		$return = Array();
		$db = Twindoo_Db::getDb ();
		$db->beginTransaction();
		try {
			$sql = "SELECT * FROM DN_ADMINTASK WHERE TASK_ASSIGNED_ID = ?";
			$return = Array ();
			$result = $db->fetchAll ( $sql , Array(Twindoo_User::getCurrentUserId()));
			foreach ( $result as $line ) {
				$return [] = $this->_createArray($line);
			}
			if (count($return) < 10) {
				$limit = 10 - count($return);
				$sql = "SELECT * FROM DN_ADMINTASK WHERE TASK_ASSIGNED_ID IS NULL LIMIT $limit";
				$result = $db->fetchAll ( $sql );
				foreach ( $result as $line ) {
					$return [] = $this->_createArray($line);
					$sql = "UPDATE DN_ADMINTASK SET TASK_ASSIGNED_ID = ? WHERE TASK_ID = ?";
					$db->query($sql, Array(Twindoo_User::getCurrentUserId(), $line['TASK_ID']));
				}
			}
			$db->commit();
		} catch (Exception $e) {
			$db->rollBack();
		}
		return ($return);
	}
	
	/**
	 * Create the informations for admin tasks
	 *
	 * @param array $line Array containing informations from database
	 *
	 * @return Array Array containing informations
	 */
	private function _createArray($line) {
		$array = Array ();
		$array ['id'] = $line ['TASK_ID'];
		$array ['message'] = vsprintf ( $this->_definitions [$line ['TASK_MESSAGE_ID']], unserialize ( $line ['TASK_MESSAGE_ARGS'] ) );
		$array ['userId'] = $line ['TASK_REPORTER_ID'];
		$user = new Twindoo_User($line ['TASK_REPORTER_ID']);
		$array ['userName'] = $user->getLogin();
		$array ['componentName'] = $line ['TASK_COMPONENT_NAME'];
		$array ['componentId'] = $line ['TASK_COMPONENT_ID'];
		$instance = 'Twinmusic_'.ucfirst(strtolower($line ['TASK_COMPONENT_NAME']));
		$instance = new $instance($line ['TASK_COMPONENT_ID']);
		$array ['groupId'] = (method_exists($instance, 'getGroupId')) ? $instance->getGroupId() : 0;
		unset($instance);
		return ($array);
	}
}
