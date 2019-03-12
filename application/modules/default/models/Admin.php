<?php

class Default_Model_Admin extends Zend_Db_Table_Abstract
{
    protected $_name='administrador';
    protected $_primary='numempleado';
    
    public function buscarcorreo($correo)
    {
        
        $query=$this->select()->where("correo=?",$correo);
        $consulta=$this->fetchRow($query);
        return $consulta;
    
    }
    
     public function actualizarPassword($usuario,$newPass)
    {
       
        $password=sha1($newPass);
        $where=("numempleado="."'$usuario'");
        $data=array("contrasena"=>$password);
        $this->update($data,$where);
    }
    
}