<?php
/**
 * 
 * MemberMouse(TM) (http://www.membermouse.com)
 * (c) MemberMouse, LLC. All rights reserved.
 */

global $current_user;

$couponsSupported = MM_PaymentServiceFactory::couponsSupported();

$view = new MM_CouponView();
$dataGrid = new MM_DataGrid($_REQUEST, "id", "desc", 10);
$data = $view->getViewData($dataGrid);
$dataGrid->setTotalRecords($data);
$dataGrid->recordName = "coupon";

$rows = array();

foreach($data as $key => $item)
{
    $coupon = new MM_Coupon($item->id);
    
	$availableDates = "";
	$endDate = $coupon->getEndDate(true);
	
	if(!empty($endDate))
	{    	
		$availableDates = $coupon->getStartDate(true)." - ".$endDate;
	}
	else
	{
		$availableDates = "After ". $coupon->getStartDate(true);
	}
	
	switch($coupon->getQuantity())
	{
		case "-1":
		case "":
			$quantityDescription = number_format($item->quantity_used)." used";
			break;
			
		default:
			$quantityDescription = number_format($item->quantity_used)." of ".number_format($coupon->getQuantity())." used ";
			break;
	}
	
	$description = "";
	
	switch($coupon->getCouponType())
	{
		case MM_Coupon::$TYPE_PERCENTAGE:
			$description = "<span style='font-family:courier;'>".$coupon->getCouponValue()."%</span> off";
			break;
			
		case MM_Coupon::$TYPE_DOLLAR:
			$description = "<span style='font-family:courier;'>".$coupon->getCouponValue(true)."</span> off";
			break;
			
		case MM_Coupon::$TYPE_FREE:
			$description = "<span style='font-family:courier;'>FREE</span>";
			break;
	}
	
	if($coupon->getCouponType() != MM_Coupon::$TYPE_FREE)
	{
		if($coupon->getRecurringBillingSetting() == "all")
		{
			$description .= " all charges";
		}
		else
		{
			$description .= " the first charge";
		}
	}
	
	$editActionUrl = 'onclick="mmjs.edit(\'mm-coupons-dialog\', \''.$coupon->getId().'\', 620, 615)"';
	$deleteActionUrl = 'onclick="mmjs.remove(\''.$coupon->getId().'\')"';
	$archiveActionUrl = 'onclick="mmjs.archive(\''.$coupon->getId().'\')"';
	$unarchiveActionUrl = 'onclick="mmjs.unarchive(\''.$coupon->getId().'\')"';
	$actions = MM_Utils::getEditIcon("Edit Coupon", '', $editActionUrl);
	$archiveActions = "";
	
	if(!MM_Coupon::isBeingUsed($coupon->getId()))
    {
		$actions .= MM_Utils::getDeleteIcon("Delete Coupon", 'margin-left:5px;', $deleteActionUrl);
    }
    else 
    {
    	$actions .= MM_Utils::getDeleteIcon("This coupon is currently being used and cannot be deleted.", 'margin-left:5px;', '', true);
    	
    	if(!$coupon->isArchived())
    	{
    		$archiveMsg = "Archive this coupon to hide it and disable it from being used.";
    		$archiveActions .= MM_Utils::getArchiveIcon($archiveMsg, 'margin-left:5px;', $archiveActionUrl);
    	}
    	else if($coupon->isArchived())
    	{
    		$archiveMsg = "Unarchive this coupon to enable it to be used.";
    		$archiveActions .= MM_Utils::getArchiveIcon($archiveMsg, 'margin-left:5px;', $unarchiveActionUrl, true);
    	}
    }
    
    $rows[] = array
    (
    		array( 'content' => "<span title='ID [".$coupon->getId()."]'>".$coupon->getCouponName()."</span>"),
    		array( 'content' => "<span style='font-family:courier;'>".strtoupper($coupon->getCouponCode())."</span>"),
    		array( 'content' => $description),
    		array( 'content' => $quantityDescription),
    		array( 'content' => $availableDates),
    		array( 'content' => (empty($item->product_restrictions) ? MM_NO_DATA : $item->product_restrictions)),
    		array( 'content' => $actions),
    		array( 'content' => $archiveActions)
    );
}

$headers = array
(
	'name'					=> array('content' => '<a onclick="mmjs.sort(\'c.coupon_name\');" href="#">Name</a>'),
	'coupon_code'			=> array('content' => '<a onclick="mmjs.sort(\'c.coupon_code\');" href="#">Coupon Code</a>'),
	'description'			=> array('content' => 'Description'),
	'quantity_used'			=> array('content' => '<a onclick="mmjs.sort(\'quantity_used\');" href="#"># Used</a>'),
	'start_date_end_date'	=> array('content' => '<a onclick="mmjs.sort(\'c.start_date\');" href="#">Valid Dates</a>'),
	'product_restrictions'	=> array('content' => 'Product Restrictions'),
	'actions'				=> array('content' => 'Actions', "attr" => "style='width:50px;'"),
	'archive'				=> array('content' => 'Archive', "attr" => "style='width:20px;'")
);

$dataGrid->setHeaders($headers);
$dataGrid->setRows($rows);

$dgHtml = $dataGrid->generateHtml();

if($dgHtml == "") {
	$dgHtml = "<p><i>No coupons.</i></p>";
}
?>
<div class="mm-wrap">
	<?php if(MM_Response::isError($couponsSupported)) { ?>
	<div class="error">
		<p><?php echo $couponsSupported->message; ?></p>
	</div>
	<?php } ?>
	
	<div class="mm-button-container">
		<a onclick="mmjs.create('mm-coupons-dialog', 620, 615)" class="mm-ui-button green"><?php echo MM_Utils::getIcon('plus-circle', '', '1.2em', '1px'); ?> Create Coupon</a>
		
		<?php 
			$showArchivedCoupons = (MM_OptionUtils::getOption(MM_CouponView::$SEARCH_OPTION_SHOW_ARCHIVED."-".$current_user->ID) == "1") ? true : false;
			$showExpiredCoupons = (MM_OptionUtils::getOption(MM_CouponView::$SEARCH_OPTION_SHOW_EXPIRED."-".$current_user->ID) == "1") ? true : false;
		?>
		
		<span style="font-size:11px;">
			<input type='hidden' id='mm-admin-id' value='<?php echo $current_user->ID; ?>' />
			<input type='checkbox' id='mm-show-archived-coupons' <?php echo ($showArchivedCoupons ? "checked":""); ?> style="margin-left:10px;" onclick="mmjs.storeCouponSearchOptions();" /> Show archived coupons
			<input type='checkbox' id='mm-show-expired-coupons' <?php echo ($showExpiredCoupons ? "checked":""); ?> style="margin-left:10px;" onclick="mmjs.storeCouponSearchOptions();" /> Show expired coupons
		</span>
	</div>

	<div class="clear"></div>
	
	<div style="width:98%">
	<?php echo $dgHtml; ?>
	</div>
</div>