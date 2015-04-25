<?php
require_once("model.php");
require_once("view.php");
require_once("controller.php");
$model = new Model();
$controller = new Controller($model);
$view = new View($controller, $model);
 
if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}();
}

if (isset($_POST['Username']) &&
    isset($_POST['Password']) &&
    isset($_POST['Name']) &&
    isset($_POST['Address'] )){
     /**/
     echo "attempting to add new user.";
     $controller->newUser($_POST['Name'], $_POST['Username'], $_POST['Password'], $_POST['Address']);
     echo "<center>Thank you ".$_POST['Name'].". Redirecting...</center>";
     echo "<meta http-equiv=\"refresh\" content=\"0; url=../\" target='_top'/>";
    }else{
     echo $view->showPage();
    }

?>
