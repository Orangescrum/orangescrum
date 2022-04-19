<?php

App::uses('AppModel', 'Model');

class CustomFieldOption extends AppModel{
	var $name = 'CustomFieldOption';
	public $belongsTo = array(
		'CustomField'=> array(
			'className'=> 'CustomField',
			'foreignKey'=> 'custom_field_id'
		),
		'User' => array('className' => 'User',
            'foreignKey' => 'user_id'
        )
		);
    }