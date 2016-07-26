<?php
$files = new ListFiles();
print_r($files->getData());


class ListFiles{
	private $host = "CHANGE ME";
	private $clientId = "CHANGE ME";
	private $clientSecret = "CHANGE ME";
	public $folder;//json object with two members, id and type(Folder or Program)
	public $offset;//integer offset for paging
	public $maxReturn;//max number of records to return
	
	public function getData(){
		$url = $this->host . "/rest/asset/v1/files.json?access_token=" . $this->getToken();
		if (isset($this->file)){
			$url .= "&folder=" . json_encode($this->folder);
		}
		if (isset($this->offset)){
			$url .= "&offset=" . $this->offset;
		}
		if (isset($this->maxReturn)){
			$url .= "&maxReturn=" . $this->maxReturn;
		}
		$ch = curl_init($url);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json',));
		$response = curl_exec($ch);
		return $response;
	}
	
	private function getToken(){
		$ch = curl_init($this->host . "/identity/oauth/token?grant_type=client_credentials&client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json'));
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		$token = $response->access_token;
		return $token;
	}
}