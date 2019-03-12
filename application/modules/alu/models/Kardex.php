<?php

class Alu_Model_Kardex extends Zend_Db_Table_Abstract{
    
    protected $_name='kardex';
    protected $_primary=array('materia', 'numcontrol','ciclo');
    
    

   public function consultarKardex($numcontrol){
       $consulta=$this->select()
                ->from(array('k'=>'kardex'),array(true))
               ->join(array('m'=>'materia'),'k.materia = m.clavemateria',array('asignatura'=>'m.asignatura','creditos'=>'m.creditos'))
                ->where('k.numcontrol=?',$numcontrol)
                ->order("k.ciclo desc")
                ->setIntegrityCheck(false);
           $resultado=$this->fetchAll($consulta);
           return $resultado;
       
       
   }
   public function vermaterias($numcontrol){
        
        $where=array("numcontrol=?"=>$numcontrol);
        $ciclos=$this->fetchAll($where);
        
        $id=array();
        
            foreach ($ciclos as $ciclo){
            
                $id[$ciclo->ciclo]=$ciclo->ciclo;
            
            }
            
            return $id;
    
       
       
       
   }
}  
 