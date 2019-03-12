<?php

class Prof_Model_Cicloescolar extends Zend_Db_Table_Abstract{
    
    protected $_name='cicloescolar';
    
    
    public function cicloActual()
    {
        $query=$this->select('cicloescolar','idperiodo')->where('periodoactual=1');
        $row=$this->fetchRow($query);
        return $row;
    }
    public function ciclos()
    {
        $query=  $this->select("idperiodo"); 
         $rowset=$this->fetchAll($query);
        $data=array();
        
            foreach ($rowset as $row)
            {
                $data[$row->idperiodo]=$row->idperiodo;
            }
            return $data;
      
    }
}