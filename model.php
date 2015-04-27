<?php
class Model
{
 public $attributes;

    public $servername;
    private $conn;
    public $useCaseContent;
    public $dbSuccess;
    public $showThis;
    public $opState; // stands for operational state
    public $UserType;
    public $UserID;
    public $Username;
    public $Name;
    public $Address;
    public $Password;
    public $UserAttributes;
    public $PatientName;

    function __construct($ctype="Unknown"){
        $this->PatientName = "_unknown";
  $this->opState = "_construct";
  $this->define($ctype);
  $this->dbSuccess = TRUE;
  $this->UserID = $this->fromCookie("UserID");
        $willRefresh=false;
 }

    public function isPatient(){

    }
    public function getAllUserAttributesFromDB(){
        $this->dbSuccess = FALSE;
        $this->connectToDB();

        $queryString = "SELECT * FROM User WHERE UserID='" .$this->UserID."';";

        $result = $this->conn->query($queryString);
        if($result->num_rows == 1){
            $this->closeDB();
            $this->dbSuccess = TRUE;
            //$row = $result->fetch_assoc();
            while($row = $result->fetch_assoc())
            {
                $this->UserAttributes=$row;
                $this->Name=$row['Name'];
                $this->UserID=$row['UserID'];
                $this->Username=$row['Username'];
                $this->Address=$row['Address'];
                $this->Password=$row['Password'];
            }
            if($this->UserAttributes['UserType']=='Patient'){

                $this->PatientName = $this->UserAttributes['Name'];
            }else{

                $this->PatientName = "Please choose a Patient.<br/>";
            }
        }else{
            $this->closeDB();
            return "ERROR";
        }
    }
    public function getUserTypeFromDB(){
        $this->dbSuccess = FALSE;
        $this->connectToDB();

        $queryString = "SELECT UserType FROM User WHERE UserID='" .$this->UserID."';";

        $result = $this->conn->query($queryString);
        if($result->num_rows == 1){
            $this->closeDB();
            $this->dbSuccess = TRUE;
            $row = $result->fetch_assoc();
            $this->UserType=$row['UserType'];
            return $this->Username;
        }else{
            $this->closeDB();
            return "ERROR";
        }
    }
    public function getUsernameFromDB(){
        $this->dbSuccess = FALSE;
        $this->connectToDB();

        $queryString = "SELECT Username FROM User WHERE UserID='" .$this->UserID."';";

        $result = $this->conn->query($queryString);
        if($result->num_rows == 1){
            $this->closeDB();
            $this->dbSuccess = TRUE;
            $row = $result->fetch_assoc();
            $this->Username=$row['Username'];
            return $this->Username;
        }else{
            $this->closeDB();
            return "ERROR";
        }
    }
    public function get_UserID_fromDB($Username, $Password){

        $this->dbSuccess = FALSE;
        $this->connectToDB();

        $queryString = "SELECT UserID FROM User WHERE Username='" .$Username."' AND Password='".$Password."';";

        $result = $this->conn->query($queryString);
        if($result->num_rows == 1){
            $this->closeDB();
            $this->dbSuccess = TRUE;
            $row = $result->fetch_assoc();
            $this->UserID = $row['UserID'];
            return $this->UserID;
        }else{
            $this->closeDB();
            return "ERROR";
        }
    }
    public function userFilledLogin(){

         $boolean = (isset($_POST['Username']) &&
             isset($_POST['Password']) &&
        !empty($_POST['Password']) &&
        !empty($_POST['Username']) );
        //print $boolean?'true':'false';
        return $boolean;
     }

 public function userFilledRegistrationForm(){
     return (isset($_POST['Name']) &&
     isset($_POST['Username']) &&
     isset($_POST['Password']) &&
     isset($_POST['Address']) &&
     !empty($_POST['Name']) &&
     !empty($_POST['Username']) &&
     !empty($_POST['Password']) &&
     !empty($_POST['Address'])
     );
 }
 
 public function isPostBack(){
  if (isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){
      return TRUE;
  }
  return FALSE;
 }
 
 public function signUpNewUser($Name, $Username, $Password, $Address){
  $this->dbSuccess=FALSE;
  $this->connectToDB();
  $this->dbSuccess=TRUE;
   $queryString = "call sign_up_patient( '".
                  $Name
                  ."', '".
                  $Username
                  ."', '".
                  $Password
                  ."', '".
                  $Address
                  ."')";
 
  if(!$this->conn->query($queryString)){
   print "Errormessage: " . $this->conn->error;
   $this->dbSuccess=FALSE;
  }
  $this->closeDB();
 }
 
 public function connectToDB($servername='localhost',$username='root', $password=''){
  
  $this->servername = $servername;
  $dbname = "LifeThread";
 
  //Create connection
  $this->conn = new mysqli($this->servername, $username, $password, $dbname);
  
  // Check connection
  if ($this->conn->connect_error) {
    die("Connection failed: " . $this->conn->connect_error );
  }
 }
 
 public function closeDB(){
  $this->conn->close();
 }
 
 function resetUserType($rtype="Unknown"){
  $this->define($rtype);
 }
 
 public function set_UserType($uType){
  $this->UserType=$uType;
  toCookie("UserType", $uType);
 }
 
 public function set_UserID($uID){
  $this->UserID = $uID;
  $this->toCookie("UserID", $uID);
 }
 

 
 public function toCookie($cookie_name, $cookie_value){
  setcookie($cookie_name, $cookie_value, time() + (86400), '/'); // 86400 = 1 day
 }
 
 public function fromCookie($cookie_name){
  if(!isset($_COOKIE[$cookie_name]) ) {
   $this->toCookie($cookie_name, "Unknown" );
   return $_COOKIE[$cookie_name];
  } else {
   return $_COOKIE[$cookie_name];
  }
 }
 
 public function define($type){
  $userType=$type;
  if(strcmp($type, "Unknown")==0){
   $this->attributes = array(
     "Authenticate" => 1,
     "Logout"       => 0,
     "Sign Up New User" => 1,
     "Schedule Appointment" => 0,
     "Cancel Appointment" => 0,
     "Prescribe Medication" => 0,
     "Write Physicians Exam" => 0,
     "Create Disease" => 0,
     "Modify Disease Thread" => 0,
     "View Medical Record" => 0,
     "View Prescription" => 0,
     "View Account Balance" => 0,
     "Make Payment" => 0,
     "Schedule Lab Test" => 0,
     "View Lab History" => 0,
     "Create Specialist Referral" => 0,
     "Update Account Information" => 0,
     "Create Emergency First Contact" => 0,
     "Write Nurses Notes" => 0
   );
  }
  elseif(strcmp($type, "Patient")==0){
   $this->attributes = array(
     "Authenticate" => 0,
     "Logout"       => 1,
     "Sign Up New User" => 1,
     "Schedule Appointment" => 1,
     "Cancel Appointment" => 1,
     "Prescribe Medication" => 0,
     "Write Physicians Exam" => 0,
     "Create Disease" => 0,
     "Modify Disease Thread" => 0,
     "View Medical Record" => 0,
     "View Prescription" => 1,
     "View Account Balance" => 1,
     "Make Payment" => 0,
     "Schedule Lab Test" => 0,
     "View Lab History" => 0,
     "Create Specialist Referral" => 0,
     "Update Account Information" => 1,
     "Create Emergency FirstContact" => 0,
     "Write Nurses Notes" => 0
   );
  }
  elseif(strcmp($type, "Nurse")==0){
    $this->attributes = array(
     "Authenticate" => 0,
     "Logout"       => 1,
     "Sign Up New User" => 1,
     "Schedule Appointment" => 1,
     "Cancel Appointment" => 1,
     "Prescribe Medication" => 0,
     "Write Physicians Exam" => 0,
     "Create Disease" => 0,
     "Modify Disease Thread" => 0,
     "View Medical Record" => 1,
     "View Prescription" => 1,
     "View Account Balance" => 0,
     "Make Payment" => 0,
     "Schedule Lab Test" => 0,
     "View Lab History" => 1,
     "Create Specialist Referral" => 0,
     "Update Account Information" => 0,
     "Create Emergency First Contact" => 0,
     "Write Nurses Notes" => 1
   );
  }
  elseif(strcmp($type, "Nurse Practitioner")==0){
    $this->attributes = array(
     "Authenticate" => 0,
     "Logout"       => 1,
     "Sign Up New User" => 1,
     "Schedule Appointment" => 1,
     "Cancel Appointment" => 1,
     "Prescribe Medication" => 1,
     "Write Physicians Exam" => 1,
     "Create Disease" => 1,
     "Modify Disease Thread" => 1,
     "View Medical Record" => 1,
     "View Prescription" => 1,
     "View Account Balance" => 0,
     "Make Payment" => 0,
     "Schedule LabTest" => 1,
     "View Lab History" => 1,
     "Create Specialist Referral" => 1,
     "Update Account Information" => 0,
     "Create Emergency First Contact" => 0,
     "Write Nurses Notes" => 0
   );
   }
  elseif(strcmp($type, "Physician")==0){ 
    /*Keep in synch with Nurse Practitioner*/
    $this->attributes = array(
     "Authenticate" => 0,
     "Logout"       => 1,
     "Sign Up New User" => 1,
     "Schedule Appointment" => 1,
     "Cancel Appointment" => 1,
     "Prescribe Medication" => 1,
     "Write Physicians Exam" => 1,
     "Create Disease" => 1,
     "Modify Disease Thread" => 1,
     "View Medical Record" => 1,
     "View Prescription" => 1,
     "View AccountBalance" => 0,
     "Make Payment" => 0,
     "Schedule Lab Test" => 1,
     "View Lab History" => 1,
     "Create Specialist Referral" => 1,
     "Update Account Information" => 0,
     "Create Emergency First Contact" => 0,
     "Write Nurses Notes" => 0
   );
  }
  elseif(strcmp($type, "Specialist")==0){
    $this->attributes = array(
     "Authenticate" => 0,
     "Logout"       => 1,
     "Sign Up New User" => 0,
     "Schedule Appointment" => 1,
     "Cancel Appointment" => 1,
     "Prescribe Medication" => 1,
     "Write Physicians Exam" => 0,
     "Create Disease" => 1,
     "Modify Disease Thread" => 1,
     "View Medical Record" => 0,
     "View Prescription" => 1,
     "View Account Balance" => 0,
     "Make Payment" => 0,
     "Schedule Lab Test" => 1,
     "View Lab History" => 1,
     "Create Specialist Referral" => 1,
     "Update Account Information" => 0,
     "Create Emergency First Contact" => 0,
     "Write Nurses Notes" => 0
   );
  }
  elseif(strcmp($type, "Admin")==0){
    $this->attributes = array(
     "Authenticate" => 0,
     "Logout"       => 1,
     "Sign Up New User" => 1,
     "Schedule Appointment" => 1,
     "Cancel Appointment" => 1,
     "Prescribe Medication" => 0,
     "Write Physicians Exam" => 0,
     "Create Disease" => 0,
     "Modify Disease Thread" => 0,
     "View Medical Record" => 0,
     "View Prescription" => 0,
     "View Account Balance" => 1,
     "Make Payment" => 1,
     "Schedule Lab Test" => 0,
     "View Lab History" => 0,
     "Create Specialist Referral" => 0,
     "Update Account Information" => 1,
     "Create Emergency First Contact" => 0,
     "Write Nurses Notes" => 0
   );
  }
  elseif(strcmp($type, "EMT")==0){
    $this->attributes = array(
     "Authenticate" => 0,
     "Logout"       => 1,
     "Sign Up New User" => 0,
     "Schedule Appointment" => 0,
     "Cancel Appointment" => 0,
     "Prescribe Medication" => 0,
     "Write Physicians Exam" => 0,
     "Create Disease" => 0,
     "Modify Disease Thread" => 0,
     "View Medical Record" => 1,
     "View Prescription" => 1,
     "View Account Balance" => 0,
     "Make Payment" => 0,
     "Schedule Lab Test" => 0,
     "View Lab History" => 0,
     "Create Specialist Referral" => 0,
     "Update Account Information" => 0,
     "Create Emergency First Contact" => 1,
     "Write Nurses Notes" => 0
   );
  }
  elseif(strcmp($type, "Technician")==0){
    $this->attributes = array(
     "Authenticate" => 0,
     "Logout"       => 1,
     "Sign Up New User" => 0,
     "Schedule Appointment" => 0,
     "Cancel Appointment" => 0,
     "Prescribe Medication" => 0,
     "Write Physicians Exam" => 0,
     "Create Disease" => 0,
     "Modify Disease Thread" => 0,
     "View Medical Record" => 0,
     "View Prescription" => 0,
     "View Account Balance" => 0,
     "Make Payment" => 0,
     "Schedule Lab Test" => 1,
     "View Lab History" => 1,
     "Create Specialist Referral" => 0,
     "Update Account Information" => 0,
     "Create Emergency First Contact" => 0,
     "Write Nurses Notes" => 0
   );
  }
  else{
    print "ERROR: UKNOWN USER TYPE IN CONSTRUCTION OF BaseUser.";
  }
 }
 
}
?>
