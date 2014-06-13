<?php
App::uses('AppModel', 'Model');
/**
 * Invoice Model
 *
 * @property Client $Client
 * @property InvoiceItem $InvoiceItem
 */
class Invoice extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'client_id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'InvoiceItem' => array(
			'className' => 'InvoiceItem',
			'foreignKey' => 'invoice_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'start_date asc',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
