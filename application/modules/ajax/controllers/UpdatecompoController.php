<?php
/**
 * Update Composition Ajax Controller
 *
 * @package    Doonoyz
 * @subpackage Ajax
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Ajax_UpdatecompoController extends Zend_Controller_Action {

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
		if (preg_match ( "/([^_]+)_([0-9]+)/", $_GET ['id'], $globb )) {
			$compo = new Twinmusic_Compo ( $globb [2] );
			$group = new Twinmusic_Group ( $compo->getGroupId () );
			if ($group->inGroup ( Twindoo_User::getCurrentUserId () ) || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
				switch ($globb [1]) {
					case "name" :
						$compo->setName ( $_GET ['value'] );
						break;
					case "public" :
						$compo->setPublic ( ($_GET ['value'] == "true") ? true : false );
						break;
					case "changeFolder" :
						$folder = new Twinmusic_Folder ( $_GET ['value'] );
						if ($folder->getGroupId () == $compo->getGroupId ()) {
							$compo->setFolderId ( $folder->getId () );
						}
						break;
				}
				$compo->commit ();
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
