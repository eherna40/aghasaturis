<?php
/**
 * Class Vinculations.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}


class Visit extends ObjectModel
{
    public $id_visit;
    public $id_comercial;
    public $id_customer;
    public $id_survey;
    public $duration;
    public $finish;
    public $date_add;
    public $date_upd;

    public static $definition = array(
        'table' => 'visit',
        'primary' => 'id_visit',
        'multilang' => false,
        'fields' => array(
            'id_customer' => array('type' => self::TYPE_INT, 'required' => true),
            'id_employee' => array('type' => self::TYPE_INT, 'required' => true),
            'id_survey' => array('type' => self::TYPE_STRING, 'required' => false),
            'duration' => array('type' => self::TYPE_STRING, 'required' => false),
            'finish' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
        ),
    );
    public function __construct($id = null )
    {
        parent::__construct($id);

    }

    public function add($autodate = true, $null_values = false)
    {
        if (!parent::add($autodate, $null_values)) {
            return false;
        }

        return $this->id;
    }

    public function getVisits($id_customer)
    {
        $sql = 'SELECT v.id_employee, v.date_add, v.id_survey, v.duration, e.firstname, e.lastname  
        FROM '._DB_PREFIX_.'visit v
        LEFT JOIN ps_employee e ON (v.id_employee = e.id_employee)
        WHERE id_customer = '. $id_customer;

        return Db::getInstance()->executeS($sql);
    }

    public function update($nullValues = false)
    {
        return parent::update($nullValues);
    }

}