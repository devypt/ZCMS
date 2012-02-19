<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function init() {
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/../library/My/Controlelr/Action/Helper', 'My_Controller_Action_Helper');
        //$initStuff = Zend_Controller_Action_HelperBroker::getStaticHelper('Initializer');
    }

    protected function _initAutoload() {
// Add autoloader empty namespace
        $autoLoader = Zend_Loader_Autoloader::getInstance();
        $autoLoader->registerNamespace('My_');
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
                    'basePath' => APPLICATION_PATH,
                    'namespace' => '',
                    'resourceTypes' => array(
                        'form' => array(
                            'path' => 'forms/',
                            'namespace' => 'Form_',
                        ),
                        'model' => array(
                            'path' => 'models/',
                            'namespace' => 'Model_'
                        ),
                    ),
                ));
// Return it so that it can be stored by the bootstrap
        return $autoLoader;
    }

    protected function _initTranslate() {
// Get cur­rent reg­istry
        $reg­istry = Zend_Registry::getInstance();
        $locale = new Zend_Locale('en_US');

        /**
         * Set up and load the trans­la­tions (all of them!)
         * resources.translate.options.disableNotices = true
         * resources.translate.options.logUntranslated = true
         */
        $trans­late = new Zend_Translate('ini', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . strtolower($locale->toString()) . '.ini', 'auto',
                        array(
                            'dis­ableNo­tices' => true, // This is a very good idea!
                            'logUn­trans­lated' => true, // Change this if you debug
                            'scan' => Zend_Translate::LOCALE_DIRECTORY
                        )
        );
        /**
         * Both of these reg­istry keys are mag­i­cal and makes
         * ZF 1.7+ do automag­i­cal things.
         */
        $reg­istry->set('Zend_Locale', $locale);
        $reg­istry->set('Zend_Translate', $trans­late);
        return $reg­istry;
    }

    protected function _initView() {
        // Initialize view
        $view = new Zend_View();
        $view->doctype('XHTML1_STRICT');
        $view->headTitle('My First Zend Framework Application');
       
        $view->menu = array('index' => array('module' => 'default'),
            'login' => array('module' => 'user', 'controller' => 'index', 'action' => 'login'),
            'register' => array('module' => 'user', 'controller' => 'index', 'action' => 'register'),
            'categories' => array('module' => 'content', 'controller' => 'index', 'action' => 'categories'),
            'posts' => array('module' => 'content', 'controller' => 'index', 'action' => 'index'),
            'contact' => array('module' => 'contact', 'controller' => 'index'));
        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
                        'ViewRenderer'
        );
        $session = new Zend_Session_Namespace('session');

        $view->lang = $session->lang;
        $view->setHelperPath(APPLICATION_PATH . '/../library/My/View/Helper', 'My_View_Helper');

        $viewRenderer->setView($view);

        // Return it, so that it can be stored by the bootstrap
        return $view;
    }

}

