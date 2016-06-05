<?php
/**
 * Manage a composition
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Compo {

	/**
	 * FLV Output buffer constant
	 */
	const SIZE_CONST = 16384; //8192 is the greatest value :(
	/**
	 * Composition Id
	 *
	 * @var int
	 */
	private $_id;
	/**
	 * Composition group id
	 *
	 * @var int
	 */
	private $_group_id = 0;
	/**
	 * Composition folder id
	 *
	 * @var int
	 */
	private $_folder_id = 0;
	/**
	 * Composition name
	 *
	 * @var string
	 */
	private $_name;
	/**
	 * Compostion internal file name
	 *
	 * @var string
	 */
	private $_file;
	/**
	 * Composition type
	 *
	 * @var string (enum)
	 */
	private $_type;
	/**
	 * Composition public state
	 *
	 * @var bool
	 */
	private $_public = 1;
	/**
	 * Composition fetched state
	 *
	 * @var char (enum)
	 */
	private $_fetched = 'N';
	/**
	 * Composition deleted state
	 *
	 * @var bool
	 */
	private $_deleted = 0;
	/**
	 * Composition original extension
	 *
	 * @var string
	 */
	private $_originalExt;
	/**
	 * Composition creation date
	 *
	 * @var date
	 */
	private $_creationDate;
	/**
	 * Compostion number of view
	 *
	 * @var int
	 */
	private $_views = 0;

	/**
	 * Constructor
	 *
	 * @param int $id Composition Id
	 */
	public function __construct($id = 0) {
		$this->_id = 0;
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_COMPO WHERE COMPO_ID = ?";
			$results = $db->fetchAll ( $sql, Array ($id ) );
			if (count ( $results )) {
				$this->_id = $results [0] ['COMPO_ID'];
				$this->_group_id = $results [0] ['GROUP_ID'];
				$this->_name = $results [0] ['COMPO_NAME'];
				$this->_file = $results [0] ['COMPO_FILE'];
				$this->_type = $results [0] ['COMPO_TYPE'];
				$this->_public = $results [0] ['COMPO_PUBLIC'];
				$this->_deleted = $results [0] ['COMPO_DELETED'];
				$this->_folder_id = $results [0] ['FOLDER_ID'];
				$this->_creationDate = $results [0] ['COMPO_CREATION'];
				$this->_originalExt = $results [0] ['COMPO_ORIGINAL_EXT'];
				$this->_views = $results [0] ['COMPO_VIEWS'];
				$this->_fetched = $results [0] ['COMPO_FETCHED'];
			}
		}
	}

	/**
	 * Get the composition Id
	 *
	 * @return int
	 */
	public function getId() {
		return ($this->_id);
	}
	/**
	 * Get the composition group id
	 *
	 * @return int
	 */
	public function getGroupId() {
		return ($this->_group_id);
	}
	/**
	 * Get composition folder id
	 *
	 * @return int
	 */
	public function getFolderId() {
		return ($this->_folder_id);
	}
	/**
	 * Get composition name
	 *
	 * @return string
	 */
	public function getName() {
		return ($this->_name);
	}
	/**
	 * Get composition internal file name
	 *
	 * @return string
	 */
	public function getFile() {
		return ($this->_file);
	}
	/**
	 * Get composition type
	 *
	 * @return string
	 */
	public function getType() {
		return ($this->_type);
	}

	/**
	 * Check if the composition is fetched
	 *
	 * @return bool
	 */
	public function isFetched() {
		return ($this->_fetched != 'N');
	}
	/**
	 * Check if the composition is public
	 *
	 * @return bool
	 */
	public function isPublic() {
		return ($this->_public ? true : false);
	}
	/**
	 * Check if the composition is deleted
	 *
	 * @return bool
	 */
	public function isDeleted() {
		return ($this->_deleted ? true : false);
	}
	/**
	 * Get composition creation date
	 *
	 * @return date
	 */
	public function getCreationDate() {
		return ($this->_creationDate);
	}
	/**
	 * Get composition number of views
	 *
	 * @return int
	 */
	public function getViews() {
		return ($this->_views);
	}
	/**
	 * get composition original extension
	 *
	 * @return string
	 */
	public function getOriginalExt() {
		return ($this->_originalExt);
	}

	/**
	 * Set composition name
	 *
	 * @param sting $value Composition name
	 */
	public function setName($value) {
		$this->_name = strip_tags ( $value );
	}
	/**
	 * Set composition internal file name
	 *
	 * @param string $value Internal file name
	 */
	public function setFile($value) {
		$this->_file = strip_tags ( $value );
	}
	/**
	 * Set composition public state
	 *
	 * @param bool $value Composition public state
	 */
	public function setPublic($value = true) {
		if ($this->isFetched ()) {
			$this->_public = ($value) ? 1 : 0;
		}
	}

	/**
	 * Set composition fetched state
	 *
	 * @param string $value 'Y' => yes, 'N' => no, 'C' => current, 'E' => error
	 */
	public function setFetched($value) {
		$security = Array ('Y', 'N', 'C', 'E' );
		if (in_array ( $value, $security )) {
			$this->_fetched = strtoupper ( $value );
		}
	}

	/**
	 * Set composition group id
	 *
	 * @param int $value Group id
	 */
	public function setGroupId($value) {
		if (is_numeric ( $value ) && $value >= 1) {
			$this->_group_id = $value;
		}
	}

	/**
	 * Set composition original Extension
	 *
	 * @param string $value Composition original extension
	 */
	public function setOriginalExt($value) {
		$this->_originalExt = strip_tags ( $value );
	}

	/**
	 * Increase composition view counter
	 *
	 */
	public function addView() {
		$this->_views ++;
	}

	/**
	 * Set composition folder id
	 *
	 * @param int $value Folder id
	 */
	public function setFolderId($value) {
		if (is_numeric ( $value ) && $value >= 1) {
			$this->_folder_id = $value;
		}
	}

	/**
	 * Set composition type
	 *
	 * @param string $value 'video', 'picture', 'music' or 'text'
	 */
	public function setType($value) {
		$security = Array ('video', 'picture', 'music', 'text' );
		if (in_array ( $value, $security )) {
			$this->_type = $value;
		}
	}

	/**
	 * Save the composition updates
	 *
	 */
	public function commit() {
		if ($this->_id == 0) {
			$this->_creationDate = date ( "Y-m-d H:i:s" );
		}
		$db = Twindoo_Db::getDb ();
		$sql = ($this->_id == 0) ? "INSERT INTO" : "UPDATE";
		$sql .= " DN_COMPO SET ";
		$sql .= "GROUP_ID = ?, ";
		$sql .= "COMPO_NAME = ?, ";
		$sql .= "COMPO_FILE = ?, ";
		$sql .= "COMPO_TYPE = ?, ";
		$sql .= "COMPO_DELETED = ?, ";
		$sql .= "COMPO_FETCHED = ?, ";
		$sql .= "COMPO_CREATION = ?, ";
		$sql .= "COMPO_ORIGINAL_EXT = ?, ";
		$sql .= "COMPO_VIEWS = ?, ";
		$sql .= "FOLDER_ID = ?, ";
		$sql .= "COMPO_PUBLIC = ?";
		if ($this->_id != 0) {
			$sql .= " WHERE COMPO_ID = ?";
		}

		$values = Array ($this->_group_id, $this->_name, $this->_file, $this->_type, 
						$this->_deleted, $this->_fetched, $this->_creationDate, $this->_originalExt, 
						$this->_views, $this->_folder_id, $this->_public );

		if ($this->_id != 0) {
			$values [] = $this->_id;
		}
		$db->query ( $sql, $values );
		if ($this->_id == 0) {
			$this->_id = $db->lastInsertId ();
		}
	}

	/**
	 * Retrieve all compositions for a group
	 *
	 * @param int  $id	 Group Id
	 * @param bool $public Only publicated compositions
	 *
	 * @return Array Array containing informations
	 */
	public function getCompoForGroup($id, $public = false) {
		if (is_numeric ( $id ) && $id > 0) {
			$db = Twindoo_Db::getDb ();
			$sql = "SELECT * FROM DN_COMPO WHERE GROUP_ID = ? AND COMPO_DELETED = '0'";
			if ($public) {
				$sql .= " AND COMPO_PUBLIC = '1'";
			}
			$sql .= " ORDER BY COMPO_TYPE";
			return ($db->fetchAll ( $sql, Array ($id ) ));
		} else {
			return (false);
		}
	}

	/**
	 * Delete the composition
	 *
	 */
	public function delete() {
		if (is_numeric ( $this->_id ) && $this->_id > 0) {
			$sql = "UPDATE DN_COMPO SET COMPO_DELETED = '1' WHERE COMPO_ID = ?";
			$db = Twindoo_Db::getDb ();
			$db->query ( $sql, Array ($this->_id ) );
		}
	}

	/**
	 * Upload the composition
	 *
	 * @param Array $file $_FILES on the upload
	 *
	 * @return bool Success of the operation
	 */
	public function uploadFile($file) {
		$acceptedExtension = self::getAcceptedExtension();

		if (! $file ['error']) {
			$temp = explode ( '.', $file ['name'] );
			$ext = $temp [count ( $temp ) - 1];

			if (strlen ($ext) && isset ( $acceptedExtension [strtolower ( $ext )] ) && $acceptedExtension [strtolower ( $ext )]) {
				$this->setType ( $acceptedExtension [strtolower ( $ext )] );
				if (is_numeric ( $this->getGroupId () ) && $this->getGroupId () > 0) {
					$filename = time () . 'key' . rand ( 0, 99999 );
					$filename = (($this->isPublic ()) ? "public" : "private") . $filename;
					$pathConverted = $this->_getConvertedPath();
					$pathOriginal = $this->_getOriginalPath();
					$filePath = $pathConverted . $filename;
					$originalFilePath = $pathOriginal . $filename;
					$this->_createPath ( $originalFilePath );
					$this->_createPath ( $filePath );
					if (! is_uploaded_file ($file ['tmp_name'])) {
						return (false);
					}
					copy ( $file ['tmp_name'], $originalFilePath );
					chmod ( $originalFilePath, 0755 );
					$this->setFile ( $filename );
					$this->setOriginalExt ( strtolower ( $ext ) );
					return (true);
				}
			}
		}
		return (false);
	}

	/**
	 * Create path if folders doesn't exists
	 *
	 * @param string $path Path to create
	 */
	private function _createPath($path) {
		if (! is_dir ( dirname ( $path ) )) {
			mkdir ( dirname ( $path ), 0755, true );
		}
		if (! file_exists ( $path )) {
			touch ( $path );
		}
	}
	
	/**
	 * Stream the current file
	 *
	 * @param int $seekat Start position
	 */
	public function stream($seekat = 0) {
		set_time_limit(0);
		@apache_setenv('no-gzip', '1');
		@ini_set('zlib.output_compression', '0');
		@ini_set('implicit_flush', '1');
		for ($i = 0; $i < ob_get_level(); $i++) {
			ob_end_flush();
		}
		ob_implicit_flush(1);
		$file = $this->_getConvertedPath() . $this->getFile ();
		$fileSize = filesize($file) - (($seekat > 0) ? $seekat  + 1 : 0);
		ob_start();
		session_cache_limiter('nocache');
		header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		header ( 'Content-Length: ' . $fileSize );
		
		switch ($this->_type) {
			case 'music':
			case 'video':
				$mimetype = 'video/x-flv';
				$ext = 'flv';
				break;
			case 'text':
				$mimetype = 'application/x-shockwave-flash';
				$ext = 'swf';
				break;
			case 'picture':
				$mimetype = 'image/'.strtolower($this->getOriginalExt());
				$ext = $this->getOriginalExt();
				break;
			default:
				$mimetype = 'application/octet-stream';
				$ext = 'flv';
				break;
		}
		header("Content-Type: $mimetype");
		header("Content-Disposition: inline; filename=\"" . rawurlencode ( $this->getName () ) . ".$ext\"");
		ob_flush();
		flush();
	
		if ($this->_type == 'music' || $this->_type == 'video') {

			if ($seekat != 0) {
				print("FLV");
				print(pack('C', 1 ));
				print(pack('C', 1 ));
				print(pack('N', 9 ));
				print(pack('N', 9 ));
			}
		}
		$fh = fopen($file, "rb");
		fseek($fh, $seekat);
		while ($line = fread($fh, self::SIZE_CONST)) {
			print $line;
			ob_flush();
			flush();
			usleep(50000);// delay minimum of .05 seconds to allow ie to flush to screen 
		}
	}
	
	/**
	 * Download the current file
	 */
	public function download() {
		set_time_limit(0);
		@apache_setenv('no-gzip', '1');
		@ini_set('zlib.output_compression', '0');
		@ini_set('implicit_flush', '1');
		for ($i = 0; $i < ob_get_level(); $i++) {
			ob_end_flush();
		}
		ob_implicit_flush(1);
		ob_start();
		$file = $this->_getOriginalPath() . $this->getFile ();
		header ( 'Content-disposition: attachment; filename=' . rawurlencode ( $this->getName () ) . '.' . $this->getOriginalExt () );
		header ( 'Content-Type: application/force-download' );
		header ( 'Content-Transfer-Encoding: file' );
		header ( 'Content-Length: ' . filesize($file) );
		header ( 'Pragma: no-cache' );
		header ( 'Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0' );
		header ( 'Expires: 0' );
		ob_flush();
		flush();

		$fileHandle = fopen($file, 'rb');
		while ($line = fread($fileHandle, self::SIZE_CONST)) {
			print $line;
			ob_flush();
			flush();
			usleep(50000);// delay minimum of .05 seconds to allow ie to flush to screen 
		}
	}
	
	/**
	 * Return the path to the composition repository for converted composition
	 *
	 * @return string Path to the converted folder
	 */
	private function _getConvertedPath() {
		$convertedPath = Zend_Registry::getInstance()->config->composition->repository->path->converted;
		$convertedPath = str_replace('<ROOT>', ROOT_DIR, $convertedPath);
		$convertedPath = str_replace('<GROUP_ID>', $this->_group_id, $convertedPath);
		$convertedPath .= ($convertedPath[strlen($convertedPath)-1] == '/') ? '' : '/';
		return ($convertedPath);
	}
	
	/**
	 * Return the path to the composition repository for original composition
	 *
	 * @return string Path to the original folder
	 */
	private function _getOriginalPath() {
		$originalPath = Zend_Registry::getInstance()->config->composition->repository->path->original;
		$originalPath = str_replace('<ROOT>', ROOT_DIR, $originalPath);
		$originalPath = str_replace('<GROUP_ID>', $this->_group_id, $originalPath);
		$originalPath .= ($originalPath[strlen($originalPath)-1] == '/') ? '' : '/';
		return ($originalPath);
	}
	
	/**
	 * Returns an array containing extensions assigned to each type
	 *
	 * @param string $mode Mode of export (EXT : Ext => type , ACCEPT : [] => '*.ext', ELSE : TYPE => all ext)
	 *
	 * @return array Array containing informations
	 */
	static public function getAcceptedExtension($mode = 'EXT') {
		$config = new Zend_Config_Ini ( ROOT_DIR . 'application/files.ini' );

		$acceptedExtension = Array ();
		foreach ( $config as $type => $array ) {
			foreach ( $array as $ext ) {
				if ($mode == 'EXT') {
					$acceptedExtension [$ext] = $type;
				} elseif ($mode == 'ACCEPT') {
					$acceptedExtension [] = "*.$ext";
				} else {
					$acceptedExtension [$type] [] = $ext;
				}
			}
		}
		return $acceptedExtension;
	}
}
