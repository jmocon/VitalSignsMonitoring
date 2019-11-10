<?php
$mdlVital = new VitalModel();
class VitalModel{

	private $Id = "";
	private $Username = "";
	private $DateTime = "";
	private $BodyTemperature = "";
	private $HeartRate = "";
	private $Diastolic = "";
	private $Systolic = "";
	private $RespirationRate = "";

	public function __construct(){}

	//Id
	public function getId(){
		return $this->Id;
	}

	public function getsqlId(){
		$Database = new Database();
		$conn = $Database->GetConn();
		$value = mysqli_real_escape_string($conn,$this->Id);
		mysqli_close($conn);
		return $value;
	}

	public function setId($Id){
		$this->Id = $Id;
	}


  //Username
  public function getUsername(){
    return $this->Username;
  }

  public function setUsername($Username){
    $this->Username = $Username;
  }


  //DateTime
  public function getDateTime(){
    return $this->DateTime;
  }

  public function setDateTime($DateTime){
    $this->DateTime = $DateTime;
  }


	//BodyTemperature
	public function getBodyTemperature(){
		return $this->BodyTemperature;
	}

	public function setBodyTemperature($BodyTemperature){
		$this->BodyTemperature = $BodyTemperature;
	}


	//HeartRate
	public function getHeartRate(){
		return $this->HeartRate;
	}

	public function setHeartRate($HeartRate){
		$this->HeartRate = $HeartRate;
	}


	//Diastolic
	public function getDiastolic(){
		return $this->Diastolic;
	}

	public function setDiastolic($Diastolic){
		$this->Diastolic = $Diastolic;
	}


	//Systolic
	public function getSystolic(){
		return $this->Systolic;
	}

	public function setSystolic($Systolic){
		$this->Systolic = $Systolic;
	}


	//RespirationRate
	public function getRespirationRate(){
		return $this->RespirationRate;
	}

	public function setRespirationRate($RespirationRate){
		$this->RespirationRate = $RespirationRate;
	}
}
?>
