<?php

namespace DG2_Phone_Button\Settings;

class SettingsPage
{
    private $dg2_phone_call_button_options;
    // class instance
    private static $instance = null;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        add_action('admin_menu', array($this, 'plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

    public function plugin_page()
    {
        add_menu_page(
            __('Click to Call Button', 'dg2-phone-button'),
            __('Click to Call Button', 'dg2-phone-button'),
            'manage_options',
            'dg2-phone-call-button',
            array($this, 'create_admin_page'),
            'dashicons-phone',
            85
        );
    }

    public function create_admin_page()
    {
        $options = get_option('dg2_phone_call_button_option_name');
        if(!$options){
            add_option('dg2_phone_call_button_option_name');
        }
        $this->dg2_phone_call_button_options = get_option('dg2_phone_call_button_option_name');
?>

        <div class="wrap">
            <h2><?php echo __('Click to Call Button', 'dg2-phone-button'); ?></h2>
            <p></p>
            <?php settings_errors(); ?>

            <form method="post" action="options.php">
                <?php
                settings_fields('dg2_phone_call_button_option_group');
                do_settings_sections('dg2-phone-call-button-admin');
                submit_button();
                ?>
            </form>
        </div>
    <?php }

    public function page_init()
    {
        register_setting(
            'dg2_phone_call_button_option_group',
            'dg2_phone_call_button_option_name',
            array($this, 'dg2_phone_call_button_sanitize')
        );

        add_settings_section(
            'dg2_phone_call_button_setting_section',
            __('Settings', 'dg2-phone-button'),
            array($this, 'dg2_phone_call_button_section_info'),
            'dg2-phone-call-button-admin'
        );

        add_settings_field(
            'phone_0',
            __('Phone link', 'dg2-phone-button'),
            array($this, 'phone_0_callback'),
            'dg2-phone-call-button-admin',
            'dg2_phone_call_button_setting_section'
        );
        add_settings_field(
            'phone_1',
            __('Phone - visible', 'dg2-phone-button'),
            array($this, 'phone_1_callback'),
            'dg2-phone-call-button-admin',
            'dg2_phone_call_button_setting_section'
        );
        add_settings_field(
            'color_bg',
            __('Button background color', 'dg2-phone-button'),
            array($this, 'color_bg_callback'),
            'dg2-phone-call-button-admin',
            'dg2_phone_call_button_setting_section'
        );
        add_settings_field(
            'color_txt',
            __('Button text color', 'dg2-phone-button'),
            array($this, 'color_txt_callback'),
            'dg2-phone-call-button-admin',
            'dg2_phone_call_button_setting_section'
        );

        add_settings_field(
            'choose_icon_1',
            __('Choose icon  ', 'dg2-phone-button'),
            array($this, 'choose_icon_1_callback'),
            'dg2-phone-call-button-admin',
            'dg2_phone_call_button_setting_section'
        );

        add_settings_field(
            'button_type_2',
            __('Choose button type  ', 'dg2-phone-button'),
            array($this, 'button_type_2_callback'),
            'dg2-phone-call-button-admin',
            'dg2_phone_call_button_setting_section'
        );
        add_settings_field(
            'dugme_x',
            __('Setup X-position from right  ', 'dg2-phone-button'),
            array($this, 'dugme_x_callback'),
            'dg2-phone-call-button-admin',
            'dg2_phone_call_button_setting_section'
        );
        add_settings_field(
            'dugme_y',
            __('Setup Y-position from bottom  ', 'dg2-phone-button'),
            array($this, 'dugme_y_callback'),
            'dg2-phone-call-button-admin',
            'dg2_phone_call_button_setting_section'
        );
        add_settings_field(
            'dg2_btn_desktop',
            __('Show on desktop view', 'dg2-phone-button'),
            array($this, 'dg2_btn_desktop_callback'),
            'dg2-phone-call-button-admin',
            'dg2_phone_call_button_setting_section'
        );
    }

    public function dg2_phone_call_button_sanitize($input)
    {
        $sanitary_values = array();
        if (isset($input['phone_0'])) {
            $sanitary_values['phone_0'] = sanitize_text_field($input['phone_0']);
        }
        if (isset($input['phone_1'])) {
            $sanitary_values['phone_1'] = sanitize_text_field($input['phone_1']);
        }
        if (isset($input['color_bg'])) {
            $sanitary_values['color_bg'] = sanitize_text_field($input['color_bg']);
        }
        if (isset($input['color_txt'])) {
            $sanitary_values['color_txt'] = sanitize_text_field($input['color_txt']);
        }
        if (isset($input['dugme_x'])) {
            $sanitary_values['dugme_x'] = sanitize_text_field($input['dugme_x']);
        }
        if (isset($input['dugme_y'])) {
            $sanitary_values['dugme_y'] = sanitize_text_field($input['dugme_y']);
        }
        if (isset($input['dg2_btn_desktop'])) {
            $sanitary_values['dg2_btn_desktop'] = sanitize_text_field($input['dg2_btn_desktop']);
        }

        if (isset($input['choose_icon_1'])) {
            $sanitary_values['choose_icon_1'] = $input['choose_icon_1'];
        }

        if (isset($input['button_type_2'])) {
            $sanitary_values['button_type_2'] = $input['button_type_2'];
        }

        return $sanitary_values;
    }

    public function dg2_phone_call_button_section_info()
    {
        /** nothing for now */
    }

    public function phone_0_callback()
    {
        $phone = isset($this->dg2_phone_call_button_options['phone_0']) ? esc_attr($this->dg2_phone_call_button_options['phone_0']) : '';
        printf(
            '<input class="regular-text" type="text" name="dg2_phone_call_button_option_name[phone_0]" id="phone_0" value="%s">',
            $phone

        );
    }
    public function phone_1_callback()
    {
        $phone = isset($this->dg2_phone_call_button_options['phone_1']) ? esc_attr($this->dg2_phone_call_button_options['phone_1']) : '';
        printf(
            '<input class="regular-text" type="text" name="dg2_phone_call_button_option_name[phone_1]" id="phone_1" value="%s">
            <br/><small class="dg2-small">%s</small>',
            $phone ,
            __('Enter a phone number or visible text, ex: Call Us Now!', 'dg2-phone-button')
        );
    }
    public function color_bg_callback()
    {
        $phone_bg = isset($this->dg2_phone_call_button_options['color_bg']) ? $this->dg2_phone_call_button_options['color_bg'] : '';        printf(
            '<input class="regular-text dg2-color-field" type="text" name="dg2_phone_call_button_option_name[color_bg]" id="color_bg" value="%s">',
        $phone_bg
        );
    }
    public function color_txt_callback()
    {
        $color_txt = isset($this->dg2_phone_call_button_options['color_txt']) ? esc_attr($this->dg2_phone_call_button_options['color_txt']) : '';
        printf(
            '<input class="regular-text dg2-color-field" type="text" name="dg2_phone_call_button_option_name[color_txt]" id="color_txt" value="%s">',
            $color_txt
        );
    }
    public function dugme_x_callback()
    {
        $dugme_x = isset($this->dg2_phone_call_button_options['dugme_x']) ? esc_attr($this->dg2_phone_call_button_options['dugme_x']) : '';
        printf(
            '<input class="regular-text" type="number" name="dg2_phone_call_button_option_name[dugme_x]" id="dugme_x" value="%s">',
            $dugme_x
        );
    }
    public function dugme_y_callback()
    {
        $dugme_y = isset($this->dg2_phone_call_button_options['dugme_y']) ? esc_attr($this->dg2_phone_call_button_options['dugme_y']) : '';
        printf(
            '<input class="regular-text" type="number" name="dg2_phone_call_button_option_name[dugme_y]" id="dugme_y" value="%s">',
            $dugme_y
        );
    }
    public function dg2_btn_desktop_callback()
    {
        $dg2_btn_desktop = (isset($this->dg2_phone_call_button_options['dg2_btn_desktop']) && $this->dg2_phone_call_button_options['dg2_btn_desktop'] === 'dg2_btn_desktop') ? 'checked' : '';
        printf(
            '<input type="checkbox" name="dg2_phone_call_button_option_name[dg2_btn_desktop]" id="dg2_btn_desktop" value="dg2_btn_desktop" %s> <label for="dg2_btn_desktop">' . __("Show", "dg2-phone-button") . '</label>',
            $dg2_btn_desktop
        );
    }


    public function choose_icon_1_callback()
    {
        $default = isset($this->dg2_phone_call_button_options['choose_icon_1']) ? "" : "checked";
    ?> <fieldset class="icons"><?php $checked = (isset($this->dg2_phone_call_button_options['choose_icon_1']) && $this->dg2_phone_call_button_options['choose_icon_1'] === 'icon1') ? 'checked' : ''; ?>
            <label for="choose_icon_1-0"><input <?php echo esc_attr($default); ?> type="radio" name="dg2_phone_call_button_option_name[choose_icon_1]" id="choose_icon_1-0" value="icon1" <?php echo esc_attr($checked); ?>> <?php echo __("Icon 1", "dg2-phone-button"); ?> <img src="<?php echo DG2_PHONE_BUTTON_ASSETS . 'img/phone_dark_style1.svg';  ?>" /></label>
            <?php $checked = (isset($this->dg2_phone_call_button_options['choose_icon_1']) && $this->dg2_phone_call_button_options['choose_icon_1'] === 'icon2') ? 'checked' : ''; ?>
            <label for="choose_icon_1-1"><input type="radio" name="dg2_phone_call_button_option_name[choose_icon_1]" id="choose_icon_1-1" value="icon2" <?php echo esc_attr($checked); ?>> <?php echo __("Icon 2", "dg2-phone-button"); ?> <img src="<?php echo DG2_PHONE_BUTTON_ASSETS . 'img/phone_dark_style2.svg'; ?>" /></label>
            <?php $checked = (isset($this->dg2_phone_call_button_options['choose_icon_1']) && $this->dg2_phone_call_button_options['choose_icon_1'] === 'icon3') ? 'checked' : ''; ?>
            <label for="choose_icon_1-2"><input type="radio" name="dg2_phone_call_button_option_name[choose_icon_1]" id="choose_icon_1-2" value="icon3" <?php echo esc_attr($checked); ?>> <?php echo __("Icon 3", "dg2-phone-button"); ?> <img src="<?php echo DG2_PHONE_BUTTON_ASSETS . 'img/phone_dark_style3.svg'; ?>" /></label>
            <?php $checked = (isset($this->dg2_phone_call_button_options['choose_icon_1']) && $this->dg2_phone_call_button_options['choose_icon_1'] === 'icon4') ? 'checked' : ''; ?>
            <label for="choose_icon_1-3"><input type="radio" name="dg2_phone_call_button_option_name[choose_icon_1]" id="choose_icon_1-3" value="icon4" <?php echo esc_attr($checked); ?>> <?php echo __("Icon 4", "dg2-phone-button"); ?> <img src="<?php echo DG2_PHONE_BUTTON_ASSETS . 'img/phone_dark_style4.svg'; ?>" /></label>
            <?php $checked = (isset($this->dg2_phone_call_button_options['choose_icon_1']) && $this->dg2_phone_call_button_options['choose_icon_1'] === 'icon5') ? 'checked' : ''; ?>
            <label for="choose_icon_1-4"><input type="radio" name="dg2_phone_call_button_option_name[choose_icon_1]" id="choose_icon_1-4" value="icon5" <?php echo esc_attr($checked); ?>> <?php echo __("Icon 5", "dg2-phone-button"); ?> <img src="<?php echo DG2_PHONE_BUTTON_ASSETS . 'img/phone_dark_style5.svg'; ?>" /></label>
            <?php $checked = (isset($this->dg2_phone_call_button_options['choose_icon_1']) && $this->dg2_phone_call_button_options['choose_icon_1'] === 'icon6') ? 'checked' : ''; ?>
            <label for="choose_icon_1-5"><input type="radio" name="dg2_phone_call_button_option_name[choose_icon_1]" id="choose_icon_1-5" value="icon6" <?php echo esc_attr($checked); ?>> <?php echo __("Icon 6", "dg2-phone-button"); ?> <img src="<?php echo DG2_PHONE_BUTTON_ASSETS . 'img/phone_dark_style6.svg'; ?>" /></label>
            <?php $checked = (isset($this->dg2_phone_call_button_options['choose_icon_1']) && $this->dg2_phone_call_button_options['choose_icon_1'] === 'icon7') ? 'checked' : ''; ?>
            <label for="choose_icon_1-6"><input type="radio" name="dg2_phone_call_button_option_name[choose_icon_1]" id="choose_icon_1-6" value="icon7" <?php echo esc_attr($checked); ?>> <?php echo __("Icon 7", "dg2-phone-button"); ?> <img src="<?php echo DG2_PHONE_BUTTON_ASSETS . 'img/phone_dark_style7.svg'; ?>" /></label>

        </fieldset>

    <?php
    }

    public function button_type_2_callback()
    {
        $default = isset($this->dg2_phone_call_button_options['button_type_2']) ? "" : "checked";
    ?> <fieldset><?php $checked = (isset($this->dg2_phone_call_button_options['button_type_2']) && $this->dg2_phone_call_button_options['button_type_2'] === 'square') ? 'checked' : ''; ?>
            <label for="button_type_2-0"><input type="radio" name="dg2_phone_call_button_option_name[button_type_2]" id="button_type_2-0" value="square" <?php echo esc_attr($checked); ?>> <?php echo __("Square Rounded", "dg2-phone-button"); ?></label><br>
            <?php $checked = (isset($this->dg2_phone_call_button_options['button_type_2']) && $this->dg2_phone_call_button_options['button_type_2'] === 'squaresharp') ? 'checked' : ''; ?>
            <label for="button_type_2-2"><input type="radio" name="dg2_phone_call_button_option_name[button_type_2]" id="button_type_2-2" value="squaresharp" <?php echo esc_attr($checked); ?>> <?php echo __("Square Sharp", "dg2-phone-button"); ?></label><br>
            <?php $checked = (isset($this->dg2_phone_call_button_options['button_type_2']) && $this->dg2_phone_call_button_options['button_type_2'] === 'circle') ? 'checked' : ''; ?>
            <label for="button_type_2-1"><input <?php echo esc_attr($default); ?> type="radio" name="dg2_phone_call_button_option_name[button_type_2]" id="button_type_2-1" value="circle" <?php echo esc_attr($checked); ?>> <?php echo __("Circle", "dg2-phone-button"); ?></label>
        </fieldset>
<?php
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
