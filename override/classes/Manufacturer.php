<?php

class Manufacturer extends ManufacturerCore {

  public $code_fam;

  public function __construct($id = null, $idLang = null){

    self::$definition['fields']['code_fam'] =  array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255);
    
    parent::__construct($id, $idLang);
  }
}
