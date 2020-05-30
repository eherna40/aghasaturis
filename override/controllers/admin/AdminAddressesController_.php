<?php
class AdminAddressesController extends AdminAddressesControllerCore
{
    public function __construct()
     {
        parent::__construct();
        // $this->fields_list['latitude'] = array('title' => $this->l('latitude'));
        // $this->fields_list['longitude'] = array('title' => $this->l('longitude'));

    }

    public function renderForm()
    {

        $this->fields_form_override = array(
            array(
                'type' => 'text',
                'label' => 'Latitude',
                'name' => 'latitude',
                'required' => false,
                'size' => 255
            ),
            array(
                'type' => 'text',
                'label' =>'Longitude',
                'name' => 'longitude',
                'required' => false,
                'size' => 32
            )
        );

        return parent::renderForm();    
    }
}