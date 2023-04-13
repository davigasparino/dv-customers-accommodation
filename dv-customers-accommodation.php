<?php
/**
 * Plugin Name: Dv Customers Accommodation
 * Plugin URI: https://davigasparino.com.br/plugins/customers-accommodation
 * Author: Davi Gasparino/
 * Author URI: https://davigasparino.com.br
 * Description: Customers Accommodation
 * Version: 1.0
 */

define('CustomerURL', plugin_dir_url(__FILE__));
define('CustomerPATH', plugin_dir_path(__FILE__));

require CustomerPATH . '/inc/Autoload.php';
$autoload = new Autoload();

$users_theme = new CustomerCPT();
$users_theme->init();
//teste