<?php

class Admin_Form_Altagrupo extends Zend_Form
{
    public function init()
    {
        
    }
    public function prueba($x=NULL,$grupo=NULL){
       
        $this->setDisableLoadDefaultDecorators(true);

         $this->setDecorators(array(
             array('viewScript',array(
                    'viewScript' => '/decorador/_altagrupo.phtml',          
            ))));
        
        
        $this->addElement('select','semestre',array(
            'required' => true,
            'class'=>"span3",
            'class'=>"btn btn-success",
            'value'=> $x ,
            'onchange'=>'form.submit();',
            'decorators' => array(
                'ViewHelper',
            ),
            'multiOptions' => array(
                '0' =>'Seleccione el Semestre',
                '1' =>'Primer Semestre',
                '2' =>'Segundo Semestre',
                '3' =>'Tercer Semestre',
                '4' =>'Cuarto Semestre',
                '5' =>'Quinto Semestre',
                ' 6' =>'Sexto Semestre')
        ));
        
        if(isset($x)){
             //print_r('form'.$grupo);
            $this->addElement('select','grupo',array(
            'required' => true,
                'class'=>"span3",
                'class'=>"btn btn-success",
            //'label' => 'Materia',
            'value'         =>  $grupo , 
            'decorators' => array(
                'ViewHelper',
            ),    
            'multiOptions' => array()
        ));
            $selecmodel= new Admin_Model_Grupo();
            $this->grupo->addMultiOptions(
                $rowset = $selecmodel->grupos($x));
        
            $this->addElement('select','profesor',array(
            'required' => true,
                'class'=>"span3",
                'class'=>"btn btn-success",
            //'label' => 'profesor',
            'decorators' => array(
                'ViewHelper',
            ),
            'multiOptions' => array()
            ));      
            $selecmodel= new Admin_Model_Profesor();
            $this->profesor->addMultiOptions(
                $rowset = $selecmodel->profesor()
                );
            
            $this->addElement('select','periodo',array(
            'required' => true,
                'class'=>"span3",
                'class'=>"btn btn-success",
            //'label' => 'periodo activo',
            'decorators' => array(
                'ViewHelper',
            ),
            'multiOptions' => array()
            ));     
            $selecmod= new Admin_Model_Cicloescolar();
            $this->periodo->addMultiOptions(
            $rows = $selecmod->periodo()
        );
            
            $this->addElement('submit', 'Guardar', array(
            'class'=>'btn btn-success',
            
          
            'label' => 'Guardar'
        ));
        
         }
        
        
    }
}

