<?php

class Admin_Form_AltaCicloescolar extends Zend_Form
{

        public function init()
    {
  
   $fecha=date("Y");
         $this->addElement('select','cicloescolar',array(
            'required'=>TRUE,
             'label'=>'ciclo escolar:',
             'multiOptions' => array(
                'ENE-JUN-'.$fecha =>'ENE-JUN-'.$fecha,
                'AGO-DIC-'.$fecha =>'AGO-DIC-'.$fecha,)
        ));



         $this->addElement('text','inicio',array(
             'label'=>'inicio:',
             

        ));
         
        $this->addElement('text','fin',array(
            'label'=>'fin:',
        )); 
        
         $this->addElement('submit', 'submit', array(
            'class'=>'btn btn-success',
            'label' => 'Registrar'
        ));
    
    }



}

