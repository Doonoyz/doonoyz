<?php
/**
 * Invitation controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class InvitationController extends Zend_Controller_Action {
	/**
	 * Init if called ajaxly or not
	 *
	 */
	public function init() {
		$this->view->setCacheLife ( 0 );
		$this->view->setLayout ( 'ajax' );
		$this->view->addLayoutVar ( 'ajaxCall', (isset ( $_POST ['ajax'] ) ? 1 : 0) );
		if (isset ( $_POST ['ajax'] ))
			unset ( $_POST ['ajax'] );
		if (! Twindoo_User::getCurrentUserId ())
			$this->_redirect ( '/' );
	}

	/**
	 * Display interface to invite a user (if user exists)
	 *
	 */
	public function indexAction() {
		$userId = $this->_getParam ( 'userId' );
		$user = new Twindoo_User ( $userId );
		if ($user->getId ()) {
			$this->view->username = $user->getLogin ();
			$this->view->userId = $user->getId ();
			$this->view->groupList = Twinmusic_Group::getManagingGroups ();
			$this->view->competenceList = Twinmusic_Competence::getList ();
			$this->view->translate = new Twinmusic_Localized ( Twindoo_User::getLocale() );

			$this->view->invitation = t_( "Invitation" );
			$this->view->presentation = t_( "You're about to invite this user with selected abilities" );
			$this->view->usernameText = t_( "Username" );
			$this->view->competenciesText = t_( "Skills" );
			$this->view->newCompetence = t_( "New skill/ability" );
			$this->view->addCompetence = t_( "Add skill/ability" );
			$this->view->newGroup = t_( "New group" );
			$this->view->invite = t_( "Invite" );
		} else
			$this->_redirect ( '/' );
	}

	/**
	 * Add the user to the selected group
	 *
	 * Called ajaxly
	 *
	 */
	public function validateAction() {
		$this->getHelper ( 'viewRenderer' )->setNoRender ();
		$userId = $this->_getParam ( 'userId' );
		$user = new Twindoo_User ( $userId );
		$success = t_( "Error while adding this user to your group" );
		if ($user->getId ()) {
			$selectedGroup = $_POST ['selectedGroup'];
			$group = new Twinmusic_Group ( $selectedGroup );
			if ($group->getId ()) {
				$group->addToGroup ( Array ($user->getId () ) );

				if (isset ( $_POST ['comp'] ) && is_array ( $_POST ['comp'] )) {
					foreach ( $_POST ['comp'] as $id ) {
						$comp = new Twinmusic_Competence ( $id );
						$comp->assignTo ( $user->getId (), $group->getId () );
					}
				}

				if (isset ( $_POST ['newcomp'] ) && is_array ( $_POST ['newcomp'] )) {
					foreach ( $_POST ['newcomp'] as $text ) {
						$comp = new Twinmusic_Competence ( );
						$comp->setName ( $text );
						$comp->setActive ( false );
						$comp->commit ();
						$comp->assignTo ( $user->getId (), $group->getId () );
					}
				}
				$success = t_( "User successfully joined your group!" );
			}
		}
		$return = array();
		$return ['default'] = $success;
		print ( Zend_Json::encode ($return));
	}

	/**
	 * Display group creation interface
	 * Save group creation informations (called ajaxly)
	 *
	 */
	public function newgroupAction() {
		if (isset ( $_POST ['name'] ) && isset ( $_POST['groupname'] ) ) {
			$this->getHelper ( 'viewRenderer' )->setNoRender ();
			$group = new Twinmusic_Group ( );
			$return = array();
			if ($group->setUrl ( $_POST ['name'] )) {
				$group->setNom ( ( trim ( $_POST['groupname'] ) == '' ? $_POST ['name'] : trim ( $_POST['groupname'] ) ) );
				$group->setAdmin ( Twindoo_User::getCurrentUserId () );
				$group->commit ();
				$group->addToGroup ( Array (Twindoo_User::getCurrentUserId () ) );
				$group->activateInGroup ( Array (Twindoo_User::getCurrentUserId () ) );
				$return ['default'] = ( $group->getId () );
			} else {
				$return ['default'] = ( 'error' );
			}
			print (Zend_Json::encode($return));
			return;
		}

		$this->view->newGroup = t_( "New group/file" );
		$this->view->groupName = t_( "Group/file Name" );
		$this->view->create = t_( "Create" );
		$this->view->groupUrl = t_( "Group/file URL" );
		$this->view->required = t_( "required fields" );
	}

	/**
	 * Display Bid interface (you want to bid for a group)
	 * Save Bid informations
	 *
	 */
	public function bidAction() {
		$groupId = (isset ( $_POST ['groupId'] ) ? $_POST ['groupId'] : $this->_getParam ( 'groupId' ));
		$group = new Twinmusic_Group ( $groupId );

		if (isset ( $_POST ['validateBid'] )) {
			$this->getHelper ( 'viewRenderer' )->setNoRender ();
			$success = t_( "You must be connected to bid for this group" );
			if (Twindoo_User::getCurrentUserId ()) {
				$success = t_( "You're already in this group" );
				if ($group->getId () && ! $group->inGroup ( Twindoo_User::getCurrentUserId (), false )) {
					$group->bidToGroup ( Twindoo_User::getCurrentUserId () );

					if (isset ( $_POST ['comp'] ) && is_array ( $_POST ['comp'] )) {
						foreach ( $_POST ['comp'] as $id ) {
							$comp = new Twinmusic_Competence ( $id );
							$comp->assignTo ( Twindoo_User::getCurrentUserId (), $group->getId () );
						}
					}

					if (isset ( $_POST ['newcomp'] ) && is_array ( $_POST ['newcomp'] )) {
						foreach ( $_POST ['newcomp'] as $text ) {
							$comp = new Twinmusic_Competence ( );
							$comp->setName ( $text );
							$comp->setActive ( false );
							$comp->commit ();
							$comp->assignTo ( Twindoo_User::getCurrentUserId (), $group->getId () );
						}
					}
					$success = t_( "You have successfully bid for the group!" );
				}
			}
			$return = Array ( 'default' => $success);
			print (Zend_Json::encode($return));
			return;
		}

		$this->view->groupname = $group->getNom ();
		$this->view->groupId = $group->getId ();
		$this->view->competenceList = Twinmusic_Competence::getList ();
		$this->view->translate = new Twinmusic_Localized ( Twindoo_User::getLocale() );

		$this->view->bid = t_( "Bid" );
		$this->view->presentation = t_( "You're about to bid for this group with selected skills/abilities" );
		$this->view->group = t_( "Group" );
		$this->view->competenciesText = t_( "Skills" );
		$this->view->newCompetence = t_( "New skill/ability" );
		$this->view->addCompetence = t_( "Add skill/ability" );
	}
}
