<?php

session_start();

$_SESSION['email'] = $_POST['Email']; 
$_SESSION['password'] = $_POST['Password'];
// Example of logging into WebMail account using email and
// password for incorporating into another web application
// utilizing WebMail Pro API

include_once __DIR__ . '/libraries/afterlogic/api.php';

if (class_exists('CApi') && CApi::IsValid())
{

// data for logging into account

$sEmail = $_SESSION['email'];
$sPassword = $_SESSION['password'];
try
{

// Getting required API class

$oApiIntegratorManager = CApi::Manager('integrator');

// attempting to obtain object for account we're trying to log into

$oAccount = $oApiIntegratorManager->LoginToAccount($sEmail, $sPassword);
if ($oAccount)
{

// populating session data from the account

$oApiIntegratorManager->SetAccountAsLoggedIn($oAccount);

// redirecting to WebMail
CApi::Location('../webmailing/index.php');
}
  else
{ 
// login error
echo '<div class="error message"><h3>'.$oApiIntegratorManager->GetLastErrorMessage().'</h3>';
echo "<p> <a href='javascript:history.back()'>Go Back and try again</a></p></div>";
}
}

catch(Exception $oException)
{

// login error

echo '<div class="error message"><h3>'.$oException->getMessage().'</h3>';
echo "<p> <a href='javascript:history.back()'>Go Back and try again</a></p></div>";
}
}
  else
{
echo 'WebMail API isn\'t available';
}
?>
<style>
.message{
    background-size: 40px 40px;
    background-image: linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%,
                        transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%,
                        transparent 75%, transparent);                                      
     box-shadow: inset 0 -1px 0 rgba(255,255,255,.4);
     width: 500px;
     border: 1px solid;
     color: #fff;
     padding: 15px;
     position: fixed;
     _position: absolute;
     text-shadow: 0 1px 0 rgba(0,0,0,.5);
     animation: animate-bg 5s linear infinite;
}
.error{
     background-color: #de4343;
     border-color: #c43d3d;
}
.error a {
    color: #fff;
}
</style>