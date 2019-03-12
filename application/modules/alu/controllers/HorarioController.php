<?php

class Alu_HorarioController extends Zend_Controller_Action
{
    public function init(){
        $auth=Zend_Auth::getInstance();
        if(!$auth->hasIdentity()){
            $this->_redirect('/');
        }
            $rol_permitido="alumno"; 
            $usuario=$auth->getStorage()->read();
            $rol=$usuario->rol;
            if(strcmp($rol,$rol_permitido)!=0){
                $auth->clearIdentity();
                $this->_redirect('/');              
            }    
    }
    public function indexAction(){
        
        $model= new Alu_Model_Ciclo();
        $ciclo=$model->cicloactual();
        
        $auth=Zend_Auth::getInstance(); 
        $usuario=$auth->getStorage()->read();
        $numcontrol=$usuario->numcontrol;
        $where=array("numcontrol=?"=>$numcontrol);
        
        $modelo=new Alu_Model_Alumno();
        //consultamos los datos del profesor  que esta en session y lo mandamos a la vista
        $alumno=$modelo->fetchRow($where);
        $this->view->alumno=$alumno;
        
        if(!$ciclo){
        
          $this->view->mensaje='<div class="alert alert-error"><a class="close" data-dismiss="alert" href="/alu/index/index">&times;</a>¡No hay un periodo activo!</div>';
            
        }else{
        $cicloactual=$ciclo->idciclo;
        
        //BORRAR LAS CONSULTAS A EE ETS CALFINAL
        $db=  Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql="SELECT materia.asignatura, lista.numcontrol, grupo.idciclo, profesor.nombre, lista.primera_e, lista.segunda_e,
              lista.tercera_e,lista.cuarta_e
              , lista.calificacionfinal, lista.ee, lista.ets,
                grupo.clavemateria  FROM materia
              Inner Join grupo ON materia.clavemateria = grupo.clavemateria
              Inner Join lista ON lista.idgrupo = grupo.idgrupo
              Inner Join profesor ON grupo.idprofesor = profesor.cedula
                WHERE grupo.idciclo =  '$cicloactual' AND lista.numcontrol = '$numcontrol' ORDER BY grupo.clavemateria ASC ";
        
        $consulta=$db->fetchAll($sql);
        
        $this->view->consulta=$consulta;
        }
    
    }
    
}