<?php
/**
 * Admin edit a component
 *
 * @package    Doonoyz
 * @subpackage Admin
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */

class Admin_EditController extends Zend_Controller_Action {
	/**
	 * Controller Initialization
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( "Admin" ) );
		$this->view->setCacheLife(0);
	}
	
	/**
	 * Edit component treatment
	 */
	public function indexAction() {
		if (isset($_POST['action'])) {
			$this->getHelper('viewRenderer')->setNoRender(true);
			$response = $this->getResponse();
			$response->clearBody();
			switch ($_POST['action']) {
				case 'edit' :
					$answer = $this->_treatEdit();
					break;
				case 'accept' :
					$answer = $this->_treatAccept();
					break;
				case 'replaceWith' :
					$answer = $this->_treatReplaceWith();
					break;
				case 'delete' :
					$answer = $this->_treatDelete();
					break;
			}
			$ans = Zend_Json::encode(Array('default' => $answer));
			$response->appendBody($ans);
			$this->view->setConfig(
				array ('scriptPath' => ROOT_DIR . 'application/modules/default/views/scripts',
					'compileDir' => ROOT_DIR . 'application/modules/default/views/compile',
					'cacheDir' => ROOT_DIR . 'application/modules/default/views/cache'
			));
			$this->view->clearAllCache();
		} else {
			$this->_treatGet();
		}
	}

	/**
	 * Edit component treatment
	 *
	 * @return string result
	 */
	private function _treatEdit() {
		if (preg_match('/[^_]+_([^_]+)_([0-9]+)/', $_POST['editionInfo'], $globb)) {
			$component = 'Twinmusic_' . ucfirst(strtolower($globb[1]));
			$instance = new $component($globb[2]);
			if (!($instance instanceof Twinmusic_Admin_Component_Interface)) {
				throw new Exception('invalid component');
			}
			$instance->setName($_POST['name']);
			if ($component == "Twinmusic_Contacttype") {
				$instance->setLogo($_POST['logo']);
				$instance->setPattern($_POST['pattern']);
				$instance->setFilter($_POST['filter']);
			}
			$instance->commit();
			$answer = t_('Data saved successfully');
		} else {
			$answer = t_('Error while saving data');
		}
		return ($answer);
	}
	
	/**
	 * Replace component by others treatment
	 *
	 * @return string result
	 */
	private function _treatReplaceWith() {
		if (preg_match('/[^_]+_([^_]+)_([0-9]+)/', $_POST['id'], $globb)) {
			$component = 'Twinmusic_' . ucfirst(strtolower($globb[1]));
			$instance = new $component($globb[2]);
			if (!($instance instanceof Twinmusic_Admin_Component_Interface)) {
				throw new Exception('invalid component');
			}
			$answer = ($instance->replaceWith($_POST['replace'])) ? t_('Data saved successfully') : t_('Error while saving data');
		} else {
			$answer = t_('Error while saving data');
		}
		return ($answer);
	}
	
	/**
	 * Accept component treatement
	 *
	 * @return string result
	 */
	private function _treatAccept() {
		if (preg_match('/[^_]+_([^_]+)_([0-9]+)/', $_POST['id'], $globb)) {
			$component = 'Twinmusic_' . ucfirst(strtolower($globb[1]));
			$instance = new $component($globb[2]);
			if (!($instance instanceof Twinmusic_Admin_Component_Interface)) {
				throw new Exception('invalid component');
			}
			$instance->setActive();
			$instance->commit();
			$answer = t_('Accepted successfully');
		} else {
			$answer = t_('Error while treating request');
		}
		return ($answer);
	}
	
	/**
	 * Delete component treatement
	 *
	 * @return string result
	 */
	private function _treatDelete() {
		if (preg_match('/[^_]+_([^_]+)_([0-9]+)/', $_POST['id'], $globb)) {
			$component = 'Twinmusic_' . ucfirst(strtolower($globb[1]));
			$instance = new $component($globb[2]);
			if (!($instance instanceof Twinmusic_Admin_Component_Interface)) {
				throw new Exception('invalid component');
			}
			$instance->delete();
			$answer = t_('Deleted successfully');
		} else {
			$answer = t_('Error while treating request');
		}
		return ($answer);
	}
	
	/**
	 * Displays interface
	 */
	private function _treatGet() {
		$componentType = $this->getRequest()->getParam('component');
		$id = (int) $this->getRequest()->getParam('id');
		$component = 'Twinmusic_' . ucfirst(strtolower($componentType));
		$instance = new $component($id);
		if (!($instance instanceof Twinmusic_Admin_Component_Interface)) {
			throw new Exception('invalid component');
		}
		if (strtolower($componentType) == 'groupstyle') {
			$componentTypeKey = 'style';
		} else {
			$componentTypeKey = $componentType;
		}
		$this->view->componentType = $componentType;
		$this->view->componentList = call_user_func(Array($component, 'getList'));
		$this->view->component = $instance;
		$this->view->listId = strtoupper($componentTypeKey . '_ID');
		$this->view->listName = strtoupper($componentTypeKey . '_NAME');
		$this->view->id = $id;
		$this->view->text = Array(
			'name' => t_("Name"),
			'submit' => t_("Submit"),
			'logo' => t_("Logo"),
			'pattern' => t_("Pattern"),
			'filter' => t_("Filter"),
			'replaceWith' => t_("Replace component with"),
			'addComponentFor' => t_("Add component for replace"),
			'acceptComponent' => t_("Accept the component"),
			'deleteComponent' => t_("Delete the component"),
		);
		$this->view->setLayout('empty');
	}
}