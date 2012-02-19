<?php

class Default_View_Helper_Menu extends Zend_View_Helper_Navigation_Menu
{
    public function renderMenu(array $options = array())
    {
        return '<!-- renderMenu called! -->' . parent::renderMenu($container, $options);
    }
}
