<?php
$pathlib=dirname(__FILE__);
//require ($pathlib.'/db.class.php');
session_start();

// Include Librari Google Client (API)
include_once 'google-client/Google_Client.php';
include_once 'google-client/contrib/Google_Oauth2Service.php';

$client_id = 'client_id'; // Google client ID remove last
$client_secret = 'client_secret'; // Google Client Secret remove last
$redirect_url = 'https://s1.cbcomtech.my.id/phpgooglelogin/lib/google.php'; // Callback URL


// Call Google API
$gclient = new Google_Client();
$gclient->setApplicationName('phpgooglelogin'); // Set dengan Nama Aplikasi Kalian
$gclient->setClientId($client_id); // Set dengan Client ID
$gclient->setClientSecret($client_secret); // Set dengan Client Secret
$gclient->setRedirectUri($redirect_url); // Set URL untuk Redirect setelah berhasil login

$google_oauthv2 = new Google_Oauth2Service($gclient);
?>