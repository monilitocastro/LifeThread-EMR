<?php
class Controller
{
    private $model;
 
    public function __construct($model){
        $this->model = $model;
    }
    
    public function newUser($Name, $Username, $Password, $Address){
    
  echo"<br>MYSQL CONNECTTODB PASS";
     $this->model->connectToDB();
     echo "<br/>pass";
     $this->model->signUpNewUser($Name, $Username, $Password, $Address);
     $this->model->closeDBConnection();
    }
 
    public function clicked() {
        $this->model->string = "Updated Data, thanks to MVC and PHP!";
    }
}
?>
