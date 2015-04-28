<!DOCTYPE html>

<?php
class View
{
    private $model;
    private $controller;
    
    
    public function __construct(&$controller,&$model) {
        $this->controller = &$controller;
        $this->model =& $model;
    }

    public function PatientNameView(){
        $result = "";
        if($this->model->UserAttributes['UserType'] == 'Patient'){
            //just return patient name
            $result = $result . $this->model->PatientName;
        }elseif( isset($this->model->UserAttributes['UserType']) && ($this->model->UserAttributes['UserType'] != 'Patient')   ){
            //For everyone else
            $result = $result . "<li><a href=\"index.php?action=DefinePatient\" target=\"_top\">Define Patient</a></li>";
        }
        return $result;
    }

    public function createSideBar(){
     $result = "Patient: ".$this->PatientNameView()."<br><br>";
     foreach($this->model->attributes as $key => $value){
     	if($value==1){
     	 $linkTitle = $key;
     	 $url = str_replace(' ', '', $key);
     	 $result = $result . "<li><a href=\"index.php?action=".$url."\" target=\"_top\">".$linkTitle."</a></li>";
     	}
     }
     
     return $result;
    }
 

    public function showTemplate($usecase){
        $this->model->useCaseContent = $usecase;
        $concatString = "<html>". $this->showPreBody() . $this->showBody() . "</html>";
        return $concatString;
    }
    public function showPreBody(){

     return "<head>
	 <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">
	 <link rel=\"stylesheet\" type=\"text/css\" href=\"blended_layout.css\">
	 <title>LifeThread Electronic Medical Record Software</title>
	 <meta name=\"description\" content=\"Write some words to describe your html page\">
         </head>";
    }
    public function showBody(){
     return "<body>" . "<div class=\"blended_grid\">". $this->showPageHeader(). $this->showPageLeftMenu(). $this->showPageContent(). $this->showPageFooter() ."</div>" . "</body>";
    }
    public function showPageHeader(){
     return "<div class=\"pageHeader\"><img src=\"logo.png\"></div>";
    }
    public function showPageLeftMenu(){
     return "<div class=\"pageLeftMenu\">
	    <ul>". $this->createSideBar() ."</ul>" ."</div>";
    }
   
    public function showPageContent(){
     $showThis=&$this->model->showThis;
     $operation = & $this->model->opState;
     
     if($operation=='trunk'){
      switch($this->model->useCaseContent){
          case "Authenticate":
        $showThis=
            "<br/>&nbsp;<br/><div style='width:300px;margin:0 auto;'><form action='index.php?action=Authenticate' method='POST'><input type=\"textbox\" name='Username'><br/>
         <input type='password' name='Password'><br/>
         <input type='reset'><input type='submit' value='Log in'></div>";
           break;
            case "SignUpNewUser":
        $showThis="<div style='width:300px;margin:0 auto;'><form action='index.php?action=SignUpNewUser' method='POST'>"."Please fill in the information:<BR/><BR/>Name:    <input type='textbox' name='Name'><br/>
Username: <input type='textbox' name='Username'><br/>
Password: <input type='password' name='Password'><br/>
Address:  <input type='textbox' name='Address'><br/>"."<input type='reset' value='Reset'>
       <input type='submit' value='Register new patient'>"."</form></div>";
            break;
          case "DefinePatient":
           $showThis = $this->showSearchTool("DefinePatient", "Name");
              break;
          case "Logout":
              $showThis=$this->model->toCookie('UserID','Unknown');
              $this->model->define('Unknown');
              header("Location: /"); /* Redirect browser */
              exit();
          case "ViewPrescription":
              $showThis = $this->model->ViewPrescription();
              break;
        default:
            break;
      }
     }elseif($operation=='showThis'){
      
     }elseif($operation=='loggedin'){


     };
     return "<div class=\"pageContent\">".$showThis."</div>";
    }

    public function showSearchTool($action, $attribute){
        return
            "<br/>&nbsp;<br/><div style='width:300px;margin:0 auto;'><form action='index.php?action=".$action."' method='POST'>Search ".$attribute.": <input type=\"textbox\" name='Name'><br/>
         <input type='reset'>&nbsp;<input type='submit' value='Search'></div>";
    }

    public function showPageFooter(){
     return "<div class=\"pageFooter\">"."</div>";
    }
}
?>
