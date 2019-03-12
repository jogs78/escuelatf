
<?php

class Admin_Form_AltaAlumno extends Zend_Form
{

    public function init()
    {
    }
    public function altaalumno(){
                 $this->setDisableLoadDefaultDecorators(true);

         $this->setDecorators(array(
             array('viewScript',array(
                    'viewScript' => '/decorador/_form.phtml',          
            ))));
   
         $this->addElement('text','numcontrol',array(
             'class'=>'input-small',
             'required' => true,
             'placeholder'=>"Solo numero",
             
             'Attribs'=>(array(
                        'required' => 'true',
                        'pattern'=>"[0-9]{9,9}")),
             
            'decorators' => array(
                'ViewHelper',
            ),
        ));
         
         $this->addElement('text','apellidos',array(
             'placeholder'=>"Solo Letras",
            'class'=>'span3',
            'required'=>TRUE,
             'Attribs'=>(array(
                        'required' => 'true',
                        'pattern'=>"[A-Za-z ñáéíóúÑÁÉÍÓÚ]{1,20}",
                        'title'=>"Se requiere apellido"
                 )),
            'decorators' => array(
                'ViewHelper',
               
            ),
        ));
         
        $this->addElement('text','nombres',array(
             'placeholder'=>"Solo Letras",
            'required'=>TRUE,
            'class'=>'span2',
            'Attribs'=>(array(
                        'required' => 'true',
                        'pattern'=>"[A-Za-z ñáéíóúÑÁÉÍÓÚ]{1,20}",
                        'title'=>"Se requiere un nombre")),
                        
            'decorators' => array(
                'ViewHelper'
            ),
        )); 
        
        $this->addElement('text','fec_na',array(
            'filters'=>array('Alnum'),
            'decorators' => array(
                'ViewHelper'
            ),
        ));
           $this->addElement('text','direccion',array(
            'decorators' => array(
                'ViewHelper'
            ),   
        ));
            $this->addElement('text','telefono',array(
            'label'=>'Telefono:',
             'Attribs'=>(array(
                        'pattern'=>"[0-9]{1,15}",
                 )),   
                
            'filters'=>array('Alnum'),
            'decorators' => array(
                'ViewHelper'
            ),    
        ));
             $this->addElement('text', 'correo_e', array(
            'required'   => true,
             'placeholder'=>"usuario@hotmail.com",     
            'Attribs'=>(array(
                        'required' => 'true',
                       'pattern'=>"[a-zA-Z0-9.+_-ñáéíóúÑÁÉÍÓÚ]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9.-]+",)),
            'filters'    => array('StringTrim'),
            'validators' => array(
            'EmailAddress',
            ),
            'decorators' => array(
                'ViewHelper'
            ),    
        ));
        $this->addElement('text', 'contrasena', array(
           
            'Attribs'=>(array( )),
            'decorators' => array(
                'ViewHelper'
            ),
         ));
        
         $this->addElement('submit', 'submit', array(
            'class'=>'btn btn-success',
            'decorators' => array(
                'ViewHelper'
            ),
            'label' => 'Registrar'
        ));
        
    }


}
