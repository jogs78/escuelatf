<?php

class Prof_GruposController extends Zend_Controller_Action{

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
        
        $auth=Zend_Auth::getInstance();
        $usuario=$auth->getStorage()->read();
        $cedula=$usuario->cedula;
      //  Zend_Registry::get('log')->info($cedula);
        
       $form=new Prof_Form_ElegirPeriodo();
        $form->Periodo($cedula);
       
        if($this->getRequest()->isPost())
              { 
                if($form->isValid($_POST))
                    {
                        
                        $periodo=$form->getValue('periodos');
                        $model= new Prof_Model_Grupos();
                        $this->view->grupos=$model->gruposAsignados($cedula, $periodo);
                        $this->view->periodo=$periodo;
                        
       
                    }
                }
       
        $this->view->form=$form;
        
        
    }
    public function imprimirAction(){
       
            
    $this->_helper->layout->disableLayout();
    $this->_helper->viewRenderer->setNoRender(); 
      if(!$this->getParam('idgrupo')){
           $this->redirect('/prof/grupos/index');
       }
      
 
  

    $pdf = new Zend_Pdf();
    $pdf->properties['Title'] = "REPORTE DE EVALUACION";
    $pdf->properties['Author'] = "SAP";

    $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
    $width  = $page->getWidth();        // A4 : 595
    $height = $page->getHeight();       // A4 : 842

    //$imagePath = WEB_DIR . '/assets/img/dif.png';
   // $imagePath='/assets/img/dif.png';
   // $image = Zend_Pdf_Image::imageWithPath($imagePath);
   // $x = 15;
   // $y = $height - 15 - 106/2;
   // $page->drawImage($image, 10,10, 20, 20);

    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
    $page->setFont($font,8);

    $page->drawText('SISTEMA PARA EL DESARROLLO INTEGRAL DE LA FAMILIA DEL ESTADO DE CHIAPAS ',170,820, 'UTF-8');
    $page->drawText('DIRECCION DE ATENCION  A GRUPOS VULNERABLES Y ASISTENCIA  EN SALUD ',180,810, 'UTF-8');
    $page->drawText('ESCUELA DE TERAPIA FISICA ',265,800, 'UTF-8');
    $page->setFont($font,7);

    $page->drawText('REPORTE DE EVALUACION ',270,770, 'UTF-8');
   
        $idgrupo=$this->getParam('idgrupo'); 
        $db =  Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql="SELECT materia.clavemateria, materia.asignatura, materia.semestre, grupo.idciclo
        FROM materia Inner Join grupo ON grupo.clavemateria = materia.clavemateria
        WHERE grupo.idgrupo = $idgrupo";
        $datos= $db->fetchRow($sql); 
      
     
     
    $page->setFont($font,6);
    $page->drawText('ASIGNATURA: ',80,730, 'UTF-8');
    $page->drawText($datos->asignatura,125,730, 'UTF-8');
    
    $page->drawText('CICLO ESCOLAR: ',250,730, 'UTF-8');
    $page->drawText(strtoupper($datos->idciclo),300,730, 'UTF-8');
    
    $page->drawText('SEMESTRE: ',400,730, 'UTF-8');
    $page->drawText($datos->semestre,435,730, 'UTF-8');
    
    $db =  Zend_Db_Table_Abstract::getDefaultAdapter();
   $sql="SELECT lista.numcontrol, alumno.nombres, alumno.apellidos, lista.primera_e, lista.segunda_e, lista.tercera_e,
        lista.cuarta_e, lista.calificacionfinal, lista.ee, lista.ets, lista.observaciones
        FROM lista
        Inner Join alumno ON lista.numcontrol = alumno.numcontrol
        WHERE lista.idgrupo =  $idgrupo
        ORDER BY alumno.apellidos ASC"; 
   $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_ITALIC);
    $page->setFont($font,6);
   $lista= $db->fetchAll($sql); 
   $page->drawText('No. ',82,700, 'UTF-8');
   $page->drawText('NOMBRES ',150,700, 'UTF-8');
   $page->drawText('EVALUACIONES',250,700, 'UTF-8');
   $page->drawText('CAL.FINAL',300,700, 'UTF-8');
   $page->drawText('E.E.',350,700, 'UTF-8');
   $page->drawText('E.T.S',400,700, 'UTF-8');
   $page->drawText('OBSERVACIONES',450,700, 'UTF-8');
   $page->drawText('1a',240,692, 'UTF-8');
   $page->drawText('2a',255,692, 'UTF-8');
   $page->drawText('3a',270,692, 'UTF-8');
   $page->drawText('4a',285,692, 'UTF-8');
   
   $page->drawLine(80,708,530 ,708);
   $page->drawLine(80,690,530 ,690);
   
   
   $num=1;
    $y=680;
   foreach ($lista as $alumno){
  
   $page->drawText($num,83,$y, 'UTF-8');
   $page->drawText(utf8_encode($alumno->apellidos." ".$alumno->nombres),95,$y, 'UTF-8');
   $page->drawText($alumno->primera_e,240,$y, 'UTF-8') ;
   $page->drawText($alumno->segunda_e,255,$y, 'UTF-8');
   $page->drawText($alumno->tercera_e,270,$y, 'UTF-8'); 
   $page->drawText($alumno->cuarta_e,285,$y, 'UTF-8');
   $page->drawText($alumno->calificacionfinal,300,$y, 'UTF-8');
   $page->drawText($alumno->ee,350,$y, 'UTF-8');
   $page->drawText($alumno->ets,400,$y, 'UTF-8');;
   $page->drawText($alumno->observaciones,450,$y, 'UTF-8');
   
   $page->setLineWidth(0.5);
   $page->drawLine(80,$y-3,530,$y-3);
   
   $y=$y-10;
   $num++;
       
   }
   $y=$y+7;
   $page->drawLine(80,708,80,$y);
   $page->drawLine(90,708,90,$y);
   $page->drawLine(238,708,238,$y);
   $page->drawLine(253,699,253,$y);
   $page->drawLine(268,699,268,$y);
   $page->drawLine(283,699,283,$y);
   $page->drawLine(298,708,298,$y);
   $page->drawLine(349,708,349,$y);
   $page->drawLine(399,708,399,$y);
   $page->drawLine(449,708,449,$y);
   $page->drawLine(238,699,298,699);
   $page->drawLine(530,708,530,$y);
   

    $pdf->pages[] = $page;
   
   // $this->getResponse()->setHeader('Content-type', 'application/x-pdf', true);
  //  $this->getResponse()->setHeader('Content-disposition', 'inline; filename="$nombre".pdf', true);
   // $this->getResponse()->setBody($pdf->render());
     
     $this->getResponse()->setHeader('Content-type', 'application/x-pdf', true);
    $this->getResponse()->setHeader('Content-disposition', "inline; filename=grupo$idgrupo.pdf", true);
    $this->getResponse()->setBody($pdf->render());
       
      }    
      
    public function capturarAction()
    {    
        //verificacmos si le dato del grupo que vamos a capturar es recibido 
        if(!$this->getParam('idgrupo')){
            $this->redirect('/prof/grupos/index');
        }

        //asignamos a una variable la variable recibida 
        $idgrupo=$this->getParam('idgrupo');        
        $model= new Prof_Model_Listas();

        //mandamos a la vista los alumnos de la lista perteneciente al grupo que queremos capturar
        $this->view->lista=$model->lista($idgrupo); 
        $datos_materia=new Prof_Model_Materia();

        //obtenemos otros datos como lo son el nombre de la materia y quien la imparte 
        $datos=new Prof_Model_Grupos();
        //mandamos esos datos a la vista 
        $this->view->datos=$datos->info_grupo($idgrupo);

        //un variable tipo post que es una matriz con las actualizaciones de las calificaciones 
        if(isset($_POST['numcontrol'])) {

            //agregamos a una variable 
            $calificaciones=$_POST['numcontrol'];
            

            //instaciamos el modelo que modificaremos 
            $modelo= new Prof_Model_Listas();

            //recorremos la matriz por cada iteracion obtenemos datos de un alumno especifico 
            $contador=0;
            foreach ($calificaciones as $alu){
                
                $where = array(
                        "idgrupo=?"=>$idgrupo,
                        "numcontrol=?"=>$alu['numcontrol'],
                    );
                
                $alumno = $modelo->fetchRow($where);
                Zend_Registry::get('log')->debug($alumno->numcontrol);
                Zend_Registry::get('log')->debug($alumno->toArray());
                
                if(!empty($alu['primera_e'])){
                    $alumno->primera_e = $alu['primera_e'];
                    $contador++;
                }
                // Segunda Evaluación 
                if(!empty($alu['segunda_e'])){    
                    $alumno->segunda_e = $alu['segunda_e'];
                    $contador++;
                }  

                //tercera  evaluacuion
                if(!empty($alu['tercera_e'])){
                    $alumno->tercera_e= $alu['tercera_e'];
                    $contador++;
                }

                //cuarta  
                if(!empty($alu['cuarta_e'])){
                    $alumno->cuarta_e=$alu['cuarta_e'];
                    $contador++;
                }

                //Cf
                if(!empty($alu['calificacionfinal'])){
                    $alumno->calificacionfinal= $alu['calificacionfinal'];
                    $contador++;
                    
                }

                //e.e
                if(!empty($alu['ee'])){
                   $alumno->ee= $alu['ee'];
                   $contador++;
                }

                //ets
                if(!empty($alu['ets'])){
                    $alumno->ets=$alu['ets'];
                    $contador++;
                }

                if(!empty($alu['observaciones'])){
                    $alumno->observaciones=$alu['observaciones'];
                    $contador++;
                }

                $alumno->save();
                Zend_Registry::get('log')->debug($alumno->toArray());
                unset($alumno);
            }
              $this->redirect("/prof/grupos/capturar/idgrupo/$idgrupo");
        }

    }
    public function terminarAction(){
        
         if(!$this->getParam('idgrupo')){
            
            $this->redirect('/prof/grupos/index');
        }
        
         $idgrupo=$this->getParam('idgrupo');
         $model= new Prof_Model_Grupos();
         $model->registrarcaptura($idgrupo);
         $this->redirect('prof/grupos/index');
        
        
        
    }
}
