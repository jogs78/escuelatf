<?php

require_once 'My/Layout.php';
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	protected function _initDataBase()
	{
		// Variable de ambiente
		$services_json = json_decode(getenv("VCAP_SERVICES"),true);
		
        $mysql_config = $services_json["mysql-5.1"][0]["credentials"];
		
		// Configuraci�n
        $config = new Zend_Config(
            array(
                'database' => array(
                    'adapter' => 'pdo_mysql',
                    'params'  => array(
                        'host'     => $mysql_config["hostname"],
                        'dbname'   => $mysql_config["name"],
                        'username' => $mysql_config["username"],
                        'password' => $mysql_config["password"],
                       // 'charset'  => 'utf8'
                    ),
                    'isDefaultTableAdapter' => true
                )
            )
        );
	
		if ( 'development' == $this->getEnvironment() ) {
			$config = new Zend_Config(
				array(
					'database' => array(
						'adapter' => 'pdo_mysql',
						'params'  => array(
							'host'     => 'localhost',
							'dbname'   => 'escuelatf',
							'username' => 'root',
							'password' => '',
							//'charset'  => 'utf8'
						),
						'isDefaultTableAdapter' => true
					)
				)
			);
		}
     //  */ 
		// Creaci�n de la conexi�n
        $db = Zend_Db::factory($config->database);
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
	 
		$db->setFetchMode(Zend_Db::FETCH_OBJ);  
	   
		if ('development' == $this->getEnvironment()) {
			$profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
			$profiler->setEnabled(true);
			$db->setProfiler($profiler);
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
	  protected function _initPlugins(){ 
       $this->bootstrap('frontController'); 
        $plugin = new My_Layout();
        $this->frontController->registerPlugin($plugin); 
    }
	
}

