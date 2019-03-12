    <?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
                
     
    }

    public function loginadminAction(){
        
        if($this->getRequest()->isPost()){
            
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		
		//Zend_Registry::get('log')->debug($this->_getAllParams());
		
        if($this->getRequest()->isPost()){
           //if ($form->isValid($_POST)) 
        //{
            $adapter = new Zend_Auth_Adapter_DbTable(
					$db,
					'administrador',
					'numempleado',
					'contrasena'
                );
		
            $adapter->setIdentity($this->getRequest()->getPost('numempleado'));
            $adapter->setCredential(sha1($this->getRequest()->getPost('contrasena')));
 
            $auth   = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);
 
            if($result->isValid()){
                    $data = $adapter->getResultRowObject(null,'contrasena');
                    $auth->getStorage()->write($data);
                    $this->_redirect('/admin/index/index');
                   
                }
                else{ 
                    
                    echo "<script type=\"text/javascript\">alert(\"Usuario o contraseña invalidos\");</script>"; 
                }
        }
    }
	}

    public function loginprofAction(){
           if($this->getRequest()->isPost()){
            $adapter = new Zend_Auth_Adapter_DbTable(
            Zend_Db_Table_Abstract::getDefaultAdapter(),
                'profesor',
                'cedula',
                'contrasena'
                );
            $adapter->setIdentity($this->getRequest()->getPost('cedula'));
            $adapter->setCredential(sha1($this->getRequest()->getPost('contrasena')));
          
            
            $auth   = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);
           if($result->isValid()){
					
                    $data = $adapter->getResultRowObject(null,'contrasena');
                    $auth->getStorage()->write($data);
                    $this->_redirect('/prof/index/index');
                    
                }
                else{ 
				
		            echo "<script type=\"text/javascript\">alert(\"Usuario o contraseña invalidos\");</script>"; 
				}
		}
	}
    
    public function loginaluAction()
    {
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
		
		//Zend_Registry::get('log')->debug($this->_getAllParams());
		
        if($this->getRequest()->isPost()){
           //if ($form->isValid($_POST)) 
        //{
            $adapter = new Zend_Auth_Adapter_DbTable(
					$db,
					'alumno',
					'numcontrol',
					'contrasena'
                );
            $adapter->setIdentity($this->_getParam('numcontrol'));
            $adapter->setCredential(sha1($this->_getParam('contrasena')));
 
            $auth   = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);
 
            if ($result->isValid())
			{
				$data = $adapter->getResultRowObject(null,'contrasena');
				$auth->getStorage()->write($data);
				$this->_redirect('/alu/index/index');
				
				
			}
			else echo "<script type=\"text/javascript\">alert(\"Usuario o contraseña invalidos\");</script>"; 
        }       
       
    }
    
}
