<?php

class Prof_Model_Listas extends Zend_Db_Table_Abstract
{
    
    protected $_name='lista';
    protected $_primary= array('idgrupo', 'numcontrol');
   // protected $_primary='numcontrol';
    
    
    //public function actualizarCalificaciones($idgrupo,$numcontrol,$datos){

    public function lista($idgrupo){
        $consulta=$this->select()
            ->from(array('l'=>'lista'),array(true))
            ->join(array('a'=>'alumno'),'l.numcontrol=a.numcontrol',array('apellidos'=>'a.apellidos','nombres'=>'a.nombres'))
            ->where('l.idgrupo=?',$idgrupo)
            ->order("a.apellidos")
            ->setIntegrityCheck(false);
            $resultado=$this->fetchAll($consulta);
            return $resultado;
    }
 
    
}  
      