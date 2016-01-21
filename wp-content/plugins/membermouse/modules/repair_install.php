<?php
/**
 *
 * MemberMouse(TM) (http://www.membermouse.com)
 * (c) MemberMouse, LLC. All rights reserved.
 */

global $wp_filesystem,$wpdb;

set_time_limit(300); //in seconds - 5 mins

$cacheDir = MM_Utils::getCacheDir();
if (false === ($creds = request_filesystem_credentials($_SERVER["REQUEST_URI"], '', false, $cacheDir, null) ) ) {
	return; // stop processing here
}

if ( ! WP_Filesystem($creds) ) 
{
	//credentials were no good, ask the user for them again
	$error = true;
	if (is_object($wp_filesystem) && $wp_filesystem->errors->get_error_code())
	{
		$error = $wp_filesystem->errors;
	}
	request_filesystem_credentials($_SERVER["REQUEST_URI"], '', $error, $cacheDir, null);
	return true;
}

if (isset($wp_filesystem))
{
	$wpfsCacheDir = MM_PLUGIN_ABSPATH."/com/membermouse/cache";
	if (!$wp_filesystem->exists($wpfsCacheDir)) 
	{
		$wp_filesystem->mkdir($wpfsCacheDir,0777);
	}
	
	$wp_filesystem->chmod($wpfsCacheDir,0777);
	$wp_filesystem->chmod($wpfsCacheDir,0777,true);
}

?>
<div class="mm-wrap">
    <p class="mm-header-text">Repair MemberMouse</p>
	<div class="mm-button-container">
	</div>
	
	<div class="clear"></div>
	<div id='mm-repair-content' style='width: 700px; font-size:14px; line-height:26px;'>
		<?php if (!MM_Utils::cacheIsWriteable()) { ?>
		1. Unable to automatically repair the cache permissions. Please manually change the permissions on the following directory and all files contained within to 777 using an FTP/SSH client. <br/>
		Cache directory location: <strong><?php echo MM_Utils::getCacheDir(); ?></strong><br/>
		<?php } else { ?>
		1. Cache directory permissions modified successfully<br/>
		<?php } ?>
		
		2. Refreshing cache... <br/>
		<em>Please wait...</em><br/>
		
		<?php 
		@ob_end_flush();
		@ob_flush();
		@flush();
		@ob_start();
		// refresh cache
		MM_MemberMouseService::authorize();
		?>
		
		Cache refreshed successfully<br/>
		
		3. Repairing database indexes...<br/>
		<em>Please wait</em><br/>
		<?php 
			$tableIndexesToPurge = array("mm_membership_levels" => "name",
										 "mm_commission_profiles" => "name",
										 "mm_orders" => "order_number",
										 "mm_transaction_key" => "transaction_key",
										 "mm_payment_services" => "token",
										 "mm_shipping_methods" => "token",
										 "mm_social_login_providers" => "token");
			
			foreach ($tableIndexesToPurge as $table=>$indexRoot)
			{
				$enumerationQuery= "SHOW INDEXES FROM {$table} WHERE Non_unique=0 AND Key_name LIKE '{$indexRoot}%'";
				$enumerationResults = $wpdb->get_results($enumerationQuery);
				foreach ($enumerationResults as $enumeratedResult)
				{
					$wpdb->query("DROP INDEX {$enumeratedResult->Key_name} ON {$table}");
				}
			}
		?>
		
		DONE
	</div>
</div>
