<?php


class Admin_AlumnoController extends Zend_Controller_Action
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

    public function indexAction(){}
    
    public function reincorporacionAction(){
        $form=new Admin_Form_Altalista();
        $model=  new Admin_Model_Cicloescolar();
        $consulta=$model->cicloactual();
        if(!$consulta){
            if(!$this->_hasParam('numcontrol')){
            if($this->getRequest()->isPost()){ 
                if($form->isValid($this->_getAllParams())){
                    $numcontrol=$_POST['baja'];
                    $model=new Admin_Model_Alumno();
                    $db = $model->getAdapter();//Conseguimos el Adapter de nuestra conexion
                    $db->beginTransaction();//iniciamos la transaccion
                    try {
                        $consulta=$model->veralumno($numcontrol);
                        if(!$consulta){   
                            echo'<div class="alert alert-error"><a class="close" data-dismiss="alert" href="/admin/cicloescolar/alta">&times;</a>¡¡Lo sentimos, el alumno ingresado no se encuntra registrado!!</div>';
                        } else{  
                            if($consulta->baja==1){
                                $data = array(  //
                                    'baja'=> '0',
                                );   
                                $db->update('alumno',$data,"numcontrol='$numcontrol'");
                                $db->commit(); //confirmamos la transaccion
                                echo"<div class=\"alert alert-success\">¡ $consulta->nombres $consulta->apellidos se reincorporo con exito!</div>";     
                            }else{  
                                echo"<div class=\"alert alert alert-info\">¡ $consulta->nombres $consulta->apellidos su situacion actual es activo, no se necesita reincorporar  !</div>";  
                            }
                        } 
                    }catch (Exception $e) {
                            $db->rollBack();
                            echo $e->getMessage(); 
                        }
               }
           }
           $this->view->form=$form; 
        }else{
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $model=new Admin_Model_Alumno();
            $db->beginTransaction();//iniciamos la transaccion
            try {
                $numcontrol=$this->_getParam('numcontrol');
                $consulta=$model->veralumno($numcontrol);
                $data = array(  //desabilita el periodo actual
                'baja'=> '0',
                );   
                $db->update('alumno',$data,"numcontrol='$numcontrol'");
                $db->commit(); //confirmamos la transaccion
                echo"<div class=\"alert alert-success\"><a class=\"close\" data-dismiss=\"alert\" href=\"/admin/alumno/buscar\">&times;</a>¡ $consulta->nombres $consulta->apellidos se reincorporo con exito!</div>";     

               // $this->_redirect("/admin/alumno/buscar");                 
            }catch (Exception $e) {
                $db->rollBack();
                echo $e->getMessage(); 
            }       
        }
           
        }else{
            echo'<div class="alert alert-info"><a class="close" data-dismiss="alert" href="/admin/index/index">&times;</a>¡No se puede reincorporar por que el semestre esta iniciado!</div>';

        }    
    }
    public function bajatemporalAction(){
        $form=new Admin_Form_Altalista();
        $model=new Admin_Model_Alumno();
        if(!$this->_hasParam('numcontrol')){    
        if($this->getRequest()->isPost()){
            if($form->isValid($this->_getAllParams())){              
                $numcontrol=$_POST['baja'];
                $consulta=$model->veralumno($numcontrol);
                $db = $model->getAdapter();//Conseguimos el Adapter de nuestra conexion
                $db->beginTransaction();//iniciamos la transaccion
                try {
                if(!$consulta){   
                            echo'<div class="alert alert-error"><a class="close" data-dismiss="alert" href="/admin/cicloescolar/alta">&times;</a>¡¡Lo sentimos, el alumno ingresado no se encuntra registrado!!</div>';
                        } else{  
                            if($consulta->baja==0){
                                $data = array(  //desabilita el periodo actual
                                    'baja'=> '1',
                                );   
                                $db->update('alumno',$data,"numcontrol='$numcontrol'");
                                $db->commit(); //confirmamos la transaccion
                                echo"<div class=\"alert alert-success\">¡ $consulta->nombres $consulta->apellidos se dio de baja con exito!</div>";     
                            }else{  
                                echo"<div class=\"alert alert alert-info\">¡ $consulta->nombres $consulta->apellidos se encuentra en baja  !</div>";  
                            }
                        }
                        }catch (Exception $e) {
                            $db->rollBack();
                            echo $e->getMessage(); 
                        }
          }
        } 
        $this->view->form=$form; 
        }else{
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $db->beginTransaction();//iniciamos la transaccion
            try {
                $numcontrol=$this->_getParam('numcontrol');
                $consulta=$model->veralumno($numcontrol);
                $data = array(  //desabilita el periodo actual
                'baja'=> '1',
                );
               $db->update('alumno',$data,"numcontrol='$numcontrol'");
               $db->commit(); //confirmamos la transaccion
               echo"<div class=\"alert alert-success\"><a class=\"close\" data-dismiss=\"alert\" href=\"/admin/alumno/buscar\">&times;</a>¡ $consulta->nombres $consulta->apellidos se dio de baja con exito!</div>";     
               //$this->_redirect("/admin/alumno/buscar");
                }catch (Exception $e) {
                    $db->rollBack();
                    echo $e->getMessage(); 
                }
        }
             
    }
    public function editargrupoAction(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        if($this->_hasParam('idgrupo') && $this->_hasParam('semestre')){
            echo 'entroo';
        }
        $idgrupo=$this->_getParam('idgrupo'); 
        $data = array( 
            'idprofesor'=>NULL,
        );   
        $db->update('grupo',$data,"idgrupo=$idgrupo");     
        $this->_redirect("/admin/alumno/altagrupo");
    }
    public function altagrupoAction(){
        $form=new Admin_Form_Altagrupo();
        $model= new Admin_Model_Cicloescolar();
        $ciclo=$model->cicloactual();
        if(!$ciclo){
          $this->view->mensaje='<div class="alert alert-error"><a class="close" data-dismiss="alert" href="/admin/cicloescolar/alta">&times;</a>¡No hay un periodo activo!</div>';
        }else{  
        $form->prueba();
        $db = $model->getAdapter();//Conseguimos el Adapter de nuestra conexion
        $db->beginTransaction();//iniciamos la transaccion         
        if($this->getRequest()->isPost()){ //si viene datos via post
            if($form->isValid($_POST)){
                   $grupo=$form->getValue('grupo');//$_POST['grupo'];                
                   $semestre=$form->getValue('semestre');//$_POST['semestre'];
                    if($semestre!=0){ 
                        $form->prueba($semestre);                           
                    if(isset($_POST['Guardar'])){ 
                        $profesor=$_POST['profesor'];
                        $data = array( 
                          'idprofesor'=> $profesor,
                        );  
                        if(isset($_POST['grupo'])){
                                $grupo=$_POST['grupo'];
                                try{
                                $db->update('grupo',$data,"idgrupo=$grupo");
                                $db->commit(); //confirmamos la transaccion
                                } catch (Exception $e){
                                    $db->rollBack(); //desase la transaccion
                                    echo $e->getMessage();
                                }                      
                          }else{
                                 echo "<script type=\"text/javascript\">alert(\"Grupo Terminado\");</script>";  
                          }
                    }    
                    $form->prueba($semestre,$grupo);
                    }
            }
    }
        }
        $this->view->form=$form;
        
    }
    public function altaAction(){
         $form= new Admin_Form_AltaAlumno();
         $form->altaalumno();
       if($this->getRequest()->isPost()){ //si viene datos via post
                if($form->isValid($this->_getAllParams())){
                    $model=new Admin_Model_Alumno();
                    $db = $model->getAdapter();//Conseguimos el Adapter de nuestra conexion
                    $db->beginTransaction();//iniciamos la transaccion
                    $alumno=$model->veralumno($form->getValue('numcontrol'));
                    if(!$alumno){
                    try {
                        $datos=$form->getValues(); 
                        $pass=$form->getValue('numcontrol');
                        $apellidos=utf8_decode($form->getValue('apellidos'));
                        $nombres=utf8_decode($form->getValue('nombres'));
                        $datos['apellidos'] =strtoupper($apellidos);
                        $datos['nombres']= strtoupper($nombres);
                        $datos['direccion']= strtoupper(utf8_decode($datos['direccion']));
                        if($datos['contrasena']==null){
                            $datos['contrasena']=$pass;
                         }
                        $datos['contrasena']= sha1($datos['contrasena']);     
                        $model->guardar($datos);
                        $db->commit(); //confirmamos la transaccion
                        return $this->_redirect('/admin/alumno/alta?edo=echo');
                        } catch (Exception $e) {
                            $db->rollBack();
                            echo $e->getMessage(); 
                        }   
                 }else{
                     return $this->_redirect('/admin/alumno/alta?edo=error');
                      // echo " <script type=\"text/JavaScript\"> alert(\" Lo sentimos, el alumno ingresado ya ha sido registrado\"); </script>";
                    }
                    
                }                
            }
        $this->view->form=$form;
    }
    public function editarAction(){
       if(!$this->_hasParam('numcontrol')){
             echo 'aaaaaaaaaa';
            return $this->_redirect("/admin/alumno/buscar");
        }
        $form= new Admin_Form_AltaAlumno();
        $form->altaalumno();
        $modelo= new Admin_Model_Alumno();
       
        if($this->getRequest()->isPost()){
            if ($form->isValid($_POST)) {
                    $model=new Admin_Model_Alumno();
                    $db = $model->getAdapter();
                    $db->beginTransaction();//iniciamos la transaccion
                    try {
                        $datos=$form->getValues();
                        $pass=$form->getValue('numcontrol');
                        $apellidos=utf8_decode($form->getValue('apellidos'));
                        $nombres=utf8_decode($form->getValue('nombres'));
                        $datos['apellidos'] =strtoupper($apellidos);
                        $datos['nombres']= strtoupper($nombres);
                        $datos['direccion']= strtoupper(utf8_decode($datos['direccion']));
                        if($datos['contrasena']==null){
                            $datos['contrasena']=$pass;
                         }
                        $datos['contrasena']= sha1($datos['contrasena']); 
                        $where = $db->quoteInto('numcontrol = ?',$this->getparam('numcontrol'));
                        $modelo->update($datos,$where);
                        $db->commit(); //confirmamos la transaccion
                        $this->_redirect("/admin/alumno/buscar");
                        } catch (Exception $e) {
                         $db->rollBack();
                            echo $e->getMessage();
                        }
            }		 
            }else{
                $row=$modelo->getRow($this->_getParam('numcontrol'));
                $row['contrasena']=null;
                if($row){
                    $form->populate($row);
                }
        }
        $this->view->form=$form;  
    }
    public function busquedaAction(){
          $this->_helper->Layout->disableLayout();
          $this->_helper->ViewRenderer->setNoRender(true);
          
             $buscar = $_POST['b'];
            if(!empty($buscar)) {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $sql = "SELECT numcontrol,apellidos,nombres,baja,semestre_act FROM alumno WHERE nombres LIKE '%".$buscar."%' or numcontrol LIKE '%".$buscar."%' or apellidos LIKE '%".$buscar."%'";
            $consulta = $db->fetchAll($sql,Zend_Db::FETCH_BOTH);
           
            echo' <div class="row">';
            echo' <div class="span1"></div>';
            echo' <div class="span10">';
            echo '<table class="table table-bordered"  >';
            echo '<tr>';
            echo '<td>'.'Numero de Control'.'</td>';
            echo '<td>'.'Semestre'.'</td>';
            echo '<td>'.'Apellido'.'</td>';
            echo '<td>'.'Nombre'.'</td>';
            echo '<td>'.'Situacion'.'</td>';
            echo '<td>'.''.'</td>';
            echo '</tr>';
                foreach ($consulta as $row) {
           echo '<tr>';
             echo '<td>'. utf8_encode($row->numcontrol).'</td>';
             echo '<td>'. utf8_encode($row->semestre_act).'</td>';
            echo '<td>'.  utf8_encode($row->apellidos).'</td>';
            echo '<td>'. utf8_encode($row->nombres).'</td>';
            if($row->baja==0){
                $situacion="<a href=\"/admin/alumno/bajatemporal?numcontrol=$row->numcontrol\">Alta</a>";
            }
            if($row->baja==1){
                $situacion="<a href=\"/admin/alumno/reincorporacion?numcontrol=$row->numcontrol\">Baja</a>";
            }
            
            echo '<td>'. $situacion.'</td>';
           
             //echo "<td><a href=\"/admin/alumno/editar?numcontrol=$row->numcontrol\"><img src =\"/img/pencil.png\">Edit</a></td>";
           echo "<td><a href=\"/admin/alumno/editar?numcontrol=$row->numcontrol\"><i class=\"icon-pencil\"></i>Editar</a></td>";
            echo '</tr>';  
          
                    }
        echo '</table>';
         echo'</div>';
         echo' <div class="span1"></div>';
         echo'</div>';
      }
          
          
      }
    public function buscarAction(){}  
}





