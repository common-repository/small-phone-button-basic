<?php

/**
 * Plugin Name: Click to Call Button
 * Plugin URI: https://digital2.rs
 * Description: Small floating click to call phone button for your website
 * Version: 1.1.3
 * Author: Digital2Web
 * Text Domain: dg2-phone-button
 */

if (!defined('ABSPATH')) exit();

require plugin_dir_path(__FILE__) . 'vendor/autoload.php';

define('DG2_PHONE_BUTTON_ASSETS', plugins_url('assets/', __FILE__));
define('DG2_PHONE_BUTTON_VERSION', '1.1.3');
define('DG2_PHONE_BUTTON_PHONE_IMAGE', plugins_url('assets/', __FILE__) . 'img/phone_dark_style1.svg');

use DG2_Phone_Button\Core\MainLoader;

MainLoader::getInstance();
