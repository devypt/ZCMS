<?php
class Form_Menu_Add extends Zend_Form
{
public function init()
{
    $this->setAction('')->setMethod('post');
     
    // Create and configure username element:
    $name = $this->createElement('text', 'name');
    $name->setLabel('name');
    $name->addValidator('stringLength', false, array(1, 255))
             ->setRequired(true);
   $is_default = $this->createElement('select', 'is_default');
    $is_default->setLabel('Is Default:')
         ->setRequired(TRUE)
         ->addMultiOptions(array('1'=> _('default'),
                                 '0'=> 'NO'));

     $submit=$this->createElement('submit', _('send'));
     
    // Add elements to form:
    $this->addElement($name)
         ->addElement($is_default)
         ->addElement($submit);
		
}
}
