<?php 
include_once("inc_header.php"); 

$id  = ((isset($_REQUEST['id'])&&$_REQUEST['id']!='')?$_REQUEST['id']:'0');
$message_id = ((isset($_REQUEST['message_id'])&&$_REQUEST['message_id']!='')?$_REQUEST['message_id']:'');

if($_SESSION['user_type'] == 0){
	$id = $_SESSION['user_id'];
}


$sql = "SELECT * FROM user WHERE id='".$id."'";
$db->execute($sql,$result);
if(mysql_num_rows($result) > 0){
	$first_name 	= mysql_result($result,0,"first_name");
	$last_name 		= mysql_result($result,0,"last_name");
	$user_name 		= mysql_result($result,0,"user_name");
	$is_activate 	= mysql_result($result,0,"is_activate");
	$type			= mysql_result($result,0,"user_type");
}else{
	$first_name 	= '';
	$last_name 		= '';
	$user_name 		= '';
	$is_activate 	= '';
	$type			= '';	
}
?>

	<div id="masthead">
		<div class="content_pad">
			<h1 class="no_breadcrumbs">User Edit</h1>
		</div> <!-- .content_pad -->
	</div> <!-- #masthead -->	

	<div id="content" class="xgrid"> 
		<div class="x12">
			<form name="user" id="user" method="post" class="form label-inline uniform" action="user-save.php">
            <input type="hidden" name="user_id" id="user_id" value="<?=$id?>" />
  			 <? if($message_id!=''){?> 
                <div class="field">
                    <label>&nbsp;</label> 
                    <span style="text-align:left;color:#FF9900;font-weight:bold;"><?=get_message($message_id)?></span>
                </div>
            <? } ?>
                <div class="field"> 
                    <label for="first_name">First Name</label>  
                    <input id="first_name" name="first_name" size="50" type="text" class="medium" value="<?=$first_name?>" />
                </div>

                <div class="field"> 
                    <label for="last_name">Last Name</label>  
                    <input id="last_name" name="last_name" size="50" type="text" class="medium" value="<?=$last_name?>" />
                </div>

                <div class="field">
                    <label for="user_name">User Name</label> 
                    <input id="user_name" name="user_name" size="50" type="text" class="medium" value="<?=$user_name?>" autocomplete="off" />
                </div>

                <div class="field">
                    <label for="password">Password</label> 
                    <input id="password" name="password" size="50" type="password" class="medium" value="" autocomplete="off" />
                </div>

                <div class="field">
                    <label for="re_password">Re enter Password</label> 
                    <input id="re_password" name="re_password" size="50" type="password" class="medium" value="" autocomplete="off" />
                </div>

				<? if($_SESSION['user_type'] == 1){ ?>
				<div class="field">
                    <label for="re_password">User Type</label> 
                    <select id="type" name="type" class="medium">
                        <optgroup label="User Type">
                            <option <?=($type==0? "selected" : "")?> value="0">Normal User</option>
                            <option <?=($type==1? "selected" : "")?> value="1">Administrator</option>
                        </optgroup>
				</select>

                </div>

                <div class="field">
                	<span class="label">Is Active?</span>
                    <div class="controlset-pad">
                        <input name="is_activate" id="is_activate" value="1" type="checkbox" <?=($is_activate == 1 ? "checked" : "")?> />
                    </div>
                </div>
				<? }else{ ?>
					<input type="hidden" name="type" id="type" value="<?=$user_type?>" />
                	<input type="hidden" name="is_activate" id="is_activate" value="<?=$is_activate?>" />
				<? } ?>	

                <div class="buttonrow">
                    <button class="btn" type="button" onClick="javascript: location='user-list.php';">Go Back</button>
                    <button class="btn btn-black" type="submit" >Save User &raquo;</button>
                    <? if($id != 0){ ?>
                    	<button class="btn btn-grey" type="button" onClick="javascript: get_confirmation('Are you sure you wish to delete this user? ','user-delete.php?id=<?=$id?>')">Delete</button>
                    <? } ?>
                </div>
            </form>
		</div> <!-- .x12 --> 
	</div> <!-- #content --> 
	 <?php include_once("inc_footer.php"); ?><!-- #footer -->		
</div> <!-- #wrapper -->
</body> 
</html>