<?php
class Form_User_Add extends Zend_Form
{
public function init()
{
    $this->setAction('')->setMethod('post');
     
    // Create and configure username element:
    $username = $this->createElement('text', 'username');
    $username->setLabel('username');
    $username->addValidator('alnum')
             ->addValidator('regex', false, array('/^[a-z]+/'))
             ->addValidator('stringLength', false, array(5, 25))
             ->setRequired(true)
             ->addFilter('StringToLower');
     
    // Create and configure password element:
    $password = $this->createElement('password', 'password');
    $password->setLabel('password:');
    $password->addValidator('StringLength', false, array(6))
             ->setRequired(true);
    
    $email = $this->createElement('text', 'email');
    $email->setLabel('Your email address:');
    $email->setRequired(TRUE);
    $email->addValidator(new Zend_Validate_EmailAddress());
    $email->addValidator(new My_Validate_IsDuplicated());
    $email->addFilters(array(
    		new Zend_Filter_StringTrim(),
    		new Zend_Filter_StringToLower()
    ));
     
            $options = array('1'=>_('active'),'0'=>_('not_active'));
        

         $is_active = $this->createElement('select', "is_active");
         $is_active->setLabel('Is active :')->setRequired(true)->addMultiOptions($options);
    $submit=$this->createElement('submit', _('save'));
     
    // Add elements to form:
    $this->addElements(array($username,$password,$email,$is_active,$submit));
		
}
}
