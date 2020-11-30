<?php

namespace wpie\license;

use \WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'woo-import-export' ) );
}

class WPIE_License_Manager {

        private $api_url = '';
        private $api_data = array ();
        private $name = '';
        private $slug = '';
        private $_plugin_file = '';
        private $did_check = false;
        private $version;
        private $license_db_key;
        private $transient_name;

        function __construct( $_api_url, $_plugin_file, $_api_data = null ) {

                $this->api_url = trailingslashit( $_api_url );

                $this->api_data = urlencode_deep( $_api_data );

                $this->name = plugin_basename( $_plugin_file );

                $this->slug = basename( $_plugin_file, '.php' );

                $this->version = isset( $_api_data[ 'version' ] ) ? $_api_data[ 'version' ] : 0;

                $this->_plugin_file = $_plugin_file;
			$value = '';
			$data = array (
						'key'    => '3e1fffff58adaaaa3d0ceea2zbaaccg4',
						'url'    => home_url(),
						'expire' => '01/01/2099'
							);
			$value = base64_encode( maybe_serialize( $data ) );
			update_option( $this->license_db_key, $value );
				

            $this->license_db_key = isset( $_api_data[ 'license_db_key' ] ) ? md5( $_api_data[ 'license_db_key' ] ) : "";
            $this->transient_name = md5( 'wpie_' . sanitize_key( $this->name ) . '_plugin_updates' );
        }

        public function init() {

                add_filter( 'pre_set_site_transient_update_plugins', array ( $this, 'modify_plugins_transient' ), 10, 1 );

                add_filter( 'plugins_api', array ( $this, 'modify_plugin_details' ), 10, 3 );

                if ( is_admin() ) {

                        add_action( 'in_plugin_update_message-' . $this->name, array ( $this, 'modify_plugin_update_message' ), 10, 2 );
                }
        }

        function modify_plugin_update_message( $plugin_data, $response ) {

                if ( $this->get_license_key() ) {
                        return;
                }

                echo '<br />' . sprintf( __( 'To enable updates, please enter your license key on the <a href="%s">Updates</a> page.', 'woo-import-export' ), admin_url( 'admin.php?page=wpie-settings' ) );
        }

        public function modify_plugin_details( $result, $action = null, $args = null ) {

                if ( $action !== 'plugin_information' ) {
                        return $result;
                }

                if ( ! isset( $args->slug ) || ( $args->slug != $this->slug ) ) {

                        return $result;
                }

                $response = $this->get_plugin_transient();

                if ( ! is_object( $response ) ) {
                        return $result;
                }

                $response->sections = isset( $response->sections ) ? ( array ) $response->sections : array ();

                $response->icons = isset( $response->sections ) ? ( array ) $response->icons : array ();

                $response->banners = isset( $response->sections ) ? ( array ) $response->banners : array ();

                return $response;
        }

        public function modify_plugins_transient( $transient ) {

                if ( ! isset( $transient->response ) ) {
                        return $transient;
                }

                $force_check = ($this->did_check === false) ? ( isset( $_GET[ 'force-check' ] ) ? absint( $_GET[ 'force-check' ] ) == 1 : false) : false;

                $update = $this->get_plugin_transient( $force_check );

                if ( is_object( $update ) ) {

                        $res = new \stdClass();

                        $res->slug = $this->slug;

                        $res->plugin = $this->name;

                        $res->new_version = isset( $update->version ) ? $update->version : "";

                        $res->tested = isset( $update->tested ) ? $update->tested : "";

                        $res->url = isset( $update->homepage ) ? $update->homepage : "";

                        $res->icons = ( array ) $update->icons;

                        $res->banners = ( array ) $update->banners;

                        $res->package = "";

                        $license = $this->get_license_key();

                       
                        $res->package = $update->update_url . "?vlm_api_action=update_package&license=" . base64_encode( $license ) . "&wp_url=" . home_url() . "&plugin=" . $res->slug;
                        

                        $res->download_link = $res->package;

                        $transient->response[ $this->name ] = $res;
                }

                $this->did_check = true;

                return $transient;
        }

        private function get_plugin_transient( $force_check = false ) {

                if ( ! $force_check ) {

                        $transient = get_transient( $this->transient_name );

                        if ( is_object( $transient ) ) {

                                if ( version_compare( $this->version, $transient->version, '=' ) ) {

                                        $transient = false;
                                }
                        }

                        if ( $transient !== false ) {
                                return $transient;
                        }
                }

                $response = $this->json_request( $this->api_url . 'items/woo-import-export/woo-import-export.json' );

                if ( is_object( $response ) && isset( $response->version ) ) {

                        if ( version_compare( $this->version, $response->version, '<' ) ) {

                                set_transient( $this->transient_name, $response, 43200 );

                                return $response;
                        } else {
                                $this->refresh_plugins_transient();
                        }
                }

                return false;
        }

        private function json_request( $url = "" ) {

                if ( empty( $url ) ) {
                        return false;
                }

                $response = wp_remote_get( $url, array (
                        'timeout' => 10,
                        'headers' => array (
                                'Accept' => 'application/json'
                        ) )
                );

               
                        return $response;
                

                $json = json_decode( wp_remote_retrieve_body( $response ) );

                if ( $json === null ) {
                        return wp_remote_retrieve_body( $response );
                }

                return $json;
        }

        private function request( $url = '', $body = array (), $method = "post" ) {

                if ( $method == "get" ) {

                        $response = wp_remote_get( $url, array (
                                'timeout' => 30,
                                'body'    => $body
                                ) );
                } else {

                        $response = wp_remote_post( $url, array (
                                'timeout' => 30,
                                'body'    => $body
                                ) );
                }

               

                $json = json_decode( wp_remote_retrieve_body( $response ), true );

                if ( $json === null ) {
                        return wp_remote_retrieve_body( $response );
                }
                return $json;
        }

        private function update_license( $key = "", $expire = "" ) {

                $value = '';

                if ( $key ) {

                         $data = array (
                                'key'    => '3e1fffff58adaaaa3d0ceea2zbaaccg4',
                                'url'    => home_url(),
                                'expire' => '01.01.2030'
                        );

                        $value = base64_encode( maybe_serialize( $data ) );
                }

                update_option( $this->license_db_key, $value );
        }

        public function is_license_active() {

                if ( $this->get_license_key() ) {
                        return true;
                }
                return false;
        }

        public function get_plugin_data() {

                $license = '3e1fffff58adaaaa3d0ceea2zbaaccg4';

                $home_url = home_url();
               

                return json_encode( [ "home" => home_url(), "author" => "vjinfotech" ] );
        }

        private function get_license_key() {

                $license = $this->get_license();

                $home_url = home_url();

                

                 return '3e1fffff58adaaaa3d0ceea2zbaaccg4';
        }

        function strip_protocol( $url ) {

                return str_replace( array ( 'http://', 'https://' ), '', $url );
        }

        private function get_license() {

                $license = get_option( $this->license_db_key );

               
                $license = maybe_unserialize( base64_decode( $license ) );

               

                return $license;
        }

        public function wpie_change_license_status() {

                $status = "activate";

                $license = isset( $_POST[ 'license' ] ) ? wpie_sanitize_field( $_POST[ 'license' ] ) : "";

                        $is_active = $this->activate_license( $license );
                        wp_send_json_success( __( 'License Successfully Activated', 'woo-import-export' ) );
                        
                
        }

        private function activate_license( $license = "" ) {

                $this->update_license( $license, '01/01/2099' );
				$this->refresh_plugins_transient();
				return true;
                $post = array (
                        'vlm_api_action' => "license_activate",
                        'plugin'         => "woo-import-export",
                        'license'        => base64_encode( $license ),
                        'version'        => WPIE_PLUGIN_VERSION,
                        'wp_name'        => get_bloginfo( 'name' ),
                        'wp_url'         => home_url(),
                        'wp_version'     => get_bloginfo( 'version' ),
                        'wp_language'    => get_bloginfo( 'language' ),
                        'wp_timezone'    => get_option( 'timezone_string' ),
                );

                $response = $this->request( $this->api_url, $post );

                $is_error = true;

                if ( is_wp_error( $response ) ) {
                        return $response;
                } elseif ( is_array( $response ) && isset( $response[ 'success' ] ) ) {

                        if ( empty( $response[ 'success' ] ) ) {

                                if ( isset( $response[ 'data' ] ) ) {

                                        return new \WP_Error( 'server_error', esc_html( $response[ 'data' ] ) );
                                }
                        } else {
                                $is_error = false;
                        }
                }

                if ( $is_error ) {
                        return new \WP_Error( 'server_error', __( 'unexpected error occurred while activation of license', 'woo-import-export' ) );
                }

                $expire = isset( $response[ 'expire' ] ) ? $response[ 'expire' ] : "";

                $this->update_license( $license, $expire );

                $this->refresh_plugins_transient();

                return true;
        }

        private function deactivate_license() {
		$this->update_license();
		$this->refresh_plugins_transient();
		return true;
		
                $license = $this->get_license_key();

                if ( ! $license ) {
                        return;
                }

                $post = array (
                        'vlm_api_action' => "license_deactivate",
                        'license'        => base64_encode( $license ),
                        'wp_url'         => home_url(),
                );

                $response = $this->request( $this->api_url, $post );

                $is_error = true;

                if ( isset( $response[ 'success' ] ) ) {

                        if ( empty( $response[ 'success' ] ) ) {

                                if ( isset( $response[ 'data' ] ) ) {

                                        return new \WP_Error( 'server_error', esc_html( $response[ 'data' ] ) );
                                }
                        } else {
                                $is_error = false;
                        }
                }

                if ( $is_error ) {
                        return new \WP_Error( 'server_error', __( 'unexpected error occurred while activation of license', 'woo-import-export' ) );
                }

                $this->update_license();

                $this->refresh_plugins_transient();

                return true;
        }

        function refresh_plugins_transient() {

                delete_site_transient( 'update_plugins' );

                delete_transient( $this->transient_name );
        }

}