<?php

class Prof_Form_CapturarCalificaciones extends Zend_Form{
    
    public function Capturar(){
        
        $this->addElement('text','primera_e',array());
        $this->addElement('text','segunda_e',array());
        $this->addElement('text','tercera_e',array());
        $this->addElement('text','cuarta_e',array());
        
        
        
        
    }
    
    
    
    
}