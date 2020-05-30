<?php

class Employee extends EmployeeCore {
       
        public $code_employee;
    
        public function __construct($id = null, $idLang = null, $idShop = null){
    
        self::$definition['fields']['code_employee'] =  array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 200);     
        parent::__construct($id, null, $idShop);
            
      }
}


