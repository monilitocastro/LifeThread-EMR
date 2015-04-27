<?php
class Controller
{
    private $model;
 
    public function __construct(&$model){
        $this->model = &$model;
    }

 public function UserIsPatient(){

 }

 public function askUserToChooseDifferently(){
  $this->model->opState = "showThis";
  $this->model->showThis = "<br/>&nbsp;<br/><center>Sorry but that user name or password are taken. Please choose another</center>";
 }
 public function loginUser(){
     $Username = $_POST['Username'];
     $Password = $_POST['Password'];
     $this->model->UserID = $this->model->get_UserID_fromDB($Username, $Password);
     //print $this->model->UserID;
     $this->model->toCookie("UserID",$this->model->UserID);
     $this->model->getAllUserAttributesFromDB();
     $this->model->opState="loggedIn";
     if($this->model->UserID=='ERROR'){
         $this->model->showThis = "<br/>&nbsp;<br/> <h3 style=\"text-align:center;\">Sorry wrong username password combination.</h3>";
     }else{
         $this->model->showThis = "<br/>&nbsp;<br/> <h3 style=\"text-align:center;\">Welcome to LifeThread.</h3>";
         $this->model->define($this->model->UserAttributes['UserType']);
     }
 }
 public function welcomeTheUser(){
  $Name = $_POST['Name'];
  $Address = $_POST['Address'];
  $Username = $_POST['Username'];
  $Password = $_POST['Password'];
    $this->model->opState = "showThis";
    $this->model->showThis = "<br/>&nbsp;<br/><center>Welcome to LifeThread, ".$Name.".<br/> You live at ". $Address .".</center>";
    $this->model->UserID = $this->model->get_UserID_fromDB($Username, $Password);
    $this->model->toCookie("UserID", $this->model->UserID);
     //print $this->model->fromCookie('UserID');
 }

    
 public function registerTheUser(){
  $Username = $_POST['Username'];
  $Name = $_POST['Name'];
  $Address = $_POST['Address'];
  $Password = $_POST['Password'];
  $this->model->signUpNewUser($Name, $Username, $Password, $Address);
 }
 
    public function clicked() {
        $this->model->string = "Updated Data, thanks to MVC and PHP!";
    }
    
}
?>
