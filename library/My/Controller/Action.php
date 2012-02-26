<?php

class My_Controller_Action extends Zend_Controller_Action {

    protected function getLog() {
        $logger = new Zend_Log();
        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/logs/error.log');

        $logger->addWriter($writer);
        return $logger;
    }

}
