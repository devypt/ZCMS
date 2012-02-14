<?php
class Form_Content_Category_Add extends Zend_Form
{
    public function init($lang = 1)
    {
       // $this->setIsArray(true);
       
       
        $langModel = new Model_Lang();
        $langs = $langModel->fetchAll();
        foreach($langs as $lang)
        {
            $subform='form_'.$lang['slug'];
             $$subform=new Zend_Form_SubForm();
                     // Create and configure username element:
        $name = $$subform->createElement('text', "name");
        $name->setLabel('name')->addValidator('stringLength', false,
            array(1, 255))->setRequired(true);


        $description = $$subform->createElement('textarea', "description");
        $description->setLabel('description:')->setRequired(true);
        
            $$subform->addElements(array($name,$description));
         $this->addSubForm($$subform,$lang['slug']);   
        }


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

        $category = $this->createElement('select', "parent_id");
        $category->setLabel('Category:')->setRequired(true)->addMultiOptions($category_select);

        $is_active = $this->createElement('select', "is_active");
        $is_active->setLabel('Is Active:')->setRequired(true)->addMultiOptions(array('1' =>
                _('active'), '0' => 'Not Active'));


        $submit = $this->createElement('submit','save');
        
         
        
        $this->addElements(array($slug,
            $category,
            $is_active,
            $submit));


    }
}
