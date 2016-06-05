<?php
/**
 * Group manager Aajx controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_GroupmanagerController extends Zend_Controller_Action {

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
			$group = new Twinmusic_Group ( $globb [2] );
			if ($group->inGroup ( Twindoo_User::getCurrentUserId (), false )) {
				switch ($globb [1]) {
					case "quit" :
						$this->_removeFromGroup ( $group );
						$this->_setAnswer ( t_( 'You\'re not in this group anymore!' ) );
						break;
					case "accept" :
						$this->_accept ( $group );
						$this->_setAnswer ( t_( 'You accepted to join this group!' ) );
						break;
					case "decline" :
						$this->_removeFromGroup ( $group );
						$this->_setAnswer ( t_( 'You declined to join this group!' ) );
						break;
				}
				$this->view->setConfig(
					array ('scriptPath' => ROOT_DIR . 'application/modules/default/views/scripts',
						'compileDir' => ROOT_DIR . 'application/modules/default/views/compile',
						'cacheDir' => ROOT_DIR . 'application/modules/default/views/cache'
				));
				$this->view->clearAllCache ( 'user:' . $group->getUrl () );
			} else
				$this->_setAnswer ( t_( 'Sorry, you\'re not in this group any longer!' ) );
		} else {
			$this->_setAnswer ( t_( "Error" ) );
		}
	}

	/**
	 * Decline invitation from group
	 *
	 * @param Twinmusic_Group $group Group to decline invitation from
	 */
	private function _removeFromGroup($group) {
		if ($group->getAdmin() != Twindoo_User::getCurrentUserId ()) {
			// I am NOT the admin so let me go away
			$group->removeFromGroup ( Array (Twindoo_User::getCurrentUserId () ) );
		} else {
			// I am the admin so delete the group
			$group->delete();
			$group->commit();
		}
	}

	/**
	 * Accept invitation from group
	 *
	 * @param Twinmusic_Group $group Group to accept invitation from
	 */
	private function _accept($group) {
		$group->activateInGroup ( Array (Twindoo_User::getCurrentUserId () ) );
	}
}
