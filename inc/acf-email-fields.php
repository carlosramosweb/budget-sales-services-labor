<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}
if ( function_exists( 'acf_add_local_field_group' ) ):

acf_add_local_field_group( array(
    'key' => 'group_6157d5d7299b3',
    'title' => 'Campos E-mail',
    'fields' => array(
        array(
            'key' => 'field_6157d66de2037',
            'label' => 'Assunto do e-mail',
            'name' => 'email_subject',
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 'Pré-Orçamento - Website',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_6157d6c97ee72',
            'label' => 'Texto Bem-vindo',
            'name' => 'text_welcome',
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 'Pré-Orçamento GPB - Website GPB - Mais de 20 anos de realizações e conquistas',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_6157f7e913c75',
            'label' => 'Enviar uma copia para o Email',
            'name' => 'send_copy_email',
            'type' => 'email',
            'instructions' => 'Deixe em branco se não quiser uma copia.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => 'E-mail aqui',
            'prepend' => '',
            'append' => '',
        ),
        array(
            'key' => 'field_6157d6083d069',
            'label' => 'Imagem do cabeçalho',
            'name' => 'header_image',
            'type' => 'image',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'url',
            'preview_size' => 'medium',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
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
        0 => 'permalink',
        1 => 'the_content',
        2 => 'excerpt',
        3 => 'discussion',
        4 => 'comments',
        5 => 'revisions',
        6 => 'slug',
        7 => 'author',
        8 => 'format',
        9 => 'page_attributes',
        10 => 'featured_image',
        11 => 'categories',
        12 => 'tags',
        13 => 'send-trackbacks',
    ),
    'active' => true,
    'description' => '',
) );

endif;
