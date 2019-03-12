<?php 
class  Alu_Form_ElegirCiclo extends Zend_Form{
    
    public function init() {
        parent::init();
    }
    public function elegirCiclo($numcontrol) {
        
          $this->addElement('select','ciclo',array(
              'label'=>'SELECCIONAR CICLO ESCOLAR:',
              'required'=>true,
                'class'=>'btn-info',
               'onchange'=>'form.submit();',
              'onclick'=>'form.submit();',
           
        ));
          $model=new Alu_Model_Kardex();
          $this->ciclo->addMultiOptions($row=$model->vermaterias($numcontrol));
    }
    
    
    
}