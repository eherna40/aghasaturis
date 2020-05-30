<?php

class Customer extends CustomerCore {
       
        
        public $code;
        public $n_employees;
        public $metros_lineales;
        public $n_locals;
        // public $address;
        // public $postcode;
        // public $city;
        // public $id_country;
        // public $id_state;
        // public $latitude;
        // public $longitude;
        public $code_employee1;
        public $code_employee2;
        public $code_employee3;
    
        public function __construct($id = null){
    
          self::$definition['fields']['code'] =  array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 200);
          self::$definition['fields']['n_employees'] =  array('type' => self::TYPE_STRING, 'validate' => 'isGenericName','size' => 255);
          self::$definition['fields']['metros_lineales'] =  array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255);
          self::$definition['fields']['n_locals'] =  array('type' => self::TYPE_INT, 'validate' => 'isGenericName', 'size' => 255);
          // self::$definition['fields']['address'] =  array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255);
          // self::$definition['fields']['postcode'] =  array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255);
          self::$definition['fields']['code_employee1'] =  array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255);
          self::$definition['fields']['code_employee2'] =  array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255);
          self::$definition['fields']['code_employee3'] =  array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255);
          // self::$definition['fields']['city'] =  array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255);
          // self::$definition['fields']['id_country'] =  array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255);
          // self::$definition['fields']['id_state'] =  array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255);
          // self::$definition['fields']['latitude'] =  array('type' => self::TYPE_FLOAT, 'validate' => 'isCoordinate', 'size' => 13);
          // self::$definition['fields']['longitude'] =  array('type' => self::TYPE_FLOAT, 'validate' => 'isCoordinate', 'size' => 13);   

        parent::__construct($id);
            
      }
}


