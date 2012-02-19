<?php
class Form_Content_Category_Add extends Zend_Form
{
    public function init($lang = 1)
    {
       // $this->setIsArray(true);
       
       
        $langModel = new Model_Lang();
        $langs = $langModel->fetchAll();
       
        $name = $this->createElement('text', "name");
        $name->setLabel('name')->addValidator('stringLength', false,
            array(1, 255))->setRequired(true);


        $description = $this->createElement('textarea', "description");
        $description->setLabel('description:')->setRequired(true);
      
        // Create and configure password element:
        $slug = $this->createElement('text', "slug");
        $slug->setLabel('slug:')->addValidator('StringLength', false,
            array(1, 255))->setRequired(true)->addFilters(array(new Zend_Filter_StringTrim(),
                new Zend_Filter_StringToLower()));


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

         $category = $this->createElement('select', "parent_id");
         $category->setLabel('Category :')->setRequired(true)->addMultiOptions($category_select);

        $lang = $this->createElement('select', "lang_id");
        $lang->setLabel('Lang:')->setRequired(true)->addMultiOptions($lang_select);

        $is_active = $this->createElement('select', "is_active");
        $is_active->setLabel('Is Active:')->setRequired(true)->addMultiOptions(array('1' =>
                _('active'), '0' => 'Not Active'));


        $submit = $this->createElement('submit','save');
        
         
        
        $this->addElements(array($name,$description,$slug,$lang,
            $category,
            $is_active,
            $submit));


    }
}
