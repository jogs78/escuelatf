<?php

class Default_Form_recuperar extends Zend_Form
{
    function init() 
    {
        
     $email = new Zend_Form_Element_Text("email");
     $email->setLabel("Escribe tu dirección de correo o email")
      ->setRequired();
//->setDecorators(array("composite"));
     $this->addElement($email);
// Configuración de recaptcha
//$keys = Zend_Registry::get('recaptcha');  
    $recaptcha = new Zend_Service_ReCaptcha('6Lf8BuESAAAAAFrBQjQs5fKDYte23tOsHntYcUpD','6Lf8BuESAAAAAM0oplpjHIa4Daig56E-tMskCR_M');
    $recaptcha->setOption('theme', 'white')
     ->setOption('lang', 'es')
    ->setOption('ignore', 'false');
    $captcha = new Zend_Form_Element_Captcha("captcha",
    array(
            'captcha' => 'ReCaptcha',
            'captchaOptions' => array(
            'captcha' => 'ReCaptcha',
            'service' => $recaptcha,
            'ignore' => false
             )
          )
    );
    $captcha->setLabel('Por favor prueba que eres humano')
    ->setRequired();

        $this->addElement($captcha);
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Recuperar")
        ->setAttrib("class", "btn btn-primary");
//->setDecorators(array("actions"));
        $this->addElement($submit);   
    
    }
}
