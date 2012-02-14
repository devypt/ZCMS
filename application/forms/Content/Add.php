<?php
class Form_Content_Add extends Zend_Form
{
public function init()
{
    $this->setAction('')->setMethod('post');
     
    // Create and configure username element:
    $name = $this->createElement('text', 'name');
    $name->setLabel('name');
    $name->addValidator('stringLength', false, array(1, 255))
             ->setRequired(true);
     
    // Create and configure password element:
    $slug = $this->createElement('text', 'slug');
    $slug->setLabel('slug:');
    $slug->addValidator('StringLength', false, array(1,255))
             ->setRequired(true);
    
    $content = $this->createElement('textarea', 'content');
    $content->setLabel('content:');
    $content->setRequired(TRUE);
    
     $submit=$this->createElement('submit', _('send'));
     
    // Add elements to form:
    $this->addElement($name)
         ->addElement($slug)
         ->addElement($content)
         ->addElement($submit);
		
}
}
