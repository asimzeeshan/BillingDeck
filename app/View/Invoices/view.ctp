<div class="invoices view">
<h2><?php echo __('Invoice'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client'); ?></dt>
		<dd>
			<?php echo $this->Html->link($invoice['Client']['name'], array('controller' => 'clients', 'action' => 'view', $invoice['Client']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('QB InvoiceID'); ?></dt>
		<dd>
			<?php echo empty($invoice['Invoice']['quickbooks_invoiceid']) ? "N/A" : $invoice['Invoice']['quickbooks_invoiceid']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Billable'); ?></dt>
		<dd>
			<?php echo ($invoice['Invoice']['is_billable']==1) ? "<b>Yes</b>" : "<i>No</i>"; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Notes'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['client_notes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notes'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['notes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Date'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['payment_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Comment'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['payment_comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($invoice['Invoice']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Invoice'), array('action' => 'edit', $invoice['Invoice']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Invoice'), array('action' => 'delete', $invoice['Invoice']['id']), null, __('Are you sure you want to delete # %s?', $invoice['Invoice']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoices'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoice Items'), array('controller' => 'invoice_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice Item'), array('controller' => 'invoice_items', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Generate PDF'), array('action' => 'create_pdf', $invoice['Invoice']['id']), array('target'=>'_blank')); ?> </li>
        
	</ul>
</div>
<div class="related view">
	<h3><?php echo __('Details'); ?></h3>
	<?php if (!empty($invoice['InvoiceItem'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Start Date'); ?></th>
		<th><?php echo __('Completion Date'); ?></th>
		<th><?php echo __('Hours'); ?></th>
		<th><?php echo __('Billing'); ?></th>
		<th><?php echo __('Is Billable'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($invoice['InvoiceItem'] as $invoiceItem): ?>
		<tr>
			<td><?php echo $invoiceItem['id']; ?></td>
			<td><?php echo ($invoiceItem['billing_type']==1) ? "Hourly" : "Fixed"; ?></td>
			<td><?php echo $invoiceItem['description']; ?></td>
			<td><?php echo $this->Time->format('M j, Y', $invoiceItem['start_date']); ?></td>
			<td><?php echo $this->Time->format('M j, Y', $invoiceItem['completion_date']); ?></td>
			<td><?php echo ($invoiceItem['billing_type']==1) ? $invoiceItem['hours'] : "<i>N/A</i>"; ?></td>
			<td><?php echo ($invoiceItem['billing_type']==2) ? $invoiceItem['billing_rate'] : "<i>N/A</i>"; ?></td>
			<td><?php echo ($invoiceItem['is_billable']==1) ? "<b>Yes</b>" : "<i>No</i>"; ?></td>
			<td><?php echo $this->Time->format('M j, Y', $invoiceItem['created']); ?></td>
			<td><?php echo $this->Time->format('M j, Y', $invoiceItem['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'invoice_items', 'action' => 'edit', $invoiceItem['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'invoice_items', 'action' => 'delete', $invoiceItem['id']), null, __('Are you sure you want to delete # %s?', $invoiceItem['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Invoice Item'), array('controller' => 'invoice_items', 'action' => 'add', $invoice['Client']['id'])); ?> </li>
		</ul>
	</div>
</div>
