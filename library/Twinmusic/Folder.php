<?php
/**
 * Folder manage
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Folder {
	/**
	 * Folder name
	 *
	 * @var string
	 */
	private $_name = "";
	/**
	 * Folder id
	 *
	 * @var int
	 */
	private $_id = 0;
	/**
	 * Folder public state
	 *
	 * @var bool
	 */
	private $_public = 1;
	/**
	 * Folder Group Id
	 *
	 * @var int
	 */
	private $_group_id = 0;

	/**
	 * Constructor
	 *
	 * @param int $id Folder Id
	 */
	public function __construct($id = 0) {
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_FOLDER WHERE FOLDER_ID = ?";
			$res = $db->fetchAll ( $sql, Array ($id ) );
			if (count ( $res )) {
				$this->_name = $res [0] ['FOLDER_NAME'];
				$this->_id = $res [0] ['FOLDER_ID'];
				$this->_public = $res [0] ['FOLDER_PUBLIC'];
				$this->_group_id = $res [0] ['GROUP_ID'];
			}
		}
	}

	/**
	 * Get Folder Id
	 *
	 * @return int
	 */
	public function getId() {
		return ($this->_id);
	}
	/**
	 * Get Folder Name
	 *
	 * @return string
	 */
	public function getName() {
		return ($this->_name);
	}
	/**
	 * Check if folder is public
	 *
	 * @return bool
	 */
	public function isPublic() {
		return ($this->_public ? true : false);
	}
	/**
	 * Get Group Id
	 *
	 * @return int
	 */
	public function getGroupId() {
		return ($this->_group_id);
	}

	/**
	 * Set folder name
	 *
	 * @param string $value folder name
	 */
	public function setName($value) {
		$this->_name = strip_tags ( $value );
	}
	/**
	 * Set folder public state
	 *
	 * @param bool $bool Public state
	 */
	public function setPublic($bool = true) {
		$this->_public = ($bool ? 1 : 0);
		$sql = "UPDATE DN_COMPO SET COMPO_PUBLIC = ? WHERE FOLDER_ID = ?";
		$db = Twindoo_Db::getDb ();
		$db->query ( $sql, array($this->_public, $this->_id) );
	}
	/**
	 * Set group id
	 *
	 * @param int $value Group id
	 */
	public function setGroupId($value) {
		if (is_numeric ( $value ) && $value > 0)
			$this->_group_id = $value;
	}

	/**
	 * Save all folder updates
	 *
	 */
	public function commit() {
		$sql = ($this->_id == 0) ? "INSERT INTO" : "UPDATE";
		$sql .= " DN_FOLDER SET ";
		$sql .= " FOLDER_NAME = ?, ";
		$sql .= " FOLDER_PUBLIC = ?, ";
		$sql .= " GROUP_ID = ? ";
		if ($this->_id != 0)
			$sql .= " WHERE FOLDER_ID = ?";

		$values = Array ($this->_name, $this->_public, $this->_group_id );
		if ($this->_id != 0)
			$values [] = $this->_id;

		$db = Twindoo_Db::getDb ();
		$db->query ( $sql, $values );
		if ($this->_id == 0)
			$this->_id = $db->lastInsertId ();
	}

	/**
	 * Get all folders and composition informations
	 *
	 * @param int  $groupId    Group Id
	 * @param bool $onlyPublic Retrieve only public folder/compositon
	 * 
	 * @return Array Array containing informations
	 */
	public function getAll($groupId = 0, $onlyPublic = false) {
		if (is_numeric ( $groupId ) && $groupId > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT f.FOLDER_ID, f.GROUP_ID, f.FOLDER_NAME, f.FOLDER_PUBLIC, c.COMPO_ID,
          c.COMPO_NAME, c.COMPO_FILE, c.COMPO_TYPE, c.COMPO_PUBLIC, c.COMPO_DELETED, c.COMPO_CREATION
          FROM DN_FOLDER f
					LEFT JOIN DN_COMPO c
						ON c.GROUP_ID = f.GROUP_ID
						AND c.FOLDER_ID = f.FOLDER_ID
						AND c.COMPO_DELETED = 0
					WHERE f.GROUP_ID = ?";
			$result = $db->fetchAll ( $sql, Array ($groupId ) );
			$final = Array ();
			if (count ( $result )) {
				foreach ( $result as $line ) {
					if (! isset ( $final [$line ['FOLDER_ID']] )) {
						$final [$line ['FOLDER_ID']] ['ID'] = $line ['FOLDER_ID'];
						$final [$line ['FOLDER_ID']] ['NAME'] = $line ['FOLDER_NAME'];
						$final [$line ['FOLDER_ID']] ['PUBLIC'] = $line ['FOLDER_PUBLIC'];
						$final [$line ['FOLDER_ID']] ['COMPO'] = Array ();
					}
					if ($line ['COMPO_ID']) {
						$final [$line ['FOLDER_ID']] ['COMPO'] [] = Array ('ID' => $line ['COMPO_ID'], 'NAME' => $line ['COMPO_NAME'], 'FILE' => $line ['COMPO_FILE'], 'TYPE' => $line ['COMPO_TYPE'], 'PUBLIC' => $line ['COMPO_PUBLIC'], 'CREATION' => $line ['COMPO_CREATION'] );
					}
				}
			}
			if ($onlyPublic) {
				foreach ( $final as $folderId => $info ) {
					if (! $info ['PUBLIC']) {
						unset ( $final [$folderId] );
					}
					foreach ( $info ['COMPO'] as $k => $compo ) {
						if (! $compo ['PUBLIC']) {
							unset ( $final [$folderId] ['COMPO'] [$k] );
						}
					}
				}
			}
			foreach ( $final as $folderId => $info ) {
				if (!count ($info ['COMPO']) && $onlyPublic) {
					unset ( $final [$folderId] );
				}
			}
			return ($final);
		}
	}

	/**
	 * Delete folders and all its compositions
	 *
	 * @return bool Success
	 */
	public function delete() {
		if ($this->_id) {
			$db = Twindoo_Db::getDb ();
			$sql = "UPDATE DN_COMPO SET COMPO_DELETED = 1 WHERE GROUP_ID = ? AND FOLDER_ID = ?";
			$values = Array ($this->_group_id, $this->_id );
			$db->query ( $sql, $values );
			$sql = "DELETE FROM DN_FOLDER WHERE FOLDER_ID = ?";
			$values = Array ($this->_id );
			$db->query ( $sql, $values );
			$this->_id = 0;
			return (true);
		} else
			return (false);
	}
}
