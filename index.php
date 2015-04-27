<?php
require_once("model.php");
require_once("view.php");
require_once("controller.php");
$model = new Model("Unknown");
$controller = new Controller($model);
$view = new View($controller, $model);
$showThis = "";
if(isset($_COOKIE['UserID'])){
    $model->getAllUserAttributesFromDB();
}
if(isset($model->UserAttributes['UserType'])){
    $model->define($model->UserAttributes['UserType']);
}
if (isset($_GET['action']) && !empty($_GET['action'])) {
    $model->opState = "trunk";
    
    if( $model->userFilledRegistrationForm() &&
        $_GET['action']=='SignUpNewUser' ){
         $controller->registerTheUser();

         if($model->dbSuccess==TRUE){

          $controller->welcomeTheUser();
             // Determine if user type is Patient or not
         }else{
          $controller->askUserToChooseDifferently();
         }
    }elseif($model->userFilledLogin() &&
         $_GET['action']='Authenticate'){
        $controller->loginUser();
       //   print $model->UserAttributes['Name'];
    }
    $showThis = $view->showTemplate($_GET['action']);
}else{
 $showThis = $view->showTemplate("");
}

print $showThis;
?>

