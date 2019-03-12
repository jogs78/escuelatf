<?php

class Alu_Model_Ciclo extends Zend_Db_Table_Abstract{
    
    protected $_name='cicloescolar';
    protected $_primary='idciclo';
    
    

    public function cicloactual(){
        
        $query=$this->select()->where('periodoactual=1');
        $consulta=  $this->fetchRow($query);
        return $consulta;
    }
}  
      