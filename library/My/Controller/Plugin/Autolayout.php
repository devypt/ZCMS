<?php
class My_Controller_Plugin_Autolayout extends Zend_Controller_Plugin_Abstract
{
public function preDispatch(Zend_Controller_Request_Abstract $request)
	
	{
	
		$controller = $request->controller;
		$module = $request->module;
		$action = $request->action;
		if($controller=='admin'){
		$layoutPath = APPLICATION_PATH . '/layouts/admin/';
		Zend_Layout::getMvcInstance()->setLayoutPath($layoutPath);
		}
	}
}

?>