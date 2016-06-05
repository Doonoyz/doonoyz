<?php
/**
 * Admin Edit component
 *
 * @package    Doonoyz
 * @subpackage Admin
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Admin_EditcomponentController extends Zend_Controller_Action {
	/**
	 * Controller Initialization
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Admin" ) );
		$this->view->setCacheLife(0);
	}
	
	/**
	 * Edit component by interface and displays interfaces
	 */
	public function indexAction() {
		$components = Array('groupstyle' => t_('Group Style'),
							'competence' => t_('Skill'),
							'contacttype' => t_('Contact type'),
							'label' => t_('Labels'),
							);
		$componentType = $this->getRequest()->getParam('component');
		if ($componentType) {
			$component = 'Twinmusic_' . ucfirst(strtolower($componentType));
			$instance = new $component();
			if (!($instance instanceof Twinmusic_Admin_Component_Interface)) {
				throw new Exception('invalid component');
			}
			if (strtolower($componentType) == 'groupstyle') {
				$componentTypeKey = 'style';
			} else {
				$componentTypeKey = $componentType;
			}
			$fakeEntry = array(
				strtoupper($componentTypeKey . '_ID') => '0',
				strtoupper($componentTypeKey . '_NAME') => t_('Choose a component')
			);
			$fillList = call_user_func(Array($component, 'getList'));
			array_unshift($fillList, $fakeEntry);
			$this->view->thelist = $fillList;
			$this->view->listId = strtoupper($componentTypeKey . '_ID');
			$this->view->listName = strtoupper($componentTypeKey . '_NAME');
			$this->view->componentName = $componentType;
			$this->view->text = array(	'editComponent' => t_('Edit this component'),
										'chooseComponent' => t_('Choose the component to edit'));
			$this->view->hasComponent = true;
		} else {
			$this->view->text = array('chooseComponent' => t_('Choose the component type to edit'));
			$this->view->components = array( '0' => t_('Choose a component style')) + $components;
			$this->view->hasComponent = false;
		}
	}
}