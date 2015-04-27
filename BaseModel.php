<?php
class BaseModel{
 public static $UserType;
 public static $UserID;
 public $servername;
 private $conn;

 
 public function doesUserExist($username, $password){}
 public function isPostBack(){
  if (isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){
      return TRUE;
  }
  return FALSE;
 }
 public function signUpNewUser($Name, $Username, $Password, $Address){
 
 $queryString = "call sign_up_patient( $Name, $Username, $Password, $Address);";
  if($this->conn->query($queryString)){
   printf("Errormessage: %s\n", $mysqli->error);
  }
  
 }
 
 public function connectToDB($servername='localhost',$username='root', $password=''){
  $this->servername = $servername;
  $dbname = "LifeThread";
 
  // Create connection
  $this->conn = new mysqli($this->servername, $username, $password, $dbname);
  
  // Check connection
  if ($this->conn->connect_error) {
    die("Connection failed: " . $this->conn->connect_error );
  }
 }
 
 public function closeDBConnection(){
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
 private function toCookie($cookie_name, $cookie_value){
  setcookie($cookie_name, $cookie_value, time() + (86400), '/'); // 86400 = 1 day
 }
 
 public function fromCookie($cookie_name){
  if(!isset($_COOKIE[$cookie_name])) {
   $concat = "set_" . $cookie_name;
   setcookie($cookie_name, "Unknown", time() + (86400), '/'); // 86400 = 1 day
   return "Unknown";
  } else {
   return $_COOKIE[$cookie_name];
  }
 }
}
?>
