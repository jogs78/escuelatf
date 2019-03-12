<?php

class Default_Model_Recuperar extends Zend_Db_Table_Abstract
{
    protected $_name='recuperar';
    protected $_primary='clave';    
   
    
    public function buscarcodigo($codigo)
    {
        
        $query=$this->select()->where("clave= ?",$codigo);
       
        $consulta=$this->fetchRow($query);
        
        return $consulta;
       
    }
     public function borrar($clave)
    {
        
        $this->delete('clave = ' ."'$clave'");
        
    }
}