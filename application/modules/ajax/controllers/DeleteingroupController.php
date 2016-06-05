<?php
/**
 * Delete in group Ajax controller to delete informations in a group
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_DeleteingroupController extends Zend_Controller_Action {

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
		
		if (preg_match ( "/([^_]+)_([0-9]+)_.+/", $_GET ['id'], $globb )) {
			$group = new Twinmusic_Group ( $globb [2] );
			if ($group->getAdmin () == Twindoo_User::getCurrentUserId () || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
				switch ($globb [1]) {
					case "deleteCompetenceUnique" :
						$this->deleteCompetenceUnique ( $group );
						break;
					case "deleteCompetence" :
						$this->deleteCompetence ( $group );
						break;
					case "deleteUser" :
						$this->deleteUser ( $group );
						break;
					case "deleteStyle" :
						$this->deleteStyle ( $group );
						break;
					case "deleteContact" :
						$this->deleteContact ( $group );
						break;
				}
				$this->view->setConfig(
					array ('scriptPath' => ROOT_DIR . 'application/modules/default/views/scripts',
						'compileDir' => ROOT_DIR . 'application/modules/default/views/compile',
						'cacheDir' => ROOT_DIR . 'application/modules/default/views/cache'
				));
				$this->view->clearAllCache ( 'user:' . $group->getUrl () );
				$this->_setAnswer ( 'ok' );
			} else
				$this->_setAnswer ( 'error' );
		} else {
			$this->_setAnswer ( 'error' );
		}
	}

	/**
	 * Delete Competence of the group admin
	 *
	 * @param Twinmusic_Group $group Group to delete competence from
	 */
	private function deleteCompetenceUnique($group) {
		if (preg_match ( "/(.+)_([0-9]+)_([0-9]+)/", $_GET ['id'], $globb )) {
			$competence = new Twinmusic_Competence ( $globb [3] );
			$competence->unAssignFor ( $group->getAdmin (), $group->getId () );
		}
	}

	/**
	 * Delete Competence of a group member
	 *
	 * @param Twinmusic_Group $group Group to delete competence from
	 */
	private function deleteCompetence($group) {
		if (preg_match ( "/(.+)_([0-9]+)_([0-9]+)_([0-9]+)/", $_GET ['id'], $globb )) {
			$competence = new Twinmusic_Competence ( $globb [4] );
			$competence->unAssignFor ( $globb [3], $group->getId () );
		}
	}

	/**
	 * Delete Style of a group
	 *
	 * @param Twinmusic_Group $group Group to delete competence from
	 */
	private function deleteStyle($group) {
		if (preg_match ( "/(.+)_([0-9]+)_([0-9]+)/", $_GET ['id'], $globb )) {
			$competence = new Twinmusic_Groupstyle ( $globb [3] );
			$competence->unAssignFor ( $group->getId () );
		}
	}

	/**
	 * Delete group member
	 *
	 * @param Twinmusic_Group $group Group to delete member from
	 */
	private function deleteUser($group) {
		if (preg_match ( "/(.+)_([0-9]+)_([0-9]+)/", $_GET ['id'], $globb )) {
			$group->removeFromGroup ( Array ($globb [3] ) );
		}
	}

	/**
	 * Delete group contact
	 *
	 * @param Twinmusic_Group $group Group to delete contact from
	 */
	private function deleteContact($group) {
		if (preg_match ( "/(.+)_([0-9]+)_([0-9]+)/", $_GET ['id'], $globb )) {
			$contact = new Twinmusic_Contact ( $globb [3] );
			if ($contact->getGroupId () == $group->getId ()) {
				$contact->delete ();
			}
		}
	}
}
