<?
error_reporting(-1);
ini_set("display_errors", 1);
date_default_timezone_set('Europe/Istanbul');

include_once( "Class/11_Control.php" );

Control::ConnectDatabase();
Control::InitialiseSystem();
Control::HandleClientComponents();
Control::AuthorizeClient();
Control::HandleAjaxRequests();
Control::HandlePageRequests();
Control::Conclude();
Control::SendOutput();










/*
$class = new ReflectionClass('System');
$arr = $class->getStaticProperties();
var_dump( $arr );
var_dump( $_COOKIE["loaded"] );
*/