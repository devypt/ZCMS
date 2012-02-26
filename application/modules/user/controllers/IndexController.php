<?php

class User_IndexController extends Zend_Controller_Action {

    public function init() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->view->identity = $auth->getIdentity();
        }
    }

    public function indexAction() {
        // TODO implement this
    }

    public function noauthAction() {
         // TODO implement this
    }

    public function loginAction() {
         $this->view->pageTitle=_('Login');
        if ($this->view->identity) {
            $this->_redirect($this->view->url(array('module'=>'default','controller'=>'index','action'=>'index')));
        }

        $form = new Form_User_Add();
        $form->removeElement('email');
        $form->removeElement('is_active');
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
                $this->view->loginMessage = _('wrong_username_or_password');
            }
        }


        $this->view->form = $form;
    }

    public function logoutAction() {
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();
        $this->_forward('login');
    }

    public function registerAction() {
        $this->view->pageTitle=_('Register');
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
    
    
    public function activateAction()
    {
        $this->view->pageTitle=_('Activate your account');
        // TODO implement this
    }
    public function forgetPasswordAction()
    {
        $this->view->pageTitle=_('Forget password');
        // TODO implement this
        
    }
    public function myaccountAction()
    {
        $this->view->pageTitle=_('My account');
        // TODO implement this
    }
    public function changeEmailAction()
    {
        $this->view->pageTitle=_('Change email');
        // TODO implement this
    }
    public function changePasswordAction()
    {
        $this->view->pageTitle=_('Change password');
        // TODO implement this
    }
    public function resnedActivationAction()
    {
        $this->view->pageTitle=_('Resend activation email');
        // TODO implement this
    }
    

}

