<?php
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!--
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2009 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * This page shows all resources available in a folder in the File Browser.
-->
<html>
<head>
	<title>Resources</title>
	<link href="browser.css" type="text/css" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript">

var oListManager = new Object() ;

oListManager.Clear = function()
{
	document.body.innerHTML = '' ;
}
/*-------------------------------------------------------------------------------*/
function removeFile(site_id,file_name){  
 var main_url=window.location.href.replace('frmresourceslist.php#','browser.html');
 var new_url=main_url+window.top.location.search;
 
	var ok=confirm("Are you sure you want to delete the image \'"+file_name+"\'?");
	if(ok){ 
		var del_status = remove_file(file_name); 
		//if(del_status==true){
			//alert(new_url);
			window.parent.frames['frmUploadWorker'].location = 'javascript:void(0)' ;
			window.parent.frames['frmResourcesList'].Refresh();
			//window.location=new_url;  
		//}else{
			//alert('Unable to delete the file');
		//}	 
	} 
}

function create_http(){
var xmlhttp = false;
	try{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}catch(e){ 
		try{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(E){
			xmlhttp = false;
		}
	}

	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	
	return xmlhttp;
}

function remove_file(file_name){
	var xmlhttp = create_http();
	var randomnumber=Math.random();
	var serverName="http://<?=$_SERVER['SERVER_NAME']?>";
	var del_status=false;
	
	var server_page = serverName+"/unlink.php?file_name="+file_name+"&rand="+randomnumber;
	 
	xmlhttp.open("GET", server_page);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { 
			if(xmlhttp.responseText=='1'){
				del_status=true; 
				alert('The file has been successfully removed'); 
			}else{
				//alert('Unable to delete the file');
			}
		}else{ 
			 del_status=false;
		}
	}
	xmlhttp.send(null); 
 return del_status;
}
 
/*-------------------------------------------------------------------------------*/
function ProtectPath(path)
{
	path = path.replace( /\\/g, '\\\\') ;
	path = path.replace( /'/g, '\\\'') ;
	return path ;
}

oListManager.GetFolderRowHtml = function( folderName, folderPath )
{
	// Build the link to view the folder.
	var sLink = '<a href="#" onclick="OpenFolder(\'' + ProtectPath( folderPath ) + '\');return false;">' ;
//require_once('../../../../../image-resize.php');
//image-resize.php?src='.$file_name_arr.'&wmax=100&hmax=100&quality=90&bgcol=DFDFDF
	return '<tr>' +
			'<td width="16">' +
				sLink +
				'<img alt="" src="images/Folder.gif" width="16" height="16" border="0"><\/a>' +
			'<\/td><td nowrap colspan="2">&nbsp;' +
				sLink +
				folderName +
				'<\/a>' +
		'<\/td><\/tr>' ;
}

oListManager.GetFileRowHtml = function( fileName, fileUrl, fileSize ){ 
	// Build the link to view the folder.
	var serverName="http://<?=$_SERVER['SERVER_NAME']?>";
	var sLink = '<a href="#" onclick="OpenFile(\'' + ProtectPath( fileUrl ) + '\');return false;">' ;
	var scaled_file=serverName+"/microsite/<?=$_SESSION['site_id']?>/images/"+fileName;
	imgSrc=serverName+"/image-resize.php?src="+scaled_file+"&wmax=100&hmax=100&quality=90&bgcol=FFFFFF"; 
	 
	 var fileToRemove="/microsite/<?=$_SESSION['site_id']?>/images/"+fileName;
	 //alert(fileName);
	return '<tr>' +
			'<td width="16" align="center">' +
				sLink +
				'<img alt="" src=\"'+imgSrc+'\" width="75" height="68" border="0"><\/a>' +
			'<\/td>'+
			'<td style="padding-left:55px;">'+sLink+fileName+'<\/a></td>'+ 
			'<td align="right">&nbsp;' + fileSize + ' KB<\/td>' +
			'<td align="right"><a href="#" onClick="javascript:removeFile(\'<?=$_SESSION['site_id']?>\',\''+fileName+'\')"><img src="/images/del.png" border="0" width="16" height="16" align="right" title="Delete"/></a></td>'+
		    '<\/tr>' ;
}
 
function OpenFolder( folderPath )
{
	// Load the resources list for this folder.
	window.parent.frames['frmFolders'].LoadFolders( folderPath ) ;
}

function OpenFile( fileUrl )
{
	window.top.opener.SetUrl( fileUrl ) ;
	window.top.close() ;
	window.top.opener.focus() ;
}

function LoadResources( resourceType, folderPath )
{
	oListManager.Clear() ;
	oConnector.ResourceType = resourceType ;
	oConnector.CurrentFolder = folderPath ;
	oConnector.SendCommand( 'GetFoldersAndFiles', null, GetFoldersAndFilesCallBack ) ;
}

function Refresh()
{
	LoadResources( oConnector.ResourceType, oConnector.CurrentFolder ) ;
}

function GetFoldersAndFilesCallBack( fckXml )
{
	if ( oConnector.CheckError( fckXml ) != 0 )
		return ;

	// Get the current folder path.
	var oFolderNode = fckXml.SelectSingleNode( 'Connector/CurrentFolder' ) ;
	if ( oFolderNode == null )
	{
		alert( 'The server didn\'t reply with a proper XML data. Please check your configuration.' ) ;
		return ;
	}
	var sCurrentFolderPath	= oFolderNode.attributes.getNamedItem('path').value ;
	var sCurrentFolderUrl	= oFolderNode.attributes.getNamedItem('url').value ;

//	var dTimer = new Date() ;

	var oHtml = new StringBuilder( '<table id="tableFiles" cellspacing="1" cellpadding="0" width="85%" align="center" border="0">' ) ;

	// Add the Folders.
	var oNodes ;
	oNodes = fckXml.SelectNodes( 'Connector/Folders/Folder' ) ;
	for ( var i = 0 ; i < oNodes.length ; i++ )
	{
		var sFolderName = oNodes[i].attributes.getNamedItem('name').value ;
		oHtml.Append( oListManager.GetFolderRowHtml( sFolderName, sCurrentFolderPath + sFolderName + "/" ) ) ;
	}

	// Add the Files. http://perl.vv3.co.uk/microsite/311/images/110-4d3e572f131304.33618393.png
	oNodes = fckXml.SelectNodes( 'Connector/Files/File' ) ;
	for ( var j = 0 ; j < oNodes.length ; j++ )
	{
		var oNode = oNodes[j] ;
		var sFileName = oNode.attributes.getNamedItem('name').value ;
		var sFileSize = oNode.attributes.getNamedItem('size').value ; 
		
		//var sImage="<img src=\""+imgSrc+"\" width=\"100\" height=\"100\" border=\"0\" name=\""+sFileName+"\"  id=\""+sFileName+"\"/>";
		//var imgPath=sImage;
		// Get the optional "url" attribute. If not available, build the url.
		var oFileUrlAtt = oNodes[j].attributes.getNamedItem('url') ;
		var sFileUrl = oFileUrlAtt != null ? oFileUrlAtt.value : encodeURI( sCurrentFolderUrl + sFileName ).replace( /#/g, '%23' ) ;

		oHtml.Append( oListManager.GetFileRowHtml( sFileName, sFileUrl, sFileSize ) ) ;
	}

	oHtml.Append( '<\/table>' ) ;

	document.body.innerHTML = oHtml.ToString() ;

//	window.top.document.title = 'Finished processing in ' + ( ( ( new Date() ) - dTimer ) / 1000 ) + ' seconds' ;

}

window.onload = function()
{
	window.top.IsLoadedResourcesList = true ;
}
	</script>
</head>
<body class="FileArea">
</body>

</html>
