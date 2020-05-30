<?php 

class AdminDownloadController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->bootstrap = true;
    }

    public function initContent()
	{
		$this->renderView();
	}

    public function renderView(){
        $this->context = Context::getContext();
        if (!($group = $this->loadObject(true))) {
            return;
        }
        $this->initPageHeaderToolbar();
        $this->tpl_view_vars = array('version' => array('php' => phpversion(), 'server' => $_SERVER['SERVER_SOFTWARE'], 'memory_limit' => ini_get('memory_limit'), 'max_execution_time' => ini_get('max_execution_time')), 'database' => array('version' => Db::getInstance()->getVersion(), 'prefix' => _DB_PREFIX_, 'engine' => _MYSQL_ENGINE_), 'uname' => function_exists('php_uname') ? php_uname('s') . ' ' . php_uname('v') . ' ' . php_uname('m') : '', 'apache_instaweb' => Tools::apacheModExists('mod_instaweb'), 'shop' => array('ps' => _PS_VERSION_, 'url' => Tools::getHttpHost(true) . __PS_BASE_URI__, 'theme' => _THEME_NAME_), 'mail' => Configuration::get('PS_MAIL_METHOD') == 1, 'smtp' => array('server' => Configuration::get('PS_MAIL_SERVER'), 'user' => Configuration::get('PS_MAIL_USER'), 'password' => Configuration::get('PS_MAIL_PASSWD'), 'encryption' => Configuration::get('PS_MAIL_SMTP_ENCRYPTION'), 'port' => Configuration::get('PS_MAIL_SMTP_PORT')), 'user_agent' => $_SERVER['HTTP_USER_AGENT']);

        return parent::renderView();

    }

}
