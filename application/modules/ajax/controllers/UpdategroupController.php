<?php
/**
 * Update Group Ajax Controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_UpdategroupController extends Zend_Controller_Action {

	protected function _setAnswer($message) {
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->setBody(Zend_Json::encode(array('default' => $message)));
	}
	/**
	 * Called By AjaxController
	 *
	 * Match the right id to the right action
	 *
	 */
	public function indexAction() {
		$this->getHelper('viewRenderer')->setNoRender(true);
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		
		if (preg_match ( "/([^_]+)_([0-9]+)(_([0-9]+))?/", $_GET ['id'], $globb )) {
			$group = new Twinmusic_Group ( $globb [2] );
			if ($group->getAdmin () == Twindoo_User::getCurrentUserId () || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
				switch ($globb [1]) {
					case "name" :
						$group->setNom ( $_GET ['value'] );
						break;
					case "lieu" :
						$group->setLieu ( $_GET ['value'] );
						break;
					case "postal" :
						$group->setPostal ( $_GET ['value'] );
						break;
					case "pays" :
						$group->setPays ( $_GET ['value'] );
						break;
					case "description" :
						$group->setDescription ( $_GET ['value'] );
						break;
					case "full" :
						$group->setFull ( ($_GET ['value'] == "full") ? false : true );
						break;
					case "url" :
						if ($group->setUrl ( $_GET ['value'] ) < 0)
							$this->_setAnswer ( 'error' );
						break;
					case "newlabel" :
						$label = new Twinmusic_Label();
						$label->setName($_GET ['value']);
						$label->setActive(false);
						$label->commit();
						$group->setLabel ( $label->getId () );
						break;
					case "label" :
						$label = new Twinmusic_Label($_GET ['value']);
						$group->setLabel ( $label->getId () );
						break;
					case "edituser" :
						$group->renameInGroup ( $globb [4], $_GET ['value'] );
						break;
				}
				$group->commit ();
				$this->view->setConfig(
					array ('scriptPath' => ROOT_DIR . 'application/modules/default/views/scripts',
						'compileDir' => ROOT_DIR . 'application/modules/default/views/compile',
						'cacheDir' => ROOT_DIR . 'application/modules/default/views/cache'
				));
				$this->view->clearAllCache ( 'user:' . $group->getUrl () );
			}
		}
		$return = trim ( $_GET ['value'] ) == "" ? t_( "(empty)" ) : Twindoo_Utile::cleanHtml ( trim ( $_GET ['value'] ) );
		$this->_setAnswer ( strip_tags ( $return ) );
	}
}
