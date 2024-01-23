# Your first controller

The **second step** to create a **MVCLite** page is to create a **controller**:
the intermediary between your **view** and your future **models**. This **controller**
will manage all the logic.

To create our first **controller**:
- **Open** the ``Controllers`` folder.
- **Create** a new PHP file ``HelloWorldController.php``. 
  Note that, by **convention**, the names of each **controller** file **end** with ``Controller`` suffix.
- **Open** it and **copy and paste** the following code **in it**:
  ```php
  <?php

  namespace MvcLite\Controllers;
  
  use MvcLite\Controllers\Engine\Controller;
  use MvcLite\Views\Engine\View;
  
  class HomeController extends Controller
  {
      public function __construct()
      {
          parent::__construct();
  
          // Empty constructor.
      }
  
      public function render(): void
      {
          View::render("HelloWorld");
      }
  }
  ```