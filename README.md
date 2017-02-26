#### Council queue System

This is a system suposed to useby council to queue people at the reception
desk. The receptionist will be able to select the service (example provided below) and
take the customer details depending on the customer type:

* Citizen: title, first name and last name fields should be displayed
* Organisation: organisation name field should be visible
* Anonymous: no input fields should be visible

Also Customer able to see the currently queued people in a list.

## Requirements

* PHP 5.1 or greater
* MySQL 4.1.2 or greater
* The mod_rewrite Apache module

## Installation

* Download and extract
* Navigate to `application/config/config.php` and fill in your `base_url`
* Set Database Configuration in `application/config/config.php`
* Find `database.sql` file in root folder and import it into MySQL server, so it creates database and necessary tables
* Point your browser to your base_url and it should display default page.
* There are three pages in this system at the moment.
    1. Default page : to display Welcome message and give links for other two pages.
    2. Create Customer page : allows user(receptionist) to add new customer details as per selected customer type.
    3. Queue page : customer can see queued people here.

######################################################################
######################################################################
######################################################################

#### Explanation of the Council queue System

## Structure
Here I created entire structure from scratch. I try to define minimal MVC structure for the requirement of this test. 

* System(in system/system.php) class loads http request and call requested controller .
* Model(in system/model.php) class extends MySQLi and define methods for data operations.
* Controller(in system/controller.php) class defines methods to load models, view, plugins and helpers.
* View(in system/view.php) class loads requested template and render it. It also allows to set variables which passed to the view.

* `Model` represents structure which interact with database and help with CRUD. Defined in `application/models`
* `View` has templates which shows user end output. Here, they are very simple pages mixture of html anf php. Defined in `application/views`
* `Controller` deals between Model and View. Also it directly process Http request through System class. Defined in `application/controllers`

* All static files (js, css and images) are under `static` folder.
 
## Here, I wrote all classes and methods necessary for current functionality only.

* CustomerController has both methods create() and listQueue() to display required pages in test. 
* create() renders templates to add customer by default; and process POST data from the form to insert in database.
* listQueue() renders page to display records from customer table with all related values.

## Unfortunately, I was unable to write phpunit test and apply LESS preprocessor for css due to  having limited time available for this test.