<?php

class Default_Bootstrap extends Zend_Application_Module_Bootstrap                              
{
        protected  function _initCaptcha(){
        /*
            $this->options = $this->getOptions();  
             Zend_Registry::set('config.recaptcha', $this->options['recaptcha']);  
    */
          } 
         
    protected function _initDatabaseProfiler(){
         
   
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        
            $db->setFetchMode(Zend_Db::FETCH_OBJ);  
            // Verificando si el ambiente está como desarrollo, de lo contrario
            // No se activa.
            if ('development' == $this->getEnvironment()) {
                $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
                $profiler->setEnabled(true);
                $db->setProfiler($profiler);
                }
       }

          
             public function _initLogger(){
                 
        if( APPLICATION_ENV == 'development' ) {
            $writer = new Zend_Log_Writer_Firebug();
            $log = new Zend_Log($writer);
            Zend_Registry::set('log', $log);
            }
        }
      
}
