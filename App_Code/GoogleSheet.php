<?php
session_start();
require_once (dirname(__FILE__)."/../vendor/autoload.php");
class GoogleSheet{
/**
 * Connect to the GoogleSheets.
 */
	private $service;
  private $sheetId;

	public function __construct(){

    $client = new Google_Client();
    $client->setApplicationName("Google Sheets and PHP Test");
    $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
    $client->setAccessType("offline");
    $client->setAuthConfig(__DIR__."/../database-f587d7d76e58.json");
    $this->service = new Google_Service_Sheets($client);
    $this->sheetId = "1CViNms2zmRaZpO0eHePIHtKvbEFuwPPkuTFT0D0lwhI";


	}

	public function GetService(){
		return $this->service;
	}

	public function GetSheetId(){
		return $this->sheetId;
	}

}
?>
