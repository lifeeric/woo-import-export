<?php

namespace wpie\import\upload\ftp;

use WP_Error;
use WP_Filesystem_FTPext;

if ( ! defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'woo-import-export' ) );
}

if ( file_exists( WPIE_IMPORT_CLASSES_DIR . '/class-wpie-upload.php' ) ) {
        require_once(WPIE_IMPORT_CLASSES_DIR . '/class-wpie-upload.php');
}

class WPIE_FTP_SFTP extends \wpie\import\upload\WPIE_Upload {

        public function __construct() {
                
        }

        public function wpie_download_file_from_ftp( $options = [], $host_path = "", $import_id = 0 ) {

                if ( ! is_dir( WPIE_UPLOAD_IMPORT_DIR ) || ! wp_is_writable( WPIE_UPLOAD_IMPORT_DIR ) ) {

                        return new \WP_Error( 'wpie_import_error', __( 'Uploads folder is not writable', 'woo-import-export' ) );
                }

                if ( file_exists( ABSPATH . 'wp-admin/includes/file.php' ) ) {

                        require_once( ABSPATH . 'wp-admin/includes/file.php');
                }
                if ( ! class_exists( 'WP_Filesystem_Base' ) ) {
                        require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );
                }

                if ( ! class_exists( 'WP_Filesystem_FTPext' ) ) {
                        require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-ftpext.php' );
                }

                if ( ! defined( 'FS_CONNECT_TIMEOUT' ) ) {
                        define( 'FS_CONNECT_TIMEOUT', 300 );
                }

                $connection = new \WP_Filesystem_FTPext( $options );

                $connected = $connection->connect();

                if ( ! $connected ) {

                        unset( $connected, $connection );

                        return new \WP_Error( 'wpie_import_error', __( 'FTP Connection Error', 'woo-import-export' ) );
                }
                unset( $connected );

                if ( ! $connection->is_file( $host_path ) ) {
                        unset( $connection );

                        return new \WP_Error( 'wpie_import_error', __( 'File Not Found', 'woo-import-export' ) );
                }

                $remote_contents = $connection->get_contents( $host_path );

                unset( $connection );

                if ( empty( $remote_contents ) ) {

                        unset( $remote_contents );

                        return new \WP_Error( 'wpie_import_error', __( 'File is Empty', 'woo-import-export' ) );
                }

                $fileName = basename( $host_path );

                $newfiledir = parent::wpie_create_safe_dir_name( $fileName );

                wp_mkdir_p( WPIE_UPLOAD_IMPORT_DIR . "/" . $newfiledir );

                wp_mkdir_p( WPIE_UPLOAD_IMPORT_DIR . "/" . $newfiledir . "/original" );

                wp_mkdir_p( WPIE_UPLOAD_IMPORT_DIR . "/" . $newfiledir . "/parse" );

                wp_mkdir_p( WPIE_UPLOAD_IMPORT_DIR . "/" . $newfiledir . "/parse/chunks" );

                $filePath = WPIE_UPLOAD_IMPORT_DIR . "/" . $newfiledir . "/original/" . $fileName;

                chmod( WPIE_UPLOAD_IMPORT_DIR . "/" . $newfiledir . "/original/", 0755 );

                if ( ! wp_is_writable( WPIE_UPLOAD_IMPORT_DIR . "/" . $newfiledir ) || false === file_put_contents( $filePath, $remote_contents ) ) {

                        if ( file_exists( $filePath ) ) {
                                unlink( $filePath );
                        }
                        unset( $fileName, $newfiledir, $filePath, $remote_contents );

                        return new \WP_Error( 'wpie_import_error', __( 'Uploads folder is not writable', 'woo-import-export' ) );
                }

                unset( $filePath, $remote_contents );

                return parent::wpie_manage_import_file( $fileName, $newfiledir, $import_id );
        }

        public function __destruct() {
                foreach ( $this as $key => $value ) {
                        unset( $this->$key );
                }
        }

}
