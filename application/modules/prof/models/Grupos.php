<?php

class Prof_Model_Grupos extends Zend_Db_Table_Abstract{
    
    protected $_name='grupo';
    protected $_primary='idgrupo';
    
    
    public function gruposAsignados($cedula,$periodo){
        
        $consulta=$this->select()
                ->from(array('g'=>'grupo'),array(true))
               ->join(array('m'=>'materia'),'g.clavemateria=m.clavemateria',array('materia'=>'m.asignatura'))
                ->where('g.idprofesor=?',$cedula)
                ->where('g.idciclo=?',$periodo)
                ->order("g.idgrupo")
                ->setIntegrityCheck(false);
           $resultado=$this->fetchAll($consulta);
          // $contar=$resultado->count();
          
           //if($contar==0) $resultado=$resultado->toArray ('Usted no tiene ninguna materia asignada');
               
         
           
           return $resultado;
                
    }
    public function grupos($cedula)
    {
        
        $query=$this->select()->where('idprofesor=?',$cedula);
        $rowset=$this->fetchAll($query);
        $datos=array();
        
        foreach ($rowset as $row){
           
            $datos[$row->idciclo]=$row->idciclo;
        }
        
         return $datos;
        
        
}
   
    public function registrarcaptura($idgrupo){
        
        $data=array('capturar'=>1);
        $where=" idgrupo = ".$idgrupo;
        $this->update($data, $where);
      
         
    }
    
       public function verificarcaptura($idgrupo){
           
           $query=$this->select()->where('idgrupo=?',$idgrupo)->where('capturar=1');
           $row=$this->fetchRow($query);
         //  print_r($row);
           return $row;
           
           
       }
       
    public function info_grupo($idgrupo){
    $consulta=$this->select()
        ->from(array('g'=>'grupo'),array(true))
        ->join(array('m'=>'materia'),'g.clavemateria=m.clavemateria',array('asignatura'=>'m.asignatura'))
        ->where('g.idgrupo=?',$idgrupo)
        ->setIntegrityCheck(false);
        $resultado=$this->fetchRow($consulta);
        return $resultado;
    }
       
     /*  $sql="SELECT materia.asignatura, grupo.idgrupo, grupo.clavemateria, grupo.idperiodo FROM grupo
               Inner Join materia ON grupo.clavemateria = materia.clave WHERE grupo.idgrupo =  ".$idgrupo;
         $this->view->datos= $db->fetchRow($sql,Zend_Db::FETCH_BOTH); 
        
       */ 
    
    
}