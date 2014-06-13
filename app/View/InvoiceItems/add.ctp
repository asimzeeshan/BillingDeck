<script language="javascript">
<!--
function showHide(val) {
	if (val==1) {
		jQuery('#InvoiceItemHours').parent().show();
		jQuery('#InvoiceItemBillingRate').parent().hide();
	} else {
		jQuery('#InvoiceItemHours').parent().hide();
		jQuery('#InvoiceItemBillingRate').parent().show();
	}
}
$(document).ready(function() {
	showHide(1);
	jQuery('#InvoiceItemHours').val(0.00);
	jQuery('#InvoiceItemBillingRate').val(0.00);

	jQuery('#InvoiceItemStartDate').val('<?php echo date('Y-m-d', strtotime('last month')); ?>');
	jQuery('#InvoiceItemCompletionDate').val('<?php echo date('Y-m-d'); ?>');

	$("#InvoiceItemStartDate").datepicker({
		   dateFormat: 'yy-mm-dd',
		   numberOfMonths: 1,
		   showButtonPanel: true,
		   changeMonth: true,
		   changeYear: true,
	 });
   
	$("#InvoiceItemCompletionDate").datepicker({
		   dateFormat: 'yy-mm-dd',
		   numberOfMonths: 1,
		   showButtonPanel: true,
		   changeMonth: true,
		   changeYear: true,
	 });
});
//-->
</script>
<div class="invoiceItems form">
<?php echo $this->Form->create('InvoiceItem'); ?>
	<fieldset>
		<legend><?php echo __('Add Invoice Item'); ?></legend>
	<?php
		echo $this->Form->input('invoice_id', array('default'=>$this->request->pass[0], 'options' => array('hiddenField'=> 'true')));
		echo $this->Form->input('billing_type', array('options' => array(1=>"Hourly Billing", 2=>"Fixed Billing"), 'onchange' => 'showHide(this.value);'));
		echo $this->Form->input('description');
		echo $this->Form->input('start_date', array('type'=>'text'));
		echo $this->Form->input('completion_date', array('type'=>'text'));
		echo $this->Form->input('hours');
		echo $this->Form->input('billing_rate');
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
