<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<p class="welcome">Welcome, please sign in</p>

<?php
include_once __DIR__ . '/libraries/afterlogic/api.php';	

$current_email = '<i class="fa fa-lock fa-fw"></i>';
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
			$current_email = '<i class="fa fa-unlock fa-fw"></i>'.$signed_email ;
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

?>
<div id="login-form">
<form action="respond-frame.php" method="post"> 
<span class="loginfield"><input placeholder="Email address" type="text" name="Email" class="loginval" value=""><br /> </span>
<input type="password" placeholder="Password" name="Password" class="pass" value=""><br />
<input type="submit" value="Login" id="loginsubmit"> </form>
 </div>
 
<style>.link{margin-left: -10px; padding: 6px 0 6px 10px;width: 100%;}
				body{background:none!important}
				.link:hover{background:#e4e1f0;}
				.user_acc {margin: 30px;clear: left;}
				.link{cursor:pointer;}
				.link span{position:relative;top:-8px;left:10px;font-family: Tahoma;font-size: 16px;}
				#login-form{display:none;color: #333;font-family: Helvetica,'Lucida Grande',Verdana,Arial,Helvetica,sans-serif;width:500px;clear:left;}		
				
				#login-form .loginval, #login-form .pass{	-moz-appearance: none;
    border: 1px solid #999;
    border-radius: 3px;
    box-sizing: border-box;
    color: #666;
    display: inline-block;
    font-family: Helvetica,Arial,Verdana,sans-serif;
    margin-bottom: 10.5px;
    max-width: 280px;
    padding: 7px;
    vertical-align: middle;
				width: 100%;}
				#loginsubmit{
					background: none repeat scroll 0 0 #50afd4;
    border: medium none;
    border-radius: 3px;
    box-sizing: border-box;
    color: white;
    cursor: pointer;
    display: inline-block;
    font-family: Helvetica,Arial,Verdana,sans-serif;
    margin: 0;
    padding: 7px 21px;
    position: relative;
    text-align: center;
    text-decoration: none !important;
    vertical-align: middle;
	background: none repeat scroll 0 0 #5772a8;
    width: 280px;				
				}
				.adm {float: right;color:navy;margin:0 15px}
				.welcome{	
    color: #666;    
    font-family: Helvetica,Arial,Verdana,sans-serif;    
    padding: 7px;
    vertical-align: middle;
	float:left;
				}
	.curr {margin: 0 0 0 28px;
    clear: left;
    color: #999;    
    font-size: 12px !important;
    font-style: italic;
    text-align: center;}
	.unread {
    border-radius: 2px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.7);
    background-color: #dc0d17;
    background-image: linear-gradient(#fa3c45, #dc0d17);
    color: #fff;
    min-height: 13px;
    padding: 1px 3px;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4);
    margin-left: 10px;    
    }
	.link a{text-decoration:none;color:#333;}			</style>
<?php

require_once '../../../../../wp-config.php';

		// Create connection
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$sql = "SELECT email FROM wm_awm_accounts";
		$result = mysqli_query($conn, $sql);		
		
	if (mysqli_num_rows($result) > 0) {
		
		echo '<div class="user_acc">';

    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {		
		if($row['email'] == $signed_email){
		$unread = '<span class="unread">'.$aData[1].'</span>';
		if($aData[1] == 0){$unread = "";}		
        echo  '<p class="link"><a href="../webmailing/index.php"><img src="img/loguser.gif" alt="" /><span>' . $row["email"]. '</span><span class="curr">Currently Signed In</span></a>'.$unread.'</p>';
		}else{
		echo  '<p class="link exist"><img src="img/loguser.gif" alt="" /><span>' . $row["email"]. '</span></p>';			
		}
		}
        echo '<p class="link another"><img src="img/notlog.gif" alt="" /><span>User another account</span></p>';
		echo '</div>';	
					
		echo "
		<script>
		$( document ).ready(function() {
		$( '.another' ).click(function() {
				$('#login-form').show();	
				$('.loginval').val('');
				$('.loginfield').show();	
				$( '#login-form' ).insertAfter( this );
		});	
		$( '.exist' ).click(function() {
				var a = $(this).children('span').text();
				$('#login-form').show();				
				$('.loginval').val(a);					
				$('.loginfield').hide();			
				$( '#login-form' ).insertAfter( this );
		});	
		$('#message').insertAfter( '.another' );
		});
		</script>";		
			
		} 
		
		else {
			echo '<style>
				#login-form{display:block;padding:50px 20px;}					
				</style>
				<script>
				$( document ).ready(function() {
		 function validateEmail($email) {
		  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		  return emailReg.test( $email );
		}		
				
		});</script>';
		}
?>