<?php

class Zend_View_Helper_flassMessage{

    protected function _flashMessage($message){
        
        $flashMessenger = $this->_helper->FlashMessenger;
        $flashMessenger->setNamespace('actionErrors');
        $flashMessenger->addMessage($message);
    }
}