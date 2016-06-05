<?php
/**
 * Ajax component to add informations in group
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
 
class Ajax_AddingroupController extends Zend_Controller_Action {

	protected function _setAnswer($message) {
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->setBody(Zend_Json::encode(array('default' => $message)));
	}
	/**
	 * Default action called by AjaxController
	 *
	 * Match the posted ID to the right action to do
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender(true);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		if (preg_match ( "/([^_]+)_([0-9]+)(_.+)?/", $_GET ['id'], $globb )) {
			$group = new Twinmusic_Group ( $globb [2] );
			if ($group->getAdmin () == Twindoo_User::getCurrentUserId () || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
				switch ($globb [1]) {
					case "addCompetenceUniqueSelect" :
						$this->addCompetenceUniqueSelect ( $group );
						break;
					case "addCompetenceSelect" :
						$this->addCompetenceSelect ( $group );
						break;
					case "addCompetenceUniqueAdding" :
						$this->addCompetenceUniqueAdding ( $group );
						break;
					case "addCompetenceAdding" :
						$this->addCompetenceAdding ( $group );
						break;
					case "addStyleSelect" :
						$this->addStyleSelect ( $group );
						break;
					case "addStyleAdding" :
						$this->addStyleAdding ( $group );
						break;
					case "addContactSelect" :
						$this->addContactSelect ( $group );
						break;
					case "addContactAdding" :
						$this->addContactAdding ( $group );
						break;
					case "addMember" :
						$this->addMember ( $group );
						break;
				}
				$this->view->setConfig(
					array ('scriptPath' => ROOT_DIR . 'application/modules/default/views/scripts',
						'compileDir' => ROOT_DIR . 'application/modules/default/views/compile',
						'cacheDir' => ROOT_DIR . 'application/modules/default/views/cache'
				));
				$this->view->clearAllCache ( 'user:' . $group->getUrl () );
			} else
				$this->_setAnswer ('error');
		} else {
			$this->_setAnswer ('error');
		}
	}

	/**
	 * Add a unique competence (added to the group admin)
	 *
	 * @param Twinmusic_Group $group Group to add competence for
	 */
	private function addCompetenceUniqueSelect($group) {
		$competence = new Twinmusic_Competence ( $_GET ['value'] );
		$competence->assignTo ( $group->getAdmin (), $group->getId () );
		$this->_setAnswer ( 'ok' );
	}

	/**
	 * Add a competence to a user (third parameter in ID)
	 *
	 * @param Twinmusic_Group $group Group to add competence for
	 */
	private function addCompetenceSelect($group) {
		if (preg_match ( "/(.+)_([0-9]+)_([0-9]+)/", $_GET ['id'], $globb )) {
			$competence = new Twinmusic_Competence ( $_GET ['value'] );
			$competence->assignTo ( $globb [3], $group->getId () );
			$this->_setAnswer ( 'ok' );
		} else
			$this->_setAnswer ( 'error' );
	}

	/**
	 * Add a new competence and assign it to the group admin
	 *
	 * @param Twinmusic_Group $group Group to add competence for
	 */
	private function addCompetenceUniqueAdding($group) {
		$competence = new Twinmusic_Competence ( );
		$competence->setName ( $_GET ['value'] );
		$competence->setActive ( false );
		$competence->commit ();
		$competence->assignTo ( $group->getAdmin (), $group->getId () );
		
		$this->_setAnswer ( 'ok' );
	}

	/**
	 * Add a new competence and assign it to the user in group
	 *
	 * @param Twinmusic_Group $group Group to add competence for
	 */
	private function addCompetenceAdding($group) {
		if (preg_match ( "/(.+)_([0-9]+)_([0-9]+)/", $_GET ['id'], $globb )) {
			$competence = new Twinmusic_Competence ( );
			$competence->setName ( $_GET ['value'] );
			$competence->setActive ( false );
			$competence->commit ();
			$competence->assignTo ( $globb [3], $group->getId () );
			
			$this->_setAnswer ( 'ok' );
		} else
			$this->_setAnswer ( 'error' );
	}

	/**
	 * Add a style to the group
	 *
	 * @param Twinmusic_Group $group Group to add style for
	 */
	private function addStyleSelect($group) {
		$style = new Twinmusic_Groupstyle ( $_GET ['value'] );
		$style->assignTo ( $group->getId () );
		$this->_setAnswer ( 'ok' );
	}

	/**
	 * Create and add style to the group
	 *
	 * @param Twinmusic_Group $group Group to add style for
	 */
	private function addStyleAdding($group) {
		$style = new Twinmusic_Groupstyle ( );
		$style->setName ( $_GET ['value'] );
		$style->setActive ( false );
		$style->commit ();
		$style->assignTo ( $group->getId () );
		
		$this->_setAnswer ( 'ok' );
	}

	/**
	 * Add contact to group
	 *
	 * @param Twinmusic_Group $group Group to add contact for
	 */
	private function addContactSelect($group) {
		$contact = new Twinmusic_Contact ( );
		$contact->setTypeId ( $_GET ['idContact'] );
		$contact->setGroupId ( $group->getId () );
		$contact->setValue ( $_GET ['value'] );
		$contact->commit ();
		$this->_setAnswer ( 'ok' );
	}

	/**
	 * Create contact type and add to the group
	 *
	 * @param Twinmusic_Group $group Group to add contact for
	 */
	private function addContactAdding($group) {
		$contacttype = new Twinmusic_Contacttype ( );
		$contacttype->setActive ( false );
		$contacttype->setName ( $_GET ['idContact'] );
		$contacttype->commit ();
		
		$contact = new Twinmusic_Contact ( );
		$contact->setTypeId ( $contacttype->getId () );
		$contact->setGroupId ( $group->getId () );
		$contact->setValue ( $_GET ['value'] );
		$contact->commit ();
		$this->_setAnswer ( 'ok' );
	}

	/**
	 * Add a member to the group
	 *
	 * @param Twinmusic_Group $group Group to add member for
	 */
	private function addMember($group) {
		$return = true;
		$user = new Twindoo_User ( $_GET ['value'] );
		if (!$user->getId ()) {
			$return = $user->create($_GET ['value']);
		}
		if ($return) {
			$group->addToGroup ( Array ($user->getId () ) );
		}
		$this->_setAnswer ( $return ? t_( 'User added successfully. Refresh to see him/her' ) : t_('User can\'t be invited, check his/her email address'));
	}
}
