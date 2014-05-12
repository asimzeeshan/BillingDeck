<?php
App::uses('AppModel', 'Model');
/**
 * Client Model
 *
 * @property Invoice $Invoice
 */
class Client extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'first_name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Invoice' => array(
			'className' => 'Invoice',
			'foreignKey' => 'client_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
