<?php

namespace Pomi;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;


class Config
{
	private $connection;
	private $configs;
	
	public function __construct()
    {
		$connectionParams = array(
			'dbname' => 'sp-rest-api',
			'user' => 'root',
			'password' => '',
			'host' => 'localhost',
			'driver' => 'pdo_mysql',
		);
		$this->connection = DriverManager::getConnection($connectionParams);

	}
	
	public function getConfigs(){
		$result = $this->connection->query("select * from config");
		//$this->configs = $result->fetchAllAssociative();
		while (($row = $result->fetchAssociative()) !== false) {
			$this->configs[$row['name']]=$row['value']; //$row['headline'];
		}
		return $this->configs;
	}
	
	public function setConfig($name,$val,$notes=''){
		$res = $this->connection->fetchOne('SELECT 1 FROM config WHERE name = ?', array($name));
		if($res){
			$this->connection->update('config', array('name' => $name,'value' => $val,'notes'=>$notes),array('name'=>$name));
		} else {
			$this->connection->insert('config', array('name' => $name,'value' => $val,'notes'=>$notes));
		}
	}
	
	public function getConfig($name){
		if(isset($this->configs[$name]) && !empty($this->configs[$name])){
			return $this->configs[$name];
		} else {
			$sql = "SELECT * FROM config WHERE name = ?";
			$res = $this->connection->fetchOne('SELECT value FROM config WHERE name = ?', array($name));
			return $res;
		}
	}
}