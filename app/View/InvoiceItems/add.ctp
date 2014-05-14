<div class="invoiceItems form">
<?php echo $this->Form->create('InvoiceItem'); ?>
	<fieldset>
		<legend><?php echo __('Add Invoice Item'); ?></legend>
	<?php
		echo $this->Form->input('invoice_id', array('default'=>$this->request->pass[0]));
		echo $this->Form->input('description');
		echo $this->Form->input('hours');
		echo $this->Form->input('is_billable', array('checked'=>'checked'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Invoice Items'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Invoices'), array('controller' => 'invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice'), array('controller' => 'invoices', 'action' => 'add')); ?> </li>
	</ul>
</div>
