<?php 

include_once dirname(__FILE__).'/../../classes/Survey.php';

class SurveysController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true; //Gestion de l'affichage en mode bootstrap
        $this->table = Survey::$definition['table']; //Table de l'objet
        $this->identifier = Survey::$definition['primary']; //Clé primaire de l'objet
        $this->className = Survey::class; //Classe de l'objet
        $this->lang = false; //Flag pour dire si utilisation de langues ou non
            
        $this->_join .= ' LEFT JOIN `'._DB_PREFIX_.'customer` c ON (
            a.`id_customer` = c.`id_customer`) ';
        $this->_join .= ' LEFT JOIN `'._DB_PREFIX_.'customer` d ON (
            a.`id_comercial` = d.`id_customer`) ';
        $this->_select .= 'c.firstname as name, d.firstname as comercial';

       
        //Appel de la fonction parente pour pouvoir utiliser la traduction ensuite

        //Liste des champs de l'objet à afficher dans la liste
        $this->fields_list = [
            'id_survey' => [ //nom du champ sql
                'title' => 'ID',
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ],
            'name' => [ //nom du champ sql
                'title' => 'Cliente',
                'align' => 'center',
                'class' => 'fixed-width-lg'
            ],
            'comercial' => [ //nom du champ sql
                'title' => 'Comercial',
                'align' => 'center',
                'class' => 'fixed-width-lg'
            ],
            'review' => [ //nom du champ sql
                'title' => 'Review',
                'align' => 'center',
                'class' => 'fixed-width-md'
            ],
            'date_add' => [ //nom du champ sql
                'title' => 'Fecha',
                'align' => 'center',
                'class' => 'fixed-width-lg'
            ],
        ];


        //Ajout d'action sur chaque ligne
        $this->addRowAction('view');

        parent::__construct();

    }

     /**
     * Affichage du formulaire d'ajout / création de l'objet
     * @return string
     * @throws SmartyException
     */
    public function renderForm()
    {
        // //Définition du formulaire d'édition
        // $this->fields_form = [
        //     //Entête
        //     'legend' => [
        //         'title' => $this->module->l('Edit Sample'),
        //         'icon' => 'icon-cog'
        //     ],
        //     //Champs
        //     'input' => [
        //         [
        //             'type' => 'text', //Type de champ
        //             'label' => $this->module->l('name'), //Label
        //             'name' => 'name', //Nom
        //             'class' => 'input fixed-width-sm', //classes css
        //             'size' => 50, //longueur maximale du champ
        //             'required' => true, //Requis ou non
        //             'empty_message' => $this->l('Please fill the postcode'), //Message d'erreur si vide
        //             'hint' => $this->module->l('Enter sample name') //Indication complémentaires de saisie
        //         ],
        //         [
        //             'type' => 'text',
        //             'label' => $this->module->l('code'),
        //             'name' => 'code',
        //             'class' => 'input fixed-width-sm',
        //             'size' => 5,
        //             'required' => true,
        //             'empty_message' => $this->module->l('Please fill the code'),
        //         ],
        //         [
        //             'type' => 'text',
        //             'label' => $this->module->l('email'),
        //             'name' => 'email',
        //             'class' => 'input fixed-width-sm',
        //             'size' => 5,
        //             'required' => true,
        //             'empty_message' => $this->module->l('Please fill email'),
        //         ],
        //         [
        //             'type' => 'text',
        //             'label' => $this->module->l('Title'),
        //             'name' => 'title',
        //             'class' => 'input fixed-width-sm',
        //             'lang' => true, //Flag pour utilisation des langues
        //             'required' => true,
        //             'empty_message' => $this->l('Please fill the title'),
        //         ],
        //         [
        //             'type' => 'textarea',
        //             'label' => $this->module->l('Description'),
        //             'name' => 'description',
        //             'lang' => true,
        //             'autoload_rte' => true, //Flag pour éditeur Wysiwyg
        //         ],
        //     ],
        //     //Boutton de soumission
        //     'submit' => [
        //         'title' => $this->l('Save'), //On garde volontairement la traduction de l'admin par défaut
        //     ]
        // ];
        return parent::renderForm();
    }

}
