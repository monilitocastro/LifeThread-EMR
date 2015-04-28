<html>
 <head><title>MVC programming style</title>
 </head>
 <body>
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
 
echo $view->output();
?>
 </body>
 </html>
