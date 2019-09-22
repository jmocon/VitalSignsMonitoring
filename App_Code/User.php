<?php
require_once ("UserModel.php");
$clsUser = new User();
class User{

	private $table = "userdata";

	public function __construct(){}

	public function Add($mdl){

		$GS = new GoogleSheet();
    $service = $GS->GetService();
    $range = $this->table;

		$values = [[
			$mdl->getUsername(),
			$mdl->getPassword(),
			$mdl->getFirstName(),
			$mdl->getMiddleName(),
			$mdl->getLastName(),
			$mdl->getAge(),
			$mdl->getGender(),
			$mdl->getAddress(),
			$mdl->getUserType()
		]];
		$body = new Google_Service_Sheets_ValueRange([
			'values' => $values
		]);
		$params = ['valueInputOption' => 'RAW'];
		$insert = ['insertDataOption' => 'INSERT_ROWS'];
		$result = $service->spreadsheets_values->append($GS->GetSheetId(),$range,$body,$params,$insert);
  }

	public function IsUsernameExist($value){
		$lstUser = $this->Get();
		$found = false;

		foreach ($lstUser as $mdlUser) {
			if ($mdlUser->getUsername() == $value) {
				$found = true;
				break;
			}
		}

		return $found;
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

    $mdl = new UserModel();
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
      $mdl = new UserModel();
      $mdl = $this->ToModel($row,$count);
      array_push($lst,$mdl);
    }
    return $lst;
  }

  public function ToModel($row,$index = 0){
    $mdl = new UserModel();
    $mdl->setId($index);
    $mdl->setUsername   ((isset($row[0])) ? $row[0] : '');
    $mdl->setPassword   ((isset($row[1])) ? $row[1] : '');
    $mdl->setFirstName  ((isset($row[2])) ? $row[2] : '');
    $mdl->setMiddleName ((isset($row[3])) ? $row[3] : '');
    $mdl->setLastName   ((isset($row[4])) ? $row[4] : '');
    $mdl->setAge        ((isset($row[5])) ? $row[5] : '');
    $mdl->setGender     ((isset($row[6])) ? $row[6] : '');
    $mdl->setAddress    ((isset($row[7])) ? $row[7] : '');
    $mdl->setUserType   ((isset($row[8])) ? $row[8] : '');
    return $mdl;
  }

	public function Delete($row){
		
	}
}
