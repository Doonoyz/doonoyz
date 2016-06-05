<?php
/**
 * Help FAQ messages
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Help {
	
	/**
	 * Private Help messages
	 *
	 * @var array
	 */
	static private $_messages = array();
	
	/**
	 * Prepare internally message for extension
	 *
	 * @return string Extension list
	 */
	static private function _prepareStudioExtension() {
		$extList = Twinmusic_Compo::getAcceptedExtension('ELSE');
		$typeList = array('music' => t_('Music'), 'picture' => t_('Picture'), 'text' => t_('Text'), 'video' => t_('Video'));
		$return = '<ul>';
		foreach ($extList as $type => $extAssigned) {
			if (isset($typeList [$type])) {
				$type = $typeList [$type];
			}
			$return .= "<li><h2>$type</h2><ul><li>";
			$return .= implode(', .', $extAssigned);
			$return .= "</li></ul></li>";
		}
		$return .= '</ul>';
		return $return;
	}
	
	/**
	 * Internally create help messages
	 */
	static private function _createMessages() {
		self::$_messages['GROUP']['ADMIN'][0]['TITLE'] = t_( 'How do I modify my group information?' );
		self::$_messages['GROUP']['ADMIN'][0]['BODY'] = t_( 'You just have to click on a criterion and you will be able to edit it! Then click OK to save your modification and Cancel to cancel.' );
		
		self::$_messages['GROUP']['ADMIN'][1]['TITLE'] = t_( 'A skill/ability/style doesn\'t exist, how do I create it?' );
		self::$_messages['GROUP']['ADMIN'][1]['BODY'] = t_( 'Select "New competence" then add it, it\'s name will be asked and then will be validated by admin. If the admin judges that this competence already exists or another is preferred, it will be automaticaly replaced for you.' );
		
		self::$_messages['GROUP']['ADMIN'][2]['TITLE'] = t_( 'Why my group/file doesn\'t appear in the search engine or on the home page?' );
		self::$_messages['GROUP']['ADMIN'][2]['BODY'] = t_( 'To appear on the search engine or on the home page, you have to specify at least one skill AND one musical style. To do so, choose your skill/musical style and click the \'Add\' link associed. A message will confirm your action.' );

		self::$_messages['STUDIO'][0]['TITLE'] = t_( 'How do I upload a composition?' );
		self::$_messages['STUDIO'][0]['BODY'] = t_( 'First, you have to create a folder. This can be done with the "Add a folder" link. When the folder is created, go inside and click the "Add a composition" icon. Choose your file on your hard drive and send it.' );
		
		self::$_messages['STUDIO'][1]['TITLE'] = t_( 'Which composition formats are accepted?' );
		self::$_messages['STUDIO'][1]['BODY'] = t_( 'You can only upload these file type, then the system will analyze it and you will be able to edit it if everything is ok:' ) . self::_prepareStudioExtension();
	}
	
	/**
	 * Return requested messages by theirs keys
	 *
	 * Pass params as exemple below : Twinmusic_Help::getMessages('GROUP', 'ADMIN') to get all admin group messages
	 *
	 * @return array Array containing help messages
	 */
	static public function getMessages() {
		self::_createMessages();
		$return = self::$_messages;
		$args = func_get_args();
		foreach ($args as $key) {
			if ( isset ( $return [ $key ] ) ) {
				$return = $return [ $key ];
			}
		}
		return ($return);
	}
}
