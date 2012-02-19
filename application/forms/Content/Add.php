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
    $content->setLabel('content:')->setAttrib('id', 'editor');
    $content->setRequired(TRUE);
    
     $categoryModel = new Model_Category();
        $categories = $categoryModel->getMainCategories();
        $category_select = array('0' => _('main_category'));
        foreach ($categories as $row) {
            $category_select[$row['id']] = $row['name'];
        }
        $langModel = new Model_Lang();
        $langs = $langModel->fetchAll();
        $lang_select=array();
        foreach ($langs as $row) {
            $lang_select[$row['id']] = $row['name'];
        }

         $category = $this->createElement('select', "category_id");
         $category->setLabel('Category :')->setRequired(true)->addMultiOptions($category_select);

        $lang = $this->createElement('select', "lang_id");
        $lang->setLabel('Lang:')->setRequired(true)->addMultiOptions($lang_select);

     $submit=$this->createElement('submit', _('send'));
     
    // Add elements to form:
    $this->addElements(array($name,$slug,$content,$lang,$category,$submit));
		
}
}
