<?php

class Prof_DatosController extends Zend_Controller_Action{

    public function init(){
        $auth=Zend_Auth::getInstance();
        if(!$auth->hasIdentity()){
            $this->_redirect('/');
        }
            $rol_permitido="profesor"; 
            $usuario=$auth->getStorage()->read();
            $rol=$usuario->rol;
            if(strcmp($rol,$rol_permitido)!=0){
                $auth->clearIdentity();
                $this->_redirect('/');              
            }    
    }
    
    public function indexAction(){
        
        //instanciamos zend aut y leemos los datos de sesion y tomamos la cedula que es la que nos interesa
        $auth=Zend_Auth::getInstance(); 
        $usuario=$auth->getStorage()->read();
        $cedula= $usuario->cedula;
        $model=new Prof_Model_Profesor();
        //consultamos los datos del profesor  que esta en session y lo mandamos a la vista
        $where=array("cedula=?"=>$cedula);
        $profesor=$model->fetchRow($where);
        $this->view->profesor=$profesor;
        
        if(isset($_POST['cedula'])){
            
            $catedratico=$_POST['cedula'];
            $profesor->direccion=$catedratico['direccion'];
            $profesor->telefono=$catedratico['telefono'];
            $profesor->correo_e=$catedratico['correo_e'];
            $profesor->save();
            $this->redirect("/prof/datos/index");
            
            
            
            
        }
        
    }
    public function cerrarsesionAction(){
        
        $auth= Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect('/');
    }
     public function cambiarclaveAction(){
         
        $auth=Zend_Auth::getInstance(); 
        $usuario=$auth->getStorage()->read();
        $cedula= $usuario->cedula;
        $model=new Prof_Model_Profesor();
        //consultamos los datos del profesor  que esta en session y lo mandamos a la vista
        $where=array("cedula=?"=>$cedula);
        $profesor=$model->fetchRow($where);
         
          if(isset($_POST['password'])){
              
              $pass=$_POST['password'];
              $anterior=  sha1($pass['anterior']);
              
               if ($profesor->contrasena!=$anterior){
                   
                       $this->view->error='<div class="alert alert-error"><a class="close" data-dismiss="alert" href="/prof/datos/cambiarclave">&times;</a>¡La contraseña anterior no es valida!</div>';
                  }
                  else{
                  $nueva=sha1($pass['nuevo']);
                  $profesor->contrasena=$nueva;
                  $this->view->error='<div class="alert alert-success"><a class="close" data-dismiss="alert" href="/prof/index/index">&times;</a>¡La contraseña se atualizo correctamente!</div>';             
                  $profesor->save();
          }
         }
        
        
    }
    
}