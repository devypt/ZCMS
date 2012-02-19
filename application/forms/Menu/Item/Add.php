<?php
class Form_Menu_Item_Add extends Zend_Form
{
public function init()
{
    $this->setAction('')->setMethod('post');
     
    // Create and configure username element:
    $name = $this->createElement('text', 'name');
    $name->setLabel('name')
         ->addValidator('stringLength', false, array(1, 255))
             ->setRequired(true);
     
    // Create and configure password element:
    $link = $this->createElement('text', 'link');
    $link->setLabel('link:')
             ->setRequired(true);

    $Model=new Model_Menu();
    $rows=$Model->getMenus();
    $rows_select=array();
    foreach($rows as $row)
    {
        $rows_select[$row['id']]=$row['name'];
    }
    
    $menuid = $this->createElement('select', 'menu_id');
    $menuid->setLabel('Menu:')
         ->setRequired(TRUE)
         ->addMultiOptions($rows_select);
    
    $is_active = $this->createElement('select', 'is_active');
    $is_active->setLabel('Is Active:')
         ->setRequired(TRUE)
         ->addMultiOptions(array('1'=> _('active'),
                                 '0'=> 'Not Active'));

    
    
     $submit=$this->createElement('submit', _('send'));
     
    // Add elements to form:
    $this->addElement($name)
         ->addElement($link)
         ->addElement($menuid)
         ->addElement($is_active)
         ->addElement($submit);
		
}
}
