<?php
/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once dirname(__FILE__).'/classes/Vinculation.php';
include_once dirname(__FILE__).'/classes/Survey.php';
include_once dirname(__FILE__).'/classes/Visit.php';
include_once dirname(__FILE__).'/classes/Gallery.php';
include_once dirname(__FILE__).'/classes/GalleryImage.php';

include_once dirname(__FILE__).'/controllers/admin/Surveys.php';
include_once dirname(__FILE__).'/controllers/admin/Visit.php';
include_once dirname(__FILE__).'/controllers/admin/AdminDownload.php';

use Symfony\Component\Form\AbstractType;
class Aghasaturis extends Module
{
    protected $config_form = false;

    public $tabs = array(
        array(
            'name' => 'Encuestas', // One name for all langs
            'class_name' => 'Surveys',
            'visible' => true,
            'parent_class_name' => 'AdminParentCustomer',
        ),
        array(
        'name' => 'Visitas', // One name for all langs
        'class_name' => 'Visit',
        'visible' => true,
        'parent_class_name' => 'AdminParentCustomer',
        )
);

    public function __construct()
    {
        $this->name = 'aghasaturis';
        $this->tab = 'administration';
        $this->version = '1.0.1';
        $this->author = 'LabelGrup Networks';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('aghasaturis');
        $this->description = $this->l('Características aghasaturis');

        $this->confirmUninstall = $this->l('');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);


    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        include_once dirname(__FILE__).'/sql/install.php';

        return parent::install() &&
            $this->installTab() &&
            $this->registerHook('header') &&
            $this->registerHook('actionCustomerFormBuilderModifier') &&
            $this->registerHook('actionEmployeeFormBuilderModifier') &&

            $this->registerHook('actionAdminAddressesFormModifier') &&
            $this->registerHook('actionAdminAddressesFormModifier') &&

            $this->registerHook('actionAfterUpdateCustomerFormHandler') &&
            $this->registerHook('actionAfterUpdateEmployeeFormHandler') &&

            $this->registerHook('actionAfterCreateEmployeeFormHandler') &&
            $this->registerHook('actionAfterCreateCustomerFormHandler') &&

            $this->registerHook('displayAdminCustomers') &&
            $this->registerHook('actionAdminControllerSetMedia');
    }


        public function uninstall()
    {
        $this->uninstallTab();
        return parent::uninstall();


    }


    private function installTab()
    {
        $tabId = (int) Tab::getIdFromClassName('Surveys');
        if (!$tabId) {
            $tabId = null;
        }

        $tab = new Tab($tabId);
        $tab->active = 1;
        $tab->class_name = 'Surveys';
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = 'Encuestas';
        }
        $tab->id_parent = (int) Tab::getIdFromClassName('AdminParentCustomer');
        $tab->module = $this->name;

        $tab->save();

        $tabId = (int) Tab::getIdFromClassName('Visit');
        if (!$tabId) {
            $tabId = null;
        }

        $tab = new Tab($tabId);
        $tab->active = 1;
        $tab->class_name = 'Visit';
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = 'Visitas';
        }
        $tab->id_parent = (int) Tab::getIdFromClassName('AdminParentCustomer');
        $tab->module = $this->name;

        return $tab->save();
    }

    private function uninstallTab()
    {
        $tabId = (int) Tab::getIdFromClassName('Surveys');
        if (!$tabId) {
            return true;
        }

        $tab = new Tab($tabId);

        $tab->delete();

        $tabId = (int) Tab::getIdFromClassName('Visit');
        if (!$tabId) {
            return true;
        }

        $tab = new Tab($tabId);

        return $tab->delete();
    }


    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookActionAdminControllerSetMedia()
    {
        $this->context->controller->addJS($this->_path.'/views/js/back.js');
        $this->context->controller->addCSS($this->_path.'/views/css/back.css');
    }


    public function renderImages($id_customer)
    {
        $gallery = Gallery::getGallery($id_customer);

        if(count($gallery)){
                foreach ($gallery as $key => $images) {
                    $html = $html . '<div class="col-6 position-relative">
                        <img class="img-fluid image-reponsive" src="'.$images['image_link'].'" />
                        <div class="position-absolute comercial-overlay">
                            <p class="mb-0">'.$images['firstname'].'</p>
                            <p class="mb-0">'.date('d-m-y', strtotime($images['date_add'])).'</p>
                        </div>
                    </div>';
            }
                    
                
        }else{
            $html = '<p class="text-muted text-center mb-0">No se ha subido imagenes para este cliente</p>';
        }
        $content = '
        <div class="col-6">
            <div class="card">
                <h3 class="card-header">
                    <i class="material-icons">camera_alt                    </i>
                    Galeria de imagenes
                    <span class="badge badge-primary rounded">'.count($gallery).'</span>
                </h3>
                <div class="card-body d-flex flex-wrap">'.$html.'</div>
            </div>
        </div>';


        return $content;    
        }


        public function renderEmployees($id_customer)
        {

            $customer = new Customer($id_customer);

            $codes = [$customer->code_employee1,$customer->code_employee2,$customer->code_employee3 ];
            $employees = [];
            $codes = array_unique($codes); 
            foreach ($codes as $key => $code) {

                if($code != '' || $code != null){

                    $sql = 'SELECT code_employee, firstname 
                    FROM '._DB_PREFIX_.'employee 
                    WHERE code_employee = '.$code; 

                    if($employee = Db::getInstance()->getRow($sql)){
                        $employees[] = $employee;
                    }

                }
            }
    
            if(count($employees)){
                $html = '
                    <table class="table">
                        <thead>
                            <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>';
                    foreach ($employees as $key => $employee){
                        $html = $html . '<tr>
                        <td>'.$employee['code_employee'].'</td>
                        <td>'.$employee['firstname'].'</td>
                        </tr>';
                    }

                    $html = $html . '</tbody></table>';
                }else{
                $html = '<p class="text-muted text-center mb-0">No se han asociado comerciales para este cliente</p>';
            } 
                    
  
            $content = '
            <div class="col-6">
                <div class="card">
                    <h3 class="card-header">
                        <i class="material-icons">how_to_reg</i>
                        Comerciales asociados
                        <span class="badge badge-primary rounded">'.count($employees).'</span>
                    </h3>
                    <div class="card-body d-flex flex-wrap">'.$html.'</div>
                </div>
            </div>';
    
    
            return $content;    
            }

    

    public function hookDisplayAdminCustomers($params)
    {

        $id_customer = $params['id_customer'];
        $gallery = $this->renderImages($id_customer);

        $employyes = $this->renderEmployees($id_customer);
        return $gallery . $employyes;
    //     $visits = Visit::getVisitsForCustomer($id_comercial);
    //     if($id_group == 3){
    //         $html2 = '';
    //         if(count($visits)){
    //             $html2 = '<table class="table">
    //             <thead>
    //                 <tr>
    //                 <th>Comercial</th>
    //                 <th>Fecha</th>
    //                 <th>Finalizado</th>
    //                 </tr>
    //             </thead>
    //             <tbody>';

    //                 foreach ($visits as $key => $visit){
    //                     $html2 = $html2 . '<tr>
    //                     <td>'.$visit['comercial'].'</td>
    //                     <td>'.$visit['date_add'].'</td>
    //                     <td>'.$visit['finish'].'</td>
    //                     </tr>';
    //             }

    //             $html2 = $html2. '</tbody>
    //             </table>';
    //         }


    //         $customers = Vinculation::getCustomers($id_comercial);
    //         // $comercials = Vinculation::getComercials($id_comercial);
    //         if(count($customers)){
    //             $html = '<table class="table">
    //             <thead>
    //                 <tr>
    //                 <th>Nombre</th>
    //                 <th>Apellido</th>
    //                 <th>Empresa</th>
    //                 </tr>
    //             </thead>
    //             <tbody>';

    //                 foreach ($customers as $key => $customer){
    //                     $html = $html . '<tr>
    //                     <td>'.$customer->firstname.'</td>
    //                     <td>'.$customer->lastname.'</td>
    //                     <td>'.$customer->company.'</td>
    //                     </tr>';
    //             }

    //             $html = $html. '</tbody>
    //             </table>';
    //         }else{
    //             $html = '<p class="text-muted text-center mb-0">
    //             Ningun comercial vinculado a este este cliente
    //           </p>';
    //         }
    //         $link = new Link();
    //         $enlace = $link->getAdminLink('Survey', true);
    //     return '<div class="col-6"><div class="card">
    //     <h3 class="card-header">
    //       <i class="material-icons">chrome_reader_mode</i>
    //       Visitas  <span class="badge badge-primary rounded">2</span>
    //       <a href='.$enlace.'
    //          class="tooltip-link float-right"
    //          data-toggle="pstooltip"
    //          title=""
    //          data-placement="top"
    //          data-original-title=""
    //       >
    //         <i class="material-icons">visibility</i>
    //       </a>
    //     </h3>
    //     <div class="card-body">
    //         '.$html2.'
    //     </div>
    //   </div>
    //   </div>
      
    //   <div class="col-6"><div class="card">
    //     <h3 class="card-header">
    //       <i class="material-icons">how_to_reg</i>
    //       Vinculados
    //       <span class="badge badge-primary rounded">'.count($customers).'</span>
    //       <a href='.$enlace.'
    //          class="tooltip-link float-right"
    //          data-toggle="pstooltip"
    //          title=""
    //          data-placement="top"
    //          data-original-title=""
    //       >
    //         <i class="material-icons">visibility</i>
    //       </a>
    //     </h3>
    //     <div class="card-body">'.$html.'
    //     </div>
    //   </div></div>';

    //     }
    }


    public function hookActionEmployeeFormBuilderModifier($params) {
        
        /** @var \Symfony\Component\Form\FormBuilder $formBuilder */
        $formBuilder = $params['form_builder'];
        $this->id_ = $params['id'];


        $formBuilder->add('code_employee',
                \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                [
                    'label' => $this->l('Codigo vendedor AT'),
                    'required' => false, //Requis ou non
                ]
            );

            if($id = $params['id'])
            {
                $employee = new Employee($id);
                $params['data']['code_employee'] = $employee->code_employee;
            }

            $formBuilder->setData($params['data']);



    }
    public function hookActionAfterUpdateEmployeeFormHandler($params) {

        $employee = new Employee($params['id']);
        $employee->code_employee = $params['form_data']['code_employee'];

        $employee->update();
    }
    public function hookActionAfterCreateEmployeeFormHandler($params) {

        $employee = new Employee($params['id']);
        $employee->code_employee = $params['form_data']['code_employee'];

        $employee->update();
    }

    public function hookActionCustomerFormBuilderModifier($params) {
        
        /** @var \Symfony\Component\Form\FormBuilder $formBuilder */
        $formBuilder = $params['form_builder'];
        $this->id_ = $params['id'];


        $formBuilder->add('code',
            \Symfony\Component\Form\Extension\Core\Type\TextType::class,
            [
                'label' => $this->l('Code'),
                'required' => true, //Requis ou non,   
            ]
        );

        $formBuilder->add('company',
            \Symfony\Component\Form\Extension\Core\Type\TextType::class,
            [
                'label' => $this->l('Empresa'),
                'required' => true, //Requis ou non
            ]
        );

        $formBuilder->add('siret',
            \Symfony\Component\Form\Extension\Core\Type\TextType::class,
            [
                'label' => $this->l('CIF/NIF'),
                'required' => true, //Requis ou non
            ]
        );

        $formBuilder->add('phone',
        \Symfony\Component\Form\Extension\Core\Type\TextType::class,
        [
            'label' => $this->l('Telefono'),
            'required' => true, //Requis ou non
        ]
    );

            $formBuilder->add('address',
            \Symfony\Component\Form\Extension\Core\Type\TextType::class,
            [
                'label' => $this->l('Direción'),
                'required' => true, //Requis ou non
            ]
        );

        $formBuilder->add('postcode',
            \Symfony\Component\Form\Extension\Core\Type\TextType::class,
            [
                'label' => $this->l('Codigo postal'),
                'required' => true, //Requis ou non
            ]
        );

                $formBuilder->add('city',
            \Symfony\Component\Form\Extension\Core\Type\TextType::class,
            [
                'label' => $this->l('Población'),
                'required' => true, //Requis ou non
            ]
        );

        $states = State::getStatesByIdCountry(6);

        $states_choice = [];
        foreach ($states as $key => $state) {
            $s = [
                $state['name'] => $state['id_state']
            ];
            $states_choice = $states_choice + $s;
        }

        $formBuilder->add('id_state',
            \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class,
            [
                'choices' => $states_choice,
                'label' => $this->l('Provincia'),
                'required' => false, //Requis ou non
            ]
        );

        $formBuilder->add('id_country',
            \PrestaShopBundle\Form\Admin\Type\CountryChoiceType::class, 
        [
            'required' => true,
            'label' => 'País'
        ]);

                $formBuilder->add('metros_lineales',
            \Symfony\Component\Form\Extension\Core\Type\TextType::class,
            [
                'label' => $this->l('Nº de Metros lineales AT'),
                'required' => false, //Requis ou non
            ]
        );
        $formBuilder->add('n_locals',
            \Symfony\Component\Form\Extension\Core\Type\TextType::class,
            [
                'label' => $this->l('Nº Locales'),
                'required' => false, //Requis ou non
            ]
        );

            $formBuilder->add('latitude',
            \Symfony\Component\Form\Extension\Core\Type\TextType::class,
            [
                'label' => $this->l('Latitud'),
                'required' => false, //Requis ou non
            ]
        );
        $formBuilder->add('longitude',
            \Symfony\Component\Form\Extension\Core\Type\TextType::class,
            [
                'label' => $this->l('Longitud'),
                'required' => false, //Requis ou non
            ]
        );


        $formBuilder->add('prov_password',
            \Symfony\Component\Form\Extension\Core\Type\HiddenType::class,
            [
                'data' => $params['id'],
            ]
        );

        $employees = Employee::getEmployees();

        $choices = [];

        foreach ($employees as $key => $employee) {
            $e = new Employee($employee['id_employee']);
            $c = [
                $e->code_employee.' '.$e->firstname => $e->id
            ];
            $choices = $choices + $c;
        }

        $formBuilder->add('code_employee1',
            \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class,
            [
                'choices' => $choices,
                'label' => $this->l('Codigo empleado 1'),
                'required' => false, //Requis ou non
            ]
        );

        $formBuilder->add('code_employee2',
            \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class,
            [
                'choices' => $choices,
                'label' => $this->l('Codigo empleado 2'),
                'required' => false, //Requis ou non
            ]
        );

        $formBuilder->add('code_employee3',
            \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class,
            [
                'choices' => $choices,
                'label' => $this->l('Codigo empleado 3'),
                'required' => false, //Requis ou non
            ]
        );



        $formBuilder->setData($params['data']);


        if($customer = new Customer($params['id'])){

            if($id_address= Address::getFirstCustomerAddressId($params['id']))
            {
                try {

                    $address = new Address($id_address);
                    $params['data']['address'] = $address->address1;
                    $params['data']['postcode'] = $address->postcode;
                    $params['data']['latitude'] = $address->latitude;
                    $params['data']['longitude'] = $address->longitude;
                    $params['data']['city'] = $address->city;
                    $params['data']['id_country'] = $address->id_country;
                    $params['data']['id_state'] = $address->id_state;
                    $params['data']['phone'] = $address->phone;
                } catch (\Throwable $th) {
                    dump($th);
                    die();
                }


            }

            $params['data']['code'] = $customer->code;
            $params['data']['siret'] = $customer->siret;
            $params['data']['company'] = $customer->company;
            $params['data']['code_employee1'] = $customer->code_employee1;
            $params['data']['code_employee2'] = $customer->code_employee2;
            $params['data']['code_employee3'] = $customer->code_employee3;
            $params['data']['n_locals'] = $customer->n_locals;
            $params['data']['metros_lineales'] = $customer->metros_lineales;

            $formBuilder->setData($params['data']);
        }
        
    }

    public function hookActionAfterUpdateCustomerFormHandler(array $params)
    {
        $customer = new Customer($params['id']);
        $customer->code = $params['form_data']['code'];
        $customer->siret = $params['form_data']['siret'];
        $customer->company = $params['form_data']['company'];
        $customer->code_employee1 = $params['form_data']['code_employee1'];
        $customer->code_employee2 = $params['form_data']['code_employee2'];
        $customer->code_employee3 = $params['form_data']['code_employee3'];

        $customer->n_locals = $params['form_data']['n_locals'];
        $customer->metros_lineales = $params['form_data']['metros_lineales'];

        $customer->update();
    
        $id_address= Address::getFirstCustomerAddressId($params['id']);
        $address = new Address($id_address);
        $address->id_state = $params['form_data']['id_state'];
        $address->id_country = $params['form_data']['id_country'];
        $address->alias = $customer->firstname .' '. $customer->lastname;
        $address->lastname = $customer->lastname;
        $address->firstname = $customer->firstname;
        $address->city = $params['form_data']['city'];
        $address->latitude = $params['form_data']['latitude'];
        $address->longitude =$params['form_data']['longitude'];
        $address->address1 = $params['form_data']['address'];
        $address->postcode = (int)$params['form_data']['postcode'];
        $address->company = $params['form_data']['company'];
        $address->dni = $params['form_data']['siret'];
        $address->phone = (int)$params['form_data']['phone'];
        $address->id_customer = $customer->id;

        $address->update();

    }
    public function hookActionAfterCreateCustomerFormHandler(array $params)
    {
        $customer = new Customer($params['id']);
        $customer->code = $params['form_data']['code'];
        $customer->siret = $params['form_data']['siret'];
        $customer->company = $params['form_data']['company'];
        $customer->code_employee1 = $params['form_data']['code_employee1'];
        $customer->code_employee2 = $params['form_data']['code_employee2'];
        $customer->code_employee3 = $params['form_data']['code_employee3'];

        $customer->n_locals = $params['form_data']['n_locals'];
        $customer->metros_lineales = $params['form_data']['metros_lineales'];

        $customer->update();
    
        $address = new Address();
        $address->id_state = $params['form_data']['id_state'];
        $address->id_country = $params['form_data']['id_country'];
        $address->alias = $customer->firstname .' '. $customer->lastname;
        $address->lastname = $customer->lastname;
        $address->firstname = $customer->firstname;
        $address->city = $params['form_data']['city'];
        $address->latitude = $params['form_data']['latitude'];
        $address->longitude =$params['form_data']['longitude'];
        $address->address1 = $params['form_data']['address'];
        $address->postcode = (int)$params['form_data']['postcode'];
        $address->company = $params['form_data']['company'];
        $address->dni = $params['form_data']['siret'];
        $address->phone = (int)$params['form_data']['phone'];
        $address->id_customer = $customer->id;
        
        $address->save();
    }

}
