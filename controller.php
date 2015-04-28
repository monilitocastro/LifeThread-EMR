<?php
class Controller
{
    private $model;
 
    public function __construct(&$model){
        $this->model = &$model;
    }

    public function UserTypeIsNowKnown(){
        if(isset($this->model->UserAttributes['UserType'])) {
            $this->model->define($this->model->UserAttributes['UserType']);
        }
    }

    public function getAllCookies(){
        if( isset($_COOKIE['UserID']) ){
            $this->model->UserAttributes['UserID']=$_COOKIE['UserID'];
            $this->model->getAllUserAttributesFromDB();
        }else{
            $this->model->UserAttributes['UserID']='Unknown';
        }
        $this->model->opState = "trunk";
    }

    public function askUserToChooseDifferently(){
        $this->model->opState = "showThis";
        $this->model->showThis = "<br/>&nbsp;<br/><center>Sorry but that user name or password are taken. Please choose another</center>";
    }
    public function loginUser(){
        $Username = $_POST['Username'];
        $Password = $_POST['Password'];
        $this->model->UserAttributes['UserID'] = $this->model->get_UserID_fromDB($Username, $Password);
        $this->model->toCookie("UserID",$this->model->UserAttributes['UserID'] );
        $this->model->getAllUserAttributesFromDB();
        $this->model->opState="loggedIn";
        if($this->model->UserAttributes['UserID'] =='ERROR'){
            $this->model->showThis = "<br/>&nbsp;<br/> <h3 style=\"text-align:center;\">Sorry wrong username password combination.</h3>";
        }else{
            $this->model->showThis = "<br/>&nbsp;<br/> <h3 style=\"text-align:center;\">Welcome to LifeThread.</h3>";
        }

        $this->model->define($this->model->UserAttributes['UserType']);
    }

    public function welcomeTheUser(){
        $Name = $_POST['Name'];
        $Address = $_POST['Address'];
        $Username = $_POST['Username'];
        $Password = $_POST['Password'];
        $this->model->opState = "showThis";
        $this->model->showThis = "<br/>&nbsp;<br/><center>Welcome to LifeThread, ".$Name.".<br/> You live at ". $Address .".</center>";
        $this->model->UserAttributes['UserID'] = $this->model->get_UserID_fromDB($Username, $Password);
        $this->model->toCookie("UserID", $this->model->UserAttributes['UserID'] );
        //print $this->model->fromCookie('UserID');
    }

    public function registerTheUser(){
        $Username = $_POST['Username'];
        $Name = $_POST['Name'];
        $Address = $_POST['Address'];
        $Password = $_POST['Password'];
        $this->model->updateUserInformation($Name, $Username, $Password, $Address);
    }
    public function updateAccountInformation(){
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
