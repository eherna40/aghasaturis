<?php
/**
 * Class vinculation.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}


class Vinculation extends ObjectModel
{
    public $id_vinculation;
    public $id_comercial;
    public $id_customer;

    public static $definition = array(
        'table' => 'vinculation',
        'primary' => 'id_vinculation',
        'fields' => array(
            'id_vinculation' => array('type' => self::TYPE_INT, 'validate' => 'isGenericName', 'required' => true),
            'id_customer' => array('type' => self::TYPE_INT, 'required' => true),
            'id_comercial' => array('type' => self::TYPE_INT, 'required' => true),
        ),
    );


    public function isVinculated($id_comercial, $id_customer)
    {
        
        $sql = 'SELECT id_vinculation FROM '._DB_PREFIX_.'vinculation WHERE id_comercial = '. (int) $id_comercial . ' AND id_customer = '.(int) $id_customer;
        return Db::getInstance()->getValue($sql);
    }

    public function isVinculatedForComercal($id_comercial)
    {
        
        // $sql = 'SELECT id_customer FROM '._DB_PREFIX_.'vinculation WHERE id_comercial = '. (int) $id_comercial;
        // return Db::getInstance()->executeS($sql);
    }

    public function getComercials($id_customer)
    {
        
        $sql = 'SELECT v.id_comecial, c.firstname FROM '._DB_PREFIX_.'vinculation 
        LEFT JOIN ps_customer c ON (c.id_customer = v.id_comercial)
        WHERE id_customer = '. (int) $id_customer;
        return Db::getInstance()->executeS($sql);
    }

    public function addMassive($id_comercial, $ids_customer)
    {
        foreach ($ids_customer as $key => $id_customer) {
            Db::getInstance()->insert('vinculation', array(
                'id_comercial' => (int)$id_comercial,
                'id_customer'      => (int)$id_customer,
            ));
        }

    }

    public function creaetVincule($id_comercial, $id_customer)
    {
            Db::getInstance()->insert('vinculation', array(
                'id_comercial' => (int)$id_comercial,
                'id_customer'      => (int)$id_customer,
            ));
    }

    public function resetCustomers($id_comercial)
    {
        Db::getInstance()->delete('vinculation', 'id_comercial = '.(int)$id_comercial);
    }

    public function getCustomers($id_employee)
    {
        $customers = [];
        $employee = new Employee($id_employee);
        $code_employee = $employee->code_employee;
        $sql = 'SELECT id_customer FROM '._DB_PREFIX_.'customer 
        WHERE code_employee1 = '.$code_employee . ' OR code_employee2 = '.$code_employee . ' OR code_employee3 = '.$code_employee . ' AND active = 1';
        if($c = Db::getInstance()->executeS($sql)){
            foreach ($c as $key => $cust) {
                $customer = new Customer($cust['id_customer']);
                $customers [] = $customer;
            } 
        }
        
        
        return $customers ;
    }

}