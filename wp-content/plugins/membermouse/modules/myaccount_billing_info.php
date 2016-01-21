<?php 
/**
 * 
 * MemberMouse(TM) (http://www.membermouse.com)
 * (c) MemberMouse, LLC. All rights reserved.
 */

global $current_user;

$user = new MM_User($current_user->ID);

$fieldInfo = array();

$field = new stdClass();
$field->fieldId = "mm_field_billing_address";
$field->fieldName = "billingaddress";
$field->label = "Address";
$fieldInfo[] = $field;

$field = new stdClass();
$field->fieldId = "mm_field_billing_city";
$field->fieldName = "billingcity";
$field->label = "City";
$fieldInfo[] = $field;

$field = new stdClass();
$field->fieldId = "mm_field_billing_state";
$field->fieldName = "billingstate";
$field->label = "State";
$fieldInfo[] = $field;

$field = new stdClass();
$field->fieldId = "mm_field_billing_zip";
$field->fieldName = "billingzipcode";
$field->label = "Zip Code";
$fieldInfo[] = $field;

$field = new stdClass();
$field->fieldId = "mm_field_billing_country";
$field->fieldName = "billingcountry";
$field->label = "Country";
$fieldInfo[] = $field;

$data = array();
	
$data["mm_field_billing_address"] = $user->getBillingAddress();
$data["mm_field_billing_city"] = $user->getBillingCity();
$data["mm_field_billing_state"] = $user->getBillingState();
$data["mm_field_billing_zip"] = $user->getBillingZipCode();
$data["mm_field_billing_country"] = $user->getBillingCountry();

$form = new MM_CheckoutForm();

if(!isset($data["mm_field_billing_country"]))
{
	$data["mm_field_billing_country"] = "";
}
$form->billingCountryList = MM_HtmlUtils::getCountryList($data["mm_field_billing_country"]);

echo $form->getJavascriptIncludes(false);

?>
<div id="mm-form-container">
	<table>
		<?php foreach($fieldInfo as $field): ?>
			<tr>
				<td><span class="mm-myaccount-dialog-label"><?php echo $field->label; ?></span></td>
				<td>
				<span style="font-family:courier; font-size:11px; margin-top:5px;">
					<?php 
						if(!isset($data[$field->fieldId]))
						{
							$data[$field->fieldId] = "";
						}
						echo MM_CheckoutForm::generateInputFormField($field->fieldName, $data, $form, "mm-myaccount-form-field");
					?>
				</span>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>

<div class="mm-dialog-footer-container">
<div class="mm-dialog-button-container">
<a href="javascript:myaccount_js.updateMemberData(<?php echo $user->getId(); ?>, 'billing-info');" class="mm-ui-button blue">Update</a>
<a href="javascript:myaccount_js.closeDialog();" class="mm-ui-button">Cancel</a>
</div>
</div>
<?php echo $form->getInitJavascript($data); ?>