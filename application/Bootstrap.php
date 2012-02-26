<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initRoute() {
        
    
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
        $registry = Zend_Registry::getInstance();
        $locale = new Zend_Locale('ar_EG');

        $translate = new Zend_Translate(array('adapter'=>'ini','content'=>APPLICATION_PATH . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR.'ar_eg.ini' , 'locale'=>'ar_EG','disableNotices'=>false));
              $translate->addTranslation(array('adapter'=>'ini','content'=>APPLICATION_PATH . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR.'en_us.ini' , 'locale'=>'en_US','disableNotices'=>false));
        $registry->set('Zend_Locale', $locale);
        $registry->set('Zend_Translate', $translate);
        return $registry;
    }

    protected function _initView() {
                 Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/../library/My/Controller/Action/Helper', 'My_Controller_Action_Helper');
       // $initStuff = Zend_Controller_Action_HelperBroker::getStaticHelper('Initializer');
        // Initialize view
        $view = new My_View();
        $view->doctype('XHTML1_STRICT');
        $view->headTitle('My First Zend Framework Application');
       
        $view->menu = array('index' => array('module' => 'default','controller'=>'index','action'=>'index'),
            'login' => array('module' => 'user', 'controller' => 'index', 'action' => 'login'),
            'register' => array('module' => 'user', 'controller' => 'index', 'action' => 'register'),
            'categories' => array('module' => 'content', 'controller' => 'index', 'action' => 'categories'),
            'posts' => array('module' => 'content', 'controller' => 'index', 'action' => 'index'),
            'contact' => array('module' => 'contact', 'controller' => 'index','action'=>'index'));
        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
                        'ViewRenderer'
        );
        $session = new Zend_Session_Namespace('session');

        $view->lang = $session->lang;
        $view->setHelperPath(APPLICATION_PATH . '/../library/My/View/Helper', 'My_View_Helper');

        $viewRenderer->setView($view);

Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

        // Return it, so that it can be stored by the bootstrap
        return $view;
    }

}

