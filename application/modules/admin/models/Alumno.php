<?php

class Admin_Model_Alumno extends Zend_Db_Table_Abstract
{
    protected $_name = 'alumno';
    protected $primary = 'numcontrol';
        public function getAll(){
        return $this->fetchAll();      
    }
     public function getRow($id)        
    {
        $id=(int) $id;
        $row=(object)$this->find($id)->current();
      
       $data = array();
         $data['numcontrol'] = $row->numcontrol ;   
         $data['apellidos'] = utf8_encode($row->apellidos); 
         $data['nombres'] = utf8_encode($row->nombres); 
         $data['fec_na'] = $row->fec_na;
         $data['direccion'] = utf8_encode($row->direccion);
         $data['telefono'] = $row->telefono;
         $data['correo_e'] = $row->correo_e;
         $data['contrasena'] = $row->contrasena;
   
        return $data;     
    }   
    public function veralumno($id)
    {
        $id=(int)$id;
        $query=$this->select()->where('numcontrol=?',$id);
        $row= $this->fetchRow($query);
        return $row;
    }
    
    

    public function guardar($data)
    {
        $row=$this->createRow($data);
        $row->save();
    }
    
    public function alumnos($semestre){
        
            if($semestre==1){$x2=100;$x3=200;}
            if($semestre==2){$x2=200;$x3=300;}
            if($semestre==3){$x2=300;$x3=400;}
            if($semestre==4){$x2=400;$x3=500;}
            if($semestre==5){$x2=500;$x3=600;}
            if($semestre==6){$x2=600;$x3=700;}

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();;
                    $db->setFetchMode(Zend_Db::FETCH_OBJ); 
                    $sql = "select grupo.idgrupo, materia.asignatura,profesor.nombre,grupo.idciclo from grupo inner 
                            join materia on grupo.clavemateria=materia.clavemateria inner join profesor on 
                        grupo.idprofesor=profesor.cedula where grupo.idciclo=(select idciclo from 
                        cicloescolar where periodoactual=1) and grupo.clavemateria>$x2 and grupo.clavemateria<$x3;" ;
                    $consulta = $db->fetchAll($sql,Zend_Db::FETCH_BOTH);      
                   // print_r($consulta);
       // $data = array();
        /*foreach ($consulta as $row) {
         $data[$row->numcontrol] = $row->nombres; 
        }*/
       // return  $data;  
        return  $consulta;  
        
    }
    

}

