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
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'vinculation` (
    `id_vinculation` int(11) NOT NULL AUTO_INCREMENT,
    `id_employee` int(11) NOT NULL,
    `id_customer` int(11) NOT NULL,
    `date_add` DATETIME,
    `date_upd` DATETIME,
    PRIMARY KEY  (`id_vinculation`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';


$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'customer_gallery` (
    `id_gallery` int(11) NOT NULL AUTO_INCREMENT,
    `id_customer` int(11) NOT NULL,
    `active` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\',
    `date_add` DATETIME,
    `date_upd` DATETIME,
    PRIMARY KEY  (`id_gallery`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';


$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'aghasa_gallery` (
    `id_image` int(11) NOT NULL AUTO_INCREMENT,
    `id_employee` int(11) NULL,
    `id_gallery` int(11) NULL,
    `name` VARCHAR(255) NULL,
    `active` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\',
    `date_add` DATETIME,
    `date_upd` DATETIME,
    PRIMARY KEY  (`id_image`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'survey` (
    `id_survey` int(11) NOT NULL AUTO_INCREMENT,
    `id_employee` int(11) NOT NULL,
    `id_customer` int(11) NOT NULL,
    `contac_name` VARCHAR(500),
    `review` int(11) NULL,
    `comments` VARCHAR(500) NULL,
    `date_add` DATETIME,
    `date_upd` DATETIME,
    PRIMARY KEY  (`id_survey`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'visit` (
    `id_visit` int(11) NOT NULL AUTO_INCREMENT,
    `id_employee` int(11) NOT NULL,
    `id_customer` int(11) NOT NULL,
    `id_survey` int(11),
    `duration` VARCHAR(100) NULL,
    `finish` DATETIME,
    `date_add` DATETIME,
    `date_upd` DATETIME,
    PRIMARY KEY  (`id_visit`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';


// $sql[] = 'ALTER TABLE `' . _DB_PREFIX_ . 'employee` 
// ADD cod_employee VARCHAR(100);';


// $sql[] = 'ALTER TABLE `' . _DB_PREFIX_ . 'manufacturer` 
// ADD `code_fam` VARCHAR(255) NULL;';


// $sql[] = 'ALTER TABLE `' . _DB_PREFIX_ . 'address` 
// ADD `latitude` DECIMAL(13,8) NULL DEFAULT NULL,
// ADD `longitude` DECIMAL(13,8) NULL DEFAULT NULL;';

// $sql[] = 'ALTER TABLE `' . _DB_PREFIX_ . 'customer` 
// ADD code VARCHAR(100),
// ADD n_employees VARCHAR(100),
// ADD n_locals VARCHAR(100),
// ADD metros_lineales VARCHAR(100),
// -- ADD address VARCHAR(100),
// -- ADD postcode VARCHAR(100),
// -- ADD city VARCHAR(100),
// -- ADD id_country VARCHAR(100),
// -- ADD id_state VARCHAR(100),
// -- ADD latitude VARCHAR(100),
// -- ADD longitude VARCHAR(100),
// ADD code_employee1 VARCHAR(100),
// ADD code_employee2 VARCHAR(100),
// ADD code_employee3 VARCHAR(100);';


foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
