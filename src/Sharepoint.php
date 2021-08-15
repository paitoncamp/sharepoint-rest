<?php

namespace Pomi;

use GuzzleHttp\Client;
use Doctrine\DBAL\Connection;
use Config;


class Sharepoint
{
	const SP_SITE='sp_site';
	const SP_SITE_NAME='sp_site_name';
	const SP_SITE_PATH='sp_site_path';
	const CLIENT_ID='client_id';
	const CLIENT_SECRET ='client_secret';
	const APP_DOMAIN = 'app_domain';
	const REDIRECT_URI='redirect_uri';
	const TENANT_ID='tenant_id';
	const AUDIENCE_PRINCIPAL_ID='audience_principal_id';
	const AUTHORIZATION_CODE='authorization_code';
	const ACCESS_TOKEN='access_token';
	const REFRESH_TOKEN='refresh_token';
	//Access Control Site/url
	const ACS_SITE ='https://accounts.accesscontrol.windows.net';
	const ACS_ENDPOINT = '/tokens/OAuth/2';
	
	private $configAttr;
	/**
	*   Config
	*/
	public $config;
	
	private $guzzleClient;
	
	public function __construct($config)
    {
		$this->config = $config;
		$this->configAttr = $this->config->getConfigs();
		$this->guzzleClient = new Client();
	}
	
	public function getToken($refresh_token=false){
		/*
		https://accounts.accesscontrol.windows.net/<site_realm>/tokens/OAuth/2
		Post parameters:
		grant_type=authorization_code
		&client_id=<client_id>@<site_realm>
		&client_secret=<client_secret>
		&code=<auth_code>
		&redirect_uri=<redirect_url>
		&resource=< audience principal ID>/<site_host>@<site_realm>
		*/
		$sp_realm = $this->configAttr[self::TENANT_ID];
		if($refresh_token){
			$grant_type='refresh_token';
			$authorization_code = $this->config->getConfig(self::REFRESH_TOKEN);
			$form_params = array("grant_type"=>$grant_type,
							"client_id"=>$this->configAttr[self::CLIENT_ID].'@'.$sp_realm,
							"client_secret"=>$this->configAttr[self::CLIENT_SECRET],
							"refresh_token"=>$authorization_code,
							"redirect_uri"=>$this->configAttr[self::REDIRECT_URI],
							"resource"=>$this->configAttr[self::AUDIENCE_PRINCIPAL_ID].'/'.$this->configAttr[self::SP_SITE].'@'.$sp_realm
			);
		} else {
			$grant_type='authorization_code';
			$authorization_code = $this->config->getConfig(self::AUTHORIZATION_CODE);
			$form_params = array("grant_type"=>$grant_type,
							"client_id"=>$this->configAttr[self::CLIENT_ID].'@'.$sp_realm,
							"client_secret"=>$this->configAttr[self::CLIENT_SECRET],
							"code"=>$authorization_code,
							"redirect_uri"=>$this->configAttr[self::REDIRECT_URI],
							"resource"=>$this->configAttr[self::AUDIENCE_PRINCIPAL_ID].'/'.$this->configAttr[self::SP_SITE].'@'.$sp_realm
			);
		}
		//get new authorization code
		
		$post_data = array();
		$post_header = array("Content-Type"=>"application/x-www-form-urlencoded");
		//return json_encode($form_params);
		
		$response = $this->guzzleClient->request('POST',self::ACS_SITE.'/'.$sp_realm.self::ACS_ENDPOINT,[
			//'headers' => $post_header,
			'form_params' => $form_params
		]);
		
		
		
		$data = json_decode($response->getBody());
		if($response->getStatusCode()=='400'){
			//if(isset($data['error']) && !empty($data['error'])){
				return 'Please run doAzureACS';
			//}
		}
		if($refresh_token){
			$this->config->setConfig(self::ACCESS_TOKEN,$data->access_token);
		} else {
			$this->config->setConfig(self::ACCESS_TOKEN,$data->access_token);
			$this->config->setConfig(self::REFRESH_TOKEN,$data->refresh_token);
		}
		return 'Access Token saved!';
		//return json_encode($form_params);
	}
	
	
}
