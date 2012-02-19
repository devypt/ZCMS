<?php

class My_View_Helper_Langurl extends Zend_View_Helper_Abstract {

    public function Langurl($params) {
        $view = new Zend_View();
        return $view->url(array('module' => 'user', 'controller' => 'index', 'action' => 'login'));
    }

}

?>