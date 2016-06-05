<?php
/**
 * Studio Ajax Controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_StudioController extends Zend_Controller_Action {

	protected function _setAnswer($message) {
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->setBody(Zend_Json::encode(array('default' => $message)));
	}
	/**
	 * Called by AjaxController
	 *
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender(true);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		
		switch ($_GET ['action']) {
			case 'createFolder' :
				$this->_createFolder ();
				break;
			case 'deleteFolder' :
				$this->_deleteFolder ();
				break;
			default :
				$this->_setAnswer ( 'error' );
				break;
		}
	}

	/**
	 * Create a new folder
	 *
	 */
	private function _createFolder() {
		$group = new Twinmusic_Group ( $_GET ['id'] );
		if ($group->inGroup ( Twindoo_User::getCurrentUserId () ) || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
			$folder = new Twinmusic_Folder ( );
			$folder->setGroupId ( $group->getId () );
			$folder->setPublic ( false );
			$folder->setName ( $_GET ['value'] );
			$folder->commit ();
			$this->_setAnswer ( $folder->getId () );
		} else
			$this->_setAnswer ( 'error' );
	}

	/**
	 * Delete a Folder and all its compositions
	 *
	 */
	private function _deleteFolder() {
		$group = new Twinmusic_Group ( $_GET ['groupId'] );
		$answer = 'error';
		if ($group->inGroup ( Twindoo_User::getCurrentUserId () ) || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
			$folder = new Twinmusic_Folder ( $_GET ['value'] );
			if ($folder->getId () && ($folder->getGroupId () == $group->getId ())) {
				$folder->delete ();
				$answer = 'ok';
			}
		}
		$this->_setAnswer ( $answer );
	}
}
