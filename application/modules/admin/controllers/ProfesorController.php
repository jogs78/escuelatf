<?php

class Admin_ProfesorController extends Zend_Controller_Action
{

    public function init(){
         
        $auth=Zend_Auth::getInstance();
        if(!$auth->hasIdentity()){
            $this->_redirect('/');
        }
            $rol_permitido="admin";  
            $usuario=$auth->getStorage()->read();
            $rol=$usuario->rol;
            if(strcmp($rol,$rol_permitido)!=0){
                $auth->clearIdentity();
                $this->_redirect('/');              
            } 
    }

    public function indexAction()
    {}

    public function altaAction()
    {
       $form= new Admin_Form_AltaProfesor();
            if($this->getRequest()->isPost())
              { 
                if($form->isValid($this->_getAllParams()))
                    {
                        $model=new Admin_Model_Profesor();
                        $db = $model->getAdapter();//Conseguimos el Adapter de nuestra conexion
                        $db->beginTransaction();//iniciamos la transaccion
                        $profesor=$model->verprofesor($form->getValue('cedula'));
                        if(!$profesor){
                        try{
                            $datos=$form->getValues();
                            $pass=$form->getValue('cedula');   
                            $nombre=utf8_decode($form->getValue('nombre'));
                            $datos['nombre']= strtoupper($nombre);
                            $datos['direccion']= strtoupper(utf8_decode($datos['direccion'])); 
                            if($datos['contrasena']==null){
                                $datos['contrasena']=$pass;
                            }
                            $datos['contrasena']= sha1($datos['contrasena']);
                            $model->guardar($datos);
                            $db->commit(); //confirmamos la transaccion
                            $this->_redirect("/admin/profesor/alta?edo=echop");
                        }
                        catch (Exception $e){
                            $db->rollBack();
                            echo $e->getMessage();        
                        }
                    }else{
                       // $db->rollBack();
                        return $this->_redirect('/admin/profesor/alta?edo=errorp');
                       // echo'else';
                    }
                    
                    }            
               
               }
        $this->view->form=$form;
    
        
    }

}





