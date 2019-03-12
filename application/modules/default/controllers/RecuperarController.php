<?php

class Default_RecuperarController extends Zend_Controller_Action
{
    public function init(){
        
       $this->_helper->layout->disableLayout();
       
       
    }
    public function indexAction(){
        
        if(!$this->getParam('opc')){    
           $this->redirect('/index/index');
         }
         
        $opc=$this->getParam('opc');      
        $form = new Default_Form_recuperar();
        if($this->getRequest()->isPost()){
         
            if ($form->isValid($_POST)){
               
                $correo=$form->getValue('email');
              
                if($opc==1){ 
                 
                    
                     $model= new Default_Model_Admin();
                      $usuario=$model->buscarcorreo($correo);
                       if($usuario==NULL)
                         {
                           echo "<script type=\"text/javascript\">alert(\"Correo invalido\");</script>";
                          
                          
                        }
                         else {
                             // $this->view->usuario=$usuario;
                               $user=$usuario->numempleado;
                                $email=$usuario->correo;
                                $nombre=utf8_encode($usuario->nombre);
                                $tipo="administrador";
                 
                            }
                }   
                       
                
                if($opc==2){
                        $model= new Default_Model_Profesor();
                        $usuario=$model->buscarcorreo($correo);
                         if($usuario==NULL)
                         {
                           echo "<script type=\"text/javascript\">alert(\"Correo invalido\");</script>";
                          
                        }
                         else {
                             // $this->view->usuario=$usuario;
                               $user=$usuario->cedula;
                                $email=$usuario->correo_e;
                                $nombre=utf8_encode($usuario->nombre);
                                $tipo="profesor";
                 
                            }
                }       
                if($opc==3){
                    $model= new Default_Model_Alumno();
                        $usuario=$model->buscarcorreo($correo);
                         if($usuario==NULL)
                         {
                           echo "<script type=\"text/javascript\">alert(\"Correo invalido\");</script>";
                          
                        }
                         else {
                             // $this->view->usuario=$usuario;
                               $user=$usuario->numcontrol;
                                $email=$usuario->correo_e;
                                $nombre= utf8_encode($usuario->nombres)." ".  utf8_encode($usuario->apellidos);
                                $tipo="alumno";
                 
                            }
                }
        
                      if($usuario!=null){ 
                        $codigo=  md5(rand(10, 10000));
                        $config = array('ssl' => 'tls','port' => 587,'auth' => 'login','username' => 'gothicman001@gmail.com','password' => 'Nestort89g');
                        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
                        $mail = new Zend_Mail('utf-8');
                        $mail->setFrom('escuelatf.com', 'Recuperacion de contraseñas');
                        $mail->addTo($correo, $nombre);
                        $mail->setSubject('Restablecer contraseña');
                        
                        
                        $vista= new Zend_View();
                        $vista->setScriptPath('correo.phtml');
                        $vista->assign('nombre',$nombre);
                        $vista->assign('codigo',$codigo);
                        $this->view->nombre=$nombre;
                        $this->view->codigo=$codigo;
                        
                        
                        $mensaje = $this->view->render("recuperar/correo.phtml");
                        //$this->view->usuario=$usuario;
                        $mail->setBodyText($mensaje);
                        
                        $fecha=date("Y-m-d");
                       // $mail->setBodyHtml($this->view->render('recuperar',"UTF-8"));
                     try
                        {
                          $db= Zend_Db_Table_Abstract::getDefaultAdapter();
                          $data=array('usuario'=>"$user",'clave'=>"$codigo",'tipo'=>"$tipo",'validez'=>$fecha);
                          $db->insert('recuperar',$data);
                          
                            $mail->send($transport);
                             $transport->getConnection()->disconnect();
                              $this->view->error='<div class="alert alert-success"><a class="close" data-dismiss="alert" href="/index/index">&times;</a>¡Ya enviamos un correo Revisa tu correo!</div>';
                              $form=null;
                        }
                    catch(Exception $w)
                    {   
                          $this->view->error='<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">&times;</a>¡No se pudo enviar el correo intentelo nuevamente!</div>';
                            
                    }
                        
                      }
        }}        
            
     $this->view->form=$form;
    }
    
    
    public function comprobarAction()
    {
       
         if(!$this->getParam('codigo')){    
           $this->redirect('/index/index');
         }
          
         
      $codigo =$this->getParam('codigo');
      $model= new Default_Model_Recuperar();
      $verificar=$model->buscarcodigo($codigo);
   
      
      if($verificar==null){
          $this->view->error='<div class="alert alert-error"><a class="close" data-dismiss="alert" href="/index/index">&times;</a>¡El enlace no es valido!</div>';  
      }
      else{
          
          $hoy=date("Y-m-d");
          if($verificar->validez==$hoy){
              
              
              if($this->getRequest()->isPost()){
                  $newpassword=$this->getRequest()->getPost('pass');
                  $tabla=$verificar->tipo;
                  if($tabla=='alumno'){
                  $modelo=new Default_Model_Alumno();
                      
                  }
                  if($tabla=='profesor'){
                  $modelo=new Default_Model_Profesor();
                  }
                  if($tabla=='administrador'){
                  $modelo=new Default_Model_Admin();
                  }
                   try{
                      $modelo->actualizarPassword($verificar->usuario,$newpassword);
                      
                                                         
                      $model->borrar("$verificar->clave");
                      $this->view->error='<div class="alert alert-success"><a class="close" data-dismiss="alert" href="/index/index">&times;</a>¡Se ha actualizado la contraseña!</div>';  
   
                      }
                        catch (Exception $e){
                      $this->view->error='<div class="alert alert-error"><a class="close" data-dismiss="alert" href="/index/index">&times;</a>¡No se pudo actualizar la contraseña!</div>';  
   
     
                      }
                  
                  }
              
           
           else{
              $this->view->formulario=true;
              $this->view->codigo=$codigo;
              
           }
          }
          else{
           
                   $this->view->error='<div class="alert alert-error"><a class="close" data-dismiss="alert" href="/index/index">&times;</a>¡El link a caducado!</div>';  
     
          }
             
          
      }
         
    }
}