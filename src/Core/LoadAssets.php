<?php

namespace DG2_Phone_Button\Core;

class LoadAssets
{

    // class instance
    private static $instance = null;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_script']);
        add_action('plugins_loaded', [$this, 'language_plugins_loaded'], 0);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_color_picker']);
    }

    function language_plugins_loaded()
    {
        load_plugin_textdomain('dg2-phone-button', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    function enqueue_script()
    {
        wp_register_style('dg2pb_style', DG2_PHONE_BUTTON_ASSETS . 'styles.css', [], DG2_PHONE_BUTTON_VERSION, 'all');
        wp_register_script('dg2pb_script', DG2_PHONE_BUTTON_ASSETS . 'scripts.js', ['jquery'], DG2_PHONE_BUTTON_VERSION, true);
        wp_enqueue_style('dg2pb_style');
        wp_enqueue_script('dg2pb_script');
    }


    function enqueue_color_picker()
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('dg2-color-picker', DG2_PHONE_BUTTON_ASSETS . 'admin-scripts.js', array('wp-color-picker'), false, true);
        wp_enqueue_style('dg2pb_admin_style', DG2_PHONE_BUTTON_ASSETS . 'admin-styles.css', [], DG2_PHONE_BUTTON_VERSION, 'all');
    }


    /**
     * Instance
     * @access public
     * @return object $instance of the class
     */
    static public function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
