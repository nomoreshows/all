<?php

// Define the IPB path here on inside the SDKConfig.php file.
define('IPB_PATH', '');
require_once('../SDKConfig.php');
$sdk = IPBSDK::instance();
$login = $sdk->getClass('login');
$self = $_SERVER['PHP_SELF'];

if( $sdk->request['dologin'] )
{
    $login->authLogin( 'admin', '123' );
    header('Location: ' . $self);
}

if( $sdk->request['logout'] )
{
    $login->logOut();
    header('Location: ' . $self);
}

if( !$login->isLoggedIn() )
{
    
    echo "You are not logged in.<Br/>";
    echo "Please <a href='{$self}?dologin=1'>Here</a> to login as admin.";
}
else
{
    echo "Welcome, {$sdk->memberData['members_display_name']} <Br/>";
    echo "Please <a href='{$self}?logout=1'>Here</a> to logout.";
}


var_dump($login->checkLoginAuth('username', 'email', 'password'));