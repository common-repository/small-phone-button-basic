<?php

namespace DG2_Phone_Button\Core;

use DG2_Phone_Button\Core\LoadAssets;
use DG2_Phone_Button\Front\FrontView;
use DG2_Phone_Button\Settings\PageMetaFields;
use DG2_Phone_Button\Settings\SettingsPage;

class MainLoader
{
    private static $instance = null;

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $this->initPlugin();
    }

    public function initPlugin()
    {
        // init classes for plugin
        LoadAssets::getInstance();
        SettingsPage::getInstance();
        FrontView::getInstance();
    }

    public static function getInstance()
    {
        return (self::$instance == null)
            ? self::$instance = new self()
            : self::$instance;
    }
}
