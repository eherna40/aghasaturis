<?php
/**
 * Class Vinculations.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}


class GalleryImage extends ObjectModel
{

    public $id_image;
    public $name;
    public $image_link;
    public $active;
    public $id_employee;
    public $date_add;
    public $date_upd;

    public static $definition = array(
        'table' => 'aghasa_gallery',
        'primary' => 'id_image',
        'multilang' => false,
        'fields' => array(
            'id_gallery' => array('type' => self::TYPE_INT, 'required' => true),
            'image_link' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 255),
            'name' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 255),
            'id_employee' => array('type' => self::TYPE_INT, 'required' => true),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
        ),
    );



    const ORIGINAL = _PS_MODULE_DIR_ . 'gallery/img/c/';

    public function __construct($id_image = null)
    {
        parent::__construct($id_image);

    }

    public function add($autodate = true, $null_values = false)
    {
        if (!parent::add($autodate, $null_values)) {
            return false;
        }

        return $this;
    }

    public function getImages($id_gallery){


        $sql = 'SELECT a.id_image, a.name, e.firstname, a.date_add, a.image_link
        FROM '._DB_PREFIX_.'aghasa_gallery a 
        LEFT JOIN ps_employee e ON (a.id_employee = e.id_employee) 
        WHERE a.id_gallery = '. $id_gallery . ' ORDER BY a.id_image DESC';

        return Db::getInstance()->executeS($sql);
    }
}