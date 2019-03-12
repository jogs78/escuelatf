<?php

class Admin_Model_Grupo extends Zend_Db_Table_Abstract
{
     protected $_name = 'grupo';

    
        public function grupos($x){
            
            if($x==1){$x2=100;$x3=200;}
            if($x==2){$x2=200;$x3=300;}
            if($x==3){$x2=300;$x3=400;}
            if($x==4){$x2=400;$x3=500;}
            if($x==5){$x2=500;$x3=600;}
            if($x==6){$x2=600;$x3=700;}

            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $sql= "select grupo.idgrupo, materia.asignatura from grupo inner join materia on grupo.clavemateria=materia.clavemateria where grupo.clavemateria>$x2 and grupo.clavemateria<$x3 and idciclo=(select idciclo from cicloescolar where periodoactual=1) and grupo.idprofesor is null;";         
                    $consulta = $db->fetchAll($sql,Zend_Db::FETCH_BOTH);                

          $data = array();
        foreach ($consulta as $row) {
         $data[$row->idgrupo] = $row->asignatura;      
        }  
               
        return $data;
    }

}

