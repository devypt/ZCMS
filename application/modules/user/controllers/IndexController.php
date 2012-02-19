<?php

class User_IndexController extends Zend_Controller_Action {

    public function init() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->view->identity = $auth->getIdentity();
        }
    }

    public function indexAction() {
        
    }

    public function noauthAction() {
        
    }

    public function loginAction() {
        
         $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->_redirect('/');
        }
        
        $form = new Form_User_Add();
        $form->removeElement('email');
        $form->removeElement('is_active');
        $form->setAction('/user/index/login');
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
            //set up the auth adapter
            // get the default db adapter
            $db = Zend_Db_Table::getDefaultAdapter();
            //create the auth adapter
            $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users',
                            'username', 'password');
            //set the username and password
            $authAdapter->setIdentity($data['username']);
            $authAdapter->setCredential(sha1($data['password']));
            //authenticate
            $result = $authAdapter->authenticate();
            if ($result->isValid()) {
                // store the username, first and last names of the user
                $auth = Zend_Auth::getInstance();
                $storage = $auth->getStorage();
                $storage->write($authAdapter->getResultRowObject(
                                array('username', 'role_id')));
                return $this->_forward('index');
            } else {
                $this->view->loginMessage = "Sorry, your username or
        		password was incorrect";
            }
        }


        $this->view->form = $form;
    }

    public function logoutAction() {
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();
        $form = new Form_User_Add();
        $form->setAction('/user/index/login');
        $form->removeElement('email');
        $this->view->form = $form;
    }

    public function registerAction() {
        $form = new Form_User_Add();
        $form->removeElement('is_active');
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $model = new Model_User();
                // if the form is valid then create the new bug
                $data = $form->getvalues();
                $result = $model->addRow($data);
                // if the createBug method returns a result
                // then the bug was successfully created
                if ($result) {
                    $this->_forward('success');
                }
            }
        }
        $this->view->form = $form;
    }

}

