<?php
class View
{
    private $model;
    private $controller;
 
    public function __construct($controller,$model) {
        $this->controller = $controller;
        $this->model = $model;
    }
    public function controls(){
     return "CONTROLS<BR/>";
    }
    public function buttons(){
     return "<input type='reset' value='Reset'>
      <input type='submit' value='Submit'>";
    }
    public function showBody(){
     return "<div style='width:300px;margin:0 auto;'><form action='index.php' method='POST'>".$this->controls().$this->buttons()."</form></div>";
    }
    
    public function showPage(){
     return "<html>"."<head><link rel='stylesheet' type='text/css' href='./blended_layout.css'></head><body><br/>&nbsp;<br/>".$this->showBody()."</body></html>";
    }
 
    public function output() {
        return '<p><a href="mvc.php?action=clicked"' . $this->model->string . "</a></p>";
    }
}
?>
