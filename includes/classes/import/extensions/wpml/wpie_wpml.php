<?php

if (!defined('ABSPATH')) {
    die(__("Can't load this file directly", 'woo-import-export'));
}

class WPIE_WPML_Import_Extension {

    public function __construct() {

        if (class_exists('SitePress')) {

            add_filter('wpie_pre_post_field_mapping_section', array($this, "get_wpml_tab_view"), 10, 2);

            add_filter('wpie_pre_term_field_mapping_section', array($this, "get_wpml_tab_view"), 10, 2);
            
            add_filter('wpie_pre_attribute_field_mapping_section', array($this, "get_wpml_tab_view"), 10, 2);

            add_filter('wpie_import_addon', array($this, "wpml_addon_init"), 10, 2);
        }
    }

    public function get_wpml_tab_view($sections = array(), $wpie_import_type = "") {

        if ($wpie_import_type == "shop_coupon") {
            return $sections;
        }

        $fileName = WPIE_IMPORT_CLASSES_DIR . '/extensions/wpml/wpie-wpml-tab.php';

        if (file_exists($fileName)) {

            require_once($fileName);

            if (function_exists("wpie_import_get_wpml_tab")) {
                $sections = wpie_import_get_wpml_tab($sections, $wpie_import_type);
            }
        }
        unset($fileName);

        return $sections;
    }

    public function wpml_addon_init($addons = array(), $wpie_import_type = "") {

        if ($wpie_import_type == "shop_coupon" || !class_exists('SitePress')) {
            return $addons;
        }

        if (!in_array('\wpie\import\wpml\WPIE_WPML_Import', $addons)) {

            $fileName = WPIE_IMPORT_CLASSES_DIR . '/extensions/wpml/class-wpie-wpml.php';

            if (file_exists($fileName)) {

                require_once($fileName);
            }
            unset($fileName);

            $addons[] = '\wpie\import\wpml\WPIE_WPML_Import';
        }

        return $addons;
    }

    public function __destruct() {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

}

new WPIE_WPML_Import_Extension();
