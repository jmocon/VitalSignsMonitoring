<?php
$mdlUser = new UserModel();
class UserModel{

	private $Id = "";
	private $Username = "";
	private $Password = "";
	private $FirstName = "";
	private $MiddleName = "";
	private $LastName = "";
	private $Age = "";
	private $Gender = "";
	private $Address = "";
	private $UserType = "";
	private $DoctorNumber = "";

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


  //Password
  public function getPassword(){
    return $this->Password;
  }

  public function setPassword($Password){
    $this->Password = $Password;
  }


	//FirstName
	public function getFirstName(){
		return $this->FirstName;
	}

	public function setFirstName($FirstName){
		$this->FirstName = $FirstName;
	}


	//MiddleName
	public function getMiddleName(){
		return $this->MiddleName;
	}

	public function setMiddleName($MiddleName){
		$this->MiddleName = $MiddleName;
	}


	//LastName
	public function getLastName(){
		return $this->LastName;
	}

	public function setLastName($LastName){
		$this->LastName = $LastName;
	}


	//Age
	public function getAge(){
		return $this->Age;
	}

	public function setAge($Age){
		$this->Age = $Age;
	}


	//Gender
	public function getGender(){
		return $this->Gender;
	}

	public function setGender($Gender){
		$this->Gender = $Gender;
	}


	//Address
	public function getAddress(){
		return $this->Address;
	}

	public function setAddress($Address){
		$this->Address = $Address;
	}


	//UserType
	public function getUserType(){
		return $this->UserType;
	}

	public function setUserType($UserType){
		$this->UserType = $UserType;
	}


	//DoctorNumber
	public function getDoctorNumber(){
		return $this->DoctorNumber;
	}

	public function setDoctorNumber($DoctorNumber){
		$this->DoctorNumber = $DoctorNumber;
	}


}
?>
