# LifeThread
LifeThread EMR using LAMP

Each use case method is reachable via hyperlink button. The use cases for a particular user type are dependent on an
attribute vector. So each user type has a unique attribute vector. Each link for use case method creates a view in the main content panel. This panel can be manipulated using HTML on $showThis attribute of model. Be care not to confuse the $showThis variable in view.php with that of the one in model.php. Each of these folders have index.php which utilizes model.php, view.php, controller.php. The file index.php contains the logic of the links, and postbacks of the website.

The architecture is as follows:

For index.php, we first get any login or new user creation information so that we can use the Username and Password variables from $_POST to find the UserID. We then get all cookies including UserID. There is not conflict between these two stages as their logic is mutually exclusive. Each longitudinal state is kept by the model.php variable called useCaseContent. This variable and action variable from $_GET are relevant in view.php

For model.php, we must program this in such a way that it will only be used to get cookies, set cookies, retrieve
database, manipulate database

For view.php, we must program this in such a way that each significant HTML must be its own php function. We
do this to allow modularity. The model.php variable useCaseContent and $_GET variable action determine the state of the showThis attribute of model.php. For user-friendly reasons there should always be a reset button to null values or default values on each form in the main content panel. The content inside the main panel should also be centered.

For controller.php, we must program this such that it will have both use of model and view. It brings information
from the web pages to the model.
