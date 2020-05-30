<?php
/**
 * Class Vinculations.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}


class Gallery extends ObjectModel
{

    const ORIGINAL =  '/modules/aghasaturis/gallery/img/c/';


    public $id_customer;
    public $id_gallery;
    public $active;
    public $date_add;
    public $date_upd;

    public static $definition = array(
        'table' => 'customer_gallery',
        'primary' => 'id_gallery',
        'multilang' => false,
        'fields' => array(
            'id_customer' => array('type' => self::TYPE_INT, 'required' => true),
            'active' => array('type' => self::TYPE_INT, 'required' => true),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
        ),
    );




    public function __construct($id_gallery = null)
    {
        parent::__construct($id_gallery);

    }

    public function add($autodate = true, $null_values = false)
    {
        if (!parent::add($autodate, $null_values)) {
            return false;
        }

        return $this->id_gallery;
    }

    public function upload($gallery, $id_employee, $file = null, $name= null)
    {

        $data = $file;
        // list($type, $data) = explode(';', $data);
        // list(, $data)      = explode(',', $data);

    
        $data = base64_decode($data);
        // return $data;
        $name = $name .'_' .uniqid(). '_'. $gallery->id . '_'. $gallery->id_customer .'.png';
        $link = Gallery::ORIGINAL . $name;
  
        $image = new GalleryImage();
        $image->id_employee = $id_employee;
        $image->id_gallery = $gallery->id_gallery;
        $image->name = $name;
        $image->image_link = $link;
        $image->active = 1;
        file_put_contents('../../aghasaturis/gallery/img/c/'.$name, $data);
 

        // Db::getInstance()->insert('aghasa_gallery', array(
        //     'id_gallery' => (int)$this->$id_gallery,
        //     'id_employee' => (int)$id_employee,
        //     'name'      => $name,
        //     'image_link' => $link,
        //     'active' => 1,
        //     'date_add' => date(),
        //     'date_upd' => date()
        // ));


        return $image->add();



    }

    public function checkGallery($id_customer)
    {
        $sql = 'SELECT id_gallery FROM '._DB_PREFIX_.'customer_gallery 
        WHERE id_customer = '. $id_customer;
        return Db::getInstance()->getValue($sql);
    }

    public function getGallery($id_customer){

        $sql = 'SELECT id_gallery FROM '._DB_PREFIX_.'customer_gallery 
        WHERE id_customer = '. $id_customer;

        $gallery = Db::getInstance()->getValue($sql);
        if($gallery){
            if(count($gallery)){
                $images = GalleryImage::getImages($gallery);
                return $images;
            }
        }else{
            return [];
        }

    }

}