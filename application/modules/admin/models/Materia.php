<?php
class Admin_Model_Materia extends Zend_Db_Table_Abstract
{
    protected $_name = 'materia';

    
        public function materias(){
        
        $rowset = $this->fetchAll();
        $data = array();
        foreach ($rowset as $row) {
         $data[$row->clavemateria] = $row->asignatura;     
        }
                
        return $data;
    }


}

