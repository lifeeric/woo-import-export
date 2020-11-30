<?php
if ( ! defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'woo-import-export' ) );
}
?>
<div class="wpie_upload_outer_container" >
        <input type="hidden" name="wpie_ftp_details" class="wpie_ftp_details" value="" >
        <div  class="wpie_file_upload_container wpie_ftp_upload_container">
                <div class="wpie_element_half_wrapper">
                        <div class="wpie_element_title"><?php esc_html_e( 'Hostname', 'woo-import-export' ); ?></div>
                        <div class="wpie_element_data">
                                <input class="wpie_content_data_input wpie_ftp_hostname" type="text" name="wpie_ftp_hostname" value="">
                        </div>
                        <div class="wpie_element_hint">example.com</div>
                </div>
                <div class="wpie_element_half_wrapper">
                        <div class="wpie_element_title"><?php esc_html_e( 'Host Port', 'woo-import-export' ); ?></div>
                        <div class="wpie_element_data">
                                <input class="wpie_content_data_input wpie_ftp_host_port" type="text" name="wpie_ftp_host_port" value="">
                        </div>
                        <div class="wpie_element_hint"><?php esc_html_e( 'Default Port : 21', 'woo-import-export' ); ?></div>
                </div>
                <div class="wpie_element_half_wrapper">
                        <div class="wpie_element_title"><?php esc_html_e( 'Host Username', 'woo-import-export' ); ?></div>
                        <div class="wpie_element_data">
                                <input class="wpie_content_data_input wpie_ftp_host_username" type="text" name="wpie_ftp_host_username" value="">
                        </div>
                </div>
                <div class="wpie_element_half_wrapper">
                        <div class="wpie_element_title"><?php esc_html_e( 'Host Password', 'woo-import-export' ); ?></div>
                        <div class="wpie_element_data">
                                <input class="wpie_content_data_input wpie_ftp_host_password" type="password" name="wpie_ftp_host_password" value="" >
                        </div>
                </div>
                <div class="wpie_element_half_wrapper">
                        <div class="wpie_element_title"><?php esc_html_e( 'Host Path', 'woo-import-export' ); ?></div>
                        <div class="wpie_element_data">
                                <input class="wpie_content_data_input wpie_ftp_host_path" type="text" name="wpie_ftp_host_path" value="">
                        </div>
                        <div class="wpie_element_hint">/home/example/sample.csv</div>
                </div>
                <div class="wpie_download_btn_wrapper">
                        <div class="wpie_btn wpie_btn_primary wpie_ftp_upload_btn">
                                <i class="fas fa-download wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Download', 'woo-import-export' ); ?>
                        </div>
                </div>
        </div>
        <div class="wpie_file_list_wrapper"></div>
</div>