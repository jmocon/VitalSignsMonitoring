<?php
require_once ("VitalModel.php");
$clsVital = new Vital();
class Vital{

	private $table = "vitaldata";
	private $gridId = 1194956557;
	private $service = 0;
	private $spreadsheetId = "1CViNms2zmRaZpO0eHePIHtKvbEFuwPPkuTFT0D0lwhI";

	public function __construct(){
		$client = new Google_Client();
		$client->setApplicationName("Google Sheets and PHP Test");
		$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
		$client->setAccessType("offline");
		$dir = dirname(__DIR__, 1);
		$client->setAuthConfig($dir."/database-f587d7d76e58.json");
		$this->service = new Google_Service_Sheets($client);
	}

	public function DeleteByUsername($username) {
		$deletable_row = [];
		$count = 0;
		$responseVital=$this->service->spreadsheets_values->get($this->spreadsheetId,$this->table);
		$valuesVital=$responseVital->getValues();
		foreach ($valuesVital as $row) {
			$count++;
			if ($row[0] == $username) {
				$id = $count;
				$id_prev = $id-1;
				$deleteOperation = array(
				                    'range' => array(
			                        'sheetId'   => $this->gridId, // <======= This mean the very first sheet on worksheet
			                        'dimension' => 'ROWS',
			                        'startIndex'=> $id_prev, //Identify the starting point,
			                        'endIndex'  => $id //Identify where to stop when deleting
				                    )
		                			);

				array_unshift($deletable_row,new Google_Service_Sheets_Request(array('deleteDimension' =>  $deleteOperation)));

			}
		}

	if (!empty($deletable_row)) {
		$delete_body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(array('requests' => $deletable_row));
		$result = $this->service->spreadsheets->batchUpdate($this->spreadsheetId,$delete_body);
	}

	}

	public function UpdateUsername($old,$new) {
		$count = 0;
		$responseVital=$this->service->spreadsheets_values->get($this->spreadsheetId,$this->table);
		$valuesVital=$responseVital->getValues();
		foreach ($valuesVital as $row) {
			$count++;
			if ($row[0] == $old) {
				$range = $this->table."!A".$count.":A".$count;
		    $values = [[$new]];
		    $body = new Google_Service_Sheets_ValueRange([
		      'values' => $values
		    ]);
		    $params = ['valueInputOption' => 'RAW'];
		    $result = $this->service->spreadsheets_values->update($this->spreadsheetId,$range,$body,$params);
			}
		}
	}
}
