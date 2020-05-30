<?php

class Address extends AddressCore {

  public $latitude;
  public $longitude;

  public function __construct($id_address = null, $id_lang = null){

    self::$definition['fields']['latitude'] =  array('type' => self::TYPE_FLOAT, 'validate' => 'isCoordinate', 'size' => 13);
    self::$definition['fields']['longitude'] =  array('type' => self::TYPE_FLOAT, 'validate' => 'isCoordinate', 'size' => 13);
    
    parent::__construct($id_address );
  }
}
