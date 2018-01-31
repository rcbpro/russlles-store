<?php include_once("inc_header.php"); ?>
<?	
	$message_id = ((isset($_REQUEST['message_id'])&&$_REQUEST['message_id']!='')?$_REQUEST['message_id']:''); 
?>   
    <div id="masthead">
		<div class="content_pad"><h1 class="no_breadcrumbs">Users</h1></div> <!-- .content_pad -->
	</div> <!-- #masthead -->	
	<div id="content" class="xgrid">
		<? if($message_id!=''){?> 
            <div class="field">
                <label>&nbsp;</label> 
                <span style="text-align:left;color:#FF9900;font-weight:bold;"><?=get_message($message_id)?></span>
            </div>
        <? } ?>
		<div class="x12">	
				<div class="font-setting"><h2>&nbsp;</h2></div><div class="cs-setting">
                <? if($_SESSION['user_type'] == 1){ ?>
                <button class="btn btn-small" onClick="javascript: location='user-edit.php?id=0';">Add New User</button>
                <? } ?>
                </div>
				<table width="100%" id="custom_table_1" border="0" align="center"  cellpadding="1" cellspacing="1">
						<tr  bgcolor="#000000">
							<th align="center">ID</th>
							<th align="left">Name</th>
							<th align="center">Edit</th>
						</tr> 
                    <? 

						$where = "";
						if($_SESSION['user_type'] == 0){
							$where = "WHERE id='".$_SESSION['user_id']."'";
						}

						$sql = "SELECT id,first_name,last_name FROM user ".$where ." ORDER BY id DESC ";

						$db->execute($sql,$result); 
						if(mysql_num_rows($result) > 0){ 
							while($row = mysql_fetch_array($result)){ 
								$name = $row['first_name']." ".$row['last_name'];

					?> 
                	<tr>
                        <td align="center"><?=$row['id']?></td>
                        <td align="left"><?=($name=="" ? "&nbsp;":$name)?></td>
                        <td align="right">
                        <a href="user-edit.php?id=<?=$row['id']?>">
                        	<img src="../images/edit.png" border="0" title="Edit User" alt="Edit User">
                        </a>
                        <a href="" onClick="javascript: get_confirmation('Are you sure you wish to delete this user? ','user-delete.php?id=<?=$row['id']?>')">
                        	<img src="../images/cross.png" border="0" title="Delete User" alt="Delete User">
                        </a>
                        </td>
                    </tr>
                <? 		} 
					}else{ 
				?>
                	<tr bgcolor="#FFFFFF">
                        <td colspan="3" align="center"><strong>No Record Found !</strong></td>
                    </tr>
                <? } ?> 
				</table>
		</div> <!-- .x12 -->
	</div> <!-- #content -->
	<?php include_once("inc_footer.php"); ?><!-- #footer -->		
</div> <!-- #wrapper -->
</body> 
</html>