<?php
/**
 *
 * MemberMouse(TM) (http://www.membermouse.com)
 * (c) MemberMouse, LLC. All rights reserved.
 */

global $wpdb;

$corruptPages = array();

$sql = "SELECT * FROM ".MM_TABLE_CORE_PAGES." WHERE (ref_type IS NULL or ref_type = '') AND (ref_id IS NULL or ref_id = '');";

$results = $wpdb->get_results($sql);

if($results)
{
	foreach($results as $row)
	{
		if(!is_null($row->page_id) && (FALSE === get_post_status($row->page_id)))
		{
			$corruptPages[] = $row;
		}
	}
}
?>
<div class="mm-wrap">
    <p class="mm-header-text">Repair Core Pages</p>
	<div class="mm-button-container">
	</div>
	
	<div class="clear"></div>
	
	<div style="width:750px;" class="mm-info-box blue">
	<?php 
		if(count($corruptPages) > 0) {
			$pageIdList = array();
	?>
		<p>Below is a list of default core pages that are associated with WordPress pages that no longer exist:</p>
		
		<ul>
		<?php foreach($corruptPages as $page) {
			$pageIdList[] = $page->id;
			echo "<li>".MM_CorePageType::getCorePageName($page->core_page_type_id)."</li>";
		}?>
		</ul>
		
		<p>Clicking on the <em>Repair Core Pages</em> button below will repair the core pages table by reinstalling the default core pages.</p>
   		<a onclick="mmjs.repairCorePages('<?php echo implode(",", $pageIdList); ?>');" class="mm-ui-button green">Repair Core Pages</a>
	</div>
	<?php } else { ?>
		There are no corrupt core pages.
	<?php } ?>
	</div>
</div>
