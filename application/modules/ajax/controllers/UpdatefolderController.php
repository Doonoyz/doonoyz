<?php
/**
 * Update Folder Ajax Controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_UpdatefolderController extends Zend_Controller_Action {
	protected function _setAnswer($message) {
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->setBody(Zend_Json::encode(array('default' => $message)));
	}

	/**
	 * Called by AjaxController
	 *
	 * Match the right id to the right action
	 *
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender(true);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		
		if (preg_match ( "/([^_]+)_([0-9]+)/", $_GET ['id'], $globb )) {
			$folder = new Twinmusic_Folder ( $globb [2] );
			$group = new Twinmusic_Group ( $folder->getGroupId () );
			if ($group->inGroup ( Twindoo_User::getCurrentUserId () ) || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
				switch ($globb [1]) {
					case "editFolder" :
						$folder->setName ( $_GET ['value'] );
						break;
					case "publicFolder" :
						$folder->setPublic ( ($_GET ['value'] == "true") ? true : false );
						break;
				}
				$folder->commit ();
				$this->view->setConfig(
					array ('scriptPath' => ROOT_DIR . 'application/modules/default/views/scripts',
						'compileDir' => ROOT_DIR . 'application/modules/default/views/compile',
						'cacheDir' => ROOT_DIR . 'application/modules/default/views/cache'
				));
				$this->view->clearAllCache ( 'user:' . $group->getUrl () );
			}
		}
		$return = trim ( $_GET ['value'] ) == "" ? t_( "(empty)" ) : Twindoo_Utile::cleanHtml ( trim ( $_GET ['value'] ) );
		$this->_setAnswer ( strip_tags ( $return ));
	}
}
