<?php

class Admin_Model_Profesor extends Zend_Db_Table_Abstract
{
    protected $_name = 'profesor';
    protected $primary = 'cedula';
    
    public function profesor(){    
        $rowset = $this->fetchAll();
        $data = array();
        foreach ($rowset as $row) {
         $data[$row->cedula] = $row->nombre;
            
        }           
        return $data;
    }
public function guardar($data)
    {
        $row=$this->createRow($data);
        $row->save();
        
    }
    public function verprofesor($id)
    {
        $query=$this->select()->where('cedula=?',$id);
        $row= $this->fetchRow($query);
        return $row;
    }

}

