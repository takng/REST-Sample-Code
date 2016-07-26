<?php
$program = new CreateProgram();
$program->folder = new stdClass();
$program->folder->id = 5562;
$program->folder->type = "Folder";
$program->name = "New Program PHP";
$program->description = "created with PHP";
$program->type = "Default";
$program->channel = "Content";

print_r($program->postData());

class CreateProgram{
	private $host = "CHANGE ME";
	private $clientId = "CHANGE ME";
	private $clientSecret = "CHANGE ME";

	//all params optional
	public $folder;//folders object with id and type
	public $name;//name of program
	public $description;//description of program
	public $type;//type of program
	public $channel;//channel of Program
	public $tags;//array of tag objects
	public $costs;//array of cost objects
	
	public function postData(){
		$url = $this->host . "/rest/asset/v1/programs.json";
		$ch = curl_init($url);
		$requestBody = $this->bodyBuilder();
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json', "Authorization: Bearer " . $this->getToken(), "Content-Type: application/json"));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
		curl_getinfo($ch);
		$response = curl_exec($ch);
		return $response;
	}

	private function getToken(){
		$ch = curl_init($this->host . "/identity/oauth/token?grant_type=client_credentials&client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json',));
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		$token = $response->access_token;
		return $token;
	}
	private function bodyBuilder(){
		$requestBody = "&description=$this->description&type=$this->type&channel=$this->channel";
		if(isset($this->name)){
			$requestBody .= "&name=$this->name";
		}
		if(isset($this->folder)){
			$jsonFolder = json_encode($this->folder);
			$requestBody .= "&folder=$jsonFolder";
		}
		if(isset($this->description)){
			$requestBody .= "&description=$this->description";
		}
		if(isset($this->type)){
			$requestBody .= "&type=$this->type";
		}
		if(isset($this->channel)){
			$requestBody .= "&channel=$this->channel";
		}
		if (isset($this->tags)){
			$jsonTags = json_encode($this->tags);
			$requestBody .= "&tags=$jsonTags";
		}
		if (isset($this->costs)){
			$jsonCosts = json_encode($this->costs);
			$requestBody .= "&costs=$jsonCosts";
		}
		return $requestBody;
	}
}