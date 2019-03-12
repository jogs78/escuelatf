<?php

class Prof_Plugin_CheckAutorization extends Zend_Controller_Plugin_Abstract{
    
     public function preDispatch(\Zend_Controller_Request_Abstract $request) {
         
          $acl = Zend_Registry::get("acl");
          $rol = Zend_Registry::get("role");
          $auth = Zend_Auth::getInstance();
          if(!$auth->hasIdentity() && !$acl->isAllowed($rol,$request->getModuleName())){
              $redirector=  Zend_Controller_Action_HelperBroker::getStaticHelper("redirector");
              $redirector->gotoUrlAndExit("/defaul/index/index");
              exit;
          }            
           if($auth->hasIdentity()){
               
               if(!$acl->isAllowed($rol,$request->getModuleName())){
                   
                   $request->setActionName("index")
                           ->setControllerName("index")
                           ->setModuleName("default")
                           ->setDispatched(true);
                   
               }
               
               
           }   
          return;
     }
}