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
     $lit = <<<EOT
Name:    <input type='textbox' name='Name'><br/>
Username: <input type='textbox' name='Name'><br/>
Password: <input type='textbox' name='Name'><br/>
Address:  <input type='textbox' name='Name'><br/>
EOT;
     return "Please fill in the information:<BR/><BR/>".$lit;
    }
    public function buttons(){
     return "<input type='reset' value='Reset'>
      <input type='submit' value='Register new patient'>";
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
