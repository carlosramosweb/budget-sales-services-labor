<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_614eea907c0c1',
	'title' => 'Campos do Formulário',
	'fields' => array(
		array(
			'key' => 'field_614eeb14e6838',
			'label' => 'Campos Fixo do Formulário',
			'name' => 'registration_fields',
			'type' => 'checkbox',
			'instructions' => 'Os campos <strong>Nome do Cliente</strong> e <strong>adereço de E-mail</strong> são obrigatórios e padrão do sistema.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				//'user_name' => 'Nome',
				//'user_email' => 'E-mail',
				'user_cpf' => 'CPF',
				'user_phone' => 'Telefone',
				'user_whatsapp' => 'WhatsApp',
				'user_company' => 'Empresa ou Condomínio',
				'user_cnpj' => 'CNPJ',
				'user_how_did' => 'Como chegou até nós?',
				'user_document' => 'Anexar Documento',
			),
			'allow_custom' => 0,
			'default_value' => array(
				//0 => 'user_name',
				//1 => 'user_email',
				2 => 'user_phone',
				3 => 'user_whatsapp',
				4 => 'user_cpf',
				5 => 'user_how_did',
			),
			'layout' => 'horizontal',
			'toggle' => 0,
			'return_format' => 'value',
			'save_custom' => 0,
		),
        array(
            'key' => 'field_614eeb14eg838',
            'label' => 'Valor Extra - Serviços',
            'name' => 'services_exit_fee',
            'type' => 'text',
            'instructions' => 'Este campo será somado ao pré-orçamento.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '48',
                'class' => '',
                'id' => '',
            ),
			'layout' => 'table',
            'default_value' => 'Vlr Extra',
            'placeholder' => 'Digite um título.',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array(
	        'key' => 'field_614eebg4e6838',
	        'label' => 'Valor Informativo - Serviços',
	        'name' => 'services_fixed_price',
	        'type' => 'text',
	        'instructions' => 'Este campo informativo não será somado.',
	        'required' => 0,
	        'conditional_logic' => 0,
	        'wrapper' => array(
	            'width' => '48',
	            'class' => '',
	            'id' => '',
	        ),
			'layout' => 'table',
	        'default_value' => 'Vlr Info',
	        'placeholder' => 'Digite um título.',
	        'prepend' => '',
	        'append' => '',
	        'maxlength' => '',
    	),
        array(
            'key' => 'field_614eeb14fg838',
            'label' => 'Valor Extra - Postos',
            'name' => 'works_exit_fee',
            'type' => 'text',
            'instructions' => 'Esse campo será somado ao pré-orçamento.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '48',
                'class' => '',
                'id' => '',
            ),
			'layout' => 'table',
            'default_value' => 'Vlr Extra',
            'placeholder' => 'Digite um título.',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array(
	        'key' => 'field_614eebg4g6838',
	        'label' => 'Valor Informativo - Postos',
	        'name' => 'works_fixed_price',
	        'type' => 'text',
	        'instructions' => 'Este campo informativo não será somado.',
	        'required' => 0,
	        'conditional_logic' => 0,
	        'wrapper' => array(
	            'width' => '48',
	            'class' => '',
	            'id' => '',
	        ),
			'layout' => 'table',
	        'default_value' => 'Vlr Info',
	        'placeholder' => 'Digite um título.',
	        'prepend' => '',
	        'append' => '',
	        'maxlength' => '',
    	),
		/*array(
			'key' => 'field_614ef24a03de7',
			'label' => 'Novos Campos de Registro',
			'name' => 'new_registration_fields',
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
					'key' => 'field_614ef27a03de8',
					'label' => 'Nome do Campo',
					'name' => 'name_registration_fields',
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
					'key' => 'field_614ef2a603de9',
					'label' => 'Tipo de Campo',
					'name' => 'type_registration_fields',
					'type' => 'select',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '15',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'text' => 'Texto',
						'checkbox' => 'Checkbox',
						'radio_button' => 'Botão de Radio',
					),
					'default_value' => 'text',
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_614ef3717ed01',
					'label' => 'Obrigatório',
					'name' => 'required_registration_fields',
					'type' => 'select',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '15',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'yes' => 'Sim',
						'no' => 'Não',
					),
					'default_value' => 'yes',
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),*/
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
));

endif;		