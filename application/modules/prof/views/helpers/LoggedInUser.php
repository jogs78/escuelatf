<?php

class Prof_View_Helper_LoggedInUser
{
    protected $view;
    function setView($view)
    {
      $this->view = $view;
    }
    function loggedInUser()
    {
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity())
        {
            $logoutUrl = $this->view->url(array('module'=>'admin','controller'=>'index','action'=>'cerrarsesion'));  
            $user = $auth->getIdentity();
            $username = $this->view->escape(ucfirst($user->cedula));
            $string = $username ; 
              //      ' | <a href="' .
            //$logoutUrl . '">CerrarSesion</a>';
        }
        else 
        {
            $loginUrl = $this->view-> url(array('module'=>'default','controller'=>'index','action'=>'index'));
            $string = '<a href="'. $loginUrl . '">Log in</a>';
        }
            return $string;
    }
}