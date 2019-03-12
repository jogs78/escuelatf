<?php

class Admin_Form_Altalista extends Zend_Form
{
    public function init()
    {
               $this->setDecorators(array(
             array('viewScript',array(
                    'viewScript' => '/decorador/_baja.phtml',          
            ))));
       $this->addElement('text','baja',array(
           'placeholder'=>"Numero de Control",
            'required' => true,
            'validators' => array('digits'),
           'class'=>"span2 search-query",
           'Attribs'=>(array(
                        'required' => 'true',
                        'pattern'=>"[0-9]{9,9}")),
           'decorators' => array(
                'ViewHelper',
            ),
   ));
        
        

    }

   
}

