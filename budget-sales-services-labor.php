<?php
/**
 * Plugin Name: Budget Sales Services Labor
 * Plugin URI: https://profiles.wordpress.org/carlosramosweb
 * Author: carlosramosweb
 * Author URI: http://plugins.criacaocriativa.com
 * Donate link: https://donate.criacaocriativa.com
 * Description: Customized budget form system for the customer. [budget_sales_services_labor]
 * Text Domain: budget-sales-services-labor
 * Domain Path: /languages/
 * Version: 3.0.0
 * Requires PHP: 7.2
 * Tested up to: 5.8.1
 * Requires: 4.6 or higher
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html 
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

date_default_timezone_set( 'America/Sao_Paulo' );

class Budget_Sales_Services_Labor {     

    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init_functions' ) );
        register_activation_hook( __FILE__, array( $this, 'activate_plugin' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate_plugin' ) );
    }
    //=>

    public function init_functions() { 
        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links_settings' ) );
        add_action( 'admin_menu', array( $this, 'register_admin_menu_page' ), 10, 2 );
        add_action( 'init', array( $this, 'create_posttype_budget' ) );
        add_action( 'init', array( $this, 'create_posttype_request_budget' ) );   
        add_action( 'add_meta_boxes', array( $this, 'add_post_box_budget_shortcode' ) );  
        add_shortcode( 'budget_sales_services_labor', array( $this, 'shortcode_form_html' ) );   
        //add_action( 'init', array( $this, 'create_budget_types_services_taxonomy' ), 0 );
        add_action( 'admin_head', array( $this, 'remove_postbox_budget_types_services_taxonomy' ), 0 );
        add_action( 'init', array( $this, 'require_plugin_acf' ), 0 );
        add_action( 'init', array( $this, 'require_fields_plugin_acf' ), 0 );
        add_action( 'admin_init', array( $this, 'remove_menu_plugin_acf' ), 0 );
        add_filter( 'wp_mail_content_type', array( $this, 'set_budget_mail_content_type' ) );        
    }
    //=>

    public function activate_plugin() {
        update_option( 'Activated_Plugin', 'budget-sales-services-labor', 'yes' );
        if ( is_admin() && get_option( 'Activated_Plugin' ) == 'budget-sales-services-labor' ) {
            $wc_settings                    = array();
            $wc_settings                    = get_option( 'settings_budget_sales_services_labor' ); 
            $settings                       = array();
            $settings['_enabled']           = isset( $wc_settings['_enabled'] ) ? $wc_settings['_enabled'] : 'yes'; 
            $settings['_enabled_hide_acf']  = isset( $wc_settings['_enabled_hide_acf'] ) ? $wc_settings['_enabled_hide_acf'] : 'yes';
            update_option( "settings_budget_sales_services_labor", $settings, 'yes' );
        }
    }
    //=>

    public function deactivate_plugin() { 
        //delete_option( "settings_budget_sales_services_labor" );
    }
    //=>

    public function plugin_action_links_settings( $links ) { 
        $settings_url   = admin_url( 'admin.php?page=settings-budget-sales-services-labor' );
        $settings_text  = 'Configurações';
        $action_links   = array(
            'settings'  => '<a href="' . esc_url( $settings_url ) . '" title="'. $settings_text .'" class="error">'. $settings_text .'</a>',
        );  
        return array_merge( $action_links, $links );
    }
    //=>

    public function register_admin_menu_page() {
        add_submenu_page(
            'edit.php?post_type=budget',
            'Budget Sales Services Labor',
            'Configurações',
            'manage_options',
            'settings-budget-sales-services-labor',
            array( $this, 'register_settings_page_admin_callback' )
        );
    }
    //=>

    public function create_posttype_budget() {     
        register_post_type( 'budget',
            array(
                'labels'            => array(
                    'name'          => 'Formulários',
                    'singular_name' => 'Formulário',
                ),
                'public'            => true,
                'has_archive'       => true,
                'rewrite'           => array( 'slug' => 'budget' ),
                'show_in_rest'      => true,   
            )
        );
    }
    //=>

    public function create_posttype_request_budget() {     
        register_post_type( 'request_budget',
            array(
                'labels'            => array(
                    'name'          => 'Lista Pré-Orçamentos',
                    'singular_name' => 'Pré-Orçamento',
                ),
                'public'            => true,
                'has_archive'       => true,
                'rewrite'           => array( 'slug' => 'request/budget' ),
                'show_in_rest'      => true,
                'show_in_menu'      => 'edit.php?post_type=budget'     
            )
        );
    }
    //=>

    public function add_post_box_budget_shortcode() {
        $screens = [ 'post', 'budget' ];
        foreach ( $screens as $screen ) {
            add_meta_box(
                'budget_box_id',
                'Shortcode',
                array( $this, 'post_box_budget_shortcode_callback' ),
                $screen,
                'side'
            );
        }
    }
    //=>

    public function post_box_budget_shortcode_callback( $post ) { ?>
        <div class="acf-label">
            <label for="acf-field_614ef0ef52f17">
                Copie e cole no corpo da página que deseja exibir o formulário.
            </label>
        </div><br/>
        <div class="acf-input">
            <strong>[budget_sales_services_labor id='<?php echo $post->ID; ?>']</strong>
        </div>
        <?php
    }
    //=>

    public function shortcode_form_html( $atts ) {
        $settings = array();
        $settings = get_option( 'settings_budget_sales_services_labor' );
        if ( isset( $settings['_enabled'] ) && $settings['_enabled'] == 'yes' ) {
            include_once( plugin_dir_path( __FILE__ ) . 'inc/budget-form-html.php' );
        } else {
            $alert = '<div class="alert alert-warning" role="alert" style="font-size: 13px; font-weight: bold; line-height: 1.5; text-align: left; box-sizing: border-box; position: relative; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem; color: #856404; background-color: #fff3cd; border-color: #ffeeba; margin-top: 1rem;">Caro, Administrador. <strong>Habilite o plugin</strong> para exibir os formulários de Pré-Orçamento.</div>';
            echo $alert;
        }
    }
    //=>

    public function create_budget_types_services_taxonomy() {
        $args = array(
            'public'            => false,
            'label'             => 'Tipos de Serviços',
            'hierarchical'      => false,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => false,
            'rewrite'           => false,
        );     
        register_taxonomy( 'types_services', 'budget', $args );
    }
    //=>     

    public function remove_postbox_budget_types_services_taxonomy() {
        remove_meta_box( 'tagsdiv-types_services' , 'budget' , 'side' ); 
    }
    //=>

    public function require_fields_plugin_acf() {
        include_once( plugin_dir_path( __FILE__ ) . 'inc/acf-budget-calculation.php' );
        include_once( plugin_dir_path( __FILE__ ) . 'inc/acf-budget-details.php' );
        //include_once( plugin_dir_path( __FILE__ ) . 'inc/acf-budget-fields.php' );
        include_once( plugin_dir_path( __FILE__ ) . 'inc/acf-email-fields.php' );
        include_once( plugin_dir_path( __FILE__ ) . 'inc/acf-form-details.php' );
        include_once( plugin_dir_path( __FILE__ ) . 'inc/acf-items-services.php' );
        include_once( plugin_dir_path( __FILE__ ) . 'inc/acf-registration-fields.php' );
        include_once( plugin_dir_path( __FILE__ ) . 'inc/acf-subtitles-registration-form.php' );
        include_once( plugin_dir_path( __FILE__ ) . 'inc/acf-system-messages.php' );
    }
    //=>

    public function require_plugin_acf() {
        require_once( plugin_dir_path( __FILE__ ) . 'libraries/advanced-custom-fields/acf.php' );
        require_once( plugin_dir_path( __FILE__ ) . 'libraries/acf-repeater/acf-repeater.php' );
    }
    //=>

    public function remove_menu_plugin_acf(){  
        $get_settings = array();
        $get_settings = get_option( 'settings_budget_sales_services_labor' ); 
        if ( isset( $get_settings['_enabled'] ) && $get_settings['_enabled'] == 'yes' ) {
            if ( isset( $get_settings['_enabled_hide_acf'] ) && $get_settings['_enabled_hide_acf'] == 'yes' ) {
                remove_menu_page( 'edit.php?post_type=acf-field-group' );
                remove_menu_page( 'post-new.php?post_type=acf-field-group' );
                remove_menu_page( 'edit.php?post_type=acf-field-group&page=acf-tools' );
            }
        }
    }
    //=>

public function check_send_form_fields( $post_fields, $file_fields ) {
    if ( isset( $post_fields ) && ! empty( $post_fields ) && isset( $post_fields['_wpnonce'] ) ) {
        $wpnonce = sanitize_text_field( $post_fields['_wpnonce'] );
        if ( ! wp_verify_nonce( $wpnonce, "budget-submit-form-data" ) ) {
            return false;
        }
        $budget_id = $this->save_budget_form( $post_fields, $file_fields );
        $this->send_mail_budget_form( $post_fields, $file_fields, $budget_id );
        return true;
    } else {
        return false;
    }
}
    //=>

public function set_budget_mail_content_type(){
    return "text/html";
}
    //=>

public function send_mail_budget_form( $post_fields, $file_fields, $budget_id ){
    if ( isset( $post_fields ) ) {
        global $post, $wp;

        $site_url           = get_site_url();
        $site_title         = get_bloginfo( 'name' );
        $site_description   = get_bloginfo( 'description' );
        $admin_email        = get_bloginfo( 'admin_email' );
        $post_id            = sanitize_text_field( $post_fields['post_id'] );
        $user_email         = '';

        if ( isset( $post_fields['registration'] ) ) {
            if ( isset( $post_fields['registration']['user_email'] ) ) {
                if ( is_email( $post_fields['registration']['user_email'] ) ) {                    
                    $user_email = sanitize_email( $post_fields['registration']['user_email'] );
                }
            }
        }

        if ( ! empty( $post_id ) && ! empty( $user_email ) ) {

            ob_start();
            $body  =  ob_get_clean();

                //$to         = 'carlosramosweb32@gmail.com';
            $to         = '' . $user_email . '';
            $subject    = 'Pré-Orçamento ' . $site_title . ' - Website';

                //$body  = '';
            $body .= '<!DOCTYPE html>';
            $body .= '<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">';
            $body .= '<head>';
            $body .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
            $body .= '<title>Newsletter | COMUNICA RH</title>';
            $body .= '</head>';
            $body .= '<body style="margin: 0 !important; padding: 0 !important;">';

            $admin_subject = get_field( 'email_subject', $post_id );
            if( ! empty( $admin_subject ) ) {
                $subject  = $admin_subject;
            }

            $admin_welcome = get_field( 'text_welcome', $post_id );
            if( ! empty( $admin_welcome ) ) {
            $body .= $admin_subject . '<br/>';
            $body .= $admin_welcome . '<br/>';
        } else {
            $body .= '<strong>Pré-Orçamento ' . $site_title . ' - Website</strong><br/>';
            $body .= '<i>' . $site_title . ' - ' . $site_description . '</i><br/>'; 
        }

        $header_image = get_field( 'header_image', $post_id );
        if( isset( $header_image ) && ! empty( $header_image ) ) {
            $body .= '<img src="' . $header_image . '" data-imagetype="External" width="700" height="" border="0" alt="Imagem do cabeçalho" style="clear:both; display:block; height:auto; max-width:700px; outline:none; text-decoration:none; width:100%">';
        }                

        $rfchoices  = get_field_object( 'registration_fields', $post_id );
        if ( isset( $post_fields['registration'] ) ) {
            $body .= '<br/>';
            $body .= '<p><strong>Dados do Cliente</strong></p>';
            $body .= '<table class="budget-table" style="border: 1px solid #666; padding:5px; width: 100%;"><tbody>';
            foreach ( $post_fields['registration'] as $key => $field ) {
                foreach ( $rfchoices['choices'] as $_key => $_field ) {
                    if ( $key == $_key ) { 
                    $body .= '<tr>';
                    $body .= '<td style="width: 20%; text-align: left; border: 1px solid #666; padding:5px;"><strong>' . $_field . '</strong></td>';
                    $body .= '<td style="text-align: left; border: 1px solid #666; padding:5px;"><strong>' . $field . '</strong></td>'; 
                    $body .= '</tr>';
                }
            }                    
        }
        $body .= '</tbody></table>';
    } 


    if ( isset( $post_fields['services'] ) && $post_fields['services'][0]['subtotal'] > 0 ) {
        $body .= '<br/>';
        $body .= '<p><strong>Serviços</strong></p>';
        $body .= '<table class="budget-table" style="border: 1px solid #666; padding:5px; width: 100%;"><thead><tr>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:left;"><strong>Name</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Quantidade</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Unid. de Medida</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Observação</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Taxa Saída</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Valor Fixo</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Subtotal</strong></th>';
        $body .= '</tr></thead><tbody>';
        foreach ( $post_fields['services'] as $key => $field ) {
            $body .= '<tr>';
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:left;">' . $field['name'] . '</td>';
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:center;">' . $field['quantity'] . '</td>';
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:center;">' . $field['measurement'] . '</td>';
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:center;">' . $field['recurrence'] . '</td>';
            $exit_fee = 0;
            if ( isset( $field['exit_fee'] ) ) {
                $exit_fee = $field['exit_fee'];
            }
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:center;">' . $exit_fee . '</td>';
            $fixed_price = 0;
            if ( isset( $field['fixed_price'] ) ) {
                $fixed_price = $field['fixed_price'];
            }
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:center;">' . $fixed_price . '</td>';
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align: right; ">R$ ' . $field['subtotal'] . '</td>';
            $body .= '</tr>';
        }
        $body .= '<tr><td colspan="7" style="text-align: right; border: 1px solid #666; padding:5px;"><strong>Subtotal</strong>: ';
        $body .= 'R$ ' . $post_fields['budget_services_subtotal'] . '</td></tr>';
        $body .= '</tbody></table>';
    }

    if ( isset( $post_fields['works'] ) && $post_fields['works'][0]['subtotal'] > 0 ) {
        $body .= '<br/>';
        $body .= '<p><strong>Postos</strong></p>';
        $body .= '<table class="budget-table" style="border: 1px solid #666; padding:5px; width: 100%;"><thead><tr>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:left;"><strong>Name</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Quantidade</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Horas Trab.</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Observação</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Período</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Taxa Saída</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Valor Fixo</strong></th>';
        $body .= '<th style="border: 1px solid #666; padding:5px; text-align:center;"><strong>Subtotal</strong></th>';
        $body .= '</tr></thead><tbody>';
        foreach ( $post_fields['works'] as $key => $field ) {
            $body .= '<tr>';
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:left;">' . $field['name'] . '</td>';
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:center;">' . $field['quantity'] . '</td>';
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:center;">' . $field['hours'] . '</td>';
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:center;">' . $field['recurrence'] . '</td>';
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:center;">' . $field['period'] . '</td>';
            $exit_fee = 0;
            if ( isset( $field['exit_fee'] ) ) {
                $exit_fee = $field['exit_fee'];
            }
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:center;">' . $exit_fee . '</td>';
            $fixed_price = 0;
            if ( isset( $field['fixed_price'] ) ) {
                $fixed_price = $field['fixed_price'];
            }
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:center;">' . $fixed_price . '</td>';
            $body .= '<td style="border: 1px solid #666; padding:5px; text-align:right;">R$ ' . $field['subtotal'] . '</td>';
            $body .= '</tr>';
        }
        $body .= '<tr><td colspan="8" style="text-align: right; border: 1px solid #666; padding:5px;"><strong>Subtotal</strong>: ';
        $body .= 'R$ ' . $post_fields['budget_works_subtotal'] . '</td></tr>';
        $body .= '</tbody></table>';
    }

    $body .= '<br/>';
    $budget_notice = get_field( 'budget_notice', $post_id );
    if( empty( $budget_notice ) ) {
        $budget_notice  = acf_get_field( 'budget_notice' )['default_value'];
    }
    if ( $budget_notice ) { 
    $body .= '<div class="alert alert-warning" role="alert" style="font-size: 13px; font-weight: bold; line-height: 1.5; text-align: left; box-sizing: border-box; position: relative; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem; color: #856404; background-color: #fff3cd; border-color: #ffeeba; margin-top: 1rem;">';
    $body .= esc_html( $budget_notice );
    $body .= '</div>';
}

$body .= '<table class="budget-table" style="border: 1px solid #666; padding:5px; width: 100%;"><thead><tr>';
$body .= '<th colspan="2" style="border: 1px solid #666; padding:5px;">Abaixo segue seu pré-orçamento com o valor total.</th>';
$body .= '</tr></thead><tbody>';
$budget_services_subtotal = 0;
if ( isset( $post_fields['budget_services_subtotal'] ) ) {
    $budget_services_subtotal = $post_fields['budget_services_subtotal'];
}
$body .= '<tr><td style="text-align: right; border: 1px solid #666; padding:5px;">Total em Serviços</td>';
$body .= '<td style="text-align: right; width: 15%; border: 1px solid #666; padding:5px;">R$ ' . $budget_services_subtotal . '</td></tr>';
$budget_works_subtotal = 0;
if ( isset( $post_fields['budget_works_subtotal'] ) ) {
    $budget_works_subtotal = $post_fields['budget_works_subtotal'];
}
$body .= '<tr><td style="text-align: right; border: 1px solid #666; padding:5px;">Total em Postos de Trabalho</td>';
$body .= '<td style="text-align: right; width: 15%; border: 1px solid #666; padding:5px;">R$ ' . $budget_works_subtotal . '</td></tr>';
$body .= '<tr><td colspan="2" style="text-align: right; border: 1px solid #666; padding:5px;"><strong>Total</strong>: ';
$budget_total = 0;
if ( isset( $post_fields['budget_total'] ) ) {
    $budget_total = $post_fields['budget_total'];
}
$body .= 'R$ ' . $budget_total . '</td></tr>';
$body .= '</tbody></table>';

$body .= '<br/>';
$body .= '<p style="font-size: 11px;"><i>*Preçoes Sujeitos a alteração.</i></p>';

$body .= '<br/>';
$body .= '<p>Acesse o site,<br/> <a href="' . esc_url( $site_url ) . '" target="_blank">Site da ' . $site_title . '</a></p>';
$body .= '</body></html>';

$headers[]  = "From: " . $site_title . " <" . $admin_email . ">" . "\r\n"; 
$send_copy_email = get_field( 'send_copy_email', $post_id );
if( ! empty( $send_copy_email ) ) {
    $headers[] = "Cc:  <" . $send_copy_email . ">" . "\r\n";
}
$headers[]  = "MIME-Version: 1.0" . "\r\n";           
$headers[]  = "Content-Type: text/html; charset=utf-8" . "\r\n";

$send = false;
if( isset( $file_fields ) && ! empty( $file_fields ) ) {

                    $file_name  = $file_fields['name'];     // [name] => Profile.pdf
                    $file_type  = $file_fields['type'];     // [type] => application/pdf
                    $file_tmp   = $file_fields['tmp_name']; // [tmp_name] => /tmp/phpbCYzkS
                    $file_error = $file_fields['error'];    // [error] =>  0
                    $file_size  = $file_fields['size'];     // [size] => 55230

                    $description = 'Anexo do Pré-Orçamento Nº: ' . $budget_id;

                    if ( ! function_exists( 'wp_handle_upload' ) ) {
                        require_once( ABSPATH . 'wp-admin/includes/file.php' );
                    }
                    $upload_overrides = array( 'test_form' => false ); 
                    $movefile = wp_handle_upload( $file_fields, $upload_overrides );

                    if ( $movefile && ! isset( $movefile['error'] ) ) { 
                        $insert_id = wp_insert_attachment(
                            array(
                                'guid'          => $movefile['url'],
                                'post_title'    => sanitize_title( $file_name ),
                                'post_content'  => $description,
                                'post_mime_type' => $file_type,
                                'post_parent'    => $post_id,
                            ),
                            $movefile['file'],
                            0
                        );
                        update_post_meta( $budget_id, '_customer_information_client_attach', 'field_614f80ddf46c6' );
                        update_post_meta( $budget_id, 'customer_information_client_attach', $insert_id );
                    } else {
                        echo "Error.\n";
                        print_r( $movefile['error'] );
                    }

                    $attachments = str_replace( content_url(), '', $movefile['url'] );
                    $attachments = array( WP_CONTENT_DIR . $attachments );
                    $send        = wp_mail( $to, $subject, $body, $headers, $attachments );
                } else {
                    $send = wp_mail( $to, $subject, $body, $headers );
                }

                if ( $send ) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }    
        } else {
            return false;
        }
    }
    //=>

    public function save_budget_form( $post_fields, $file_fields ){
        if ( isset( $post_fields ) ) {
            global $post, $wp, $wpdb;

            $site_url           = get_site_url();
            $site_title         = get_bloginfo( 'name' );
            $site_description   = get_bloginfo( 'description' );
            $admin_email        = get_bloginfo( 'admin_email' );
            $post_id            = sanitize_text_field( $post_fields['post_id'] );
            $post_title         = sanitize_text_field( $post_fields['post_title'] );
            $user_name          = '';
            $user_email         = '';

            if ( isset( $post_fields['registration'] ) ) {
                if ( isset( $post_fields['registration']['user_email'] ) ) {
                    if ( is_email( $post_fields['registration']['user_email'] ) ) {                    
                        $user_email = sanitize_email( $post_fields['registration']['user_email'] );
                    }
                }
                if ( isset( $post_fields['registration']['user_name'] ) ) {                   
                    $user_name = $post_fields['registration']['user_name'];
                }
            }

            if ( ! empty( $post_id ) && ! empty( $user_email ) && ! empty( $user_name ) ) {
                $lastid     =  $wpdb->insert_id;
                $post_date  =  date( 'd/m/Y H:i:s' );
                $post_title = $user_name . ' | ' . $post_date . ' | ' . $post_title;
                $args       = array(
                    'post_title'      => wp_strip_all_tags( $post_title ),
                    'post_content'    => 'Pré-Orçamento ' . $site_title . ' - Website',
                    'post_status'     => 'publish',
                    'post_author'     => 1,
                    'post_type'       => 'request_budget',
                    'post_parent'     => $post_id,
                    'post_date'       => date( 'Y-m-d H:i:s', time() ),
                );                 
                $insert_id = wp_insert_post( $args );

                if ( $insert_id ) {

                    $rfchoices = get_field_object( 'field_614f7f1ba59c9' );
                    if ( isset( $post_fields['registration'] ) ) {
                        foreach ( $post_fields['registration'] as $key => $field ) {
                            foreach ( $rfchoices['sub_fields'] as $_key => $sub_field ) {
                                $sub_name = $sub_field['name'];
                                $sname    = str_replace( "client_", "", $sub_name );
                                $rfname   = str_replace( "user_", "", $key );
                                if ( $rfname == $sname ) { 
                                $field_name = 'customer_information_' . $sub_name;
                                update_post_meta( $insert_id, $field_name, $field );
                                update_post_meta( $insert_id, '_' . $field_name, 'field_614f7f1ba59c9' );
                            }
                        }                    
                    }
                } 

                if ( isset( $post_fields['services'] ) && $post_fields['services'][0]['subtotal'] > 0 ) {                        
                    $i = 0;
                    foreach ( $post_fields['services'] as $key => $field ) {
                        if ( isset( $field['name'] ) ) {

                            update_post_meta( $insert_id, '_items_services_' . $i . '_item_name', 'field_614f825afe019' );
                            update_post_meta( $insert_id, 'items_services_' . $i . '_item_name', $field['name'] ); 

                            update_post_meta( $insert_id, '_items_services_' . $i . '_item_quantity', 'field_614f825afe020' );
                            update_post_meta( $insert_id, 'items_services_' . $i . '_item_quantity', $field['quantity'] ); 

                            update_post_meta( $insert_id, '_items_services_' . $i . '_item_price', 'field_614f825afe021' );
                            update_post_meta( $insert_id, 'items_services_' . $i . '_item_price', $field['price'] ); 

                            update_post_meta( $insert_id, '_items_services_' . $i . '_item_recurrence', 'field_614f825afe022' );
                            update_post_meta( $insert_id, 'items_services_' . $i . '_item_recurrence', $field['recurrence'] ); 

                            update_post_meta( $insert_id, '_items_services_' . $i . '_item_measurement', 'field_614f825afe023' );
                            update_post_meta( $insert_id, 'items_services_' . $i . '_item_measurement', $field['measurement'] ); 

                            if ( isset( $field['exit_fee'] ) && $field['exit_fee'] > 0 ) {
                                update_post_meta( $insert_id, '_items_services_' . $i . '_item_exit_fee', 'field_614ee1b04a775' );
                                update_post_meta( $insert_id, 'items_services_' . $i . '_item_exit_fee', $field['exit_fee'] );
                            }
                            if ( isset( $field['fixed_price'] ) && $field['fixed_price'] > 0  ) {
                                update_post_meta( $insert_id, '_items_services_' . $i . '_item_fixed_price', 'field_614e70904a775' );
                                update_post_meta( $insert_id, 'items_services_' . $i . '_item_fixed_price', $field['fixed_price'] ); 
                            }

                            update_post_meta( $insert_id, '_items_services_' . $i . '_item_subtotal', 'field_614f825afe024' );
                            update_post_meta( $insert_id, 'items_services_' . $i . '_item_subtotal', $field['subtotal'] ); 
                        }   
                        $i++;                          
                    }
                    update_post_meta( $insert_id, '_items_services', 'field_614f81b118121' );
                    update_post_meta( $insert_id, 'items_services', $i );
                } 

                if ( isset( $post_fields['works'] ) && $post_fields['works'][0]['subtotal'] > 0 ) {
                    $i = 0;
                    foreach ( $post_fields['works'] as $key => $field ) {
                        if ( isset( $field['name'] ) ) {
                            update_post_meta( $insert_id, '_items_works_' . $i . '_item_name', 'field_614f82c0b4be9' );
                            update_post_meta( $insert_id, 'items_works_' . $i . '_item_name', $field['name'] ); 

                            update_post_meta( $insert_id, '_items_works_' . $i . '_item_quantity', 'field_614f82c0b4be1' );
                            update_post_meta( $insert_id, 'items_works_' . $i . '_item_quantity', $field['quantity'] ); 

                            update_post_meta( $insert_id, '_items_works_' . $i . '_item_hours', 'field_614fh2c0b4be1' );
                            update_post_meta( $insert_id, 'items_works_' . $i . '_item_hours', $field['hours'] ); 

                            update_post_meta( $insert_id, '_items_works_' . $i . '_item_price', 'field_614f82c0b4bea' );
                            update_post_meta( $insert_id, 'items_works_' . $i . '_item_price', $field['price'] ); 

                            update_post_meta( $insert_id, '_items_works_' . $i . '_item_recurrence', 'field_614f8221ce073' );
                            update_post_meta( $insert_id, 'items_works_' . $i . '_item_recurrence', $field['recurrence'] ); 

                            update_post_meta( $insert_id, '_items_works_' . $i . '_item_period', 'field_614f82c0b4be2' );
                            update_post_meta( $insert_id, 'items_works_' . $i . '_item_period', $field['period'] ); 

                            if ( isset( $field['exit_fee'] ) && $field['exit_fee'] > 0 ) {
                                update_post_meta( $insert_id, '_items_works_' . $i . '_item_exit_fee', 'field_314f6b8ef4653' );
                                update_post_meta( $insert_id, 'items_works_' . $i . '_item_exit_fee', $field['exit_fee'] );
                            }
                            if ( isset( $field['exit_fee'] ) && $field['exit_fee'] > 0 ) {
                                update_post_meta( $insert_id, '_items_works_' . $i . '_item_fixed_price', 'field_614f6e8ef4653' );
                                update_post_meta( $insert_id, 'items_works_' . $i . '_item_fixed_price', $field['fixed_price'] );
                            }

                            update_post_meta( $insert_id, '_items_works_' . $i . '_item_subtotal', 'field_614f82c0b4be4' );
                            update_post_meta( $insert_id, 'items_works_' . $i . '_item_subtotal', $field['subtotal'] ); 
                        }   
                        $i++;                          
                    }
                    update_post_meta( $insert_id, '_items_works', 'field_614f81b118121' );
                    update_post_meta( $insert_id, 'items_works', $i );
                } 

                $subtotal_services  = 0;
                $subtotal_works     = 0;
                $budget_total       = 0;
                if( isset( $post_fields['budget_services_subtotal'] ) ) {
                    $subtotal_services = $post_fields['budget_services_subtotal'];
                }
                if( isset( $post_fields['budget_works_subtotal'] ) ) {
                    $subtotal_works = $post_fields['budget_works_subtotal'];
                }
                if( isset( $post_fields['budget_total'] ) ) {
                    $budget_total = $post_fields['budget_total'];
                }

                update_post_meta( $insert_id, '_status', 'field_614f7dbdf3ff2' );
                update_post_meta( $insert_id, 'status', 'processing' );

                update_post_meta( $insert_id, '_subtotal_services', 'field_614f84cbc5542' );
                update_post_meta( $insert_id, 'subtotal_services', $subtotal_services );

                update_post_meta( $insert_id, '_subtotal_works', 'field_614f84cbc5545' );
                update_post_meta( $insert_id, 'subtotal_works', $subtotal_works );

                update_post_meta( $insert_id, '_total_budget', 'field_614f84d6c5543' );
                update_post_meta( $insert_id, 'total_budget', $budget_total );

                return $insert_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}
    //=>

public function register_settings_page_admin_callback() {
    global $wpdb;
    $message    = "";

    if( isset( $_POST['_update'] ) && isset( $_POST['_wpnonce'] ) ) {
        $_update = sanitize_text_field( $_POST['_update'] );
        $_wpnonce = sanitize_text_field( $_POST['_wpnonce'] );

        if( isset( $_wpnonce ) && isset( $_update ) ) {
            if ( ! wp_verify_nonce( $_wpnonce, "settings-budget-sales-services-labor" ) ) {
                $message = "error"; 
            } else {
                $post_settings = array();
                $post_settings = (array)$_POST;

                $new_settings['_enabled']           = isset( $post_settings['_enabled'] ) ? $post_settings['_enabled'] : ''; 
                $new_settings['_page_tutorial']     = isset( $post_settings['_page_tutorial'] ) ? $post_settings['_page_tutorial'] : '';
                $new_settings['_enabled_hide_acf']  = isset( $post_settings['_enabled_hide_acf'] ) ? $post_settings['_enabled_hide_acf'] : 'yes';

                $settings = array();
                $settings = get_option( 'settings_budget_sales_services_labor' );
                update_option( "settings_budget_sales_services_labor", array_merge( $settings, $new_settings ) );

                $message = "updated";
            }
        }
    }
    $get_settings = get_option( 'settings_budget_sales_services_labor' );
    ?>

    <div id="wpwrap">

        <h1>Configurações</h1>
        <p>Defina algumas configurações para este plugin.<p/> 

            <?php if( isset( $message ) ) { ?>
                <div class="wrap">    
                    <?php if( $message == "updated" ) { ?>
                        <div id="message" class="updated notice is-dismissible" style="margin-left: 0px;">
                            <p>Sucesso! Os dados foram atualizados com sucesso!</p>
                            <button type="button" class="notice-dismiss">
                                <span class="screen-reader-text">
                                    Ignore este aviso.
                                </span>
                            </button>
                        </div>
                    <?php } ?>    
                    <?php if( $message == "error" ) { ?>
                    <div id="message" class="updated error is-dismissible" style="margin-left: 0px;">
                        <p>Erro! Não foi possível fazer atualizações!</p>
                        <button type="button" class="notice-dismiss">
                            <span class="screen-reader-text">
                                Ignore este aviso.
                            </span>
                        </button>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="wrap woocommerce">
        <!--nav-wrapper-->
        <?php
        if( isset( $_GET['tab'] ) ) {
            $tab = esc_attr( $_GET['tab'] );
        }
        $admin_url =  admin_url( 'admin.php?page=settings-budget-sales-services-labor' );
        ?>
        <nav class="nav-tab-wrapper wc-nav-tab-wrapper">
            <a href="<?php echo esc_url( $admin_url ); ?>" class="nav-tab <?php if( empty( $tab ) ) { echo "nav-tab-active"; }; ?>">
                Configurações
            </a>
            <a href="<?php echo esc_url( $admin_url . '&tab=reports' ); ?>" class="nav-tab <?php if( $tab == "reports" ) { echo "nav-tab-active"; }; ?>">
                Relatórios
            </a>
            <a href="<?php echo esc_url( $admin_url . '&tab=tutorial' ); ?>" class="nav-tab <?php if( $tab == "tutorial" ) { echo "nav-tab-active"; }; ?>">
                Tutorial
            </a>
        </nav>

        <?php if( ! isset( $tab ) ) { ?>
            <!--form-->
            <form method="POST" id="mainform" name="mainform">
                <!--standard-->
                <table class="form-table">
                    <tbody>
                        <!---->
                        <tr valign="top">
                            <th scope="row">
                                <label>
                                Habilitar Plugin
                            </label>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" name="_enabled" value="yes" <?php if( esc_attr( $get_settings['_enabled'] ) == "yes" ) { echo 'checked="checked"'; } ?>>
                                <span>Sim</span>
                            </label>
                        </td>
                    </tr>  
                            <!----
                            <tr valign="top">
                                <th scope="row">
                                    <label>
                                        Habilitar Página Tutorial
                                    </label>
                                </th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="_enabled_tutorial" value="yes" <?php //if( esc_attr( $get_settings['_enabled_tutorial'] ) == "yes" ) { echo 'checked="checked"'; } ?>>
                                        <span>Sim</span>
                                    </label>
                                </td>
                            </tr>
                        -->
                        <!---->
                        <tr valign="top">
                            <th scope="row">
                                <label>
                                Página de Tutorial
                            </label>
                        </th>
                        <td>                                
                        <label>
                            <select name="_page_tutorial">
                                <option value="">
                                    Selecione uma página
                                </option> 
                                <?php 
                                $pages = get_pages(
                                    array(  
                                        'post_status' => 'publish,private'
                                    )
                                );
                                foreach ( $pages as $page ) {
                                    $selected = ''; 
                                    if( esc_attr( $get_settings['_page_tutorial'] ) == $page->ID ) { 
                                        $selected = 'selected="selected"'; 
                                    } 
                                    $option = '<option value="' . esc_attr( $page->ID ) . '" ' . $selected . '>';
                                    $option .= $page->post_title;
                                    $option .= '</option>';
                                    echo $option;
                                }
                                ?>
                            </select>
                        </label>
                    </td>
                </tr>  
                <!---->
            </tbody>
        </table>
        <!---->
        <hr/>
        <div class="submit">
            <button class="button-primary" type="submit">
                Salvar Alterações
            </button>
            <input type="hidden" name="_update" value="yes">
            <input type="hidden" name="_wpnonce" value="<?php echo esc_attr( wp_create_nonce( 'settings-budget-sales-services-labor' ) ); ?>">
        </div>
        <!---->  
    </form>
<?php } else if( isset( $tab ) && $tab == 'reports' ) { ?>

    <?php                    
    $filter_start   = date( 'Y-m-d', strtotime( '-1 month' ) );
    $filter_end     = date( 'Y-m-d' );
    if ( isset( $_POST['filter_start'] ) && isset( $_POST['filter_end'] ) ) {
        $filter_start   = $_POST['filter_start'];
        $filter_end     = $_POST['filter_end'];
    }

    $start  = explode( '-', $filter_start );
    $end    = explode( '-', $filter_end );

    $year_start     = $start['0'];
    $month_start    = $start['1'];
    $day_start      = $start['2'];

    $year_end       = $end['0'];
    $month_end      = $end['1'];
    $day_end        = $end['2'];
    ?>
    <div class="alignleft actions" style="margin-top: 20px; margin-bottom: 20px;">
        <form method="post" action="<?php echo esc_url( $admin_url . '&tab=reports' ); ?>">
            <label for="filter-by-date" class="screen-reader-text">Filtrar por data</label>
            <span class="filter-actions">
                Desde: 
                <input type="date" name="filter_start" value="<?php echo esc_attr( $filter_start ); ?>"> 
            </span>
            <span class="filter-actions">
                Até: 
                <input type="date" name="filter_end" value="<?php echo esc_attr( $filter_end ); ?>">
            </span> 
        </select>
        <input type="hidden" name="_wpnonce" value="<?php echo esc_attr( wp_create_nonce( 'filter-by-date-budget-sales-services-labor' ) ); ?>">
        <input type="submit" class="button action-button" value="Filtrar">
    </div>

    <!--standard-->
    <table class="form-table" style="margin-top: 20px;">
        <thead>
            <tr valign="center" style="background: #dcdcde;">
            <th style="border: 1px solid #999; padding: 15px 10px; text-align: center; width: 8%;">
                ID
            </th>
            <th style="border: 1px solid #999; padding: 15px 10px; text-align: left; width: 38%;">
                Formulário Orçado
            </th>
            <th style="border: 1px solid #999; padding: 15px 10px; text-align: center; width: 13.5%; background: #dae1f2;">
                Processando
            </th>
            <th style="border: 1px solid #999; padding: 15px 10px; text-align: center; width: 13.5%; background: #fae9c7;">
                Aguardando
            </th>
            <th style="border: 1px solid #999; padding: 15px 10px; text-align: center; width: 13.5%; background: #e2efdc;">
                Concluído
            </th>
            <th style="border: 1px solid #999; padding: 15px 10px; text-align: center; width: 13.5%; background: #fee5db;">
                Cancelado
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $processing_total   = '0'; 
        $onhold_total       = '0';
        $concluded_total    = '0';
        $cancelled_total    = '0';

        $budget = get_posts(
            array(
                'numberposts'   => -1,
                'post_type'     => 'budget',
            )
        );

        if ( isset( $budget ) ) {
            foreach ( $budget as $key => $item ) { 
                $budget_id      = esc_attr( $item->ID );
                $budget_parent  = esc_attr( $item->post_parent );
                $budget_title   = esc_attr( $item->post_title );
                ?>
                <!---->
                <tr valign="top">
                    <td style="border: 1px solid #999; padding: 15px 10px; text-align: center;">
                        <?php echo $budget_id; ?>
                    </td>
                    <td style="border: 1px solid #999; padding: 15px 10px; text-align: left;">
                        <?php echo $budget_title; ?>                                
                    </td>
                    <td style="border: 1px solid #999; padding: 15px 10px; text-align: center; background: #dae1f2;">
                        <?php 
                        $processing = get_posts(
                            array(
                                'numberposts'   => -1,
                                'post_type'     => 'request_budget',
                                'post_parent'   => $budget_id,
                                'post_status'   => 'publish',
                                'meta_key'      => 'status',
                                'meta_value'    => 'processing',
                                'orderby'       => 'date',
                                'order'         => 'DESC',
                            )
                        );
                        if ( isset( $processing ) ) {
                            $count  = 0;
                            foreach ( $processing as $_key => $_item ) { 
                                $startDate  = date( 'Y-m-d', strtotime( $filter_start ) );
                                $endDate    = date( 'Y-m-d', strtotime( $filter_end ) );
                                $currentDate  = date( 'Y-m-d', strtotime( $_item->post_date ) );
                                if ( ( $currentDate >= $startDate ) && ( $currentDate <= $endDate ) ){
                                    $postmeta = get_post_meta( $_item->ID );
                                    $processing_total += $postmeta['total_budget']['0'];                                        
                                    $count++;
                                }
                            }
                            echo $count;
                        } else {
                            echo 0;
                        }
                        ?>
                    </td>
                    <td style="border: 1px solid #999; padding: 15px 10px; text-align: center; background: #fae9c7;">
                        <?php 
                        $onhold = get_posts(
                            array(
                                'numberposts'   => -1,
                                'post_type'     => 'request_budget',
                                'post_parent'   => $budget_id,
                                'post_status'   => 'publish',
                                'meta_key'      => 'status',
                                'meta_value'    => 'on-hold',
                                'orderby'       => 'date',
                                'order'         => 'DESC',
                            )
                        );
                        if ( isset( $onhold ) ) {
                            $count  = 0;
                            foreach ( $onhold as $_key => $_item ) { 
                                $startDate  = date( 'Y-m-d', strtotime( $filter_start ) );
                                $endDate    = date( 'Y-m-d', strtotime( $filter_end ) );
                                $currentDate  = date( 'Y-m-d', strtotime( $_item->post_date ) );
                                if ( ( $currentDate >= $startDate ) && ( $currentDate <= $endDate ) ){
                                    $postmeta = get_post_meta( $_item->ID );
                                    $onhold_total += $postmeta['total_budget']['0'];                                        
                                    $count++;
                                }
                            }
                            echo $count;
                        } else {
                            echo 0;
                        }
                        ?>
                    </td>
                    <td style="border: 1px solid #999; padding: 15px 10px; text-align: center; background: #e2efdc;">
                        <?php 
                        $concluded = get_posts(
                            array(
                                'numberposts'   => -1,
                                'post_type'     => 'request_budget',
                                'post_parent'   => $budget_id,
                                'post_status'   => 'publish',
                                'meta_key'      => 'status',
                                'meta_value'    => 'concluded',
                                'orderby'       => 'date',
                                'order'         => 'DESC',
                            )
                        );
                        if ( isset( $concluded ) ) {
                            $count  = 0;
                            foreach ( $concluded as $_key => $_item ) { 
                                $startDate  = date( 'Y-m-d', strtotime( $filter_start ) );
                                $endDate    = date( 'Y-m-d', strtotime( $filter_end ) );
                                $currentDate  = date( 'Y-m-d', strtotime( $_item->post_date ) );
                                if ( ( $currentDate >= $startDate ) && ( $currentDate <= $endDate ) ){
                                    $postmeta = get_post_meta( $_item->ID );
                                    $concluded_total += $postmeta['total_budget']['0'];                                        
                                    $count++;
                                }
                            }
                            echo $count;
                        } else {
                            echo 0;
                        }
                        ?>
                    </td>
                    <td style="border: 1px solid #999; padding: 15px 10px; text-align: center; background: #fee5db;">
                        <?php 
                        $cancelled = get_posts(
                            array(
                                'numberposts'   => -1,
                                'post_type'     => 'request_budget',
                                'post_parent'   => $budget_id,
                                'post_status'   => 'publish',
                                'meta_key'      => 'status',
                                'meta_value'    => 'cancelled',
                                'orderby'       => 'date',
                                'order'         => 'DESC',
                            )
                        );
                        if ( isset( $cancelled ) ) {
                            $count  = 0;
                            foreach ( $cancelled as $_key => $_item ) { 
                                $startDate  = date( 'Y-m-d', strtotime( $filter_start ) );
                                $endDate    = date( 'Y-m-d', strtotime( $filter_end ) );
                                $currentDate  = date( 'Y-m-d', strtotime( $_item->post_date ) );
                                if ( ( $currentDate >= $startDate ) && ( $currentDate <= $endDate ) ){
                                    $postmeta = get_post_meta( $_item->ID );
                                    $cancelled_total += $postmeta['total_budget']['0'];                                        
                                    $count++;
                                }
                            }
                            echo $count;
                        } else {
                            echo 0;
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
            <tr valign="center" style="background: #dcdcde;">
                <td colspan="2" style="border: 1px solid #999; padding: 15px 10px; text-align: right; text-transform: uppercase;">
                    <strong>Representação em Espécie</strong>
                </td>
                <td style="border: 1px solid #999; padding: 15px 10px; text-align: center; background: #dae1f2;"> 
                    <strong>
                        <?php if ( isset( $processing_total ) && $processing_total > 0 ) {
                            $ptotal = number_format( $processing_total, 2, ',', '' );
                            echo 'R$ ' . $ptotal;
                        } else {
                            echo 'R$ 0,00';
                        }?>
                    </strong>
                </td>
                <td style="border: 1px solid #999; padding: 15px 10px; text-align: center; background: #fae9c7;"> 
                    <strong>
                        <?php if ( isset( $onhold_total ) && $onhold_total > 0 ) {
                            $ohtotal = number_format( $onhold_total, 2, ',', '' );
                            echo 'R$ ' . $ohtotal;
                        } else {
                            echo 'R$ 0,00';
                        }?>
                    </strong>
                </td>
                <td style="border: 1px solid #999; padding: 15px 10px; text-align: center; background: #e2efdc;"> 
                    <strong>
                        <?php if ( isset( $concluded_total ) && $concluded_total > 0 ) {
                            $ctotal = number_format( $concluded_total, 2, ',', '' );
                            echo 'R$ ' . $ctotal;
                        } else {
                            echo 'R$ 0,00';
                        }?>
                    </strong>
                </td>
                <td style="border: 1px solid #999; padding: 15px 10px; text-align: center; background: #fee5db;"> 
                    <strong>
                        <?php if ( isset( $cancelled_total ) && $cancelled_total > 0 ) {
                            $cltotal = number_format( $cancelled_total, 2, ',', '' );
                            echo 'R$ ' . $cltotal;
                        } else {
                            echo 'R$ 0,00';
                        }?>
                    </strong>
                </td>
            </tr>
        <?php } ?>
        <!---->
    </tbody>
</table>
<style type="text/css">
    @media ( max-width: 780px ) {
        table tr {
            display: inline-grid !important;
            width: 100% !important;
        }
        table tr th,
        table tr td {
            display: inline-grid;
            width: auto !important;
            text-align: center !important;
        }
        .filter-actions, 
        .action-button {
            display: inline-grid !important;
            text-align: center !important;
            width: 100% !important;
            margin-bottom: 10px;
        }
        .filter-actions input, 
        .action-button input {
            text-align: center !important;
            width: 100% !important;
        }
    }
</style>
<?php } else if( isset( $tab ) && $tab == 'tutorial' ) {
    $page_id    = intval( $get_settings['_page_tutorial'] );
    $tutorial   = get_post( $page_id );  ?>
    <div style="margin-top: 20px;">
        <?php echo $tutorial->post_content; ?>
    </div>
<?php } ?>
<!---->
</div>
</div>            
<?php
}
    //=>

}
new Budget_Sales_Services_Labor();