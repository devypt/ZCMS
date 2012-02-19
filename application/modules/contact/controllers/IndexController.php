<?php

class Contact_IndexController extends Zend_Controller_Action {

    public function init() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->view->identity = $auth->getIdentity();
        }
    }

    public function indexAction() {
        $config = array('auth' => 'login',
            'username' => 'wjgilmore@gmail.com',
            'password' => 'secret',
            'ssl' => 'tls');
        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
        Zend_Mail::setDefaultTransport($transport);
        $firstName='Ahmed';
        $website_url='http://yahoo.com';
        $registrationKey='11';
        $email_support='aaa';
        require APPLICATION_PATH."/mail-templates/ar/activation.php";
       
        $form = new Form_Contact_Add();
        $form->setAction('/contact/index');
        if ($this->_request->isPost() && $form->isValid($_POST)) {
            $data = $form->getValues();
//chaining
            $mail = new Zend_Mail();
            $mail->createAttachment("/home/gamenomad/reports/report.pdf");

            $mail->setBodyText($data['message']);
            $mail->setBodyHtml('My Nice <b>Test</b> Text');
            $mail->setFrom($data['email']);
            $mail->addTo('devypt@gmail.com', 'Some Recipient');
            $mail->setSubject($data['subject']);
            $mail->send();
            return $this->_forward('_success');
        }

        $this->view->form = $form;
    }

    private function _success() {
        
    }

}

