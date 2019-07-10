<?php
require_once ("VitalModel.php");
$clsVital = new Vital();
class Vital{

	private $table = "vitaldata";

	public function __construct(){}


	public function DeleteByUsername($username) {
		$GS = new GoogleSheet();
    $service = $GS->GetService();
    $range = $this->table;
		$items = [];

		$lstVital = $this->Get();
		foreach ($lstVital as $mdlVital) {
			if ($mdlVital->getUsername() == $username) {
				array_push($items,$mdlVital->getId());
			}
		}
		for ($i=count($items)-1; $i >= 0; $i--) {
			$id_prev = $items[$i] - 1;
			$deleteOperation =
				array(
					'range' => array(
            'sheetId'   => 1194956557, // <======= This mean the very first sheet on worksheet
            'dimension' => 'ROWS',
            'startIndex'=> $id_prev, //Identify the starting point,
            'endIndex'  => $items[$i] //Identify where to stop when deleting
          )
      	);
			$deletable_row[] = new Google_Service_Sheets_Request(
        array('deleteDimension' =>  $deleteOperation)
      );
			$delete_body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(
			  array('requests' => $deletable_row)
			);
			$result = $service->spreadsheets->batchUpdate($GS->GetSheetId(),$delete_body);
		}
	}

  public function Get(){

    $GS = new GoogleSheet();
    $service = $GS->GetService();
    $range = $this->table;
    $response = $service->spreadsheets_values->get($GS->GetSheetId(),$range);
    $result = $response->getValues();

		return $this->ListTransfer($result);
	}


  public function ModelTransfer($result){

    $mdl = new VitalModel();
    while($row = mysqli_fetch_array($result))
    {
      $mdl = $this->ToModel($row);
    }
    return $mdl;
  }

  public function ListTransfer($result){
    $lst = array();
    $count = 0;
    foreach ($result as $row) {
      $count++;
      $mdl = new VitalModel();
      $mdl = $this->ToModel($row,$count);
      array_push($lst,$mdl);
    }
    return $lst;
  }

  public function ToModel($row,$index = 0){
    $mdl = new VitalModel();
    $mdl->setId($index);
    $mdl->setUsername   			((isset($row[0])) ? $row[0] : '');
    $mdl->setDateTime   			((isset($row[1])) ? $row[1] : '');
    $mdl->setBodyTemperature  ((isset($row[2])) ? $row[2] : '');
    $mdl->setHeartRate 				((isset($row[3])) ? $row[3] : '');
    $mdl->setBloodPressure		((isset($row[4])) ? $row[4] : '');
    $mdl->setDiastolic        ((isset($row[5])) ? $row[5] : '');
    $mdl->setSystolic     		((isset($row[6])) ? $row[6] : '');
    $mdl->setRespirationRate  ((isset($row[7])) ? $row[7] : '');
    return $mdl;
  }
}
