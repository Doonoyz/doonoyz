<?php
/**
 * Studio Controller
 *
 * @package    Doonoyz
 * @subpackage Controller
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class StudioController extends Zend_Controller_Action {

	/**
	 * Init layout
	 *
	 */
	public function init() {
		$this->view->setLayout ( 'default' );
		$this->view->addLayoutVar ( 'title', t_( 'Studio' ) );
		$this->view->setCacheLife ( 0 );
	}

	/**
	 * Display all authorized groups studios
	 *
	 */
	public function indexAction() {
		$this->view->groups = Twinmusic_Invitation::getMyGroups ();
		$this->view->title = t_( "Choose one of your group" );
		$this->view->noGroup = t_( "Sorry, you have no group!" );
	}

	/**
	 * Display selected group studio
	 *
	 */
	public function manageAction() {
		if (! Twindoo_User::getCurrentUserId ())
			$this->_redirect ( "/" );
		$username = $this->_getParam ( 'groupname' );
		$group = Twinmusic_Group::getGroupByUrl ( $username );
		if (!$group->isActive() || !$group->getId()) {
			$this->_redirect ( "/studio" );
		}
		if ($group->inGroup ( Twindoo_User::getCurrentUserId () ) || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
			$this->view->addLayoutVar ( 'title', sprintf ( t_( 'Studio :: %s' ), $group->getUrl ( ) ) );
			$folders = new Twinmusic_Folder ( );
			$this->view->compos = $folders->getAll ( $group->getId () );
			$this->view->groupId = $group->getId ();
			$this->view->help = t_( "Help" );
			$this->view->addFolder = t_( "Add a folder" );
			$this->view->addCompo = t_( "Add a composition" );
			$this->view->deleteFolder = t_( "Delete this folder" );
			$this->view->publicFolder = t_( "Public?" );
			$this->view->editFolder = t_( "Edit folder name" );
			$magickey = Twindoo_Utile::getFlashSession();
			$this->view->magickey = $magickey;

			$this->view->groupId = $group->getId ();
		} else {
			$this->_redirect ( "/studio" );
		}
	}

	/**
	 * Display One composition detailed interface
	 *
	 */
	public function showinterfaceAction() {
		$this->view->setLayout ( 'ajax' );
		$this->view->setCacheLife ( 0 );
		$this->view->addLayoutVar ( 'ajaxCall', 1 );

		$compo = new Twinmusic_Compo ( $_GET ['id'] );
		if ($compo->getId ()) {
			$group = new Twinmusic_Group ( $compo->getGroupId () );
			if ($group->inGroup ( Twindoo_User::getCurrentUserId () ) || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
				if (! $compo->isDeleted ()) {
					$folders = new Twinmusic_Folder ( );
					$this->view->compo = $compo;
					$this->view->folders = $folders->getAll ( $group->getId () );
					
					$this->view->name = t_('Name');
					$this->view->publicity = t_('Public');
					$this->view->notProcessed = t_('Your composition will be analyzed soon by the system, you will be able to publish it if the system validates it. If not, it will be deleted');
					$this->view->download = t_('Download original file');
					$this->view->delete = t_('Delete this composition');
					$this->view->changeFolder = t_('Change composition folder');
				} else {
					$this->view->fatalError = t_( "Composition doesn't exist anymore" );
				}
			} else
				$this->view->fatalError = t_( "Not your composition" );
		} else
			$this->view->fatalError = t_( "Not your composition" );
	}
	
	/**
	 * Action to upload a composition
	 *
	 */
	public function uploadcompoAction() {
		$this->getHelper ( 'viewRenderer' )->setNoRender ();

		$username = $this->_getParam ( 'groupname' );
		$folderId = 0;
		$folderId = ( int ) $this->_getParam ( 'folderId' );
		$json = Array();
		$group = new Twinmusic_Group ( $username );
		if ($group->inGroup ( Twindoo_User::getCurrentUserId () ) || Twinmusic_Admin::isAdmin ( Twindoo_User::getCurrentUserId () )) {
			if (isset ( $_FILES ['file'] ) && ! $_FILES ['file'] ['error'] && $folderId > 0 && is_numeric ( $folderId )) {
				$compo = new Twinmusic_Compo ( );
				$compo->setGroupId ( $group->getId () );
				$compo->setName ( basename ( $_FILES ['file'] ['name'] ) );
				$compo->setFolderId ( $folderId );
				$compo->setPublic ( false );
				if ($compo->uploadFile ( $_FILES ['file'] )) {
					$compo->commit ();
					$this->view->clearAllCache ( 'user:' . $username );

					$json['status'] = 'ok';
					$json['message'] = sprintf ( t_( "%s uploaded successfully!" ), basename ( $_FILES ['file'] ['name'] ) );
				} else
					$json = $this->_prepareError ( $_FILES ['file'] ['name'], 5 );
			} else {
				if (isset($_FILES ['file'])) {
					$json = $this->_prepareError ( $_FILES ['file'] ['name'], $_FILES ['file'] ['error'] );
				} else {
					$json['status'] = 'error';
					$json['message'] = t_( 'No file uploaded!' );
				}
			}
		} else {
			$json['status'] = 'error';
			$json['message'] = t_( 'You\'re not in group' );
		}
		print Zend_Json::encode ( $json );
	}

	/**
	 * Prepare Error message
	 *
	 * @param string $name  Filename
	 * @param int    $error Error Type
	 *
	 * @return string Array containing error type + message
	 */
	private function _prepareError($name, $error) {
		$filename = $name;
		switch ($error) {
			case '1' :
			case '2' :
				$json['message'] = sprintf ( t_( "%s is too big, it must not exceed %s" ), $filename, ini_get ( "upload_max_filesize" ) );
				break;
			case '3' :
			case '8' :
				$json['message'] = sprintf ( t_( "%s partially uploaded" ), $filename );
				break;
			case '4' :
				$json['message'] = t_( "No file uploaded!" );
				break;
			case '5' :
				$json['message'] = t_( "Unauthorized file type!" );
				break;
			case '6' :
			case '7' :
			default :
				$json['message'] = t_( "Server-side error, please <a href='mailto:contact@doonoyz.com'>contact us</a>" );
				break;
		}
		$json['status'] = 'error';
		return ($json);
	}
}
