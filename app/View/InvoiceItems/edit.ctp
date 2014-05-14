<div class="invoiceItems form">
<?php echo $this->Form->create('InvoiceItem'); ?>
	<fieldset>
		<legend><?php echo __('Edit Invoice Item'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('invoice_id');
		echo $this->Form->input('description');
		echo $this->Form->input('start_date');
		echo $this->Form->input('completion_date');
		echo $this->Form->input('hours');
		echo $this->Form->input('is_billable');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('InvoiceItem.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('InvoiceItem.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Invoice Items'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Invoices'), array('controller' => 'invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice'), array('controller' => 'invoices', 'action' => 'add')); ?> </li>
	</ul>
</div>
