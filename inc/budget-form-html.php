<?php

/**
 * Class and Function List:
 * Function list:
 * Classes list:
 */
if (!defined('ABSPATH')) {
    exit();
}

global $post, $wp;
$budget_form_url             = home_url(add_query_arg(array(), $wp->request));
$post_id                     = $atts['id'];

// acf subtitles registration form
$form_title                  = get_field('form_title', $post_id);
$form_subtitle               = get_field('form_subtitle', $post_id);
$subtitle_services           = get_field('subtitle_services', $post_id);
$title_attach                = get_field('title_attach', $post_id);
$title_button_submit         = get_field('title_button_submit', $post_id);

if (empty($form_title)) {
    $form_title                  = acf_get_field('form_title')['default_value'];
}
if (empty($form_subtitle)) {
    $form_subtitle               = acf_get_field('form_subtitle')['default_value'];
}
if (empty($subtitle_services)) {
    $subtitle_services           = acf_get_field('subtitle_services')['default_value'];
}
if (empty($title_attach)) {
    $title_attach                = acf_get_field('title_attach')['default_value'];
}
if (empty($title_button_submit)) {
    $title_button_submit         = acf_get_field('title_button_submit')['default_value'];
}

$services_measurement        = get_field('services_measurement', $post_id);
if (empty($services_measurement)) {
    $services_measurement        = acf_get_field('services_measurement')['default_value'];
}

$post_title                  = get_the_title();
/*
$new_registration_fields = get_field( 'new_registration_fields', $post_id );
if ( $new_registration_fields ) {

    foreach ( $new_registration_fields as $key => $item ) {
        $name_registration_fields     = $item['name_registration_fields'];
        // Endereço
        $type_registration_fields     = $item['type_registration_fields'];
        // text
        $required_registration_fields    = $item['required_registration_fields'];
        // yes
    }
}
*/

/*
if ( isset( $_POST ) && ! empty( $_POST ) ) {
    echo '<pre>';
    print_r( $_POST );
    echo '</pre>';
}
*/

$registration_fields         = get_field('registration_fields', $post_id);
$registration_fields_choices = get_field_object('registration_fields', $post_id);
$form_services               = get_field('form_services', $post_id);
$form_works                  = get_field('form_works', $post_id);

$services_exit_fee           = get_field('services_exit_fee', $post_id);
if (empty($services_exit_fee)) {
    $services_exit_fee           = acf_get_field('services_exit_fee')['default_value'];
}
$services_fixed_price        = get_field('services_fixed_price', $post_id);
if (empty($services_fixed_price)) {
    $services_fixed_price        = acf_get_field('services_fixed_price')['default_value'];
}

$works_exit_fee              = get_field('works_exit_fee', $post_id);
if (empty($works_exit_fee)) {
    $works_exit_fee              = acf_get_field('works_exit_fee')['default_value'];
}
$works_fixed_price           = get_field('works_fixed_price', $post_id);
if (empty($works_fixed_price)) {
    $works_fixed_price           = acf_get_field('works_fixed_price')['default_value'];
}

$post_fields                 = $_POST;
$file_fields                 = '';
if (isset($_FILES['user_document'])) {
    $file_fields                 = $_FILES['user_document'];
}
$enable_msg                  = $this->check_send_form_fields($post_fields, $file_fields);

if ($enable_msg) {
    $form_msg_title              = '';
    $form_msg                    = '';
    $error_message               = get_field('error_message', $post_id);
    if (empty($error_message)) {
        $form_msg_title              = 'Erro!';
        $form_msg                    = acf_get_field('error_message')['default_value'];
    } else {
        $form_msg_title              = 'Erro!';
        $form_msg                    = $error_message;
    }
    $success_message             = get_field('success_message', $post_id);
    if (empty($success_message)) {
        $form_msg_title              = 'Sucesso!';
        $form_msg                    = acf_get_field('success_message')['default_value'];
    } else {
        $form_msg_title              = 'Sucesso!';
        $form_msg                    = $success_message;
    }
}

$budget_notice               = get_field('budget_notice', $post_id);
if (empty($budget_notice)) {
    $budget_notice               = acf_get_field('budget_notice')['default_value'];
}
?>

<script type='text/javascript' async src='//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>

<div class='section_wrapper mcb-section-inner'>

    <?php if ($enable_msg) {
    ?>
        <div class='wrap mcb-wrap one valign-top clearfix' id='wrap-message-budget'>
            <div class='column mcb-column one column_column form-header column-margin-0px'>
                <div class='column_attr clearfix align_center mobile_align_center' style=''>
                    <h3 class='themecolor'><b><?php echo esc_attr($form_msg_title);
                                                ?></b></h3>
                    <h3 class='subtitle-form'><?php echo esc_attr($form_msg);
                                                ?></h3>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <?php if (!$enable_msg) {
    ?>
        <div class='wrap mcb-wrap one valign-top clearfix' id='wrap-form-budget' style=''>
            <div class='mcb-wrap-inner'>

                <div class='column mcb-column one column_column form-header column-margin-0px'>
                    <div class='column_attr clearfix align_center mobile_align_center' style=''>
                        <h3 class='themecolor'><b><?php echo esc_attr($form_title);
                                                    ?></b></h3>
                        <h3 class='subtitle-form'><?php echo esc_attr($form_subtitle);
                                                    ?></h3>
                    </div>
                </div>

                <div class='column mcb-column column_column form'>
                    <div class='column_attr clearfix align_center' style=''>
                        <div class='cf7sg-container cf7sg-not-grid'>
                            <div id='cf7sg-form-orcamento' class='key_orcamento'>
                                <div role='form' class='wpcf7' lang='pt-BR' dir='ltr'>

                                    <form action="<?php echo esc_url($budget_form_url); ?>" name='form-main-budget' method='post' class='wpcf7-form init' enctype='multipart/form-data'>

                                        <div class='form-orcamento'>

                                            <div class='form-registration-fields'>

                                                <?php //if (isset($item) && $item == 'user_name') { 
                                                ?>
                                                <div class='column one-second'>
                                                    <span class='wpcf7-form-control-wrap wrap_user_name'>
                                                        <input type='text' id='user_name' name='registration[user_name]' class='wpcf7-form-control wpcf7-text wpcf7-validates-as-required user_name' placeholder='Nome' required=''>
                                                    </span>
                                                </div>
                                                <?php //} 
                                                ?>
                                                <?php //if (isset($item) && $item == 'user_email') { 
                                                ?>
                                                <div class='column one-second'>
                                                    <span class='wpcf7-form-control-wrap wrap_user_email'>
                                                        <input type='email' id='user_email' name='registration[user_email]' class='wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email user_email' placeholder='E-mail' required=''>
                                                    </span>
                                                </div>
                                                <?php //} 
                                                ?>

                                                <?php if ($registration_fields) {

                                                    $fields_user_document = false;
                                                    foreach ($registration_fields as $key                  => $item) {
                                                ?>

                                                        <?php if (isset($item) && $item == 'user_cpf') {
                                                        ?>
                                                            <div class='column one-second'>
                                                                <span class='wpcf7-form-control-wrap wrap_user_cpf'>
                                                                    <input type='tel' id='user_cpf' name='registration[cpf]' class='wpcf7-form-control wpcf7-text wpcf7-tel wpcf7-validates-as-required wpcf7-validates-as-tel user_cpf' placeholder='CPF' required=''>
                                                                </span>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php if (isset($item) && $item == 'user_phone') {
                                                        ?>
                                                            <div class='column one-second'>
                                                                <span class='wpcf7-form-control-wrap wrap_user_phone'>
                                                                    <input type='tel' id='user_phone' name='registration[user_phone]' class='wpcf7-form-control wpcf7-text wpcf7-tel wpcf7-validates-as-required wpcf7-validates-as-tel user_phone' placeholder='Telefone' required=''>
                                                                </span>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php if (isset($item) && $item == 'user_whatsapp') {
                                                        ?>
                                                            <div class='column one-second'>
                                                                <span class='wpcf7-form-control-wrap wrap_user_whatsapp'>
                                                                    <input type='tel' id='user_whatsapp' name='registration[user_whatsapp]' class='wpcf7-form-control wpcf7-text wpcf7-tel wpcf7-validates-as-required wpcf7-validates-as-tel user_whatsapp' placeholder='WhatsApp' required=''>
                                                                </span>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php if (isset($item) && $item == 'user_company') {
                                                        ?>
                                                            <div class='column one-second'>
                                                                <span class='wpcf7-form-control-wrap wrap_user_company'>
                                                                    <input type='text' id='user_company' name='registration[user_company]' class='wpcf7-form-control wpcf7-text wpcf7-validates-as-required user_company' placeholder='Empresa ou Condomínio' required=''>
                                                                </span>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php if (isset($item) && $item == 'user_cnpj') {
                                                        ?>
                                                            <div class='column one-second'>
                                                                <span class='wpcf7-form-control-wrap wrap_user_cnpj'>
                                                                    <input type='tel' id='user_cnpj' name='registration[user_cnpj]' class='wpcf7-form-control wpcf7-text wpcf7-tel wpcf7-validates-as-required wpcf7-validates-as-tel user_cnpj' placeholder='CNPJ' required=''>
                                                                </span>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php if (isset($item) && $item == 'user_how_did') {
                                                        ?>
                                                            <div class='column one-second'>
                                                                <span class='wpcf7-form-control-wrap wrap_user_how_did'>
                                                                    <input type='text' id='user_how_did' name='registration[user_how_did]' class='wpcf7-form-control wpcf7-text wpcf7-validates-as-required user_how_did' placeholder='Como chegou até nós?' required=''>
                                                                </span>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>

                                                        <?php if (isset($item) && $item == 'user_document') {
                                                            $fields_user_document = true;
                                                        }
                                                        ?>

                                                    <?php
                                                    }
                                                    ?>
                                                    <div style='clear: both;'></div>
                                                    <div style='clear: both;' class='budget-fields-message'></div>
                                            </div>
                                        <?php
                                                }
                                        ?>

                                        <div class='column_attr clearfix' style='clear: both; width: 100%; display: block;margin: 30px 0;'>
                                            <h3 class='subtitle-form align_center mobile_align_center' style='text-align: center;'><?php echo esc_attr($subtitle_services);
                                                                                                                                    ?></h3>
                                        </div>

                                        <?php if ($form_services) {
                                        ?>

                                            <div id='budget-services-table' class='budget-services' style='border-top: 1px solid rgb(237, 237, 237); border-radius: 10px 10px 0px 0px; border-right: 1px solid rgb(237, 237, 237); border-left: 1px solid rgb(237, 237, 237); padding: 14px 10px 0; background-color: #f7f7f7;'>

                                                <div id='services-row-0' class='bubble-r-line budget-row' style='margin-bottom: 15px; border-bottom: 1px solid #55c59326;'>

                                                    <div class='column one-fifth column-field' style='width: 15%;text-align: left;'>

                                                        <label id='services-label-0' class='services-label label-title' style='text-align: center;' for=''>
                                                            Serviços/Produtos
                                                        </label>

                                                        <select name='services[0][name]' id='services-name-0' class='bubble-element Dropdown services-name' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252); box-sizing: border-box; z-index: 4; height: 45px; top: 0px; color: rgb(107, 107, 107); font-family: DM Sans; font-size: 14px; border-radius: 10px; width: 100%;' onchange='change_data_services( this )'>
                                                            <option class='dropdown-choice dropdown-placeholder' value='' style='color: rgb(107, 107, 107); display: none;'>Selecione</option>
                                                            <?php foreach ($form_services as $key => $item) {
                                                            ?>
                                                                <option class="<?php echo esc_attr($item['services_price']); ?>" value="<?php echo trim(esc_attr($item['services_name'])); ?>" style='color: rgb(107, 107, 107);'><?php echo trim(esc_attr($item['services_name']));
                                                                                                                                                                                                                                    ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <input type='hidden' id='services-measurement-0' name='services[0][measurement]' class='services-measurement' readonly value='M²'>
                                                    </div>

                                                    <div class='column one-fifth column-field' style='width: 15%;text-align: center;'>
                                                        <label class='services-label' style='text-align: center;' for=''>
                                                            Qtd.
                                                        </label>
                                                        <label for='services-quantity-0' class='label-for' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252);  box-sizing: border-box; z-index: 11; height: 45px; border-radius: 10px; font-family: DM Sans; font-size: 14px; color: rgb(107, 107, 107); padding: 0px 10px; width: 100%; padding-right: 35px;'>
                                                            <span>/Unid.</span>
                                                            <input type='number' id='services-quantity-0' name='services[0][quantity]' class='bubble-element input services-quantity' placeholder='Quantidade...' min='1' value='1' onchange='change_quantity_services( this )' style='border: 0; padding: 13px 5px; text-align: center;'>
                                                        </label>
                                                    </div>

                                                    <div class='column one-fifth column-field' style='width: 13%; text-align: center;'>
                                                        <label class='services-label' style='text-align: center;' for=''>Observação</label>
                                                        <input type='text' id='services-recurrence-0' name='services[0][recurrence]' class='bubble-element input services-recurrence' placeholder='Digite aqui...' min='0' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252);  box-sizing: border-box; height: 45px; border-radius: 10px; font-family: DM Sans; font-size: 14px; color: rgb(107, 107, 107); padding: 0px 10px; width: 100%;' value=''>

                                                        <input type='hidden' id='services-price-0' name='services[0][price]' class='services-price' min='0' readonly value='0'>
                                                    </div>

                                                    <div class='column one-fifth column-field field-exit-fee' style='display: none; width: 9%; text-align: center;'>
                                                        <label class='services-label' style='text-align: center; height: 40px; line-height: 1em;' for=''>
                                                            <?php echo esc_attr($services_exit_fee);
                                                            ?>
                                                        </label>

                                                        <input type='text' id='services-exit-fee-0' name='services[0][exit_fee]' class='bubble-element input services-exit-fee' placeholder='0,00' min='0' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252);  box-sizing: border-box; height: 45px; border-radius: 10px; font-family: DM Sans; font-size: 14px; color: rgb(107, 107, 107); padding: 0px 10px; width: 100%;' value='0' readonly=''>
                                                    </div>

                                                    <div class='column one-fifth column-field field-fixed-price' style='display: none; width: 8%; text-align: center;'>
                                                        <label class='services-label' style='text-align: center;' for=''>
                                                            <?php echo esc_attr($services_fixed_price);
                                                            ?>
                                                        </label>

                                                        <input type='text' id='services-fixed-price-0' name='services[0][fixed_price]' class='bubble-element input services-fixed-price' placeholder='0,00' min='0' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252);  box-sizing: border-box; height: 45px; border-radius: 10px; font-family: DM Sans; font-size: 14px; color: rgb(107, 107, 107); padding: 0px 10px; width: 100%;' value='0' readonly=''>
                                                    </div>

                                                    <div class='column one-fifth column-field' style='width: 12%;text-align: center;'>
                                                        <label class='services-label' style='text-align: center;' for=''>Subtotal</label>

                                                        <input type='number' id='services-subtotal-0' name='services[0][subtotal]' class='bubble-element input services-subtotal' placeholder='/uma vez' min='0' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252);  box-sizing: border-box; height: 45px; border-radius: 10px; font-family: DM Sans; font-size: 14px; color: rgb(107, 107, 107); padding: 0px 10px; width: 100%;' readonly value='0'>
                                                    </div>

                                                    <div class='column one-fifth acf-actions' style='width: 12%;text-align: center;'>

                                                        <label class='services-label' style='text-align: center;' for=''>Ação</label>

                                                        <input type='button' value='X' id='services-remove-button-0' class='services-button remove hidden' style='padding: 10px 15px !important; background: red !important; cursor: pointer;' onclick='remove_row_fields_services( this );'>

                                                        <input type='button' value='+' id='services-add-button-0' class='services-button add' style='padding: 10px 15px !important; background: #55c593 !important; cursor: pointer;' onclick='add_row_fields_services( this );'>
                                                    </div>

                                                    <div style='clear: both;'></div>
                                                </div>

                                            </div>

                                            <div style='clear: both;' class='budget-services-message'></div>

                                            <div id='budget-services-calculation' class='wrap mcb-wrap one valign-top clearfix' style='margin: 10px 0 15px;'>
                                                <div class='mcb-wrap-inner'>
                                                    <div class='column one-fifth' style='width: 80%;text-align: right;'>
                                                        <strong>SubTotal:</strong>
                                                    </div>
                                                    <div class='column one-fifth' style='width: 15%;text-align: left;'>
                                                        R$ <span class='services-total'>0, 00</span>
                                                    </div>
                                                    <input type='hidden' id='budget_services_subtotal' name='budget_services_subtotal' min='0' readonly value='0'>
                                                </div>
                                            </div>
                                            <div style='clear: both;'></div>

                                        <?php
                                        }
                                        ?>
                                        <!---->

                                        <?php if ($form_works) {
                                        ?>

                                            <div id='budget-works-table' class='budget-works' style='border-top: 1px solid rgb(237, 237, 237); border-radius: 10px 10px 0px 0px; border-right: 1px solid rgb(237, 237, 237); border-left: 1px solid rgb(237, 237, 237); padding: 14px 10px 0; background-color: #f7f7f7;'>

                                                <div id='works-row-0' class='bubble-r-line budget-row' style='margin-bottom: 13px; border-bottom: 1px solid #55c59326;'>

                                                    <div class='column one-fifth column-field' style='width: 12%;text-align: left;'>

                                                        <label class='works-label' style='text-align: center;' for=''>
                                                            Postos
                                                        </label>

                                                        <select name='works[0][name]' id='works-name-0' class='bubble-element Dropdown works-name' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252); box-sizing: border-box; z-index: 4; height: 45px; top: 0px; color: rgb(107, 107, 107); font-family: DM Sans; font-size: 14px; border-radius: 10px; width: 100%;' onchange='change_data_works( this )'>
                                                            <option class='dropdown-choice dropdown-placeholder' value='' style='color: rgb(107, 107, 107); display: none;'>Selecione</option>
                                                            <?php foreach ($form_works as $key => $item) {
                                                            ?>
                                                                <option class="<?php echo esc_attr($item['works_price']); ?>" value="<?php echo trim(esc_attr($item['works_name'])); ?>" style='color: rgb(107, 107, 107);'><?php echo trim(esc_attr($item['works_name']));
                                                                                                                                                                                                                            ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class='column one-fifth column-field' style='width: 10%;text-align: center;'>
                                                        <label class='works-label' style='text-align: center;' for=''>
                                                            Qtd.
                                                        </label>

                                                        <label for='works-quantity-0' class='label-for' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252);  box-sizing: border-box; z-index: 11; height: 45px; border-radius: 10px; font-family: DM Sans; font-size: 14px; color: rgb(107, 107, 107); padding: 0px 10px; width: 100%; padding-right: 35px;'>
                                                            <span style='margin-left: 10px;'>/Unid.</span>
                                                            <input type='number' id='works-quantity-0' name='works[0][quantity]' class='bubble-element input works-quantity' placeholder='Quantidade...' min='1' value='1' onchange='change_quantity_works( this )' style='border: 0; padding: 13px 5px; text-align: center;'>
                                                        </label>
                                                    </div>

                                                    <div class='column one-fifth column-field' style='width: 10%;text-align: center;'>
                                                        <label class='works-label' style='text-align: center;' for=''>
                                                            Horas Trab.
                                                        </label>

                                                        <label for='works-hours-0' class='label-for' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252);  box-sizing: border-box; z-index: 11; height: 45px; border-radius: 10px; font-family: DM Sans; font-size: 14px; color: rgb(107, 107, 107); padding: 0px 10px; width: 100%; padding-right: 35px;'>
                                                            <span style='margin-left: 10px;'>/Unid.</span>
                                                            <input type='number' id='works-hours-0' name='works[0][hours]' class='bubble-element input works-hours' placeholder='Quantidade...' min='1' value='1' onchange='change_hours_works( this )' style='border: 0; padding: 13px 5px; text-align: center;'>
                                                        </label>
                                                    </div>

                                                    <div class='column one-fifth column-field' style='width: 10%;text-align: center;'>
                                                        <label class='works-label' style='text-align: center;' for=''>
                                                            Observação
                                                        </label>

                                                        <select id='works-recurrence-0' name='works[0][recurrence]' class='bubble-element Dropdown works-recurrence' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252); box-sizing: border-box; z-index: 4; height: 45px; top: 0px; color: rgb(107, 107, 107); font-family: DM Sans; font-size: 14px; border-radius: 10px; width: 100%;'>
                                                            <option class='dropdown-choice dropdown-placeholder' value='' style='color: rgb(107, 107, 107); display: none;'>Selecione</option>
                                                            <option class='dropdown-choice' value='Vez Única' style='color: rgb(107, 107, 107);'>Vez Única</option>
                                                            <option class='dropdown-choice' value='Ocasional' style='color: rgb(107, 107, 107);'>Ocasional</option>
                                                            <option class='dropdown-choice' value='Tempo Indeterminado' style='color: rgb(107, 107, 107);'>Tempo Indeterminado</option>
                                                            <option class='dropdown-choice' value='Contrato Fixo' style='color: rgb(107, 107, 107);'>Contrato Fixo</option>
                                                        </select>

                                                        <input type='hidden' id='works-price-0' name='works[0][price]' class=' works-price' min='0' readonly value='0'>
                                                    </div>

                                                    <div class='column one-fifth column-field' style='width: 8%;text-align: center;'>
                                                        <label class='works-label' style='text-align: center;' for=''>
                                                            Período
                                                        </label>

                                                        <select id='works-period-0' name='works[0][period]' class='bubble-element Dropdown works-period' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252); box-sizing: border-box; z-index: 4; height: 45px; top: 0px; color: rgb(107, 107, 107); font-family: DM Sans; font-size: 14px; border-radius: 10px; width: 100%;' onchange='change_period_works( this )'>
                                                            <option class='dropdown-choice' value='Diurno' style='color: rgb(107, 107, 107);'>Diurno</option>
                                                            <option class='dropdown-choice' value='Noturno' style='color: rgb(107, 107, 107);'>Noturno</option>
                                                        </select>
                                                    </div>

                                                    <div class='column one-fifth column-field field-exit-fee' style='display: none; width: 9%; text-align: center;'>
                                                        <label class='works-label' style='text-align: center;' for=''>
                                                            <?php echo esc_attr($works_exit_fee);
                                                            ?>
                                                        </label>

                                                        <input type='text' id='works-exit-fee-0' name='works[0][exit_fee]' class='bubble-element input works-exit-fee' placeholder='0,00' min='0' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252);  box-sizing: border-box; height: 45px; border-radius: 10px; font-family: DM Sans; font-size: 14px; color: rgb(107, 107, 107); padding: 0px 10px; width: 100%;' value='0' readonly=''>
                                                    </div>

                                                    <div class='column one-fifth column-field field-fixed-price' style='display: none; width: 8%; text-align: center;'>
                                                        <label class='works-label' style='text-align: center;' for=''>
                                                            <?php echo esc_attr($works_fixed_price);
                                                            ?>
                                                        </label>

                                                        <input type='text' id='works-fixed-price-0' name='works[0][fixed_price]' class='bubble-element input works-fixed-price' placeholder='0,00' min='0' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252);  box-sizing: border-box; height: 45px; border-radius: 10px; font-family: DM Sans; font-size: 14px; color: rgb(107, 107, 107); padding: 0px 10px; width: 100%;' value='0' readonly=''>
                                                    </div>

                                                    <div class='column one-fifth column-field' style='width: 12%;text-align: center;'>
                                                        <label class='works-label' style='text-align: center;' for=''>
                                                            Subtotal
                                                        </label>

                                                        <input type='input' id='works-subtotal-0' name='works[0][subtotal]' class='bubble-element input works-subtotal' placeholder='/uma vez' min='0' style='text-align: center; border: 1px solid rgb(82, 196, 147); background-color: rgb(252, 252, 252);  box-sizing: border-box; height: 45px; border-radius: 10px; font-family: DM Sans; font-size: 14px; color: rgb(107, 107, 107); padding: 0px 10px; width: 100%;' readonly value='0'>
                                                    </div>

                                                    <div class='column one-fifth acf-actions' style='width: 12%;text-align: center;'>

                                                        <label class='works-label' style='text-align: center;' for=''>
                                                            Ação
                                                        </label>

                                                        <input type='button' value='X' id='works-remove-button-0' class='works-button remove hidden' style='padding: 10px 15px !important; background: red !important; cursor: pointer;' onclick='remove_row_fields_works( this );'>

                                                        <input type='button' value='+' id='works-add-button-0' class='works-button add' style='padding: 10px 15px !important; background: #55c593 !important; cursor: pointer;' onclick='add_row_fields_works( this );'>
                                                    </div>

                                                    <div style='clear: both;'></div>
                                                </div>

                                            </div>

                                            <div style='clear: both;' class='budget-works-message'></div>

                                            <div id='budget-works-calculation' class='wrap mcb-wrap one valign-top clearfix' style='margin: 10px 0 15px;'>
                                                <div class='mcb-wrap-inner'>
                                                    <div class='column one-fifth' style='width: 80%;text-align: right;'>
                                                        <strong>SubTotal:</strong>
                                                    </div>
                                                    <div class='column one-fifth' style='width: 15%;text-align: left;'>
                                                        R$ <span class='works-total'>0, 00</span>
                                                    </div>
                                                    <input type='hidden' id='budget_works_subtotal' name='budget_works_subtotal' min='0' readonly value='0'>
                                                </div>
                                            </div>
                                            <div style='clear: both;'></div>

                                        <?php
                                        }
                                        ?>

                                        <?php if ($fields_user_document) {
                                        ?>
                                            <div id='budget-user-document' class='wrap-document' style='clear:both; margin-top:40px; border-top: 1px solid rgb(237, 237, 237); border-radius: 10px 10px 0px 0px; border-right: 1px solid rgb(237, 237, 237); border-left: 1px solid rgb(237, 237, 237); padding: 14px 10px 0;'>
                                                <label>
                                                    <?php echo esc_attr($title_attach);
                                                    ?>
                                                </label>
                                                <span class='wpcf7-form-control-wrap curriculo'>
                                                    <input type='file' id='user_document' name='user_document' class='wpcf7-form-control wpcf7-file wpcf7-validates-as-required user_document' accept='.pdf,.doc,.docx' value=''>
                                                </span>
                                            </div>
                                            <div style='clear: both;' class='budget-document-user-message'></div>
                                        <?php
                                        }
                                        ?>

                                        <?php if ($budget_notice) {
                                        ?>
                                            <div id='budget_notice' class='budget-notice'>
                                                <div class='alert alert-warning' role='alert' style='font-size: 13px; font-weight: bold; line-height: 1.5; text-align: left; box-sizing: border-box; position: relative; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem; color: #856404; background-color: #fff3cd; border-color: #ffeeba; margin-top: 1rem;'>
                                                    <?php echo esc_html($budget_notice);
                                                    ?>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <div class='column one' style='clear:both; border-top: 1px solid rgb(237, 237, 237); border-radius: 10px 10px 0px 0px; border-right: 1px solid rgb(237, 237, 237); border-left: 1px solid rgb(237, 237, 237); padding: 14px 10px 0;'>

                                            <div class='column one-second' style='width: 60%; text-align: right; padding: 20px;'>

                                                <strong class='budget_total_text'>Total:</strong>
                                                <span style='color: #55c593;'>R$</span>
                                                <strong class='budget_total' style='font-size: 2em; color: #e91e63;'>0, 00</strong>

                                                <input type='hidden' id='budget_total' name='budget_total' min='1' readonly value='0'>
                                                <input type='hidden' name='_wpnonce' value="<?php echo esc_attr(wp_create_nonce('budget-submit-form-data')); ?>">
                                                <input type='hidden' name='action' value='submit_form_data'>
                                                <input type='hidden' name='post_id' value="<?php echo $post_id; ?>">
                                                <input type='hidden' name='post_title' value="<?php echo $post_title; ?>">
                                            </div>

                                            <div class='column one-second' style='width: 35%; text-align: right; display: flex;'>
                                                <input type='button' value="<?php echo esc_attr($title_button_submit); ?>" class='wpcf7-form-control wpcf7-submit' id='submit-form-ajax-data' onclick='submit_form_ajax_data();'>
                                                <span class='budget-loader hidden' style='padding: 8px 0 0;'>
                                                    <img class='dark-loader' src='<?php echo plugin_dir_url(__FILE__); ?>assets/images/dark-loader.gif' alt='dark-loader' style='width: 45px;'>
                                                </span>
                                            </div>
                                            <div style='clear: both;' class='budget-submit-message'></div>
                                        </div>

                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

</div>

<?php if (!$enable_msg) {
?>
    <style type='text/css'>
        .services-total,
        .works-total {
            font-size: 1.5em;
            font-weight: bold;
            color: #55c593;
        }

        .hidden {
            display: none !important;
        }

        form label.label-for span {
            position: absolute;
            margin: 0;
            background: #fcfcfc;
            padding: 7px 0px;
            margin-left: 25px;
            margin-top: 1px;
        }

        .services-label,
        .works-label {
            line-height: 1em !important;
            min-height: 40px !important;
        }

        @media only screen and (max-width: 780px) {

            .section_wrapper,
            .container,
            .four.columns .widget-area {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .column.one-fifth,
            .column.one-second {
                text-align: center !important;
                margin: 0 0 10px !important;
            }

            .alert.alert-warning {
                text-align: center !important;
            }

            .column.one-second .budget_total_text {
                display: block;
            }
        }
    </style>

    <script type='text/javascript' src='https://code.jquery.com/jquery-3.6.0.slim.min.js'></script>
    <script type='text/javascript'>
        <?php if ($registration_fields) {

            foreach ($registration_fields as $key     => $item) {
        ?>
                <?php if ($item == 'user_phone') {
                ?>
                    document.getElementById('user_phone').addEventListener('blur', function(e) {
                        var x = e.target.value.replace(/\D/g, '').match(/( \d {
                            2
                        }
                    )(\d {
                        4
                    })(\d {
                        4
                    }) / );
                    e.target.value = '(' + x[1] + ') ' + x[2] + '-' + x[3];
                }
            );
            <?php
                }
            ?>
            <?php if ($item == 'user_whatsapp') {
            ?>
                document.getElementById('user_whatsapp').addEventListener('blur', function(e) {
                    var x = e.target.value.replace(/\D/g, '').match(/( \d {
                        2
                    }
                )(\d {
                    5
                })(\d {
                    4
                }) / );
                e.target.value = '(' + x[1] + ') ' + x[2] + '-' + x[3];
            }
        );
        <?php
                }
        ?>
        <?php if ($item == 'user_cpf') {
        ?>
            document.getElementById('user_cpf').addEventListener('blur', function(e) {
                var x = e.target.value.replace(/\D/g, '').match(/( \d {
                    3
                }
            )(\d {
                3
            })(\d {
                3
            })(\d {
                2
            }) / );
            e.target.value = x[1] + '.' + x[2] + '.' + x[3] + '-' + x[4];
        }
        );
        <?php
                }
        ?>
        <?php if ($item == 'user_cnpj') {
        ?>
            document.getElementById('user_cnpj').addEventListener('blur', function(e) {
                var x = e.target.value.replace(/\D/g, '').match(/( \d {
                    2
                }
            )(\d {
                3
            })(\d {
                3
            })(\d {
                4
            })(\d {
                2
            }) / );
            e.target.value = x[1] + '.' + x[2] + '.' + x[3] + '/' + x[4] + '-' + x[5];
        }
        );
        <?php
                }
        ?>
        <?php
            }
        }
        ?>

        function submit_form_ajax_data() {

            var loader = document.querySelector('.budget-loader');
            var submit = document.querySelector('#submit-form-ajax-data');
            loader.classList.remove('hidden');
            submit.setAttribute('disabled', 'disabled');

            var submit_message = document.querySelector('.budget-submit-message');
            var message = document.querySelector('.budget-fields-message');
            submit_message.innerHTML = '';
            message.innerHTML = '';

            <?php if ($registration_fields) {
            ?>
                <?php $choices = $registration_fields_choices['choices'];
                ?>
                <?php foreach ($registration_fields as $key     => $item) {
                ?>
                    <?php if (isset($item) && $item != '') {
                    ?>
                        <?php
                        foreach ($choices as $_key    => $_item) {
                            if ($item == $_key) {

                                $name    = $_item;
                            }
                        }
                        ?>
                        var <?php echo $item;
                            ?> = document.querySelector(".form-registration-fields input#<?php echo $item; ?>");
                        <?php if ($item == 'user_document') {
                        ?>
                            <?php echo $item;
                            ?> = document.querySelector('#budget-user-document input.user_document');
                        <?php
                        }
                        ?>
                        if (<?php echo $item;
                            ?>.value == null || <?php echo $item;
                    ?>.value == '') {
                            <?php echo $item;
                            ?>.focus();
                            <?php if ($item == 'user_document') {
                            ?>
                                var message_document = document.querySelector('.budget-document-user-message');
                                message_document.innerHTML = '';
                                message_document.innerHTML = '<p style="color: red;">O item <?php echo $name; ?> é Obrigatório.</p>';
                                loader.classList.add('hidden');
                                submit.removeAttribute('disabled');
                                return false;
                            <?php
                            } else {
                            ?>
                                message.innerHTML = '<p style="color: red;">O item <?php echo $name; ?> é Obrigatório.</p>';
                                loader.classList.add('hidden');
                                submit.removeAttribute('disabled');
                                return false;
                            <?php
                            }
                            ?>
                        }

                    <?php
                    }
                    ?>
                <?php
                }
                ?>
            <?php
            }
            ?>

            <?php if ($form_services && !$form_works) {
            ?>
                if (!check_row_fields_services(0)) {
                    message.innerHTML = '<p style="color: red;">Você precisa preencher algum tipo de Serviço são Obrigatório.</p>';
                    loader.classList.add('hidden');
                    submit.removeAttribute('disabled');
                    return false;
                }
            <?php
            }
            ?>
            <?php if (!$form_services && $form_works) {
            ?>
                if (!check_row_fields_works(0)) {
                    message.innerHTML = '<p style="color: red;">Você precisa preencher algum tipo de Posto são Obrigatório.</p>';
                    loader.classList.add('hidden');
                    submit.removeAttribute('disabled');
                    return false;
                }

            <?php
            }
            ?>
            <?php if ($form_services && $form_works) {
            ?>
                if (!check_row_fields_services(0) && !check_row_fields_works(0)) {
                    message.innerHTML = '<p style="color: red;">Você precisa preencher algum tipo de Serviço ou Posto são Obrigatório.</p>';
                    loader.classList.add('hidden');
                    submit.removeAttribute('disabled');
                    return false;
                }
            <?php
            }
            ?>

            <?php if (!$form_services && !$form_works) {
            ?>
                loader.classList.add('hidden');
                submit.removeAttribute('disabled');
                return false;
            <?php
            } else {
            ?>
                loader.classList.add('hidden');
                submit.setAttribute('disabled', 'disabled');
                document.forms['form-main-budget'].submit();
                return true;
            <?php
            }
            ?>
        }

        function get_budget_symbol(sname) {
            switch (sname) {
                case 'M²':
                    return '/M²';
                    break;
                case 'Metro linear':
                    return '/M';
                    break;
                case 'Unidade':
                    return '/Um';
                    break;
                case 'Peça':
                    return '/Pç';
                    break;
                case 'Kilo':
                    return '/KG';
                    break;
                case 'Litro':
                    return '/L';
                    break;
                case 'Galão':
                    return '/Gal';
                    break;
                case 'Lata':
                    return '/Lt';
                    break;
                case 'Tonelada':
                    return '/T';
                    break;
                case 'Saco':
                    return '/Sc';
                    break;
                case 'Serviço':
                    return '/Serv';
                    break;
                case 'Execução':
                    return '/Exec';
                    break;
                case 'Hora':
                    return '/Hr';
                    break;
                case 'Dia':
                    return '/Dia';
                    break;
                case 'Mês':
                    return '/Mês';
                    break;
                case 'Km':
                    return '/Km';
                    break;
            }
        }

        <?php if ($form_services) {
        ?>

            function change_exit_fee_services(key, sname) {
                var efee = '0';
                <?php foreach ($form_services as $key => $item) {
                ?>
                    if (sname == "<?php echo esc_attr($item['services_name']); ?>") {
                        if (parseFloat(<?php echo esc_attr($item['services_exit_fee']);
                                        ?>) > 0) {
                            var field_exit_fee = document.querySelector('#services-row-' + key + ' .field-exit-fee');
                            field_exit_fee.setAttribute('style', 'display: block; width: 9%; text-align: center;');
                            var exit_fee = document.querySelector('#services-row-' + key + ' input.services-exit-fee');
                            exit_fee.value = "<?php echo esc_attr($item['services_exit_fee']); ?>";
                            efee = "<?php echo esc_attr($item['services_exit_fee']); ?>";
                        } else {
                            var field_exit_fee = document.querySelector('#services-row-' + key + ' .field-exit-fee');
                            field_exit_fee.setAttribute('style', 'display: none; width: 9%; text-align: center;');
                            var exit_fee = document.querySelector('#services-row-' + key + ' input.services-exit-fee');
                            exit_fee.value = '0';
                        }
                    }
                <?php
                }
                ?>
                return efee;
            }

            function change_fixed_price_services(key, sname) {
                var fprice = '0';
                <?php foreach ($form_services as $key => $item) {
                ?>
                    if (sname == "<?php echo esc_attr($item['services_name']); ?>") {
                        if (parseFloat(<?php echo esc_attr($item['services_fixed_price']);
                                        ?>) > 0) {
                            var field_fixed_price = document.querySelector('#services-row-' + key + ' .field-fixed-price');
                            field_fixed_price.setAttribute('style', 'display: block; width: 9%; text-align: center;');
                            var fixed_price = document.querySelector('#services-row-' + key + ' input.services-fixed-price');
                            fixed_price.value = "<?php echo esc_attr($item['services_fixed_price']); ?>";
                            fprice = "<?php echo esc_attr($item['services_fixed_price']); ?>";
                        } else {
                            var field_fixed_price = document.querySelector('#services-row-' + key + ' .field-fixed-price');
                            field_fixed_price.setAttribute('style', 'display: none; width: 9%; text-align: center;');
                            var fixed_price = document.querySelector('#services-row-' + key + ' input.services-fixed-price');
                            fixed_price.value = '0';
                        }
                    }
                <?php
                }
                ?>
                return fprice;
            }

            function change_measurement_services(sname) {
                var measurement = '';
                <?php foreach ($form_services as $key => $item) {
                ?>
                    if (sname == "<?php echo esc_attr($item['services_name']); ?>") {
                        measurement = "<?php echo esc_attr($item['services_measurement']); ?>";
                    }
                <?php
                }
                ?>
                return measurement;
            }

            function change_services_title(sname) {
                var title = '';
                <?php foreach ($form_services as $key => $item) {
                ?>
                    if (sname == "<?php echo esc_attr($item['services_name']); ?>") {
                        title = "<?php echo esc_attr($item['services_title']); ?>";
                    }
                <?php
                }
                ?>
                return title;
            }

            function change_data_services(sel) {
                var title = change_services_title(sel.value);
                var sname = change_measurement_services(sel.value);
                var price = sel.options[sel.selectedIndex].className;
                var price_id = sel.id;

                var key = price_id.replace(/[^0-9]/g, '');

                price = price.replace(',', '.');
                var exit_fee = change_exit_fee_services(key, sel.value);
                var fixed_price = change_fixed_price_services(key, sel.value);
                jQuery('#services-row-' + key + ' #services-label-' + key).html(title);
                jQuery('#services-row-' + key + ' input.services-measurement').val(sname);
                jQuery('#services-row-' + key + ' input.services-price').val(price);

                jQuery('#services-row-' + key + ' label.label-for span').html(get_budget_symbol(sname));
                var quantity = jQuery('#services-row-' + key + ' input.services-quantity').val();
                var subtotal = (parseInt(quantity) * parseFloat(price)) + parseFloat(exit_fee);
                jQuery('#services-row-' + key + ' input.services-subtotal').val(subtotal.toFixed(2));
                check_services_total();
            }

            function change_quantity_services(sel) {
                var quantity = sel.value;

                var quantity_id = sel.id;

                var key = quantity_id.replace(/[^0-9]/g, '');

                var price = jQuery('#services-row-' + key + ' input.services-price').val();
                //price        = price.replace( ',', '.' );
                var exit_fee = document.querySelector('#services-row-' + key + ' input.services-exit-fee').value;
                var fixed_price = document.querySelector('#services-row-' + key + ' input.services-fixed-price').value;
                var subtotal = (parseInt(quantity) * parseFloat(price)) + parseFloat(exit_fee);
                jQuery('#services-row-' + key + ' input.services-subtotal').val(subtotal.toFixed(2));
                check_services_total();
            }

            function check_services_total() {

                var row_subtotal = document.querySelectorAll('#budget-services-table div.budget-row input.services-subtotal');
                var row_total = document.querySelector('#budget-services-calculation .services-total');
                var input_subtotal = document.querySelector('#budget_services_subtotal');
                var total = 0;
                var subtotal = 0;
                jQuery('#budget-services-table div.budget-row').each(function(i) {
                    total = parseFloat(total) + parseFloat(row_subtotal[i].value);
                    row_total.innerHTML = total.toFixed(2);
                    input_subtotal.setAttribute('value', total.toFixed(2));
                    i++;
                });
                check_budget_total();
            }

            function remove_row_fields_services(sel) {

                var row_id = sel.id;

                var key = row_id.replace(/[^0-9]/g, '');

                if (key > 0) {
                    $('#services-row-' + key).remove();
                    reset_remove_services_row_fields(key);
                }
            }

            function add_row_fields_services(sel) {

                var row_id = sel.id;

                var key = row_id.replace(/[^0-9]/g, '');

                var check_fields = check_row_fields_services(key);
                if (check_fields) {
                    $('#services-row-' + key).clone().appendTo('#budget-services-table');
                    reset_services_row_fields(key);
                }
            }

            function check_row_fields_services(key) {

                var message = document.querySelector('.budget-services-message');
                message.innerHTML = '';

                var name = document.querySelector('#services-row-' + key + ' select.services-name');
                if (name.value == '') {
                    name.focus();
                    message.innerHTML = '<p style="color: red;">O item Nome do Serviço é Obrigatório.</p>';
                    return false;
                }
                var quantity = document.querySelector('#services-row-' + key + ' input.services-quantity');
                if (quantity.value < 1) {
                    quantity.focus();
                    message.innerHTML = '<p style="color: red;">O item Quantidade é Obrigatório.</p>';
                    return false;
                }
                var price = document.querySelector('#services-row-' + key + ' input.services-price');
                if (price.value < 1) {
                    price.focus();
                    message.innerHTML = '<p style="color: red;">O item Preço é Obrigatório e não pode ser vazio ou abaixo de zero.</p>';
                    return false;
                }
                /*var recurrence  = document.querySelector( '#services-row-' + key + ' input.services-recurrence' );
                if ( recurrence.value == '' ) {
                    recurrence.focus();
                    message.innerHTML = '<p style="color: red;">O item Observação é Obrigatório.</p>';
                    return false;
                }
                */
                var subtotal = document.querySelector('#services-row-' + key + ' input.services-subtotal');
                if (subtotal.value < 1) {
                    subtotal.focus();
                    message.innerHTML = '<p style="color: red;">O item Total é Obrigatório e não pode ser vazio ou abaixo de zero.</p>';
                    return false;
                }
                return true;
            }

            function reset_remove_services_row_fields(key) {

                var row = document.querySelectorAll('#budget-services-table div.budget-row');
                $('#budget-services-table div.budget-row').each(function(i) {
                    row[i].setAttribute('id', 'services-row-' + i);

                    if (row.length > 0 && i > 0) {
                        var j = (parseInt(row.length) - 1);
                        var last_add = document.querySelector('#services-row-' + j + ' .add');
                        last_add.classList.remove('hidden');
                    }

                    var name = document.querySelector('#services-row-' + i + ' select.services-name');
                    name.setAttribute('name', 'services[' + i + '][name]');
                    name.setAttribute('id', 'services-name-' + i);
                    name.focus();

                    var title = document.querySelector('#services-row-' + i + ' label.label-title');
                    title.setAttribute('id', 'services-label-' + i);

                    var quantity = document.querySelector('#services-row-' + i + ' input.services-quantity');
                    quantity.setAttribute('name', 'services[' + i + '][quantity]');
                    quantity.setAttribute('id', 'services-quantity-' + i);

                    var price = document.querySelector('#services-row-' + i + ' input.services-price');
                    price.setAttribute('name', 'services[' + i + '][price]');
                    price.setAttribute('id', 'services-price-' + i);

                    var recurrence = document.querySelector('#services-row-' + i + ' input.services-recurrence');
                    recurrence.setAttribute('name', 'services[' + i + '][recurrence]');

                    recurrence.setAttribute('id', 'services-recurrence-' + i);

                    var measurement = document.querySelector('#services-row-' + i + ' input.services-measurement');
                    measurement.setAttribute('name', 'services[' + i + '][measurement]');

                    measurement.setAttribute('id', 'services-measurement-' + i);

                    var exit_fee = document.querySelector('#services-row-' + i + ' input.services-exit-fee');
                    exit_fee.setAttribute('name', 'services[' + i + '][exit_fee]');
                    exit_fee.setAttribute('id', 'services-exit-fee-' + i);

                    var fixed_price = document.querySelector('#services-row-' + i + ' input.services-fixed-price');
                    fixed_price.setAttribute('name', 'services[' + i + '][fixed_price]');

                    fixed_price.setAttribute('id', 'services-fixed-price-' + i);

                    var subtotal = document.querySelector('#services-row-' + i + ' input.services-subtotal');
                    subtotal.setAttribute('name', 'services[' + i + '][subtotal]');

                    subtotal.setAttribute('id', 'services-subtotal-' + i);

                    var remove = document.querySelector('#services-row-' + i + ' input.services-button.remove');
                    remove.setAttribute('id', '' + i + '');

                    remove.setAttribute('id', 'services-remove-button-' + i);

                    var add = document.querySelector('#services-row-' + i + ' input.services-button.add');
                    add.setAttribute('id', '' + i + '');

                    add.setAttribute('id', 'services-add-button-' + i);
                    i++;
                });
                if (row.length == 1) {
                    var button_add = document.querySelector('#services-row-0 input.services-button.add');
                    button_add.classList.remove('hidden');
                }
                check_services_total();
            }

            function reset_services_row_fields(key) {
                var row = document.querySelectorAll('#budget-services-table div.budget-row');
                $('#budget-services-table div.budget-row').each(function(i) {
                    row[i].setAttribute('id', 'services-row-' + i);
                    var row_add = document.querySelector('#services-row-0 input.services-button.add');
                    row_add.classList.add('hidden');
                    if (row.length >= 1 && i >= 1) {
                        var j = (i - 1);
                        var last_add = document.querySelector('#services-row-' + j + ' .add');
                        last_add.classList.add('hidden');
                    } else {
                        var button_add = document.querySelector('#services-row-0 input.services-button.add');
                        button_add.classList.remove('hidden');
                    }
                    if (i > 0) {
                        var name = document.querySelector('#services-row-' + i + ' select.services-name');
                        name.setAttribute('name', 'services[' + i + '][name]');
                        name.setAttribute('id', 'services-name-' + i);

                        var title = document.querySelector('#services-row-' + i + ' label.services-label');
                        title.setAttribute('id', 'services-title-' + i);

                        var quantity = document.querySelector('#services-row-' + i + ' input.services-quantity');
                        quantity.setAttribute('name', 'services[' + i + '][quantity]');
                        quantity.setAttribute('id', 'services-quantity-' + i);

                        var price = document.querySelector('#services-row-' + i + ' input.services-price');
                        price.setAttribute('name', 'services[' + i + '][price]');
                        price.setAttribute('id', 'services-price-' + i);

                        var recurrence = document.querySelector('#services-row-' + i + ' input.services-recurrence');
                        recurrence.setAttribute('name', 'services[' + i + '][recurrence]');

                        recurrence.setAttribute('id', 'services-recurrence-' + i);

                        var measurement = document.querySelector('#services-row-' + i + ' input.services-measurement');
                        measurement.setAttribute('name', 'services[' + i + '][measurement]');

                        measurement.setAttribute('id', 'services-measurement-' + i);

                        var exit_fee = document.querySelector('#services-row-' + i + ' input.services-exit-fee');
                        exit_fee.setAttribute('name', 'services[' + i + '][exit_fee]');

                        exit_fee.setAttribute('id', 'services-exit-fee-' + i);

                        var fixed_price = document.querySelector('#services-row-' + i + ' input.services-fixed-price');
                        fixed_price.setAttribute('name', 'services[' + i + '][fixed_price]');

                        fixed_price.setAttribute('id', 'services-fixed-price-' + i);

                        var subtotal = document.querySelector('#services-row-' + i + ' input.services-subtotal');
                        subtotal.setAttribute('name', 'services[' + i + '][subtotal]');

                        subtotal.setAttribute('id', 'services-subtotal-' + i);

                        var remove = document.querySelector('#services-row-' + i + ' .remove');

                        remove.setAttribute('id', 'services-remove-button-' + i);
                        remove.classList.remove('hidden');

                        var add = document.querySelector('#services-row-' + i + ' .add');
                        add.setAttribute('id', 'services-add-button-' + i);
                        add.classList.remove('hidden');

                        if ((parseInt(key) + 1) == i) {
                            var bname = document.querySelector('#services-row-' + i + ' #services-name-' + i);
                            bname.value = '';
                            var bquantity = document.querySelector('#services-row-' + i + ' #services-quantity-' + i);
                            bquantity.value = '1';
                            var bprice = document.querySelector('#services-row-' + i + ' #services-price-' + i);
                            bprice.value = '0';
                            var brecurrence = document.querySelector('#services-row-' + i + ' #services-recurrence-' + i);
                            brecurrence.value = '';

                            var field_exit_fee = document.querySelector('#services-row-' + i + ' .field-fixed-price');
                            field_exit_fee.setAttribute('style', 'display:none; width: 9%; text-align: center;');
                            var exit_fee = document.querySelector('#services-row-' + i + ' #services-exit-fee-' + i);
                            exit_fee.value = '0';

                            var field_fixed_price = document.querySelector('#services-row-' + i + ' .field-fixed-price');
                            field_fixed_price.setAttribute('style', 'display:none; width: 9%; text-align: center;');
                            var fixed_price = document.querySelector('#services-row-' + i + ' #services-exit-fee-' + i);
                            fixed_price.value = '0';

                            var bsubtotal = document.querySelector('#services-row-' + i + ' #services-subtotal-' + i);
                            bsubtotal.value = '0';
                        }
                    }
                    i++;
                });
            }
        <?php
        }
        ?>

        <?php if ($form_services || $form_works) {
        ?>

            function check_budget_total() {

                <?php if ($form_services && $form_works) {
                ?>
                    var services_subtotal = document.querySelector('#budget_services_subtotal');
                    var works_subtotal = document.querySelector('#budget_works_subtotal');
                    var bgt_total = document.querySelector('.budget_total');

                    var budget_total = document.querySelector('#budget_total');

                    var total = parseFloat(services_subtotal.value) + parseFloat(works_subtotal.value);
                    bgt_total.innerHTML = total.toFixed(2);
                    budget_total.setAttribute('value', total.toFixed(2));
                <?php
                }
                ?>

                <?php if ($form_services && !$form_works) {
                ?>
                    var services_subtotal = document.querySelector('#budget_services_subtotal');
                    var bgt_total = document.querySelector('.budget_total');

                    var budget_total = document.querySelector('#budget_total');

                    var total = parseFloat(services_subtotal.value);
                    bgt_total.innerHTML = total.toFixed(2);
                    budget_total.setAttribute('value', total.toFixed(2));
                <?php
                }
                ?>

                <?php if (!$form_services && $form_works) {
                ?>
                    var works_subtotal = document.querySelector('#budget_works_subtotal');
                    var bgt_total = document.querySelector('.budget_total');

                    var budget_total = document.querySelector('#budget_total');

                    var total = parseFloat(works_subtotal.value);
                    bgt_total.innerHTML = total.toFixed(2);
                    budget_total.setAttribute('value', total.toFixed(2));
                <?php
                }
                ?>
            }

        <?php
        }
        ?>

        <?php if ($form_works) {
        ?>

            function change_exit_fee_works(key, sname) {
                var efee = '0';
                <?php foreach ($form_works as $key => $item) {
                ?>
                    if (sname == "<?php echo esc_attr($item['works_name']); ?>") {
                        if (parseFloat(<?php echo esc_attr($item['works_exit_fee']);
                                        ?>) > 0) {
                            var field_exit_fee = document.querySelector('#works-row-' + key + ' .field-exit-fee');
                            field_exit_fee.setAttribute('style', 'display: block; width: 9%; text-align: center;');
                            var exit_fee = document.querySelector('#works-row-' + key + ' input.works-exit-fee');
                            exit_fee.value = "<?php echo esc_attr($item['works_exit_fee']); ?>";
                            efee = "<?php echo esc_attr($item['works_exit_fee']); ?>";
                        } else {
                            var field_exit_fee = document.querySelector('#works-row-' + key + ' .field-exit-fee');
                            field_exit_fee.setAttribute('style', 'display: none; width: 9%; text-align: center;');
                            var exit_fee = document.querySelector('#works-row-' + key + ' input.works-exit-fee');
                            exit_fee.value = '0';
                        }
                    }
                <?php
                }
                ?>
                return efee;
            }

            function change_fixed_price_works(key, sname) {
                var fprice = '0';
                <?php foreach ($form_works as $key => $item) {
                ?>
                    if (sname == "<?php echo esc_attr($item['works_name']); ?>") {
                        if (parseFloat(<?php echo esc_attr($item['works_fixed_price']);
                                        ?>) > 0) {
                            var field_fixed_price = document.querySelector('#works-row-' + key + ' .field-fixed-price');
                            field_fixed_price.setAttribute('style', 'display: block; width: 8%; text-align: center;');
                            var fixed_price = document.querySelector('#works-row-' + key + ' input.works-fixed-price');
                            fixed_price.value = "<?php echo esc_attr($item['works_fixed_price']); ?>";
                            fprice = "<?php echo esc_attr($item['works_fixed_price']); ?>";
                        } else {
                            var field_fixed_price = document.querySelector('#works-row-' + key + ' .field-fixed-price');
                            field_fixed_price.setAttribute('style', 'display: none; width: 8%; text-align: center;');
                            var fixed_price = document.querySelector('#works-row-' + key + ' input.works-fixed-price');
                            fixed_price.value = '0';
                        }
                    }
                <?php
                }
                ?>
                return fprice;
            }

            function change_measurement_works(sname) {
                var measurement = '';
                <?php foreach ($form_works as $key => $item) {
                ?>
                    if (sname == "<?php echo esc_attr($item['works_name']); ?>") {
                        measurement = "<?php echo esc_attr($item['works_measurement']); ?>";
                    }
                <?php
                }
                ?>
                return measurement;
            }

            function change_data_works(sel) {
                var sname = change_measurement_works(sel.value);
                var price = sel.options[sel.selectedIndex].className;
                var price_id = sel.id;

                var key = price_id.replace(/[^0-9]/g, '');

                var exit_fee = change_exit_fee_works(key, sel.value);
                var fixed_price = change_fixed_price_works(key, sel.value);
                jQuery('#works-row-' + key + ' input.works-price').val(price);
                jQuery('#works-row-' + key + ' label.label-for span').html(get_budget_symbol(sname));
                var quantity = jQuery('#works-row-' + key + ' input.works-quantity').val();
                var hours = jQuery('#works-row-' + key + ' input.works-hours').val();
                var subtotal = ((parseInt(quantity) * parseFloat(hours)) * parseFloat(price)) + parseFloat(exit_fee);
                jQuery('#works-row-' + key + ' input.works-subtotal').val(subtotal.toFixed(2));
                check_works_total();

                var period = jQuery('#works-row-' + key + ' select.works-period').val();
                if (period == 'Noturno') {
                    var subtotal = jQuery('#works-row-' + key + ' input.works-subtotal').val();
                    var wtotal = (parseFloat(subtotal) + ((parseFloat(subtotal) * 20) / 100)) + parseFloat(exit_fee);
                    jQuery('#works-row-' + key + ' input.works-subtotal').val(wtotal.toFixed(2));
                    check_works_total();
                } else {
                    var quantity = jQuery('#works-row-' + key + ' input.works-quantity').val();
                    var price = jQuery('#works-row-' + key + ' input.works-price').val();
                    var hours = jQuery('#works-row-' + key + ' input.works-hours').val();
                    price = price.replace(',', '.');
                    var subtotal = ((parseInt(quantity) * parseFloat(hours)) * parseFloat(price)) + parseFloat(exit_fee);
                    jQuery('#works-row-' + key + ' input.works-subtotal').val(subtotal.toFixed(2));
                    check_works_total();
                }
            }

            function change_quantity_works(sel) {
                var quantity = sel.value;

                var quantity_id = sel.id;

                var key = quantity_id.replace(/[^0-9]/g, '');

                var price = jQuery('#works-row-' + key + ' input.works-price').val();
                var hours = jQuery('#works-row-' + key + ' input.works-hours').val();
                price = price.replace(',', '.');
                var subtotal = (parseInt(quantity) * parseInt(hours)) * parseFloat(price);
                jQuery('#works-row-' + key + ' input.works-subtotal').val(subtotal.toFixed(2));
                check_works_total();

                var period = jQuery('#works-row-' + key + ' select.works-period').val();
                if (period == 'Noturno') {
                    var exit_fee = document.querySelector('#works-row-' + key + ' input.works-exit-fee').value;
                    var fixed_price = document.querySelector('#works-row-' + key + ' input.works-fixed-price').value;
                    var subtotal = jQuery('#works-row-' + key + ' input.works-subtotal').val();
                    var wtotal = parseFloat(subtotal) + ((parseFloat(subtotal) * 20) / 100);
                    jQuery('#works-row-' + key + ' input.works-subtotal').val(wtotal.toFixed(2));
                    check_works_total();
                } else {
                    var exit_fee = document.querySelector('#works-row-' + key + ' input.works-exit-fee').value;
                    var fixed_price = document.querySelector('#works-row-' + key + ' input.works-fixed-price').value;
                    var quantity = jQuery('#works-row-' + key + ' input.works-quantity').val();
                    var price = jQuery('#works-row-' + key + ' input.works-price').val();
                    var hours = jQuery('#works-row-' + key + ' input.works-hours').val();
                    price = price.replace(',', '.');
                    var subtotal = ((parseInt(quantity) * parseInt(hours)) * parseFloat(price)) + parseFloat(exit_fee);
                    jQuery('#works-row-' + key + ' input.works-subtotal').val(subtotal.toFixed(2));
                    check_works_total();
                }
            }

            function change_hours_works(sel) {
                var hours = sel.value;

                var hours_id = sel.id;

                var key = hours_id.replace(/[^0-9]/g, '');

                var quantity = jQuery('#works-row-' + key + ' input.works-quantity').val();
                var price = jQuery('#works-row-' + key + ' input.works-price').val();
                var hours = jQuery('#works-row-' + key + ' input.works-hours').val();
                price = price.replace(',', '.');
                var subtotal = (parseInt(quantity) * parseInt(hours)) * parseFloat(price);
                jQuery('#works-row-' + key + ' input.works-subtotal').val(subtotal.toFixed(2));
                check_works_total();

                var period = jQuery('#works-row-' + key + ' select.works-period').val();
                if (period == 'Noturno') {
                    var subtotal = jQuery('#works-row-' + key + ' input.works-subtotal').val();
                    var wtotal = parseFloat(subtotal) + ((parseFloat(subtotal) * 20) / 100);
                    jQuery('#works-row-' + key + ' input.works-subtotal').val(wtotal.toFixed(2));
                    check_works_total();
                } else {
                    var quantity = jQuery('#works-row-' + key + ' input.works-quantity').val();
                    var price = jQuery('#works-row-' + key + ' input.works-price').val();
                    var hours = jQuery('#works-row-' + key + ' input.works-hours').val();
                    price = price.replace(',', '.');
                    var subtotal = (parseInt(quantity) * parseInt(hours)) * parseFloat(price);
                    jQuery('#works-row-' + key + ' input.works-subtotal').val(subtotal.toFixed(2));
                    check_works_total();
                }
            }

            function change_period_works(sel) {
                var period = sel.value;
                var period_id = sel.id;
                console.log('period: ' + period);
                console.log('period_id: ' + period_id);
                var key = period_id.replace(/[^0-9]/g, '');

                if (period == 'Noturno') {
                    var exit_fee = jQuery('#works-row-' + key + ' input.works-exit-fee').val();
                    var subtotal = jQuery('#works-row-' + key + ' input.works-subtotal').val();
                    var wtotal = parseFloat(subtotal) + ((parseFloat(subtotal) * 20) / 100) + parseFloat(exit_fee);
                    var hours = jQuery('#works-row-' + key + ' input.works-hours').val();
                    jQuery('#works-row-' + key + ' input.works-subtotal').val(wtotal.toFixed(2));
                    check_works_total();
                } else {
                    var quantity = jQuery('#works-row-' + key + ' input.works-quantity').val();
                    var price = jQuery('#works-row-' + key + ' input.works-price').val();
                    var hours = jQuery('#works-row-' + key + ' input.works-hours').val();
                    price = price.replace(',', '.');
                    var exit_fee = jQuery('#works-row-' + key + ' input.works-exit-fee').val();
                    var subtotal = (parseInt(quantity) * parseInt(hours)) * parseFloat(price) + (parseFloat(exit_fee));
                    jQuery('#works-row-' + key + ' input.works-subtotal').val(subtotal.toFixed(2));
                    check_works_total();
                }
            }

            function check_works_total() {

                var row_subtotal = document.querySelectorAll('#budget-works-table div.budget-row input.works-subtotal');
                var row_total = document.querySelector('#budget-works-calculation .works-total');
                var input_subtotal = document.querySelector('#budget_works_subtotal');
                var total = 0;
                var subtotal = 0;
                $('#budget-works-table div.budget-row').each(function(i) {
                    total = parseFloat(total) + parseFloat(row_subtotal[i].value);
                    row_total.innerHTML = total.toFixed(2);
                    input_subtotal.setAttribute('value', total.toFixed(2));
                    i++;
                });
                check_budget_total();
            }

            function remove_row_fields_works(sel) {

                var row_id = sel.id;

                var key = row_id.replace(/[^0-9]/g, '');

                if (key > 0) {
                    $('#works-row-' + key).remove();
                    reset_remove_works_row_fields(key);
                }
            }

            function add_row_fields_works(sel) {

                var row_id = sel.id;

                var key = row_id.replace(/[^0-9]/g, '');

                var check_fields = check_row_fields_works(key);
                if (check_fields) {
                    $('#works-row-' + key).clone().appendTo('#budget-works-table');
                    reset_works_row_fields(key);
                }
            }

            function check_row_fields_works(key) {

                var message = document.querySelector('.budget-works-message');
                message.innerHTML = '';
                var name = document.querySelector('#works-row-' + key + ' select.works-name');
                if (name.value == '') {
                    name.focus();
                    message.innerHTML = '<p style="color: red;">O item Nome do Serviço é Obrigatório.</p>';
                    return false;
                }
                var quantity = document.querySelector('#works-row-' + key + ' input.works-quantity');
                if (quantity.value < 1) {
                    quantity.focus();
                    message.innerHTML = '<p style="color: red;">O item Quantidade é Obrigatório.</p>';
                    return false;
                }
                var price = document.querySelector('#works-row-' + key + ' input.works-price');
                if (price.value < 1) {
                    price.focus();
                    message.innerHTML = '<p style="color: red;">O item Preço é Obrigatório e não pode ser vazio ou abaixo de zero.</p>';
                    return false;
                }
                /*var recurrence  = document.querySelector( '#works-row-' + key + ' select.works-recurrence' );
                if ( recurrence.value == '' ) {
                    recurrence.focus();
                    message.innerHTML = '<p style="color: red;">O item Observação é Obrigatório.</p>';
                    return false;
                }
                */
                var period = document.querySelector('#works-row-' + key + ' select.works-period');
                if (period.value == '') {
                    period.focus();
                    message.innerHTML = '<p style="color: red;">O item Período é Obrigatório.</p>';
                    return false;
                }
                var subtotal = document.querySelector('#works-row-' + key + ' input.works-subtotal');
                if (subtotal.value < 1) {
                    subtotal.focus();
                    message.innerHTML = '<p style="color: red;">O item Total é Obrigatório e não pode ser vazio ou abaixo de zero.</p>';
                    return false;
                }
                return true;
                // disabled
            }

            function reset_remove_works_row_fields(key) {

                var row = document.querySelectorAll('#budget-works-table div.budget-row');
                $('#budget-works-table div.budget-row').each(function(i) {
                    row[i].setAttribute('id', 'works-row-' + i);
                    if (row.length > 0 && i > 0) {
                        var j = (parseInt(row.length) - 1);
                        var last_add = document.querySelector('#works-row-' + j + ' .add');
                        last_add.classList.remove('hidden');
                    }
                    var name = document.querySelector('#works-row-' + i + ' select.works-name');
                    name.setAttribute('name', 'works[' + i + '][name]');
                    name.setAttribute('id', 'works-name-' + i);

                    var quantity = document.querySelector('#works-row-' + i + ' input.works-quantity');
                    quantity.setAttribute('name', 'works[' + i + '][quantity]');
                    quantity.setAttribute('id', 'works-quantity-' + i);

                    var hours = document.querySelector('#works-row-' + i + ' input.works-hours');
                    hours.setAttribute('name', 'works[' + i + '][hours]');
                    hours.setAttribute('id', 'works-hours-' + i);

                    var price = document.querySelector('#works-row-' + i + ' input.works-price');
                    price.setAttribute('name', 'works[' + i + '][price]');
                    price.setAttribute('id', 'works-price-' + i);

                    var recurrence = document.querySelector('#works-row-' + i + ' select.works-recurrence');
                    recurrence.setAttribute('name', 'works[' + i + '][recurrence]');

                    recurrence.setAttribute('id', 'works-recurrence-' + i);

                    var period = document.querySelector('#works-row-' + i + ' select.works-period');
                    period.setAttribute('name', 'works[' + i + '][period]');

                    period.setAttribute('id', 'works-period-' + i);

                    var exit_fee = document.querySelector('#works-row-' + i + ' input.works-exit-fee');
                    exit_fee.setAttribute('name', 'works[' + i + '][exit_fee]');

                    exit_fee.setAttribute('id', 'works-exit-fee-' + i);

                    var fixed_price = document.querySelector('#works-row-' + i + ' input.works-fixed-price');
                    fixed_price.setAttribute('name', 'works[' + i + '][fixed_price]');

                    fixed_price.setAttribute('id', 'works-fixed-price-' + i);

                    var subtotal = document.querySelector('#works-row-' + i + ' input.works-subtotal');
                    subtotal.setAttribute('name', 'works[' + i + '][subtotal]');

                    subtotal.setAttribute('id', 'works-subtotal-' + i);

                    var remove = document.querySelector('#works-row-' + i + ' input.works-button.remove');
                    remove.setAttribute('id', '' + i + '');

                    remove.setAttribute('id', 'works-remove-button-' + i);

                    var add = document.querySelector('#works-row-' + i + ' input.works-button.add');
                    add.setAttribute('id', '' + i + '');

                    add.setAttribute('id', 'works-add-button-' + i);
                    i++;
                });
                if (row.length == 1) {
                    var add = document.querySelector('#works-row-0 input.works-button.add');
                    add.classList.remove('hidden');
                }
                check_works_total();
            }

            function reset_works_row_fields(key) {
                var row = document.querySelectorAll('#budget-works-table div.budget-row');
                $('#budget-works-table div.budget-row').each(function(i) {
                    row[i].setAttribute('id', 'works-row-' + i);
                    var row_add = document.querySelector('#works-row-0 input.works-button.add');
                    row_add.classList.add('hidden');
                    if (row.length > 1 && i > 1) {
                        var j = (i - 1);
                        var last_add = document.querySelector('#works-row-' + j + ' .add');
                        last_add.classList.add('hidden');
                    }
                    if (i > 0) {
                        var name = document.querySelector('#works-row-' + i + ' select.works-name');
                        name.setAttribute('name', 'works[' + i + '][name]');
                        name.setAttribute('id', 'works-name-' + i);
                        name.focus();

                        var quantity = document.querySelector('#works-row-' + i + ' input.works-quantity');
                        quantity.setAttribute('name', 'works[' + i + '][quantity]');
                        quantity.setAttribute('id', 'works-quantity-' + i);

                        var hours = document.querySelector('#works-row-' + i + ' input.works-hours');
                        hours.setAttribute('name', 'works[' + i + '][hours]');
                        hours.setAttribute('id', 'works-hours-' + i);

                        var price = document.querySelector('#works-row-' + i + ' input.works-price');
                        price.setAttribute('name', 'works[' + i + '][price]');
                        price.setAttribute('id', 'works-price-' + i);

                        var recurrence = document.querySelector('#works-row-' + i + ' select.works-recurrence');
                        recurrence.setAttribute('name', 'works[' + i + '][recurrence]');

                        recurrence.setAttribute('id', 'works-recurrence-' + i);

                        var period = document.querySelector('#works-row-' + i + ' select.works-period');
                        period.setAttribute('name', 'works[' + i + '][period]');

                        period.setAttribute('id', 'works-period-' + i);

                        var exit_fee = document.querySelector('#works-row-' + i + ' input.works-exit-fee');
                        exit_fee.setAttribute('name', 'works[' + i + '][exit_fee]');

                        exit_fee.setAttribute('id', 'works-exit-fee-' + i);

                        var fixed_price = document.querySelector('#works-row-' + i + ' input.works-fixed-price');
                        fixed_price.setAttribute('name', 'works[' + i + '][fixed_price]');

                        fixed_price.setAttribute('id', 'works-fixed-price-' + i);

                        var subtotal = document.querySelector('#works-row-' + i + ' input.works-subtotal');
                        subtotal.setAttribute('name', 'works[' + i + '][subtotal]');

                        subtotal.setAttribute('id', 'works-subtotal-' + i);

                        var remove = document.querySelector('#works-row-' + i + ' .remove');

                        remove.setAttribute('id', 'works-remove-button-' + i);
                        remove.classList.remove('hidden');

                        var add = document.querySelector('#works-row-' + i + ' .add');
                        add.setAttribute('id', 'works-add-button-' + i);
                        add.classList.remove('hidden');

                        if ((parseInt(key) + 1) == i) {
                            var bname = document.querySelector('#works-row-' + i + ' #works-name-' + i);
                            bname.value = '';
                            var bquantity = document.querySelector('#works-row-' + i + ' #works-quantity-' + i);
                            bquantity.value = '1';
                            var bhours = document.querySelector('#works-row-' + i + ' #works-hours-' + i);
                            bhours.value = '1';
                            var bprice = document.querySelector('#works-row-' + i + ' #works-price-' + i);
                            bprice.value = '0';
                            var brecurrence = document.querySelector('#works-row-' + i + ' #works-recurrence-' + i);
                            brecurrence.value = '';

                            var field_exit_fee = document.querySelector('#works-row-' + i + ' .field-fixed-price');
                            field_exit_fee.setAttribute('style', 'display:none; width: 9%; text-align: center;');
                            var exit_fee = document.querySelector('#works-row-' + i + ' #works-exit-fee-' + i);
                            exit_fee.value = '0';

                            var field_fixed_price = document.querySelector('#works-row-' + i + ' .field-fixed-price');
                            field_fixed_price.setAttribute('style', 'display:none; width: 9%; text-align: center;');
                            var fixed_price = document.querySelector('#works-row-' + i + ' #works-exit-fee-' + i);
                            fixed_price.value = '0';

                            var bperiod = document.querySelector('#works-row-' + i + ' #works-period-' + i);
                            bperiod.value = 'Diurno';
                            var bsubtotal = document.querySelector('#works-row-' + i + ' #works-subtotal-' + i);
                            bsubtotal.value = '0';
                        }
                    }
                    i++;
                });
            }
        <?php
        }
        ?>
    </script>

<?php
}
?>