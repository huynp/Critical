<?php
/**
 * 
 * MemberMouse(TM) (http://www.membermouse.com)
 * (c) MemberMouse, LLC. All rights reserved.
 */
global $current_user;

$view = new MM_SafeModeView();
$currentMode = MM_SafeMode::getMode();
$modeList = MM_SafeMode::getModeLabels();
$modeListHtml = MM_HtmlUtils::generateSelectionsList($modeList,$currentMode);

?>
<div class="mm-wrap">
	<div style="width:750px;" class="mm-info-box blue">
		<p>3rd party software is commonly installed and run alongside the MemberMouse plugin within the WordPress environment. 
		This can include themes, plugins and custom code. Sometimes even themes and plugins that are functioning as intended can 
		interfer with MemberMouse so removing these external factors is an essential first step in diagnosing the source of 
		a problem.</p>
		
		<p>Our customer success team is here to help answer any questions you have in regards to using the MemberMouse software.
		If a 3rd party theme or plugin is causing an issue, you should contact the author of the 3rd party software for support 
		or discontinue using the offending software. For more information, please read our <a href="http://membermouse.uservoice.com/knowledgebase/articles/520776-membermouse-support-policy" target="_blank">support policy</a>.</p>
	</div>
	
	<div style="width:750px;" class="mm-info-box yellow">
    	<p>Enabling <em>Safe Mode</em> creates a "clean" environment by deactivating all plugins and switching to the default 
		WordPress theme (if available). When you disable <em>Safe Mode</em> MemberMouse will restore the plugins and theme 
		that were originally activated.</p>
		
		<p>Read this article if you'd prefer to <a href="http://membermouse.uservoice.com/knowledgebase/articles/319204-troubleshooting-plugin-and-theme-conflicts" target="_blank" style="color:#8a6d3b">deactivate your plugins and theme manually</a>.</p>
	
		<?php 
   	if($currentMode == MM_SafeMode::$MODE_ENABLED)
   	{
   	?>
   		<a onclick="mmjs.setSafeModeStatus('<?php echo MM_SafeMode::$MODE_DISABLED; ?>');" class="mm-ui-button red">Disable Safe Mode</a>
   <?php
   	}
   	else 
   	{
   	?>
   		<a onclick="mmjs.setSafeModeStatus('<?php echo MM_SafeMode::$MODE_ENABLED; ?>');" class="mm-ui-button green">Enable Safe Mode</a>
   	<?php
   	}
   	?>
   	
    	<table style="width:750px;"><tr>
    	<td style="width:50%">
    	<?php 
    	 $activePlugins = MM_SafeMode::getActivePluginNames(); 
    	?>
    	<strong>Active Plugins (<?php echo count($activePlugins); ?>)</strong><br/>
    	
    	<?php 
		   echo implode(", ", $activePlugins);
    	?>
    	    	
    	<div style="margin-top:10px;">
    	<strong>Active Theme</strong><br/>
    	<?php 
    		echo MM_SafeMode::getActiveThemeName();
    	?></div></td>
    	<td>
    	<?php 
	   	if($currentMode == MM_SafeMode::$MODE_ENABLED)
	   	{
    	 	$savedPlugins = MM_SafeMode::getSavedPluginNames(); 
    	?>
    	<strong><em>Saved Plugins (<?php echo count($savedPlugins); ?>)</em></strong><br/>
    	
    	<?php 
		   echo implode(", ", $savedPlugins);
    	?>
    	    	
    	<div style="margin-top:10px;">
    	<strong><em>Saved Theme</em></strong><br/>
    	<?php 
    		echo MM_SafeMode::getSavedThemeName();
    	?></div>
	   <?php
	   	}
	   	?>
    	</td>
    	</tr></table>
    </div>
	
	<?php
	$log = MM_SafeMode::getLog();
	
	if(count($log) > 0) {
	?>
	
	<div style="margin-top: 20px; width: 750px;">
		<p><span style="font-size:16px;">Safe Mode Log</span> <a onclick="mmjs.clearLog()" style="font-size:11px; margin-left:5px;">clear log</a></p>
		<table style="width:100%;">
			<tr>
				<td style="width:180px;"><strong>Date</strong></td>
				<td style="width:60px;"><strong>Action</strong></td>
				<td><strong>Details</strong></td>
			</tr>
			<?php 
				foreach($log as $logEvent) {
			?>
			<tr>
				<td style="vertical-align:top;"><?php echo MM_Utils::dateToLocal($logEvent->date); ?></td>
				<td style="vertical-align:top;"><?php 
					if($logEvent->mode == MM_SafeMode::$MODE_ENABLED) 
					{
						echo MM_Utils::getIcon('play-circle', 'green', '1.3em', '2px', "Safe Mode Enabled");
					} 
					else
					{
						echo MM_Utils::getIcon('stop', 'red', '1.2em', '1px', "Safe Mode Disabled");
					}
				?></td>
				<td><span style="font-size:11px"><?php echo $logEvent->message; ?></span></td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<?php } ?>
</div>