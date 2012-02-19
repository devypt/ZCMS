<?php

class My_Controller_Plugin_Multilanguage extends Zend_Controller_Plugin_Abstract{
    public function routeStartup (Zend_Controller_Request_Abstract $request)
    {
        //check if it's at homepage http://zfcms.me
 if (substr($request->getRequestUri(), 0, -1) == $request->getBaseUrl()){
    $request->setRequestUri($request->getRequestUri()."en"."/");
    $request->setParam("language", "en");
}else{
    $url=$request->getRequestUri();
    $url=  str_replace($request->getBaseUrl, '', $url);
    $url=explode('/',$url);
    if(in_array($url[1],array('ar','en')))
    {
    $request->setRequestUri($request->getRequestUri());
    $request->setParam("language", $url[0]);    
    }else{
    $request->setRequestUri($request->getRequestUri().'en/');
    $request->setParam("language", "en");
    }
    
}
    }
 
    public function routeShutdown (Zend_Controller_Request_Abstract $request)
    {
 $language =  $request->getParam("language", Zend_Registry::getInstance()->Zend_Locale->getLanguage());
 if($language=='en')
 {
     $language_locale='en_US';
 }else{
     $language_locale='ar_EG';
 }
$locale = new Zend_Locale($language_locale);
Zend_Registry::getInstance()->Zend_Locale->setLocale($locale);
$translate = Zend_Registry::getInstance()->Zend_Translate;
$translate->getAdapter()->setLocale(Zend_Registry::getInstance()->Zend_Locale);
Zend_Controller_Router_Route::setDefaultTranslator($translate);
    }
}
?>
