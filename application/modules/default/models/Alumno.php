
<?php

class Default_Model_Alumno extends Zend_Db_Table_Abstract
{
    protected $_name = 'alumno';
    protected $primary = 'numcontrol';

    public function buscarcorreo($correo)
    {
        $query=$this->select()->where("correo_e=?",$correo);
        $consulta=$this->fetchRow($query);
        return $consulta;
    }
    
    public function actualizarPassword($usuario,$newPass)
    {
        $password=sha1($newPass);
        $where=('numcontrol='."'$usuario'");
        $data=array("contrasena"=>$password);
        $this->update($data,$where);
    }
    

}

