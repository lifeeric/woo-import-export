<?php
if ( ! defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'woo-import-export' ) );
}

$templates = array();

if ( file_exists( WPIE_CLASSES_DIR . '/class-wpie-common-action.php' ) ) {

        require_once(WPIE_CLASSES_DIR . '/class-wpie-common-action.php');

        $cmm_act = new WPIE_Common_Actions();

        $templates = $cmm_act->get_import_list();

        unset( $cmm_act );
}
$ext_tab_files = apply_filters( 'wpie_manage_import_tab_files', array() );
?>

<div class="wpie_main_container">
        <div class="wpie_content_header">
                <div class="wpie_content_header_inner_wrapper">
                        <div class="wpie_content_header_title"><?php esc_html_e( 'Manage Import', 'woo-import-export' ); ?></div>
                </div>
        </div>
        <div class="wpie_content_wrapper">
                <div class="wpie_section_wrapper">
                        <div class="wpie_content_data_header wpie_section_wrapper_selected">
                                <div class="wpie_content_title"><?php esc_html_e( 'Import Log', 'woo-import-export' ); ?></div>
                                <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                        </div>
                        <div class="wpie_section_content wpie_show">
                                <div class="wpie_table_action_wrapper">
                                        <div class="wpie_table_action_container">
                                                <select class="wpie_content_data_select wpie_log_bulk_action">
                                                        <option value=""><?php esc_html_e( 'Bulk Actions', 'woo-import-export' ); ?></option>   
                                                        <option value="delete"><?php esc_html_e( 'Delete', 'woo-import-export' ); ?></option>   
                                                </select>
                                        </div>
                                        <div class="wpie_table_action_btn_container">
                                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_log_action_btn">
                                                        <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Apply', 'woo-import-export' ); ?>
                                                </div>
                                        </div>
                                </div>
                                <table class="wpie_log_table table table-bordered">
                                        <thead>
                                                <tr>
                                                        <td class="wpie_log_check_wrapper">
                                                                <input type="checkbox" class="wpie_checkbox wpie_log_check_all" id="wpie_log_check_all" value="1"/>
                                                                <label for="wpie_log_check_all" class="wpie_checkbox_label"></label>
                                                        </td>
                                                        <td class="wpie_log_lable"><?php esc_html_e( 'File Name', 'woo-import-export' ); ?></td>
                                                        <td class="wpie_log_lable"><?php esc_html_e( 'Query', 'woo-import-export' ); ?></td>
                                                        <td class="wpie_log_lable"><?php esc_html_e( 'Summary', 'woo-import-export' ); ?></td>
                                                        <td class="wpie_log_lable"><?php esc_html_e( 'Date', 'woo-import-export' ); ?></td>
                                                        <td class="wpie_log_lable"><?php esc_html_e( 'Status', 'woo-import-export' ); ?></td>
                                                        <td class="wpie_log_lable"><?php esc_html_e( 'Actions', 'woo-import-export' ); ?></td>
                                                </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ( ! empty( $templates ) ) {

                                                    $date_format = get_option( 'date_format' );

                                                    $time_format = get_option( 'time_format' );

                                                    $date_time_format = $date_format . " " . $time_format;

                                                    foreach ( $templates as $template ) {

                                                            $date = isset( $template->create_date ) ? $template->create_date : "";

                                                            $id = isset( $template->id ) ? $template->id : 0;

                                                            $opration_type = isset( $template->opration_type ) ? $template->opration_type : "";

                                                            $last_update_date = isset( $template->last_update_date ) ? $template->last_update_date : "";

                                                            $process_log = isset( $template->process_log ) ? maybe_unserialize( $template->process_log ) : array();

                                                            $options = isset( $template->options ) ? maybe_unserialize( $template->options ) : array();

                                                            $activeFile = isset( $options[ 'activeFile' ] ) ? $options[ 'activeFile' ] : "";

                                                            $importFile = isset( $options[ 'importFile' ] ) ? $options[ 'importFile' ] : "";

                                                            $file = isset( $importFile[ $activeFile ] ) ? $importFile[ $activeFile ] : array();

                                                            $fileName = isset( $file[ 'fileName' ] ) ? $file[ 'fileName' ] : "";

                                                            $status = isset( $template->status ) ? $template->status : "";

                                                            if ( $status == "completed" ) {
                                                                    $process_status = __( 'Completed', 'woo-import-export' );
                                                            } elseif ( $status == "background" || $status == "processing" ) {
                                                                    $process_status = __( 'Processing', 'woo-import-export' );
                                                            } elseif ( $status == "paused" ) {
                                                                    $process_status = __( 'Paused', 'woo-import-export' );
                                                            } elseif ( $status == "stopped" ) {
                                                                    $process_status = __( 'Stopped', 'woo-import-export' );
                                                            } else {
                                                                    $process_status = __( 'Processing', 'woo-import-export' );
                                                            }

                                                            $uid = uniqid();
                                                            ?>
                                                                <tr class="wpie_log_wrapper wpie_log_wrapper_<?php echo esc_attr( $id ); ?>">
                                                                        <td class="wpie_log_check_wrapper">
                                                                                <input type="checkbox" class="wpie_checkbox wpie_log_check" id="wpie_log_check_<?php echo esc_attr( $id ); ?>" value="<?php echo esc_attr( $id ); ?>"/>
                                                                                <label for="wpie_log_check_<?php echo esc_attr( $id ); ?>" class="wpie_checkbox_label"></label>
                                                                        </td>
                                                                        <td class="wpie_log_data"><?php echo esc_html( $fileName ); ?></td>
                                                                        <td class="wpie_log_data"><?php echo esc_html( maybe_unserialize( $opration_type ) ); ?></td>
                                                                        <td class="wpie_log_data">
                                                                            <?php
                                                                            echo esc_html( __( "Last run", 'woo-import-export' ) . " : " . date_i18n( $date_time_format, strtotime( $last_update_date ) ) );
                                                                            ?>
                                                                                <br />
                                                                                <?php
                                                                                echo esc_html( __( "Total", 'woo-import-export' ) . " " . (isset( $process_log[ 'total' ] ) ? $process_log[ 'total' ] : 0 ) . " " . __( "Records", 'woo-import-export' ) );
                                                                                ?>
                                                                                <br />
                                                                                <?php
                                                                                echo esc_html( (isset( $process_log[ 'imported' ] ) ? $process_log[ 'imported' ] : 0 ) . " " . __( "Records Imported", 'woo-import-export' ) );
                                                                                ?>
                                                                                <br />
                                                                                <?php
                                                                                echo esc_html( (isset( $process_log[ 'updated' ] ) ? $process_log[ 'updated' ] : 0 ) . " " . __( "updated", 'woo-import-export' ) . ", " );
                                                                                echo esc_html( (isset( $process_log[ 'created' ] ) ? $process_log[ 'created' ] : 0 ) . " " . __( "created", 'woo-import-export' ) . ", " );
                                                                                echo esc_html( (isset( $process_log[ 'skipped' ] ) ? $process_log[ 'skipped' ] : 0 ) . " " . __( "skipped", 'woo-import-export' ) );
                                                                                ?>
                                                                        </td>
                                                                        <td class="wpie_log_data"><?php echo esc_html( date_i18n( $date_time_format, strtotime( $date ) ) ); ?></td>
                                                                        <td class="wpie_log_data wpie_log_status"><?php echo esc_html( $process_status ); ?></td>
                                                                        <td class="wpie_log_data wpie_action_<?php echo esc_attr( $status ); ?>" >                                       
                                                                                <div class="wpie_log_action_btns wpie_download_template_file_btn"><i class="fas fa-file-alt wpie_general_btn_icon wpie_data_tipso" data-tipso="<?php esc_attr_e( 'Download', 'woo-import-export' ); ?>" aria-hidden="true"></i></div>
                                                                                <div class="wpie_log_action_btns wpie_template_file_log_btn"><i class="fas fa-list-ul wpie_general_btn_icon wpie_data_tipso" data-tipso="<?php esc_attr_e( 'Download Log File', 'woo-import-export' ); ?>" aria-hidden="true"></i></div>
                                                                                <div class="wpie_log_action_btns wpie_process_pause_btn"><i class="fas fa-pause wpie_general_btn_icon wpie_data_tipso" data-tipso="<?php esc_attr_e( 'Pause', 'woo-import-export' ); ?>" aria-hidden="true"></i></div>
                                                                                <div class="wpie_log_action_btns wpie_process_stop_btn"><i class="fas fa-stop-circle wpie_general_btn_icon wpie_data_tipso" data-tipso="<?php esc_attr_e( 'Stop', 'woo-import-export' ); ?>" aria-hidden="true"></i></div>
                                                                                <div class="wpie_log_action_btns wpie_process_resume_btn"><i class="fas fa-play wpie_general_btn_icon wpie_data_tipso" data-tipso="<?php esc_attr_e( 'Resume', 'woo-import-export' ); ?>" aria-hidden="true"></i></div>
                                                                                <a  class="wpie_log_action_btns wpie_process_reimport_btn" href="<?php echo admin_url( "admin.php?page=wpie-new-import&import_id=" . $id . "&ref_id=" . $uid . "&nonce=" . wp_create_nonce( $id . $uid ) ); ?>"><i class="fas fa-redo-alt wpie_general_btn_icon wpie_data_tipso" data-tipso="<?php esc_attr_e( 'Reimport', 'woo-import-export' ); ?>" aria-hidden="true"></i></a>
                                                                                <div class="wpie_log_action_btns wpie_delete_template_btn"><i class="fas fa-trash wpie_general_btn_icon wpie_data_tipso" data-tipso="<?php esc_attr_e( 'Delete', 'woo-import-export' ); ?>" aria-hidden="true"></i></div>
                                                                        </td>
                                                                </tr>
                                                                <?php
                                                                unset( $date, $id, $opration_type, $last_update_date, $process_log, $options, $fileName, $status, $process_status );
                                                        }
                                                        unset( $date_format, $time_format );
                                                } else {
                                                        ?>
                                                        <tr>
                                                                <td colspan="7">
                                                                        <div class="wpie_empty_records"><?php esc_html_e( 'No Records Found', 'woo-import-export' ); ?></div>
                                                                </td>
                                                        </tr>
                                                <?php } ?>
                                        </tbody>
                                </table>
                        </div>
                </div>
                <?php
                if ( ! empty( $ext_tab_files ) ) {

                        foreach ( $ext_tab_files as $_file ) {

                                if ( file_exists( $_file ) ) {
                                        include $_file;
                                }
                        }
                }
                ?>
        </div>
</div>
<div class="modal fade wpie_error_model" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content wpie_error">
                        <div class="modal-header">
                                <h5 class="modal-title"><?php esc_html_e( 'ERROR', 'woo-import-export' ); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times wpie_general_btn_icon " aria-hidden="true"></i>
                                </button>
                        </div>
                        <div class="modal-body">
                                <div class="wpie_error_content"></div>
                        </div>
                        <div class="modal-footer">
                                <div class="wpie_btn wpie_btn_red wpie_btn_radius " data-dismiss="modal">
                                        <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Ok', 'woo-import-export' ); ?>
                                </div>
                        </div>
                </div>
        </div>
</div>
<div class="wpie_doc_wrapper">
        <div class="wpie_doc_container">
                <a class="wpie_doc_url" href="<?php echo esc_url( WPIE_SUPPORT_URL ); ?>" target="_blank"><?php esc_html_e( 'Support', 'woo-import-export' ); ?></a>
                <div class="wpie_doc_url_delim">|</div>
                <a class="wpie_doc_url" href="<?php echo esc_url( WPIE_DOC_URL ); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'woo-import-export' ); ?></a>
        </div>
</div>
<div class="wpie_loader wpie_hidden">
        <div></div>
        <div></div>
</div>
<div class="modal fade wpie_delete_templates_data" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title wpie_import_proccess_title" ><?php esc_html_e( 'Confirm', 'woo-import-export' ); ?></h5>
                        </div>
                        <div class="modal-body">
                                <div class="wpie_delete_text_msg"><?php esc_html_e( 'Are you sure want to delete?', 'woo-import-export' ); ?></div>
                        </div>
                        <div class="modal-footer">
                                <div class="wpie_btn wpie_btn_primary wpie_btn_radius " data-dismiss="modal">
                                        <i class="fas fa-times wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'cancel', 'woo-import-export' ); ?>
                                </div>
                                <div class="wpie_btn  wpie_btn_primary wpie_btn_radius wpie_delete_templates" data-dismiss="modal" >
                                        <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Ok', 'woo-import-export' ); ?>
                                </div>
                        </div>
                </div>
        </div>
</div>
<form class="wpie_download_file_frm" method="post">
        <input type="hidden" class="wpie_download_file" name="wpie_download_import_id" value="" />
</form>
<form class="wpie_download_log_file_frm" method="post">
        <input type="hidden" class="wpie_download_import_log_id" name="wpie_download_import_log_id" value="" />
</form>
<?php
unset( $templates );
