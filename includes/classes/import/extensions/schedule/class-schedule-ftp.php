<?php

namespace wpie\import\schedule;

use \wpie\import\upload\ftp\WPIE_FTP_SFTP;

if ( ! defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'woo-import-export' ) );
}

if ( file_exists( WPIE_IMPORT_CLASSES_DIR . '/extensions/schedule/class-schedule-base.php' ) ) {

        require_once(WPIE_IMPORT_CLASSES_DIR . '/extensions/schedule/class-schedule-base.php');
}

class Schedule_Ftp extends Schedule_Base {

        public function __construct( $options = [] ) {

                $this->options = $options;

                parent::generate_template();

                $this->process_upload_files();
        }

        private function process_upload_files() {

                if ( $this->downlod_file() === false || $this->validate_upload() === false ) {

                        $this->delete_template();

                        return false;
                }
                return true;
        }

        private function downlod_file() {

                $fileName = WPIE_IMPORT_CLASSES_DIR . '/extensions/ftp-sftp/class-ftp-sftp.php';

                if ( ! file_exists( $fileName ) ) {

                        return false;
                }

                require_once($fileName);

                $upload = new WPIE_FTP_SFTP();

                $ftp_details = isset( $this->options [ "wpie_ftp_details" ] ) ? wpie_sanitize_field( $this->options [ "wpie_ftp_details" ] ) : '';

                if ( ! empty( $ftp_details ) ) {

                        $ftp_details = json_decode( wp_unslash( $ftp_details ), true );

                        if ( is_array( $ftp_details ) && ! empty( $ftp_details ) ) {

                                $hostname = isset( $ftp_details[ "host" ] ) ? wpie_sanitize_field( $ftp_details[ "host" ] ) : '';

                                $host_port = isset( $ftp_details[ "post" ] ) && absint( $ftp_details[ "post" ] ) > 0 ? absint( wpie_sanitize_field( $ftp_details[ "post" ] ) ) : 21;

                                $host_username = isset( $ftp_details[ "username" ] ) ? wpie_sanitize_field( $ftp_details[ "username" ] ) : '';

                                $host_password = isset( $ftp_details[ "password" ] ) ? wpie_sanitize_field( $ftp_details[ "password" ] ) : '';

                                $host_path = isset( $ftp_details[ "path" ] ) ? wpie_sanitize_field( $ftp_details[ "path" ] ) : '';

                                $connection_arguments = array(
                                        'port'     => $host_port,
                                        'hostname' => $hostname,
                                        'username' => $host_username,
                                        'password' => $host_password,
                                );

                                $file_list = $upload->wpie_download_file_from_ftp( $connection_arguments, $host_path, $this->id );

                                if ( ! is_wp_error( $file_list ) ) {
                                        unset( $upload, $file );
                                        return $file_list;
                                }
                        }
                }
                unset( $upload, $ftp_details );

                return false;
        }

}
