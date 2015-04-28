<?php
require_once("model.php");
require_once("view.php");
require_once("controller.php");
$model = new Model("Unknown");
$controller = new Controller($model);
$view = new View($controller, $model);
$showThis = "";


if( $model->userFilledRegistrationForm() &&
    $_GET['action']=='SignUpNewUser' )         {
    $controller->registerTheUser();
    $controller->UserTypeIsNowKnown();
    if($model->dbSuccess==TRUE){
        $controller->welcomeTheUser();
        $controller->UserTypeIsNowKnown();
    }else{
        $controller->askUserToChooseDifferently();
    }

}elseif( $model->userFilledRegistrationForm() &&
    $_GET['action']=='UpdateAccountInformation' )         {
    //$controller->updateAccountInformation();
    $controller->UserTypeIsNowKnown();
    if($model->dbSuccess==TRUE){
        $controller->welcomeTheUser();
        $controller->UserTypeIsNowKnown();
    }else{
        $controller->askUserToChooseDifferently();
    }

}elseif($model->userFilledLogin() &&
    $_GET['action']='Authenticate'){
    $controller->loginUser();
    //   print $model->UserAttributes['Name'];
}

$controller->getAllCookies();
$controller->UserTypeIsNowKnown();
if (isset($_GET['action']) && !empty($_GET['action'])) {

    $showThis = $view->showTemplate($_GET['action']);
}else{
    $showThis = $view->showTemplate("");
}

print $showThis;
?>

