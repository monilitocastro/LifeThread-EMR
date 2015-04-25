# LifeThread
LifeThread EMR using LAMP
All Model classes must extend BaseModel. BaseModel holds all access to the database including connecting and closing.
The View and Controller classes do not have base classes.

Each use case method is reachable via link button. The use cases for a particular user type are dependent on an
attribute vector. So each user type has a unique attribute vector. Each link for use case method sends the iframe
to a new folder. Each of these folders have index.php which utilizes model.php, view.php, controller.php.

For model.php, we must program this in such a way that it will only be used to get cookies, set cookies, retrieve
database, manipulate database. (Model must be extended by BaseModel.)

For view.php, we must program this in such a way that each significant HTML must be its own php function. We
do this to allow modularity.

For controller.php, we must program this such that it will have both use of model and view. It brings information
from the web pages to the model.

The folder Bare files includes the index.php and m-v-c class files needed to set up
the use case methods. View.php is set up so that a form is shown with reset and
submit buttons.

If multiple post backs are needed for index.php, it is apt to set a cookie variable
to keep track of the state. Use model classes toCookie and fromCookie method
to facilitate this.

Calendar program is modified from cal.php which is an open source
calendar php rendering program. It has been modified to include
radio buttons, next and previous months button. Original repository is located at https://github.com/Goatella/PHP-Calendar


