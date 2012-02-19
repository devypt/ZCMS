<?php
class Form_Contact_Add extends Zend_Form
{
public function init()
{
    $this->setAction('')->setMethod('post');
     
    // Create and configure username element:
    $name = $this->createElement('text', 'name');
    $name->setLabel('name');
    $name->addValidator('stringLength', false, array(5, 50))
             ->setRequired(true);
     
     
   
    
    $email = $this->createElement('text', 'email');
    $email->setLabel('Your email address:');
    $email->setRequired(TRUE);
    $email->addValidator(new Zend_Validate_EmailAddress());
    $email->addValidator(new My_Validate_IsExist());
    $email->addFilters(array(
    		new Zend_Filter_StringTrim(),
    		new Zend_Filter_StringToLower()
    ));
    
     $subject = $this->createElement('text', 'subject');
    $subject->setLabel(_('subject'));
    $subject->setRequired(TRUE);
    $subject->addFilters(array(
    		new Zend_Filter_StringTrim()
    ));
    
    $message = $this->createElement('textarea', 'message');
    $message->setLabel('message:');
    $message->setRequired(TRUE);
    $message->addFilters(array(
        new Zend_Filter_HtmlEntities()
        
    ));
    $submit=$this->createElement('submit', _('save'));
     
    // Add elements to form:
    $this->addElement($name)
         ->addElement($email)
         ->addElement($subject)
         ->addElement($message)
         // use addElement() as a factory to create 'Login' button:
         ->addElement($submit);
		
}
}
