<?php

class Admin_CicloescolarController extends Zend_Controller_Action
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
    public function contmater($numcontrol,$idciclo,$semestre){
         $db = Zend_Db_Table_Abstract::getDefaultAdapter();
          $db->setFetchMode(Zend_Db::FETCH_OBJ);
          $ma=0;$totaldemateria=0;$bandera=0;
          if($semestre==1){$x2=100;$x3=200;}
            if($semestre==2){$x2=200;$x3=300;}
            if($semestre==3){$x2=300;$x3=400;}
            if($semestre==4){$x2=400;$x3=500;}
            if($semestre==5){$x2=500;$x3=600;}
            if($semestre==6){$x2=600;$x3=700;}
           // $sqlcont="select count(*) as contador from materia where clavemateria>$x2 and clavemateria <$x3;";
         // $materiacontador = $db->fetchRow($sqlcont); //total de matarias por semestre
          $sqlcalificacion="select calificacionfinal,ee,ets from kardex where numcontrol=$numcontrol and ciclo='$idciclo';";
                 $calificacion = $db->fetchAll($sqlcalificacion,Zend_Db::FETCH_BOTH);
              foreach ($calificacion as $cal) { 
                  $totaldemateria++;
                  if($cal->calificacionfinal && $cal->calificacionfinal>=6 ){                        
                        $ma++;    
                    }
                    if ($cal->ee && $cal->ee>=6 ){
                        $ma++;   
                    }
                    if($cal->ets && $cal->ets>=6 ){            
                        $ma++;
                    }
              }
             
              $promedio=$totaldemateria/2;
              if($promedio<=$ma){
          
                  $bandera=1;
              }
              return $bandera;
                    
    }
    public function checaralumno($numcontrol,$idciclo){ //lleca alumnos que allan reprobado
        $bandera=0;$calfinal=0;$ee=0;$ets=0;
          $db = Zend_Db_Table_Abstract::getDefaultAdapter();
          $db->setFetchMode(Zend_Db::FETCH_OBJ);
          $sqlcalificacion="select materia,numcontrol,calificacionfinal,ee,ets from kardex where numcontrol=$numcontrol and ciclo='$idciclo';";
                 $calificacion = $db->fetchAll($sqlcalificacion,Zend_Db::FETCH_BOTH);
              foreach ($calificacion as $rowcalificacion) {  //checa calificacion que no aya reprobado                  
                              
                  if($rowcalificacion->calificacionfinal==NULL || $rowcalificacion->calificacionfinal<6){
                      $calfinal=1;}
                  if($rowcalificacion->ee==NULL || $rowcalificacion->ee<6){
                      $ee=1;}   
                  if( $rowcalificacion->ets==NULL || $rowcalificacion->ets<6){
                     $ets=1;}
                  if($calfinal==1 && $ee==1 && $ets==1){
                      $bandera=1;
                      break;
                  }
                  else{
                      $bandera=2;
                      $calfinal=0;
                      $ee=0;
                      $ets=0;
                      }
              }

          return $bandera;
    }
    public function inscribir($semestre_act,$idciclo,$numcontrol,$materia=NULL){
           
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        if(is_null($materia)){
            if($semestre_act==0){$x2=100;$x3=200;}
            if($semestre_act==1){$x2=100;$x3=200;} //checar
            if($semestre_act==2){$x2=200;$x3=300;}
            if($semestre_act==3){$x2=300;$x3=400;}
            if($semestre_act==4){$x2=400;$x3=500;}
            if($semestre_act==5){$x2=500;$x3=600;}
            if($semestre_act==6){$x2=600;$x3=700;}
            $sql = "select idgrupo from grupo where clavemateria>$x2 and clavemateria<$x3 and idciclo='$idciclo';" ;
        }else{
            $sql = "select idgrupo from grupo where idciclo='$idciclo' and clavemateria=$materia;" ; //reprobados          
        }       
        $consulta = $db->fetchAll($sql,Zend_Db::FETCH_BOTH);
        foreach ($consulta as $row){
            $data = array(
                 'idgrupo' => $row->idgrupo,
                 'numcontrol'=>$numcontrol,
                  ); 
                    $db->insert('lista',$data);     
        }      
    }
    public function fech_ant_ala_actual($numcontrol){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);  
        $sql="select ciclo from kardex where numcontrol=$numcontrol order by fechacontrol desc limit 1;";
        $consulta = $db->fetchRow($sql,Zend_Db::FETCH_BOTH);   
        $idciclo=$consulta->ciclo;
        return $idciclo;
    }
    public function altaAction(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "select idciclo,iniciop,finp,periodoactual,periodoiniciado from cicloescolar where periodoactual=1" ;
        $consulta = $db->fetchAll($sql,Zend_Db::FETCH_BOTH); 
        
        if (!$consulta){
            $form=new Admin_Form_AltaCicloescolar();
            if($this->getRequest()->isPost()){
                $data = array(
              'idciclo' => $_POST['cicloescolar'],
              'iniciop' => $_POST['inicio'],
              'finp'=>$_POST['fin'],
              'periodoactual'=>1,
          ); 
                try{
           $db->insert('cicloescolar',$data);  
                $this->_redirect("admin/cicloescolar/alta"); 
                }  catch (ErrorException $w){
                     echo "<script type=\"text/javascript\">alert(\"CICLO ESCOLAR NO VALIDO\");</script>"; 
                }
            }
            $this->view->form=$form;
          
        }else{            
              $this->view->posts = $consulta;
        }       
    }
    public function iniciarAction(){
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();//Conseguimos el Adapter de nuestra conexion
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $db->beginTransaction();//iniciamos la transaccion   
      try{
          $idciclo=$this->_getParam('id'); // obtengo el id del ciclo actual  
          $sql = "select clavemateria from materia;" ;
          $consulta = $db->fetchAll($sql);
          foreach ($consulta as $row) {
              $data = array(
                  'clavemateria' => $row->clavemateria,
                  'idciclo'=>$idciclo,
               ); 
              $db->insert('grupo',$data); 
          }
          $sql = "select semestre_act,numcontrol from alumno where baja=0;" ;
          $consultanumcontrol = $db->fetchAll($sql,Zend_Db::FETCH_BOTH);
           foreach ($consultanumcontrol as $rowsemestre_act) { //incribe alumnos
               $semestre_anterior=$this->fech_ant_ala_actual($rowsemestre_act->numcontrol);
               $semestre_act=$rowsemestre_act->semestre_act;
               $numcontrol=$rowsemestre_act->numcontrol;
               if($semestre_act==0){  //nuevo ingreso  
                    
                   $this->inscribir($semestre_act,$idciclo,$numcontrol,NULL);    
                    $data = array(  
                        'semestre_act'=>$semestre_act+1,
                    );   
                    $idalumno=$rowsemestre_act->numcontrol;
                    $db->update('alumno',$data,"numcontrol=$idalumno");
               }
               if($semestre_act>0 && $semestre_act<=6){
 
                     $bandera=$this->checaralumno($numcontrol,$semestre_anterior);
                     if($bandera==2 || $bandera==0 ){//alumnos regulares
                    
                         $this->inscribir($semestre_act,$idciclo,$numcontrol,null);   
                     }
                     if($bandera==1){//incribir alumnos reprobados   checar
                         $ban=$this->contmater($rowsemestre_act->numcontrol,$semestre_anterior,$semestre_act);
                         if($ban==1){
                             $sql="select materia from kardex where (ciclo='$semestre_anterior') and 
                               (calificacionfinal<6 or calificacionfinal is null) and 
                               (ee<6 or ee is null) and (ets<6 or ets is null) and numcontrol=$numcontrol;";       
                         $consultamateria = $db->fetchAll($sql,Zend_Db::FETCH_BOTH);
                         foreach ($consultamateria as $row1) {
                             $this->inscribir(NULL,$idciclo,$numcontrol,$row1->materia);   
                         }
                         }
                         if($ban==0){
                             $this->inscribir($semestre_act,$idciclo,$numcontrol,null);
                         }
                     }          
                }   
            }
            $data = array(  //inicia le periodo
                'periodoiniciado'=> '1'
            );   
            $db->update('cicloescolar',$data,"idciclo='$idciclo'");
            $db->commit(); //confirmamos la transaccion
            $this->_redirect("admin/cicloescolar/alta");
      }catch (Exception $e) {
          $db->rollBack();
          echo $e->getMessage(); 
      }
    }
    public function terminarAction(){
        
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();//Conseguimos el Adapter de nuestra conexion
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $idciclo=$this->_getParam('id');

      $sql1="select capturar from grupo where capturar=0 and idciclo='$idciclo' and idprofesor is not null;";
      $consulta = $db->fetchAll($sql1,Zend_Db::FETCH_BOTH);
      if($consulta){
         echo"<div class=\"alert alert-info\"><a class=\"close\" data-dismiss=\"alert\" href=\"/admin/index/index\">&times;</a>¡No han concluido la captura de calificaciones!</div>";     
         $sql1="select distinct nombre from grupo inner join profesor on grupo.idprofesor=profesor.cedula where capturar=0 and grupo.idciclo='$idciclo' and idprofesor is not null;";
         $consulta = $db->fetchAll($sql1,Zend_Db::FETCH_BOTH);
         if(!$consulta){
                      echo"<div class=\"alert alert-info\"><a class=\"close\" data-dismiss=\"alert\" href=\"/admin/alumno/altagrupo\">&times;</a>¡Algunos grupos no tienen profesores!</div>";     

         }else{
         echo' <div class="row">';
            echo' <div class="span4"></div>';
            echo' <div class="span4">';
            echo '<table class="table table-bordered"  >';
            echo '<tr>';
            echo '<td>'.'Nombres de los Catedraticos'.'</td>';
            echo '</tr>';
                foreach ($consulta as $row) {
           echo '<tr>';
            echo '<td>'. utf8_encode($row->nombre).'</td>';
            echo '</tr>';  
                    }
        echo '</table>';
        echo'</div>';
         echo' <div class="span4"></div>';
         echo'</div>';
      }
      }
      else{     
      $db->beginTransaction();//iniciamos la transaccion 
      $idciclo=$this->_getParam('id');
      try{
      $sql = "select numcontrol,clavemateria,calificacionfinal,idciclo,ee,ets,observaciones from lista inner join grupo on lista.idgrupo=grupo.idgrupo where idciclo='$idciclo' order by numcontrol;" ;
      $consulta = $db->fetchAll($sql,Zend_Db::FETCH_BOTH);
      foreach ($consulta as $row) {
          $sql = "select iniciop from cicloescolar where idciclo='$row->idciclo';" ;
          $fechacontrol = $db->fetchRow($sql,Zend_Db::FETCH_BOTH);
          if($row->calificacionfinal>=6){
              $calredondeo=round($row->calificacionfinal);
          }
          if($row->calificacionfinal<6){
              $calredondeo=5;
          }
          $data = array(
              'numcontrol' => $row->numcontrol,
              'materia' => $row->clavemateria,
              'calificacionfinal'=> $calredondeo,
              'ciclo'=>$row->idciclo,
              'ee'=>  $row->ee,
              'ets'=>  $row->ets,
              'observaciones'=>$row->observaciones,
              'fechacontrol'=>$fechacontrol->iniciop,
          );     
           $db->insert('kardex',$data);  
      }
   
      $sql="select DISTINCT numcontrol from kardex where ciclo='$idciclo'";//numero de control que esten iscrito en ciclo actual
      $consulta = $db->fetchAll($sql,Zend_Db::FETCH_BOTH);
     
      foreach ($consulta as $row) { 
          $bandera=$this->checaralumno($row->numcontrol,$idciclo); 
          if($bandera==2 || $bandera==0){ //aumenta de semestre si aprobo todas sus materias
              $sqlsemestre_act="select semestre_act from alumno where numcontrol=$row->numcontrol;";
              $semestre_act = $db->fetchAll($sqlsemestre_act,Zend_Db::FETCH_BOTH);             
              foreach ($semestre_act as $rowsemestre_act) {
                $semestre=$rowsemestre_act->semestre_act;    
                $data = array(
                    'semestre_act'=>$semestre+1,
                );
                $db->update('alumno',$data,"numcontrol=$row->numcontrol");
              }
          }
          if($bandera==1){
          }
      }
      $data = array(  //desabilita el periodo actual
          'periodoiniciado'=> '2',
          'periodoactual'=>NULL
      );   
      $db->update('cicloescolar',$data,"idciclo='$idciclo'");
      $db->commit(); //confirmamos la transaccion
      return $this->_redirect('/admin/cicloescolar/alta');
    }catch (Exception $e) {
        $db->rollBack();
        echo $e->getMessage(); 
                        }
    
     }
    }
    

}



