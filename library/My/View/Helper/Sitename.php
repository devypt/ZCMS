<?php
class My_View_Helper_Sitename extends Zend_View_Helper_Abstract
{
	function Sitename()
	{
		$langModel=new Model_Lang();
                $settingModel=new Model_Setting();
                $lang= Zend_Registry::getInstance()->Zend_Locale->getLanguage();
                $lang_id=$langModel->getLangId($lang);
                return $settingModel->getSiteName($lang_id);
	}
        
}