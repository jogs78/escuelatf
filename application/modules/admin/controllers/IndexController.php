<?php

//require_once 'library/Zend/Config/Ini.php';
//require_once 'library/Zend/Db.php';
class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {$auth=Zend_Auth::getInstance();
        if(!$auth->hasIdentity()){
            $this->_redirect('/');
        }
        $rol_permitido="admin";  
            $usuario=$auth->getStorage()->read();
            $rol=$usuario->rol;
        if(strcmp($rol,$rol_permitido)!=0){
            $auth->clearIdentity();
                        
            }
    }



    public function indexAction()
    {
        set_time_limit( 0 );
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $config = $db->getConfig();
        $path = "Tables_in_escuelatf".date("Y.m.d").".sql" ;
        $x="mysqldump --opt -u{$config['username']} -p{$config['password']} -h{$config['host']} {$config['dbname']} >$path";
        system($x); 
        $db->closeConnection();

    }


}

