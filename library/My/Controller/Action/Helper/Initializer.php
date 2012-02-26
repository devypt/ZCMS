<?php

class My_Controller_Action_Helper_Initializer extends Zend_Controller_Action_Helper_Abstract {

    public function init() {
        $controller = $this->getActionController();
        $controller->config = Zend_Registry::get('config');
        $router = $controller->getRouter();
        $router->setGlobalParam('lang', 'en');
        
    }

}

?>