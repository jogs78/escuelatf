<?php

include_once 'Roles.php';

class Escuela_Acl extends Zend_Acl{
    
    
    public function __construct() {
       
        $this->addRole(new Zend_Acl_Role(Roles::ALUMNO))
             ->addRole(new Zend_Acl_Role(Roles::PROFESOR))
                ->addRole(new Zend_Acl_Role(Roles::ADMIN));
       
        $this->allow(Roles::PROFESOR,null,array('prof'));
        $this->allow(Roles::ADMIN);
        $this->deny(Roles::ALUMNO,null,array('prof'));
        
       
        
        
        $this->addResource(new Zend_Acl_Resource("prof"));
        $this->deny(null,"prof");
        $this->allow(Roles::PROFESOR,"prof");
    
         $this->allow(Roles::ADMIN,null,array('admin'));
        $this->allow(Roles::ADMIN);
        $this->deny(Roles::ALUMNO,null,array('admin'));
        $this->addResource(new Zend_Acl_Resource("admin"));
        $this->deny(null,"admin");
        $this->allow(Roles::ADMIN,"admin");
        
        
    }
    
    
    
}