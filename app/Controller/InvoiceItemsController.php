<?php
App::uses('AppController', 'Controller');
/**
 * InvoiceItems Controller
 *
 * @property InvoiceItem $InvoiceItem
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class InvoiceItemsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * Helpers
 *
 * @var array
 */
    public $helpers = array('Form', 'Html', 'Js', 'Time');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->InvoiceItem->recursive = 0;
		$this->set('invoiceItems', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->InvoiceItem->exists($id)) {
			throw new NotFoundException(__('Invalid invoice item'));
		}
		$options = array('conditions' => array('InvoiceItem.' . $this->InvoiceItem->primaryKey => $id));
		$this->set('invoiceItem', $this->InvoiceItem->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			// Hack to save '0' in the appropriate field if that billing type was not selected
			if ($this->request->data['InvoiceItem']['billing_type']==1) {
				$this->request->data['InvoiceItem']['billing_rate']	= "0";
			} else {
				$this->request->data['InvoiceItem']['hours']		= "0";
			}
			// END of Hack

			$this->InvoiceItem->create();
			if ($this->InvoiceItem->save($this->request->data)) {
				$this->Session->setFlash(__('The invoice item has been saved.'));
				return $this->redirect(array('controller' => 'invoices', 'action' => 'view', $this->request->data['InvoiceItem']['invoice_id']));
			} else {
				$this->Session->setFlash(__('The invoice item could not be saved. Please, try again.'));
			}
		}
		$invoices = $this->InvoiceItem->Invoice->find('list');
		$this->set(compact('invoices'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->InvoiceItem->exists($id)) {
			throw new NotFoundException(__('Invalid invoice item'));
		}
		if ($this->request->is(array('post', 'put'))) {
			// Hack to save '0' in the appropriate field if that billing type was not selected
			if ($this->request->data['InvoiceItem']['billing_type']==1) {
				$this->request->data['InvoiceItem']['billing_rate']	= "0";
			} else {
				$this->request->data['InvoiceItem']['hours']		= "0";
			}
			// END of Hack

			if ($this->InvoiceItem->save($this->request->data)) {
				$this->Session->setFlash(__('The invoice item has been saved.'));
				return $this->redirect(array('controller' => 'invoices', 'action' => 'view', $this->request->data['InvoiceItem']['invoice_id']));
			} else {
				$this->Session->setFlash(__('The invoice item could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('InvoiceItem.' . $this->InvoiceItem->primaryKey => $id));
			$this->request->data = $this->InvoiceItem->find('first', $options);
		}
		$invoices = $this->InvoiceItem->Invoice->find('list');
		$this->set(compact('invoices'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->InvoiceItem->id = $id;
		if (!$this->InvoiceItem->exists()) {
			throw new NotFoundException(__('Invalid invoice item'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->InvoiceItem->delete()) {
			$this->Session->setFlash(__('The invoice item has been deleted.'));
		} else {
			$this->Session->setFlash(__('The invoice item could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('controller'=>'invoices', 'action' => 'index'));
	}
}
