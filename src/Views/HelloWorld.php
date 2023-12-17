<?php
use MvcLite\Engine\InternalResources\Storage;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hello, World! :)</title>

    <?php
    Storage::include("Css/Example/index.css");
    ?>
</head>
<body>

<h1>
    Hello, World! :)
</h1>

<p>
    This is a new <strong>MVCLite</strong> project.
</p>

<p>
    This view can be edited.
</p>

</body>
</html>