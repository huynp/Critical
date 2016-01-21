<?php
/**
 * 
 * MemberMouse(TM) (http://www.membermouse.com)
 * (c) MemberMouse, LLC. All rights reserved.
 */

if(isset($_REQUEST[MM_Session::$PARAM_USER_ID])) 
{
	$user = new MM_User($_REQUEST[MM_Session::$PARAM_USER_ID]);

	if($user->isValid()) 
	{
		// check to make sure current employee has access to manage this member
		global $current_user;
		$employee = MM_Employee::findByUserId($current_user->ID);
		$allowAccess = true;
		
		if($employee->isValid())
		{
			$allowAccess = $employee->canManageMember($user);
		}
		
		if($allowAccess) 
		{
?>
<div id="mm-form-container">
	<?php 
		if(isset($_GET["page_id"]))
		{
			$udPage = new MM_UserDefinedPage($_GET["page_id"]);
			
			$data = new stdClass();
			$data->member_id = $user->getId();
			$userData = MM_APIService::getMember($data);
			
			if($udPage->isValid())
			{
				echo "<iframe src='".$udPage->getUrl()."?".http_build_query($userData->message)."' width='98%' height='650px'></iframe>";
			}
			else 
			{
				echo "<em>ERROR: User-defined page not found.</em>";
			}
		}
		else 
		{
			echo "<em>ERROR: User-defined page not found.</em>";
		}
	?>
</div>

<div style='clear: both; height:20px;'></div>

<?php 
	}
	else
	{
		echo "<div style=\"margin-top:10px;\"><em>You do not have permission to manage this member.</em></div>";
	}
}
else 
{
	echo "<div style=\"margin-top:10px;\"><em>Invalid Member ID</em></div>";
}
}
?>