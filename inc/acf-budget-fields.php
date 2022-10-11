<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

if ( function_exists( 'acf_add_local_field_group' ) ):

acf_add_local_field_group( array(
    'key' => 'group_614f85e160357',
    'title' => 'Campos do Orçamento',
    'fields' => array(
        array(
            'key' => 'field_614f8613d225d',
            'label' => 'Campos Extras',
            'name' => 'extra_fields',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => '',
            'sub_fields' => array(
                array(
                    'key' => 'field_614f8649d225e',
                    'label' => 'Nome do Campo',
                    'name' => 'field_name',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_614f8671d225f',
                    'label' => 'Preço do Campo',
                    'name' => 'field_value',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'request_budget',
            ),
            array(
                'param' => 'current_user_role',
                'operator' => '==',
                'value' => 'administrator',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
) );

endif;
