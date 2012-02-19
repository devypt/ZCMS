<?php
class My_Controller_Plugin_LangSelector extends Zend_Controller_Plugin_Abstract
{
public function preDispatch(Zend_Controller_Request_Abstract $request)
{
$this->registry = Zend_Registry::getInstance();
// Get our translate object from registry.
$translate = $this->registry->get('Zend_Translate');
$currLocale = $translate->getLocale();
// Create Session block and save the locale
$session = new Zend_Session_Namespace('session');

$lang = $request->getParam('lang',"");
// Reg­is­ter all your "approved" locales below.
switch($lang) {
case "ar":
$lan­gLo­cale = 'ar_EG'; break;
case "fr":
$lan­gLo­cale = 'fr_FR'; break;
case "en":
$lan­gLo­cale = 'en_US'; break;
default:
$lan­gLo­cale = 'en_US';
}
$newLo­cale = new Zend_Locale();
$newLo­cale->setLocale($lan­gLo­cale);
$this->registry->set('Zend_Locale', $newLo­cale);

$translate->setLocale($lan­gLo­cale);
$session->lang = $lang;

// Save the mod­i­fied trans­late back to reg­istry
$this->registry->set('Zend_Translate', $translate);
$this->view->translate=$translate;
}
}