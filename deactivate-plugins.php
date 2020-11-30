<?php

if ( ! defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'woo-import-export' ) );
}

if ( ! function_exists( "wpie_auto_deactivate_woo_pro_plugins" ) ) {

        function wpie_auto_deactivate_woo_pro_plugins() {

                $plugins = [];

                if ( is_plugin_active( 'vj-wp-import-export/vj-wp-import-export.php') ) {
                        $plugins[] = 'woo-import-export/woo-import-export.php';
                }
                if ( is_plugin_active( 'wp-import-export-lite/wp-import-export-lite.php' ) ) {
                        $plugins[] = 'wp-import-export-lite/wp-import-export-lite.php';
                }
                if ( ! empty( $plugins ) ) {
                        deactivate_plugins( $plugins );
                }
        }

}
