<?php
class My_Validate_IsExist extends Zend_Validate_Abstract {
	const IsExist = "";
	protected $_messageTemplates = array (self::IsExist => "Email is already registered" );
	
	public function isValid($value) {
		
		$dataModel = new Model_User (); // check if the email exists
		if (! $dataModel->email_exists ( $value )) {
			return true;
		} else {
			$this->_error ( self::IsExist );
			return false;
		}
	
	}
}
?>
