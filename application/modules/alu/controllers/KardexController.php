<?php

class Alu_KardexController extends Zend_Controller_Action{
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
        
        $auth=Zend_Auth::getInstance(); 
        $usuario=$auth->getStorage()->read();
        $numcontrol=$usuario->numcontrol;
        $where=array("numcontrol=?"=>$numcontrol);
        
        $model=new Alu_Model_Alumno();
        //consultamos los datos del profesor  que esta en session y lo mandamos a la vista
        $alumno=$model->fetchRow($where);
        $this->view->alumno=$alumno;
        $kardex=new Alu_Model_Kardex();
        $calificaciones=$kardex->consultarKardex($numcontrol);
        $this->view->kardex=$calificaciones;
        
    }
      public function boletaAction(){
           
        $auth=Zend_Auth::getInstance(); 
        $usuario=$auth->getStorage()->read();
        $numcontrol=$usuario->numcontrol;
        $where=array("numcontrol=?"=>$numcontrol); 
        $model=new Alu_Model_Alumno();
        $alumno=$model->fetchRow($where);
        $form=new Alu_Form_ElegirCiclo();
        $form->elegirCiclo($numcontrol);
        if($this->getRequest()->isPost($_POST)){
                
                if ($form->isValid($_POST)) {
                    
                    $ciclo=$form->getValue('ciclo');
                    $this->redirect("/alu/kardex/imprimir?ciclo=$ciclo");
                          
          }
         }
        $this->view->alumno=$alumno; 
        $this->view->form=$form;
          
      }
      public function imprimirAction(){
          
      $this->_helper->layout->disableLayout();
      $this->_helper->viewRenderer->setNoRender(); 
      if(!$this->getParam('ciclo')){
           $this->redirect('/alu/kardex/boleta');
       }
      $ciclo=$this->getParam('ciclo');
      $auth=Zend_Auth::getInstance(); 
      $usuario=$auth->getStorage()->read();
      $numcontrol=$usuario->numcontrol;
      $where=array("numcontrol=?"=>$numcontrol);
        
        $model=new Alu_Model_Alumno();
        $alumno=$model->fetchRow($where);
        
 
  

    $pdf = new Zend_Pdf();
  //  $pdf->properties['Title'] = "Boleta de calificaciones";
   // $pdf->properties['Author'] = "SAP";

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

    $page->drawText('Sistema Para el Desarrollo Integral de  la Familia del estado de Chiapas.',155,820, 'UTF-8');
    
    
    
    $page->setFont($font,7.5);
    $page->drawText('Dirección General.',250,810, 'UTF-8');
    
    $page->drawText('Dirección de Atención a Grupos Vulnerables y Asistencia en Salud.',167,800, 'UTF-8');
    $page->drawText('Departamento de Rehabilitación Integral.',210,790, 'UTF-8');
    
    $page->drawText('Escuela de Terapia Física.',240,780, 'UTF-8');
    $image = Zend_Pdf_Image::imageWithPath('boleta_logo1.png');
    $page->drawImage($image,99,772,165 ,807);
    $image2 = Zend_Pdf_Image::imageWithPath('boleta_logo2.png');
    $page->drawImage($image2,390,770,490 ,815);
    

    
        $db =  Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql="SELECT materia.asignatura,materia.nc, materia.semestre, kardex.calificacionfinal, kardex.ciclo, kardex.materia,
              kardex.ee, kardex.ets, kardex.observaciones, kardex.numcontrol, materia.clavemateria
              FROM kardex
              Inner Join materia ON kardex.materia = materia.clavemateria WHERE kardex.ciclo =  '$ciclo' AND kardex.numcontrol =  '$numcontrol'";
        $datos=$db->fetchAll($sql);
    $page->setFont($font,7.5);
    $page->drawText('El responsable de servicios escolares de la Escuela de terapia Física del sistema para el Desarollo Integral de la Familia del',90,730, 'UTF-8');
    $page->drawText('Estado de Chiapas; hace constar que el(la) alumno(a). ',90,720, 'UTF-8');
    
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD_OBLIQUE);
    $page->setFont($font,8);
    $page->drawText(utf8_encode($alumno->apellidos." ".$alumno->nombres).".",210,700, 'UTF-8');
    
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
    $page->setFont($font,7);
   
    $page->drawText('las siguientes calificaciones.',90,670, 'UTF-8');
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD_OBLIQUE);
    $page->setFont($font,7);
    $page->drawText('NOMBRE DE LA MATERIA',95,640, 'UTF-8');
    $page->drawText('CALIFICACION',275,640, 'UTF-8');
    $page->drawText('OBSERVACIONES',340,640, 'UTF-8');
    $page->drawLine(95, 650, 500, 650);
    $page->drawLine(95, 635, 500, 635);
    $page->drawText('NUMERO',270,625, 'UTF-8');
    $page->drawText('LETRA',305,625, 'UTF-8');
    $page->drawLine(95, 620, 500, 620);
    
    $y=610;
    $ma=0;
    $ciclo_boleta=null;
    $semestre_boleta=null;
   $page->setFont($font,5);
    foreach ($datos as $cal){
        $ciclo_boleta=$cal->ciclo;
        $semestre_boleta=$cal->semestre;
         $calificacion=null;
         if($cal->calificacionfinal && $cal->calificacionfinal>=6 )
                    {
                        $calificacion=$cal->calificacionfinal; 
                        $ma++;
                    }
                    if ($cal->ee && $cal->ee>=6 )
                    {
                        $calificacion=$cal->ee;
                                $ma++;
                        
                    }
                    if($cal->ets && $cal->ets>=6 )
                    {
                        $calificacion=$cal->ets;
                        $ma++;
                     }
                    if(!$calificacion){$calificacion=5;}
                    
    $page->drawText(utf8_encode($cal->nc),96,$y, 'UTF-8');
    $page->drawText($calificacion,280,$y, 'UTF-8');
    $letra=null;
    if($calificacion==10){
        $letra="DIEZ";
    }
    if($calificacion==9){
        $letra="NUEVE";
    }
    if($calificacion==8){
        $letra="OCHO";
    }
    if($calificacion==7){
        $letra="SIETE";
    }
     if($calificacion==6){
        $letra="SEIS";
    }
    if(!$letra){
        $letra="N/A";
    }
    $page->drawText($letra,310,$y, 'UTF-8');
    $page->drawText($cal->observaciones,340,$y, 'UTF-8');
     $y-=15;
     $page->setLineWidth(0.8);
     $page->drawLine(95, $y+10, 500, $y+10);
    
    }
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
    $page->setFont($font,7);
     $page->drawText('Con el numero de control '.$alumno->numcontrol.' cursó el '.$semestre_boleta.'° semestre de la Licenciatura en Terapia Fisica,en el periodo '.$ciclo_boleta." y obtuvo",90,680, 'UTF-8');
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD_OBLIQUE);
    $page->setFont($font,7);
    
     $y+=10;
    $page->drawLine(95,650,95, $y);
    $page->drawLine(267,650,267, $y);
    $page->drawLine(303,635,303, $y);
    $page->drawLine(335,650,335, $y);
    $page->drawLine(500,650,500, $y);
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
    $page->setFont($font,7);
    $y-=30;
    if($ma==1){
        $page->drawText('El presente documento ampara '.$ma.' materia aprobada de acuerdo al plan de estudios en vigor, la escala  de calificaciones  es  de',100,$y, 'UTF-8');
    }else{
        $page->drawText('El presente documento ampara '.$ma.' materias aprobadas de acuerdo al plan de estudios en vigor, la escala de calificaciones es de',100,$y, 'UTF-8');
    }
    $y-=10;
    $page->drawText('5 a 10,minima para ser aprobada 6.',100,$y, 'UTF-8');
    $dia=date("j");
    $mes=date("n"); $mes=mes($mes);
    
    $ano=date("Y"); $y-=10;
    if($dia==1){
        $dia=  dia($dia);
    $page->drawText('Se extiende la presente en la ciudad de Tuxtla Gutiérrez, Chiapas al '.$dia.' dia del mes de '.$mes.' del '.$ano,100,$y, 'UTF-8');
    }
    
    $dia=dia($dia);
    $page->drawText('Se extiende la presente en la ciudad de Tuxtla Gutiérrez, Chiapas a los '.$dia.' dias del mes de '.$mes.' del '.$ano,100,$y, 'UTF-8');
    $y-=50;
    $page->drawText('LIC. JOSE HOMERO ABARCA',225,$y, 'UTF-8'); $y-=15;
    $page->drawText('RESPONSABLE DE SERVICIOS ESCOLARES',200,$y, 'UTF-8');
    
    $pdf->pages[] = $page;
     
    $this->getResponse()->setHeader('Content-type', 'application/x-pdf', true);
    $this->getResponse()->setHeader('Content-disposition', "inline; filename=boleta-$numcontrol-$ciclo.pdf", true);
    $this->getResponse()->setBody($pdf->render());
       
         
      }
    
}
function mes($num){
    /**
     * Creamos un array con los meses disponibles.
     * Agregamos un valor cualquiera al comienzo del array para que los números coincidan
     * con el valor tradicional del mes. El valor "Error" resultará útil
     **/
    $meses = array('Error', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
 
    /**
     * Si el número ingresado está entre 1 y 12 asignar la parte entera.
     * De lo contrario asignar "0"
     **/
    $num_limpio = $num >= 1 && $num <= 12 ? intval($num) : 0;
    return $meses[$num_limpio];
}
function dia($num){
    /**
     * Creamos un array con los meses disponibles.
     * Agregamos un valor cualquiera al comienzo del array para que los números coincidan
     * con el valor tradicional del mes. El valor "Error" resultará útil
     **/
    $dias = array('error','primer', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete','ocho','nueve','diez','once','doce','trece','catorce','quince',
        'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte', 'veintiuno','veintidós','Veintitrés','Veinticuatro','Veinticinco','Veintiséis',
        'Veintisiete','Veintiocho','Veintinueve','treinta','treinta y uno');
 
    /**
     * Si el número ingresado está entre 1 y 12 asignar la parte entera.
     * De lo contrario asignar "0"
     **/
    $dia = $num >= 1 && $num <= 31 ? intval($num) : 0;
    return $dias[$dia];
}
?>