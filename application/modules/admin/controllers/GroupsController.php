<?php
/**
 * Admin Group managing
 *
 * @package    Doonoyz
 * @subpackage Admin
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Admin_GroupsController extends Zend_Controller_Action {
	/**
	 * Controller initialization
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Admin" ) );
		$this->view->setCacheLife(0);
	}
	
	/**
	 * Displays interface
	 */
	public function indexAction() {
		$groupurl = $this->getRequest()->getParam('groupurl');
		$this->view->groupList = Twinmusic_Group::getAllGroups();
		$this->view->selectedGroup = $groupurl;
		if ($groupurl) {
			$this->view->currentGroup = Twinmusic_Group::getGroupByUrl($groupurl);
		}
		$this->view->text = Array(	'groupManaging' => t_("Group managing"),
									'editGroup' => t_('Edit this group'),
									'censor' => t_('Censor'),
									'censorGroup' => t_('Edit group censor'),
									'active' => t_('Active'),
									'activeGroup' => t_('Active group'),
									'blockGroup' => t_('Block group'),
									'consultGroup' => t_('Consult group'),
								);
	}
}