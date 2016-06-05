<?php
/**
 * Locale system
 *
 * @package    Doonoyz
 * @subpackage library
 * @author     Jeremy MOULIN <jeremy.moulin@doonoyz.com>
 * @copyright  2008-2009 Doonoyz
 * @version    Paper
 */
class Twinmusic_Localized {
	
	/**
	 * Add message to PO
	 *
	 * @param string $string Message to add (add only if not already in po)
	 */
	private function _addMessage($string) {
		$file = file_get_contents ( ROOT_DIR . "application/languages/addedValues.en.po" );
		if ($file === false) {
			$file = '';
		}
		$string = str_replace ( '"', '\"', $string );
		$toSearch = "msgid \"$string\"";

		if (strpos ( $file, $toSearch ) === false) {
			$file = $file . "\n";
			$file .= "\nmsgid \"$string\"\n";
			$file .= "msgstr \"\"";
			$fHandle = @fopen ( ROOT_DIR . "application/languages/addedValues.en.po", "wb+" );
			if ($fHandle) {
				@fputs ( $fHandle, $file );
				@fclose ( $file );
			}
		}
	}

	/**
	 * Translate the message and add the message to PO if not translatable
	 *
	 * @param string $string Message to translate
	 * 
	 * @return string Translated message
	 */
	public function translate($string) {
		$registry = Zend_Registry::getInstance ();
		try {
			$tr = $registry->get ( 'translate' );
			if ($tr->isTranslated ( $string )) {
				return ($tr->_ ( $string ));
			} else {
				$this->_addMessage ( $string );
				return ($string);
			}
		} catch ( Exception $e ) {
			return ($string);
		}
	}
	
	/**
	 * Translate a date in the format of the current locale
	 *
	 * @param string $date Date to translate
	 *
	 * @return string Translated date
	 */
	public function translateDate($date) {
		return ($date);
	}
}
