<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}
if ( function_exists( 'acf_add_local_field_group' ) ):

acf_add_local_field_group( array(
    'key' => 'group_614ef05888495',
    'title' => 'Mensagens do Formulário',
    'fields' => array(
        array(
            'key' => 'field_614ef0b175814',
            'label' => 'Mensagem de Erro',
            'name' => 'error_message',
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 'Opa! Não foi possível enviar seu pedido de pré-orçamento. Tente novamente mais tarde.',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_614ef0ef52f17',
            'label' => 'Mensagem de Sucesso',
            'name' => 'success_message',
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 'Obrigado! Seu pedido de pré-orçamento foi enviado com sucesso.',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'budget',
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
    'hide_on_screen' => array(
        0 => 'the_content',
        1 => 'excerpt',
        2 => 'discussion',
        3 => 'comments',
        4 => 'revisions',
        5 => 'format',
        6 => 'page_attributes',
        7 => 'featured_image',
        8 => 'categories',
        9 => 'tags',
        10 => 'send-trackbacks',
    ),
    'active' => true,
    'description' => '',
) );

endif;
