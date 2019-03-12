<?php

class Application_Model_Roles{
    
    const ADMIN ="admin";
    const PROFESOR= "profesor";
    const ALUMNO="alumno";
    
    private static $_roles=array(
        
        Model_Roles::ADMIN=>"Administrador",Model_Roles::PROFESOR=>"Profesor",Model_Roles::ALUMNO=>"Alumno",
        
    );
    
    public static function getRoles(){
        
        
        return self::$_roles;
    }
    
}