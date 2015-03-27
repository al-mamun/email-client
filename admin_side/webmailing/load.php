<?php

include_once __DIR__ . '/libraries/afterlogic/api.php';


$current_email = '<i class="dashicons dashicons-lock"></i> Not signed in to email';
if(!isset($_SESSION['email']) || !isset($_SESSION['password'])){
		$_SESSION['email']="";
		$_SESSION['password']="";	    
	}

if (class_exists('CApi') && CApi::IsValid())
	{
		session_start();
		$sEmail = $_SESSION['email'];
	    $sPassword = $_SESSION['password'];
	    $sFolder = 'INBOX';			
	
	try
		{
		$oApiIntegratorManager = CApi::Manager('integrator');
		$oAccount = $oApiIntegratorManager->LoginToAccount($sEmail, $sPassword);
		if ($oAccount)
			{
			$oApiMailManager = CApi::Manager('mail');
			$aData = $oApiMailManager->FolderCounts($oAccount, $sFolder); 
			$signed_email = $oAccount->Email;
			$current_email = '<i class="dashicons dashicons-email-alt"></i> '.$signed_email ;
			if (is_array($aData) && 4 === count($aData))
				{ 
				/**echo '<pre>'; echo 'Folder: '.$sFolder."\n"; echo 'Count: '.$aData[0]."\n"; echo 'Unread: '.$aData[1]."\n"; echo 'UidNext: '.$aData[2]."\n"; echo 'Hash: '.$aData[3]; echo '</pre>'; **/
				}
			}
		  else
			{
			echo $oApiIntegratorManager->GetLastErrorMessage();			
			}
		}

	catch(Exception $oException)
		{
		//echo $oException->getMessage();
		}
	}
  else
	{
	echo 'WebMail API isn\'t available';
	}

if (!isset($aData[1]))
	{
	$aData[1] = "";
	}

$unread = '<span class="unread">' . $aData[1] . '</span>';

if ($aData[1] == 0)
	{
	$unread = "";
	}
	echo $unread;
	echo '<span class="cur_emo">'.$current_email.'</span>' ;
	
	echo '<pre>';
echo $_SESSION["token"];
echo '</pre>';