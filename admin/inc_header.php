<?php 
session_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);
header("Cache-control: private");
if(!$_SESSION['is_logged']){
	header("location: index.php");
	exit();
}

require_once("../config/config.php");
require_once("../lib/class.config_db.php");
//require_once("../lib/class.mysql.php");
require_once("../lib/database.php");
include_once("../lib/ckeditor/ckeditor.php");
include_once("inc_message.php");

$page = $_SERVER['REQUEST_URI'];
if(isset($_REQUEST['msg'])){
	$msg = $_REQUEST['msg'];
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-type" content="text/html; charset=utf-8" /> 
<title><?php echo ADMIN_PANEL_TITLE?></title> 
<link rel="stylesheet" href="../css/reset.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="../css/text.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="../css/form.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="../css/buttons.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="../css/grid.css" type="text/css" media="screen" title="no title" />	
<link rel="stylesheet" href="../css/layout.css" type="text/css" media="screen" title="no title" />	
<link rel="stylesheet" href="../css/ui-darkness/jquery-ui-1.8.12.custom.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="../css/plugin/jquery.visualize.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="../css/plugin/facebox.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="../css/plugin/uniform.default.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="../css/plugin/dataTables.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="../css/custom.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="../css/prettyPhoto.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="../css/pagination.css" rel="stylesheet" type="text/css" /> 
<script src="../js/jquery/jquery-1.5.2.min.js"></script>
<script src="../js/jquery/jquery-ui-1.8.12.custom.min.js"></script>
<script src="../js/misc/excanvas.min.js"></script>
<script src="../js/jquery/facebox.js"></script>
<script src="../js/jquery/jquery.visualize.js"></script>
<script src="../js/jquery/jquery.dataTables.min.js"></script>
<script src="../js/jquery/jquery.tablesorter.min.js"></script>
<script src="../js/jquery/jquery.uniform.min.js"></script>
<script src="../js/jquery/jquery.placeholder.min.js"></script>
<script src="../js/widgets.js"></script>
<script src="../js/dashboard.js"></script>
<script src="../js/jquery.js" language="javascript" type="text/javascript"></script>
<script src="../js/jquery.validate.min.js" language="javascript" type="text/javascript"></script>
<script src="../js/validation.js" language="javascript" type="text/javascript"></script>
<script src="../js/jquery.prettyPhoto.js" language="javascript" type="text/javascript"></script>
<script src="../js/jquery.min.js" language="javascript" type="text/javascript"></script>
<script src="../js/stepcarousel.js" language="javascript" type="text/javascript"></script>
<script src="../js/jquery-1.4.4.min.js" language="javascript" type="text/javascript"></script>
<script src="../js/corners.js" language="javascript" type="text/javascript"></script>
<script src='../js/editable.js' language="javascript" type='text/javascript'></script>
<script language="javascript" type="text/javascript">
$(window).ready(function() {
	$("#pricesDiv").corner("keep");
});
</script>
</head> 
<body> 
<div id="wrapper">
	<div id="top"><?php echo $page?>
		<div class="content_pad">			
			<ul class="right">
				<li><a href="javascript:;" class="top_icon"><span class="ui-icon ui-icon-person"></span>Logged in as <?=$_SESSION['logged_user']?></a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div> <!-- .content_pad -->
	</div> <!-- #top -->
	<div id="header">
		<div class="content_pad">
			<img src="<?php echo ADMIN_PANEL_LOGO_SRC?>" />
		</div> <!-- .content_pad -->	
	</div> <!-- #header -->	
	