# MVCLite official documentation

It's time to say **Hello, MVCLite**!

**MVCLite** is a client-side PHP framework whose watchwords are **lightness**, 
**ease of use** and **security**.

## Get started

### Let's start with controllers

As you can see, **controllers** are a pillar of a **MVC** application.
We must create them before all.

**Let's create our first controller!**

- Open folder `src/Controllers`.
- Create the controller class `HelloWorldController.php`.
- Put the following code into the created class:
```php
<?php

namespace MvcLite\Controllers;

/**
 * The controller used by the tutorial.
 */
class TestController
{
    public function __construct()
    {
        // Empty constructor.
        // We will see the constructor functions more later.
    }

    /**
     * The called controller method.
     */
    public function renderPage(): void
    {
        echo "Hello, World!";
    }
}
```

**Your first controller is ready:** when `renderPage()` method is called, 
it will display `Hello, World!` on your page.

### Let's start with router

The router is **THE** intermediate between client and controllers. It plays
the dispatch role into the application.

To begin with **MVCLite**, we only need to edit `src/Router/routes.php`.
This file allows to create our routes.

In **MVCLite**, a route is represented by **five** information:
- **The HTTP method:** `GET`.
- **The route path:** `https://example.com/[route_path]`.
- **The controller:** the view linked controller.
- **The controller method:** the called controller method.
- **The name:** it is **_optional_**, but it makes router easy to use and maintain.
By using it in route calling, you can change the route path without change it
for each route calling, because you will use it to use your route.

**Let's create our first route!**

- Open `src/Router/routes.php`.
- Put the route creation line at the file ending:

```php
<?php

/*
 * routes.php
 * MVCLite framework by belicfr
 */


use MvcLite\Controllers\HelloController;
use MvcLite\Router\Engine\Router;

// Let's create our route!
// Here it is 3 arguments: path, controller class, controller method.
Router::get("/hello-world", HelloWorldController::class, "renderPage");
```

**Your first route is created and ready:** when you open your website on your
favorite browser with `https://[DOMAIN_NAME]/hello-world` as URL, `Hello, World!`
will be displayed on your page.

### Let's start with views

It is always better to use **views** than simple "echo" instructions. Let's see
how to create one:
- To begin, open folder `src/Views`.
- Create the view file `HelloWorld.php`.
- Put the following code into the created file:
```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hello, World! :)</title>
</head>
<body>

<h1>
    Hello, World! :)
</h1>

<p>
    My name is John Doe!
</p>

</body>
</html>
```
- Go to your `HelloWorldController`.
- Replace the **echo** instruction line by the following line:
```php
\MvcLite\Views\Engine\View::render("HelloWorld");
```
- You can put the View class namespace into an `use` instruction
than put it before class name to beautify and simplify your code.
- Now, if you refresh your browser tab, you will see the HTML rendering!

**But... we can do better!** Use dynamic variable to replace static `John Doe`?

- Go to your controller, and change your view rendering line by:
```php
\MvcLite\Views\Engine\View::render("HelloWorld", [
    // View rendering properties.
    // You can pass variables to view here!
    
    "myName" => "Marc Smith"
]);
```
- Return to your view, and change `<p>` tag by:
```html
<p>
    My name is <?= $myName ?>!
</p>
```

**Now, you can see `Marc Smith` instead of `John Doe`!**