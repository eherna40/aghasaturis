<?php
/**
 * Class Vinculations.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}


class Survey extends ObjectModel
{
    public $id_survey;
    public $id_comercial;
    public $id_customer;
    public $contact_name;
    public $review;
    public $comments;
    public $date_add;
    public $date_upd;

    public static $definition = array(
        'table' => 'survey',
        'primary' => 'id_survey',
        'multilang' => false,
        'fields' => array(
            'id_survey' => array('type' => self::TYPE_INT, 'validate' => 'isGenericName', 'required' => true),
            'id_customer' => array('type' => self::TYPE_INT, 'required' => true),
            'id_comercial' => array('type' => self::TYPE_INT, 'required' => true),
            'contact_name' => array('type' => self::TYPE_STRING, 'required' => false),
            'review' => array('type' => self::TYPE_INT, 'required' => true),
            'comments' => array('type' => self::TYPE_STRING, 'required' => false),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
        ),
    );

    

    public function getSurveys($id_comercial = null){

        $sql = 'SELECT * FROM '._DB_PREFIX_.'survey';
        if($id_comercial){
            $sql = $sql . ' WHERE id_customer'. $id_customer;
        }
        return Db::getInstance()->ExecuteS($sql);
    }

}