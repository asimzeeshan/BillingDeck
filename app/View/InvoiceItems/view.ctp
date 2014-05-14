<div class="invoiceItems view">
<h2><?php echo __('Invoice Item'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($invoiceItem['InvoiceItem']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice'); ?></dt>
		<dd>
			<?php echo $this->Html->link($invoiceItem['Invoice']['id'], array('controller' => 'invoices', 'action' => 'view', $invoiceItem['Invoice']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($invoiceItem['InvoiceItem']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hours'); ?></dt>
		<dd>
			<?php echo h($invoiceItem['InvoiceItem']['hours']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Billable'); ?></dt>
		<dd>
			<?php echo h($invoiceItem['InvoiceItem']['is_billable']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($invoiceItem['InvoiceItem']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($invoiceItem['InvoiceItem']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Invoice Item'), array('action' => 'edit', $invoiceItem['InvoiceItem']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Invoice Item'), array('action' => 'delete', $invoiceItem['InvoiceItem']['id']), null, __('Are you sure you want to delete # %s?', $invoiceItem['InvoiceItem']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoice Items'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice Item'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoices'), array('controller' => 'invoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice'), array('controller' => 'invoices', 'action' => 'add')); ?> </li>
	</ul>
</div>
