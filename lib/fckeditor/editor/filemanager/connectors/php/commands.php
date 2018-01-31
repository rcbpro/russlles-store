<?php
session_start();

require_once("../../../../../../config/init.php");
require_once("../../../../../class.mysql.php");

/*
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
 * This is the File Manager Connector for PHP.
 */
 
 /*--------------------------------------------------------------------------------------------------------------------
 Start budget website funtion area
 
	Author		:	Sanjana
	Purpose     :   Create new name of image and insert image details to databse
	Created     :   06/10/2009
 ---------------------------------------------------------------------------------------------------------------------*/
	//$con=mysql_connect('mysql03.ceylonnet.com','EasyUni_sanjana','5VYMNmTg')or die('Not connect with server'.mysql_error());
	//mysql_select_db('EasyUni_sanjana',$con);
/*----------------------------------------------------------------------------------------------------------------
Function Name	:  	cretae_new_image_name()
Purpose			:	create image name to uploaded image using databse image_id field
Parameters		:

Author          :   Sanjana
Created         :   06/10/2009

Modification:               
                    
----------------------------------------------------------------------------------------------------------------*/
function get_next_image_name(){
	$db=new mySQL();
	$sql="SHOW TABLE STATUS LIKE 'e8_uploaded_image'";
	$db->execute($sql,$result);
	$row = mysql_fetch_array($result) ;
	$next_id =$row['Auto_increment'];//get auto increment value
	unset($db,$result);
    return $next_id;//return auto increment value
}
/*----------------------------------------------------------------------------------------------------------------
Function Name	:  	image_detail()
Purpose			:	Insert image details to database using parameters passing from commands.php in FCkEditor
Parameters		:	$original_name,
					$new_name

Author          :   Sanjana
Created         :   06/10/2009

Modification:        
                            
----------------------------------------------------------------------------------------------------------------*/
function image_detail($original_name,$new_name){
	$now_date_time=date('Y-m-d H:i:s');
	$db=new mySQL();
	$sql="INSERT INTO e8_uploaded_image (original_file_name,uploaded_date_time,uploaded_name) VALUES('$original_name','$now_date_time','$new_name')";
	$db->execute($sql,$result);
	unset($db,$result);
}
/*----------------------------------------------------------------------------------------------------------------
	end budget website developer function area
----------------------------------------------------------------------------------------------------------------*/
function GetFolders( $resourceType, $currentFolder )
{
	// Map the virtual path to the local server path.
	$sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'GetFolders' ) ;

	// Array that will hold the folders names.
	$aFolders	= array() ;

	$oCurrentFolder = @opendir( $sServerDir ) ;

	if ($oCurrentFolder !== false)
	{
		while ( $sFile = readdir( $oCurrentFolder ) )
		{
			if ( $sFile != '.' && $sFile != '..' && is_dir( $sServerDir . $sFile ) )
				$aFolders[] = '<Folder name="' . ConvertToXmlAttribute( $sFile ) . '" />' ;
		}
		closedir( $oCurrentFolder ) ;
	}

	// Open the "Folders" node.
	echo "<Folders>" ;

	natcasesort( $aFolders ) ;
	foreach ( $aFolders as $sFolder )
		echo $sFolder ;

	// Close the "Folders" node.
	echo "</Folders>" ;
}

function GetFoldersAndFiles( $resourceType, $currentFolder )
{
	// Map the virtual path to the local server path.
	$sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'GetFoldersAndFiles' ) ;

	// Arrays that will hold the folders and files names.
	$aFolders	= array() ;
	$aFiles		= array() ;

	$oCurrentFolder = @opendir( $sServerDir ) ;

	if ($oCurrentFolder !== false)
	{
		while ( $sFile = readdir( $oCurrentFolder ) )
		{
			if ( $sFile != '.' && $sFile != '..' )
			{
				if ( is_dir( $sServerDir . $sFile ) )
					$aFolders[] = '<Folder name="' . ConvertToXmlAttribute( $sFile ) . '" />' ;
				else
				{
					$iFileSize = @filesize( $sServerDir . $sFile ) ;
					if ( !$iFileSize ) {
						$iFileSize = 0 ;
					}
					if ( $iFileSize > 0 )
					{
						$iFileSize = round( $iFileSize / 1024 ) ;
						if ( $iFileSize < 1 )
							$iFileSize = 1 ;
					}

					$aFiles[] = '<File name="' . ConvertToXmlAttribute( $sFile ) . '" size="' . $iFileSize . '" />' ;
				}
			}
		}
		closedir( $oCurrentFolder ) ;
	}

	// Send the folders
	natcasesort( $aFolders ) ;
	echo '<Folders>' ;

	foreach ( $aFolders as $sFolder )
		echo $sFolder ;

	echo '</Folders>' ;

	// Send the files
	natcasesort( $aFiles ) ;
	echo '<Files>' ;

	foreach ( $aFiles as $sFiles )
		echo $sFiles ;

	echo '</Files>' ;
}

function get_file_extension($file_name){ 
	$file	=	strtolower($file_name);
	$ext	=	split("[/\\.]", $file_name);
	$last	=	count($ext)-1;
	return $ext[$last];
}

function CreateFolder( $resourceType, $currentFolder )
{
	if (!isset($_GET)) {
		global $_GET;
	}
	$sErrorNumber	= '0' ;
	$sErrorMsg		= '' ;

	if ( isset( $_GET['NewFolderName'] ) )
	{
		$sNewFolderName = $_GET['NewFolderName'] ;
		$sNewFolderName = SanitizeFolderName( $sNewFolderName ) ;

		if ( strpos( $sNewFolderName, '..' ) !== FALSE )
			$sErrorNumber = '102' ;		// Invalid folder name.
		else
		{
			// Map the virtual path to the local server path of the current folder.
			$sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'CreateFolder' ) ;

			if ( is_writable( $sServerDir ) )
			{
				$sServerDir .= $sNewFolderName ;

				$sErrorMsg = CreateServerFolder( $sServerDir ) ;

				switch ( $sErrorMsg )
				{
					case '' :
						$sErrorNumber = '0' ;
						break ;
					case 'Invalid argument' :
					case 'No such file or directory' :
						$sErrorNumber = '102' ;		// Path too long.
						break ;
					default :
						$sErrorNumber = '110' ;
						break ;
				}
			}
			else
				$sErrorNumber = '103' ;
		}
	}
	else
		$sErrorNumber = '102' ;

	// Create the "Error" node.
	echo '<Error number="' . $sErrorNumber . '" />' ;
}

function FileUpload( $resourceType, $currentFolder, $sCommand )
{
//$fp = fopen('upload.txt', 'w');
//fwrite($fp, 'Start uploading..'); 


	if (!isset($_FILES)) {
		global $_FILES;
	}
	$sErrorNumber = '0' ;
	$sFileName = '' ;

	if ( isset( $_FILES['NewFile'] ) && !is_null( $_FILES['NewFile']['tmp_name'] ) )
	{
		global $Config ;
		
		$oFile = $_FILES['NewFile'] ;

		// Map the virtual path to the local server path.
		$sServerDir = ServerMapFolder( $resourceType, $currentFolder, $sCommand ) ;

		// Get the uploaded file name.
		$sFileName = $oFile['name'] ;
		$sFileName = SanitizeFileName( $sFileName ) ;

		$sOriginalFileName = $sFileName ;
		$original_file_name=$sFileName;//assign to original file name to variable..... --- Budget website ---
		
		// Get the extension.
		$sExtension = substr( $sFileName, ( strrpos($sFileName, '.') + 1 ) ) ;
		$sExtension = strtolower( $sExtension ) ;

		if ( isset( $Config['SecureImageUploads'] ) )
		{
			if ( ( $isImageValid = IsImageValid( $oFile['tmp_name'], $sExtension ) ) === false )
			{
				$sErrorNumber = '202' ;
				//fwrite($fp, 'error -202 line 265'); 
			}
		}

		if ( isset( $Config['HtmlExtensions'] ) )
		{
			if ( !IsHtmlExtension( $sExtension, $Config['HtmlExtensions'] ) &&
				( $detectHtml = DetectHtml( $oFile['tmp_name'] ) ) === true )
			{
				$sErrorNumber = '202' ;
				//fwrite($fp, 'error -202 line 275'); 
			}
		}

		// Check if it is an allowed extension.
		if ( !$sErrorNumber && IsAllowedExt( $sExtension, $resourceType ) )
		{
			$iCounter = 0 ;
			
			
		/*	$sFileName= rand(10000,1000000);
			$sFileName= $sFileName .".". $sExtension;*/
			$sFileName = get_next_image_name();
			$orginal_file_name=strtolower($oFile['name']);
			//get_file_extension($file_name)
			
			$file_name_without_extension=str_replace(get_file_extension($orginal_file_name),'',$orginal_file_name);
			//$sFileName= $sFileName . "-" . uniqid("",true) .".". $sExtension;
			$sFileName= str_replace(' ','_',$file_name_without_extension). "-" .$sFileName.".". $sExtension;
			while ( true )
			{
				$sFilePath = $sServerDir . $sFileName ;

				if ( is_file( $sFilePath ) )
				{
					$iCounter++ ;
					$sFileName = RemoveExtension( $sOriginalFileName ) . '(' . $iCounter . ').' . $sExtension ;
					$sErrorNumber = '201' ;
					//fwrite($fp, 'error -201 line 303'); 
				}
				else
				{
					move_uploaded_file( $oFile['tmp_name'], $sFilePath ) ;

					if ( is_file( $sFilePath ) )
					{
						if ( isset( $Config['ChmodOnUpload'] ) && !$Config['ChmodOnUpload'] )
						{
							break ;
						}

						$permissions = 0777;

						if ( isset( $Config['ChmodOnUpload'] ) && $Config['ChmodOnUpload'] )
						{
							$permissions = $Config['ChmodOnUpload'] ;
						}

						$oldumask = umask(0) ;
						chmod( $sFilePath, $permissions ) ;
						umask( $oldumask ) ;
					}

					break ;
				}
			}

			if ( file_exists( $sFilePath ) )
			{
				//previous checks failed, try once again
				if ( isset( $isImageValid ) && $isImageValid === -1 && IsImageValid( $sFilePath, $sExtension ) === false )
				{
					@unlink( $sFilePath ) ;
					$sErrorNumber = '202' ;
					//fwrite($fp, 'error -202 line 339'); 
				}
				else if ( isset( $detectHtml ) && $detectHtml === -1 && DetectHtml( $sFilePath ) === true )
				{
					@unlink( $sFilePath ) ;
					$sErrorNumber = '202' ;
					//fwrite($fp, 'error -202 line 345'); 
				}
			}
		}
		else
			$sErrorNumber = '202' ;
			//fwrite($fp, 'error -202 line 350'); 
	}
	else
		$sErrorNumber = '202' ;
		//fwrite($fp, 'error -202 line 353'); 


	$sFileUrl = CombinePaths( GetResourceTypePath( $resourceType, $sCommand ) , $currentFolder ) ;
	$sFileUrl = CombinePaths( $sFileUrl, $sFileName ) ;
	
/*----------------------------------------------------------------------------------------------------------------
	Start  budget website developer function call
----------------------------------------------------------------------------------------------------------------*/
	image_detail($original_file_name,$sFileName);
/*----------------------------------------------------------------------------------------------------------------
	end budget website developer function call
----------------------------------------------------------------------------------------------------------------*/
	
	SendUploadResults( $sErrorNumber, $sFileUrl, ($sFileName . "------" . $flag )) ;
	//fwrite($fp, 'end upload '.$sErrorNumber); 
	//fclose($fp);
	exit ;
}
?>
