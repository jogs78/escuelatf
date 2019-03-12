<?php

class Admin_Model_Cicloescolar extends Zend_Db_Table_Abstract
{
    protected $_name='cicloescolar';
    protected $_primary='idciclo';
    
    public function periodo(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $sql = "select idciclo from cicloescolar where periodoactual=1" ;
                    $consulta = $db->fetchAll($sql,Zend_Db::FETCH_BOTH);                
        $data = array();
        foreach ($consulta as $row) {
         $data[$row->idciclo] = $row->idciclo;      
        }              
        return $data;
    }
    public function cicloactual(){
              
        $query=$this->select()
                ->where('periodoiniciado=1')
                ->where('periodoactual=1');
        $consulta=  $this->fetchRow($query);
        return $consulta;
    }

}

