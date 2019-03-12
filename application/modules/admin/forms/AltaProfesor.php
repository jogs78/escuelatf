<?php

class Admin_Form_AltaProfesor extends Zend_Form
{
    

    public function init()
    {
       $this->setDisableLoadDefaultDecorators(true);

       $this->setDecorators(array(
             array('viewScript',array(
                    'viewScript' => '/decorador/_altaprofesor.phtml',          
            ))));
   
       $this->addElement('text','cedula',array(
        'required'=>TRUE,
        'Attribs'=>(array(
            'required' => 'true',
            
                 )),
        'decorators' => array(
                'ViewHelper'
            ),
           
       ));
       $this->addElement('text','nombre',array(
        'required'=>TRUE,
        'Attribs'=>(array(
            'required' => 'true',
            'pattern'=>"[A-Za-z ñáéíóúÑÁÉÍÓÚ]{1,20}",
                 )),
        'decorators' => array(
                'ViewHelper'
            ),
           
       ));
       $this->addElement('text','direccion',array(
           'Attribs'=>(array(
                 )),
        'decorators' => array(
                'ViewHelper'
            ),
           
       ));
       $this->addElement('text','correo_e',array(
           
        'required'=>TRUE,
           'placeholder'=>"usuario@hotmail.com",
           'Attribs'=>(array(
                        'required' => 'true',
                       'pattern'=>"[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9.-]+",)),
        'decorators' => array(
                'ViewHelper'
            ),
           
       ));
        $this->addElement('text','telefono',array(

             'Attribs'=>(array(
                        'pattern'=>"[0-9]{1,15}",
                 )),
        'decorators' => array(
                'ViewHelper'
            ),
           
       ));
         $this->addElement('text','fecha_clases',array(
            'filters'=>array('Alnum'),
            'decorators' => array(
                'ViewHelper'
            ),
        ));
         $this->addElement('text','especialidad',array(
             'Attribs'=>(array(
                'pattern'=>"[A-Za-z ñáéíóúÑÁÉÍÓÚ]{1,20}",
                 )),
        'decorators' => array(
                'ViewHelper'
            ),
           
       ));
         
         $this->addElement('text','contrasena',array(
        
             'Attribs'=>(array(
                
                 )),
             'decorators' => array(
                'ViewHelper'
            ),
           
       ));
         
         $this->addElement('submit', 'submit', array(
            'class'=>'btn btn-success',
             //'onclick'=>"alta()",
            'decorators' => array(
                'ViewHelper'
            ),
            'label' => 'Registrar'
        ));

    }


}

