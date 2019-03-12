<?php

class Alu_DatosController extends Zend_Controller_Action{

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
        
        //instanciamos zend aut y leemos los datos de sesion y tomamos el numero de control que es la que nos interesa
        $auth=Zend_Auth::getInstance(); 
        $usuario=$auth->getStorage()->read();
        $numcontrol=$usuario->numcontrol;
        $where=array("numcontrol=?"=>$numcontrol);
        
        $model=new Alu_Model_Alumno();
        //consultamos los datos del profesor  que esta en session y lo mandamos a la vista
        $alumno=$model->fetchRow($where);
        $this->view->alumno=$alumno;
        
        if(isset($_POST['numcontrol'])){
            
            $datos=$_POST['numcontrol'];
            $alumno->direccion=$datos['direccion'];
            $alumno->telefono=$datos['telefono'];
            $alumno->correo_e=$datos['correo_e'];
            $alumno->save();
            $this->redirect("/alu/datos/index");
            
            
            
            
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
        $numcontrol= $usuario->numcontrol;
        $model=new Alu_Model_Alumno();
        //consultamos los datos del alumno  que esta en session y lo mandamos a la vista
        $where=array("numcontrol=?"=>$numcontrol);
        $alumno=$model->fetchRow($where);
        
         
          if(isset($_POST['password'])){
              
              $pass=$_POST['password'];
              
              $anterior=sha1($pass['anterior']);
             
             if(strcmp($alumno->contrasena,$anterior)){
             
                  $this->view->error='<div class="alert alert-error"><a class="close" data-dismiss="alert" href="/alu/datos/cambiarclave">&times;</a>¡La contraseña anterior no es valida!</div>';
                }                  
                  else{
                  $nueva=sha1($pass['nuevo']);
                  $alumno->contrasena=$nueva;
                  
                    try{
                        $alumno->save();
                        $this->view->error='<div class="alert alert-success"><a class="close" data-dismiss="alert" href="/alu/index/index">&times;</a>¡La contraseña se atualizo correctamente!</div>';             
                    }
                    catch (Exception $a){
                        $this->view->error='<div class="alert alert-success"><a class="close" data-dismiss="alert" href="/alu/index/index">&times;</a>¡Ha ocurrido un error intentelo mas tarde!</div>';             
                  
                    }
                  }
         }
        
        
    }
    
}