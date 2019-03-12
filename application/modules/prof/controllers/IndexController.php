<?php

class Prof_IndexController extends Zend_Controller_Action{

    public function init(){
        
        $auth=Zend_Auth::getInstance();
        if(!$auth->hasIdentity()){
            $this->_redirect('/');
        }
            $rol_permitido="profesor"; 
            $usuario=$auth->getStorage()->read();
            $rol=$usuario->rol;
            if(strcmp($rol,$rol_permitido)!=0){
                $auth->clearIdentity();
                $this->_redirect('/');              
            }
    }
    public function indexAction(){
        
       
    }
}