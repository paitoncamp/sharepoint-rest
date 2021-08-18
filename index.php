<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\StreamedResponse;

use Symfony\Component\HttpFoundation\Request;
use Pomi\Sharepoint;
use Pomi\Config as SPConfig;

$app = new Silex\Application();
$app['url'] = "https://example.localhost";
$app['sharepoint_base_url']='https://example.sharepoint.com';
$app['debug'] = true;

$spconfig = new SPConfig();
$sp = new Sharepoint($spconfig);

$app->get('/doAzureACS/{scope}', function ($scope) use ($app,$spconfig) {
	if(!$scope || $scope==''){
		$scope='Web.Read';
	}
	$requestPath ='/_layouts/oauthauthorize.aspx?client_id='.$spconfig->getConfig(Sharepoint::CLIENT_ID).'&scope='.$scope.'&response_type=code&redirect_uri='.$app['url'];
	$redirectACS = $app['sharepoint_base_url'].$spconfig->getConfig(Sharepoint::SP_SITE_PATH).$requestPath;
	return   $app->redirect($redirectACS); //$redirectACS; //
});

$app->get('/doAccessToken/{param}', function ($param) use ($app,$sp) {
	if(isset($param) && !empty($param) && $param=='refresh'){
		return $sp->getToken(true);
	} else {
		return $sp->getToken();
	}
	
});

$app->get('/doAccessToken/', function () use ($app,$sp) {
	return $sp->getToken();
});


$app->get('/', function (Request $request) use ($app,$sp) {
	

	$code   = $request->get('code');
	$error   = $request->get('error');
	$errordesc   = $request->get('error_description');
	
	if(isset($code) && !empty($code)){
		//if found access code, store it to database for next use 
		$sp->config->setConfig(Sharepoint::AUTHORIZATION_CODE,$code);
		//echo "Authorization code saved!";
		return "Authorization code saved!";
	} 
	if(isset($error) && !empty($error)){
		return "Error : $error <br/>Error Desc : $errordesc ";
	}
	return "401";
});


$app->run();

