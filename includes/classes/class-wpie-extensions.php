<?php

namespace wpie\addons;

if ( ! defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'woo-import-export' ) );
}

class WPIE_Extension {

        private $wpie_export_extensions = array ();
        private $wpie_import_extensions = array ();
        private $wpie_activated_extensions = array ();

        public function __construct() {

                add_action( 'wp_ajax_wpie_ext_save_extensions', array ( $this, 'wpie_ext_save_extensions' ) );

                add_action( 'wp_ajax_wpie_ext_save_extension_data', array ( $this, 'wpie_ext_save_extension_data' ) );

                add_filter( 'wpie_get_export_remote_locations', array ( $this, 'wpie_get_export_remote_locations' ), 10, 1 );
        }

        public function wpie_get_export_extension() {

                if ( empty( $this->wpie_export_extensions ) ) {

                        $this->wpie_export_extensions = array (
                                "wpie_acf_export"               => array (
                                        "name"         => __( "Advanced Custom Fields", 'woo-import-export' ),
                                        "include_path" => WPIE_EXPORT_CLASSES_DIR . "/extensions/acf/wpie_acf.php",
                                        "short_desc"   => __( "Export Advanced Custom Fields from WordPress Site", 'woo-import-export' )
                                ),
                                "wpie_bg_export"                => array (
                                        "name"         => __( "Background Export", 'woo-import-export' ),
                                        "include_path" => WPIE_EXPORT_CLASSES_DIR . "/extensions/bg/wpie_bg.php",
                                        "short_desc"   => __( "Export in Background from WordPress Site", 'woo-import-export' )
                                ),
                                "wpie_schedule_export"          => array (
                                        "name"         => __( "Schedule Export", 'woo-import-export' ),
                                        "include_path" => WPIE_EXPORT_CLASSES_DIR . "/extensions/schedule/class-wpie-schedule.php",
                                        "short_desc"   => __( "Export automatically and periodically from WordPress Site", 'woo-import-export' )
                                ),
                                "wpie_user_export"              => array (
                                        "name"         => __( "User", 'woo-import-export' ),
                                        "include_path" => WPIE_EXPORT_CLASSES_DIR . "/extensions/user/wpie_user.php",
                                        "short_desc"   => __( "Export Users & User's metadata from WordPress Site", 'woo-import-export' )
                                ),
                                "wpie_wc_export"                => array (
                                        "name"         => __( "WooCommerce", 'woo-import-export' ),
                                        "is_default"   => true,
                                        "include_path" => WPIE_EXPORT_CLASSES_DIR . "/extensions/wc/wpie_wc.php",
                                        "short_desc"   => __( "Export Products, Orders, Product Categories and coupons from WordPress Site", 'woo-import-export' )
                                ),
                                "wpie_wpml_export"              => array (
                                        "name"         => __( "WPML", 'woo-import-export' ),
                                        "include_path" => WPIE_EXPORT_CLASSES_DIR . "/extensions/wpml/wpie_wpml.php",
                                        "short_desc"   => __( "Export multilingual content from WordPress Site", 'woo-import-export' )
                                ),
                                "wpie_product_attribute_export" => array (
                                        "name"         => __( "Product Attributes", 'woo-import-export' ),
                                        "include_path" => WPIE_EXPORT_CLASSES_DIR . "/extensions/product-attribute/wpie_product_attribute.php",
                                        "short_desc"   => __( "Export Product Attributes from WordPress Site", 'woo-import-export' )
                                )
                        );
                }

                return apply_filters( "wpie_export_extensions", $this->wpie_export_extensions );
        }

        public function wpie_get_import_extension() {

                if ( empty( $this->wpie_import_extensions ) ) {

                        $this->wpie_import_extensions = array (
                                "wpie_import_local_upload"            => array (
                                        "name"         => __( "Upload From Desktop", 'woo-import-export' ),
                                        "is_default"   => true,
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/local-upload/wpie_local_upload.php",
                                ),
                                "wpie_import_existing_file_upload"    => array (
                                        "name"         => __( "Use existing file", 'woo-import-export' ),
                                        "is_default"   => true,
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/existing-file/wpie_existing_file.php",
                                ),
                                "wpie_acf_import"                     => array (
                                        "name"         => __( "Advanced Custom Fields", 'woo-import-export' ),
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/acf/wpie_acf.php",
                                        "short_desc"   => __( "Import Advanced Custom Fields to WordPress Site", 'woo-import-export' )
                                ),
                                "wpie_bg_import"                      => array (
                                        "name"         => __( "Background Import", 'woo-import-export' ),
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/bg/wpie_bg.php",
                                        "short_desc"   => __( "Import in Background to WordPress Site", 'woo-import-export' )
                                ),
                                "wpie_import_dropbox_file_upload"     => array (
                                        "name"         => __( "Dropbox", 'woo-import-export' ),
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/dropbox/wpie_dropbox.php",
                                        "short_desc"   => __( "Import File from Dropbox to WordPress Site", 'woo-import-export' ),
                                        "settings"     => WPIE_IMPORT_CLASSES_DIR . "/extensions/dropbox/wpie_dropbox_settings.php"
                                ),
                                "wpie_import_ftp_file_upload"         => array (
                                        "name"         => __( "Upload From FTP/SFTP", 'woo-import-export' ),
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/ftp-sftp/wpie_ftp_sftp.php",
                                        "short_desc"   => __( "Import File from FTP/SFTP to WordPress Site", 'woo-import-export' ),
                                ),
                                "wpie_import_googledrive_file_upload" => array (
                                        "name"         => __( "Google Drive", 'woo-import-export' ),
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/googledrive/wpie-gdrive.php",
                                        "short_desc"   => __( "Import File from Google Drive to WordPress Site", 'woo-import-export' ),
                                        "settings"     => WPIE_IMPORT_CLASSES_DIR . "/extensions/googledrive/wpie_googledrive_settings.php"
                                ),
                                "wpie_import_onedrive_file_upload"    => array (
                                        "name"         => __( "Microsoft Onedrive", 'woo-import-export' ),
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/onedrive/wpie_onedrive.php",
                                        "short_desc"   => __( "Import File from Microsoft Onedrive to WordPress Site", 'woo-import-export' ),
                                        "settings"     => WPIE_IMPORT_CLASSES_DIR . "/extensions/onedrive/wpie_onedrive_settings.php"
                                ),
                                "wpie_schedule_import"                => array (
                                        "name"         => __( "Schedule Import", 'woo-import-export' ),
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/schedule/wpie_schedule.php",
                                        "short_desc"   => __( "Import automatically & periodically to WordPress Site", 'woo-import-export' )
                                ),
                                "wpie_import_url_file_upload"         => array (
                                        "name"         => __( "Upload From URL", 'woo-import-export' ),
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/url-upload/wpie_url_upload.php",
                                        "short_desc"   => __( "Import File from URL to WordPress Site", 'woo-import-export' ),
                                ),
                                "wpie_user_import"                    => array (
                                        "name"         => __( "User Import", 'woo-import-export' ),
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/user/user.php",
                                        "short_desc"   => __( "Import Users & User's metadata to WordPress Site", 'woo-import-export' )
                                ),
                                "wpie_wc_import"                      => array (
                                        "is_default"   => true,
                                        "name"         => __( "WooCommerce Import", 'woo-import-export' ),
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/wc/wc.php",
                                        "short_desc"   => __( "Import Products, Orders, Product Categories and coupons to WordPress Site", 'woo-import-export' )
                                ),
                                "wpie_wpml_import"                    => array (
                                        "name"         => __( "WPML", 'woo-import-export' ),
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/wpml/wpie_wpml.php",
                                        "short_desc"   => __( "Import multilingual content to WordPress Site", 'woo-import-export' )
                                ),
                                "wpie_product_attribute_import"       => array (
                                        "name"         => __( "Product Attributes", 'woo-import-export' ),
                                        "include_path" => WPIE_IMPORT_CLASSES_DIR . "/extensions/product-attribute/wpie_product_attribute.php",
                                        "short_desc"   => __( "Import Product Attributes to WordPress Site", 'woo-import-export' )
                                )
                        );
                }

                return apply_filters( "wpie_import_extensions", $this->wpie_import_extensions );
        }

        public function wpie_ext_save_extensions() {

                $return_value = array ();

                $wpie_ext = isset( $_POST[ 'wpie_ext' ] ) ? wpie_sanitize_field( $_POST[ 'wpie_ext' ] ) : "";

                if ( ! empty( $wpie_ext ) ) {
                        $wpie_ext = maybe_serialize( $wpie_ext );
                } else {
                        $wpie_ext = "";
                }

                update_option( "wpie_extensions", $wpie_ext );

                unset( $wpie_ext );

                $return_value[ 'status' ] = 'success';

                $return_value[ 'message' ] = __( "Settings Successfully Updated", 'woo-import-export' );

                echo json_encode( $return_value );

                die();
        }

        public function wpie_ext_save_extension_data() {

                $return_value = array ();

                $wpie_ext = isset( $_POST[ 'wpie_ext' ] ) ? wpie_sanitize_field( $_POST[ 'wpie_ext' ] ) : "";

                if ( ! empty( $wpie_ext ) ) {

                        $wpie_ext_data = maybe_serialize( $_POST );

                        update_option( $wpie_ext, $wpie_ext_data );

                        unset( $settings, $wpie_ext_id, $wpie_ext_data, $option_name );

                        $return_value[ 'status' ] = 'success';

                        $return_value[ 'message' ] = __( "Settings Successfully Updated", 'woo-import-export' );
                } else {

                        $return_value[ 'status' ] = 'error';

                        $return_value[ 'message' ] = __( "Extension Not Found", 'woo-import-export' );
                }
                unset( $wpie_ext );

                echo json_encode( $return_value );

                die();
        }

        public function wpie_get_activated_ext() {

                if ( empty( $this->wpie_activated_extensions ) ) {

                        $wpie_extensions = get_option( 'wpie_extensions' );

                        $wpie_ext = $this->wpie_get_export_extension();

                        $wpie_imp_ext = $this->wpie_get_import_extension();

                        $wpie_ext = array_merge( $wpie_ext, $wpie_imp_ext );

                        if ( $wpie_extensions ) {

                                $default_ext = [];
                                if ( ! empty( $wpie_ext ) ) {
                                        foreach ( $wpie_ext as $key => $ext ) {

                                                if ( isset( $ext[ 'is_default' ] ) && $ext[ 'is_default' ] == true ) {
                                                        $default_ext[] = $key;
                                                }
                                        }
                                }
                                $this->wpie_activated_extensions = array_unique( array_merge( $default_ext, maybe_unserialize( $wpie_extensions ) ) );
                        } else {

                                $this->wpie_activated_extensions = array_keys( $wpie_ext );
                        }

                        unset( $wpie_extensions );
                }

                return apply_filters( "wpie_activated_extensions", $this->wpie_activated_extensions );
        }

        public function wpie_init_extensions( $type = "all" ) {

                $wpie_activated_ext = $this->wpie_get_activated_ext();

                try {
                        $wpie_ext = array ();

                        if ( is_array( $wpie_activated_ext ) && ! empty( $wpie_activated_ext ) ) {
                                $data = $wpie_activated_ext;
                        } else {
                                $data = array ();
                        }

                        if ( $type == "all" || $type == "export" ) {

                                $wpie_ext = $this->wpie_get_export_extension();
                        }

                        if ( $type == "all" || $type == "import" ) {

                                $wpie_imp_ext = $this->wpie_get_import_extension();

                                $wpie_ext = array_merge( $wpie_ext, $wpie_imp_ext );

                                unset( $wpie_imp_ext );
                        }

                        if ( ! empty( $wpie_ext ) ) {
                                foreach ( $wpie_ext as $key => $ext ) {

                                        if ( ((isset( $ext[ 'is_default' ] ) && $ext[ 'is_default' ] == true) || (in_array( $key, $data ) && isset( $ext[ 'include_path' ] ))) && file_exists( $ext[ 'include_path' ] ) ) {
                                                require_once($ext[ 'include_path' ]);
                                        }
                                }
                        }
                        unset( $data, $wpie_ext );
                } catch ( Exception $e ) {
                        // echo $e->getMessage();
                }
                unset( $wpie_activated_ext );
        }

        public function wpie_export_extension_info( $wpie_ext = "" ) {

                $wpie_export_ext = $this->wpie_get_export_extension();

                if ( ! empty( $wpie_ext ) && isset( $wpie_export_ext[ $wpie_ext ] ) ) {
                        unset( $wpie_export_ext );
                        return true;
                }

                unset( $wpie_export_ext );

                return false;
        }

        public function wpie_import_extension_info( $wpie_ext = "" ) {

                $wpie_import_ext = $this->wpie_get_import_extension();

                if ( ! empty( $wpie_ext ) && isset( $wpie_import_ext[ $wpie_ext ] ) ) {
                        unset( $wpie_import_ext );
                        return true;
                }

                unset( $wpie_import_ext );

                return false;
        }

        public function wpie_get_export_remote_locations( $remote_loc = array () ) {

                $wpie_export_ext = $this->wpie_get_export_extension();

                $wpie_activated_ext = $this->wpie_get_activated_ext();

                if ( ! empty( $wpie_export_ext ) && is_array( $wpie_activated_ext ) && ! empty( $wpie_activated_ext ) ) {

                        foreach ( $wpie_activated_ext as $wpie_ext ) {

                                if ( ! (isset( $wpie_export_ext[ $wpie_ext ] ) && isset( $wpie_export_ext[ $wpie_ext ][ 'is_external_save' ] ) && $wpie_export_ext[ $wpie_ext ][ 'is_external_save' ] === true) ) {
                                        continue;
                                }
                                if ( isset( $remote_loc[ $wpie_ext ] ) ) {
                                        continue;
                                }

                                $option_name = "wpie_export_ext_" . $wpie_ext;

                                $settings = maybe_unserialize( get_option( $option_name ) );

                                $remote_loc[ $wpie_ext ] = array (
                                        "label" => isset( $wpie_export_ext[ $wpie_ext ] ) && isset( $wpie_export_ext[ $wpie_ext ][ 'name' ] ) ? $wpie_export_ext[ $wpie_ext ][ 'name' ] : "",
                                        "data"  => $settings
                                );
                                unset( $option_name, $settings );
                        }
                }
                unset( $wpie_activated_ext, $wpie_export_ext );

                return $remote_loc;
        }

        public function __destruct() {
                foreach ( $this as $key => $value ) {
                        unset( $this->$key );
                }
        }

}
