<?php

class Prof_Form_ElegirPeriodo extends Zend_Form{
    
 
     
    public function Periodo($cedula){
        
        
        $this->addElement('select','periodos',array(
             'required'=>false,
             'label'=>'Seleccione:',
            'onclick'=>'form.submit();',
            'onchange'=>'form.submit();',
             'multiOptions' => array()
        ));
        $model= new Prof_Model_Grupos(); 
        $this->periodos->addMultiOptions($rowset=$model->grupos($cedula));
      
      //  $this->addElement('submit', 'enviar',array('label'=>'Ver','class'=>'btn-success'));
       }
    
    
    
    
    
}