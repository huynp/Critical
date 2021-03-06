<?php 
	$orderItem = new MM_OrderItem($p->orderItemId);
	
	if($orderItem->isValid())
	{
		$scheduledPaymentEvent = MM_ScheduledPaymentEvent::findNextScheduledEventByOrderItemId($orderItem->getId(),false);
		if ($scheduledPaymentEvent->isValid())
		{
			$crntRebillDate = MM_Utils::dateToLocal($scheduledPaymentEvent->getScheduledDate(), "m/d/Y");
?>
<div id='mm-edit-subscription-div'>
<input type='hidden' id='order_item_id' value='<?php echo $p->orderItemId ?>' />
<a href="#"></a>
<p>Next Rebill Date</p>
<p style="font-size:11px;">
	<input id="mm-next-rebill-date" type="text" style="width: 152px" value="<?php echo $crntRebillDate; ?>" /> 
	<a onClick="jQuery('#mm-next-rebill-date').focus();"><?php echo MM_Utils::getCalendarIcon(); ?></a>
</p>

</div>

<div class="mm-dialog-footer-container">
<div class="mm-dialog-button-container">
<a href="javascript:mmjs.saveSubscription();" class="mm-ui-button blue">Save</a>
<a href="javascript:mmjs.closeDialog();" class="mm-ui-button">Cancel</a>
</div>
</div>
<script type='text/javascript'>
jQuery(document).ready(function()
{	
	jQuery("#mm-next-rebill-date").datepicker();
});
</script>
<?php } else { ?>
	Scheduled payment event is invalid
<?php } ?>
<?php } else { ?>
	Invalid order item ID
<?php } ?>