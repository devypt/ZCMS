<?php

class Form_Default_Setting extends Zend_Form {

    public function init() {
        $this->setAction('')->setMethod('post');

        // Create and configure username element:
        $name = $this->createElement('text', 'site_name');
        $name->setLabel('name');
        $name->addValidator('stringLength', false, array(1, 255))
                ->setRequired(true);
        $description = $this->createElement('textarea', 'site_description');
        $description->setLabel(_('Site description'))
                ->addValidator('StringLength', false, array(1, 255))
                ->setRequired(TRUE);
        $keywords = $this->createElement('textarea', 'site_keywords');
        $keywords->setLabel(_('Site keywords'))
                ->addValidator('StringLength', false, array(1, 255))
                ->setRequired(TRUE);
        
        $copyrights = $this->createElement('textarea', 'site_copyrights');
        $copyrights->setLabel(_('Site copyrights'))
                ->addValidator('StringLength', false, array(1, 255))
                ->setRequired(TRUE);

        $site_status = $this->createElement('select', 'site_status');
        $site_status->setLabel('Is default')
                    ->setRequired(TRUE)
                    ->addMultiOptions(array('1' => _('opened'),
                    '0' => 'closed'));

        $submit = $this->createElement('submit', _('save'));

        // Add elements to form:
        $this->addElements(array($name,$description,$keywords,$copyrights,$site_status,$submit));
    }

}
