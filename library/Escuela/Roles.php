<?php

class Roles{
    
    const ADMIN ="admin";
    const PROFESOR= "profesor";
    const ALUMNO="alumno";
    
    private static $_roles=array(
        
        Roles::ADMIN=>"admin",Roles::PROFESOR=>"profesor",Roles::ALUMNO=>"Alumno"
        
    );
    
    public static function getRoles(){
        
        
        return self::$_roles;
    }
    
}