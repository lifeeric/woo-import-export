<?php
if ( ! defined( 'ABSPATH' ) )
        die( __( "Can't load this file directly", 'woo-import-export' ) );

global $wp_roles;

$user_roles = $wp_roles->get_names();

if ( isset( $user_roles[ 'administrator' ] ) ) {
        unset( $user_roles[ 'administrator' ] );
}
$templates = array();

if ( file_exists( WPIE_CLASSES_DIR . '/class-wpie-common-action.php' ) ) {

        require_once(WPIE_CLASSES_DIR . '/class-wpie-common-action.php');

        $cmm_act = new WPIE_Common_Actions();

        $templates = $cmm_act->wpie_get_templates();

        unset( $cmm_act );
}
$delete_on_uninstall = get_option( "wpie_delete_on_uninstall", 0 );

if ( file_exists( WPIE_CLASSES_DIR . '/class-wpie-license-manager.php' ) ) {
        require_once(WPIE_CLASSES_DIR . '/class-wpie-license-manager.php');
}

$license = new \wpie\license\WPIE_License_Manager(
        WPIE_PLUGIN_API,
        WPIE_PLUGIN_FILE,
        array( 'version' => WPIE_PLUGIN_VERSION, 'license_db_key' => "wpie_license", 'author' => 'vjinfotech' )
);

$license_status = $license->is_license_active();

$active_class = "";
$deactive_class = "";
if ( $license_status ) {
        $active_class = "wpie_hide";
} else {
        $deactive_class = "wpie_hide";
}
?>

<div class="wpie_main_container">
        <div class="wpie_content_header">
                <div class="wpie_content_header_inner_wrapper">
                        <div class="wpie_content_header_title"><?php esc_html_e( 'Settings', 'woo-import-export' ); ?></div>
                </div>
        </div>
        <div class="wpie_content_wrapper">
                <div class="wpie_section_wrapper">
                        <div class="wpie_content_data_header">
                                <div class="wpie_content_title"><?php esc_html_e( 'Licenses', 'woo-import-export' ); ?></div>
                                <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                        </div>
                        <div class="wpie_section_content">
                                <div class="wpie_setting_element_wrapper wpie_license_activation_wrapper <?php echo esc_attr( $active_class ); ?>">
                                        <div class="wpie_setting_element_lable"><?php esc_html_e( 'License Key', 'woo-import-export' ); ?></div>
                                        <div class="wpie_setting_element_data">
                                                <div class="wpie_setting_element">
                                                        <input type="text" class="wpie_content_data_input wpie_license_key" value=""/>
                                                </div>
                                                <div class="wpie_setting_element_hint"><?php esc_html_e( 'A license key is required to access plugin updates and support.', 'woo-import-export' ); ?></div>
                                        </div>
                                        <div class="wpie_setting_element_btn">
                                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_activate_license">
                                                        <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Activate', 'woo-import-export' ); ?>
                                                </div>
                                        </div>
                                </div>
                                <div class="wpie_setting_element_wrapper wpie_license_deactivation_wrapper <?php echo esc_attr( $deactive_class ); ?>">
                                        <div class="wpie_setting_element_lable"><?php esc_html_e( 'License Status', 'woo-import-export' ); ?></div>
                                        <div class="wpie_setting_element_data">
                                                <div class="wpie_setting_element wpie_license_status"><?php esc_html_e( 'Activated', 'woo-import-export' ); ?></div>
                                        </div>
                                        <div class="wpie_setting_element_btn">
                                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_deactivate_license">
                                                        <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'deactivate', 'woo-import-export' ); ?>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
                <div class="wpie_section_wrapper">
                        <div class="wpie_content_data_header">
                                <div class="wpie_content_title"><?php esc_html_e( 'Manage Templates', 'woo-import-export' ); ?></div>
                                <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                        </div>
                        <div class="wpie_section_content">
                                <div class="wpie_setting_element_wrapper">
                                        <div class="wpie_setting_element_data">
                                                <div class="wpie_setting_element">
                                                        <form class="wpie_template_export" name="wpie_template_export" method="post" action="">
                                                                <select class="wpie_content_data_select wpie_template_list" name="wpie_template_list[]" multiple="multiple" data-placeholder="<?php esc_html_e( 'Choose Templates', 'woo-import-export' ); ?>">
                                                                    <?php
                                                                    if ( ! empty( $templates ) ) {
                                                                            foreach ( $templates as $data ) {
                                                                                    $id = isset( $data->id ) ? absint( $data->id ) : 0;

                                                                                    $options = isset( $data->options ) ? maybe_unserialize( $data->options ) : array();

                                                                                    $name = isset( $options[ 'wpie_template_name' ] ) ? $options[ 'wpie_template_name' ] : "";
                                                                                    if ( empty( $name ) ) {
                                                                                            $name = isset( $options[ 'template_name' ] ) ? $options[ 'template_name' ] : "";
                                                                                    }
                                                                                    if ( $id > 0 && ! empty( $name ) ) {
                                                                                            ?>
                                                                                                <option value="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $name ); ?></option>
                                                                                                <?php
                                                                                        }
                                                                                }
                                                                        }
                                                                        ?>
                                                                </select>
                                                        </form>
                                                </div>
                                        </div>
                                        <div class="wpie_setting_element_btn">
                                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_template_delete_btn">
                                                        <i class="fas fa-times wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Delete', 'woo-import-export' ); ?>
                                                </div>
                                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_template_export_btn">
                                                        <i class="fas fa-file-export wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Export', 'woo-import-export' ); ?>
                                                </div>
                                        </div>
                                </div>
                                <div class="wpie_setting_element_wrapper">
                                        <div class="wpie_setting_element_data">
                                                <div class="wpie_setting_element">
                                                        <input type="file" class="wpie_template_file" name="wpie_template_file"/>
                                                </div>
                                        </div>
                                        <div class="wpie_setting_element_btn">
                                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_template_import_btn">
                                                        <i class="fas fa-download wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Import', 'woo-import-export' ); ?>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
                <?php if ( current_user_can( 'administrator' ) || is_super_admin() ) { ?>
                        <div class="wpie_section_wrapper">
                                <div class="wpie_content_data_header">
                                        <div class="wpie_content_title"><?php esc_html_e( 'Plugin Access Permission', 'woo-import-export' ); ?></div>
                                        <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                                </div>
                                <div class="wpie_section_content">
                                        <div class="wpie_setting_element_wrapper">
                                                <form class="wpie_user_role_frm">
                                                        <div class="wpie_setting_element_only_data">
                                                                <div class="wpie_setting_element">
                                                                        <select class="wpie_content_data_select wpie_role_list" name="wpie_user_role" data-placeholder="<?php esc_attr_e( 'Choose Role', 'woo-import-export' ); ?>">
                                                                                <option value=""><?php esc_html_e( 'Choose Role', 'woo-import-export' ); ?></option>                                   
                                                                                <?php
                                                                                if ( ! empty( $user_roles ) ) {
                                                                                        foreach ( $user_roles as $key => $name ) {
                                                                                                ?>
                                                                                                <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></option>
                                                                                                <?php
                                                                                        }
                                                                                }
                                                                                ?>
                                                                        </select>
                                                                </div>
                                                                <div class="wpie_import_cap_wrapper">
                                                                        <div class="wpie_import_cap_container">
                                                                                <input type="checkbox" class="wpie_checkbox wpie_user_cap wpie_new_export" id="wpie_cap_new_export" name="wpie_cap_new_export" value="1"/>
                                                                                <label for="wpie_cap_new_export" class="wpie_checkbox_label"><?php esc_html_e( 'New Export', 'woo-import-export' ); ?></label>
                                                                        </div>
                                                                        <div class="wpie_import_cap_container">
                                                                                <input type="checkbox" class="wpie_checkbox wpie_manage_export wpie_user_cap" id="wpie_cap_manage_export" name="wpie_cap_manage_export" value="1"/>
                                                                                <label for="wpie_cap_manage_export" class="wpie_checkbox_label"><?php esc_html_e( 'Manage Export', 'woo-import-export' ); ?></label>
                                                                        </div>
                                                                        <div class="wpie_import_cap_container">
                                                                                <input type="checkbox" class="wpie_checkbox wpie_new_import wpie_user_cap" id="wpie_cap_new_import" name="wpie_cap_new_import" value="1"/>
                                                                                <label for="wpie_cap_new_import" class="wpie_checkbox_label"><?php esc_html_e( 'New Import', 'woo-import-export' ); ?></label>
                                                                        </div>
                                                                        <div class="wpie_import_cap_container">
                                                                                <input type="checkbox" class="wpie_checkbox wpie_manage_import wpie_user_cap" id="wpie_cap_manage_import" name="wpie_cap_manage_import" value="1"/>
                                                                                <label for="wpie_cap_manage_import" class="wpie_checkbox_label"><?php esc_html_e( 'Manage Import', 'woo-import-export' ); ?></label>
                                                                        </div>
                                                                        <div class="wpie_import_cap_container">
                                                                                <input type="checkbox" class="wpie_checkbox wpie_settings wpie_user_cap" wpie_user_cap id="wpie_cap_settings" name="wpie_cap_settings" value="1"/>
                                                                                <label for="wpie_cap_settings" class="wpie_checkbox_label"><?php esc_html_e( 'Settings', 'woo-import-export' ); ?></label>
                                                                        </div>
                                                                        <div class="wpie_import_cap_container">
                                                                                <input type="checkbox" class="wpie_checkbox wpie_extensions wpie_user_cap" id="wpie_cap_ext" name="wpie_cap_ext" value="1"/>
                                                                                <label for="wpie_cap_ext" class="wpie_checkbox_label"><?php esc_html_e( 'Manage Extensions', 'woo-import-export' ); ?></label>
                                                                        </div>
                                                                        <div class="wpie_import_cap_container">
                                                                                <input type="checkbox" class="wpie_checkbox wpie_add_shortcode wpie_user_cap" id="wpie_cap_add_shortcode" name="wpie_cap_add_shortcode" value="1"/>
                                                                                <label for="wpie_cap_add_shortcode" class="wpie_checkbox_label"><?php esc_html_e( 'Add Shortcode', 'woo-import-export' ); ?></label>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </form>
                                                <div class="wpie_setting_element_btn">
                                                        <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_save_cap_btn">
                                                                <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Save', 'woo-import-export' ); ?>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                <?php } ?>
                <div class="wpie_section_wrapper">
                        <div class="wpie_content_data_header">
                                <div class="wpie_content_title"><?php esc_html_e( 'Advance Options', 'woo-import-export' ); ?></div>
                                <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                        </div>
                        <div class="wpie_section_content">
                                <div class="wpie_setting_element_wrapper">
                                        <div class="wpie_import_cap_container">
                                                <input type="checkbox" class="wpie_checkbox wpie_delete_data_on_unistall" <?php if ( $delete_on_uninstall == 1 ) { ?>checked="checked"<?php } ?> id="wpie_delete_data_on_unistall" name="wpie_delete_data_on_unistall" value="1"/>
                                                <label for="wpie_delete_data_on_unistall" class="wpie_checkbox_label"><?php esc_html_e( 'Delete All Data on plugin uninstall', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_setting_element_btn">
                                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_advanced_options_save">
                                                        <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Save', 'woo-import-export' ); ?>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
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
<?php
unset( $user_roles, $delete_on_uninstall, $templates );
