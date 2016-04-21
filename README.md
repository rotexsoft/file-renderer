# PHP File Renderer

![Build Status](https://travis-ci.org/rotexsoft/file-renderer.svg?branch=master&style=flat-square) &nbsp; https://travis-ci.org/rotexsoft/file-renderer 

## Introduction

This is a simple, elegant and flexible tool that can be used to render php files (also referred to as `Views` within this documentation)
that emit valid html output to a web-browser. It is designed to be unobtrusive; your view files can easily be used with a different 
rendering or templating library. You do not need to learn any new syntax (or markup / templating language) in order to compose your 
view; simply write your views in plain old php. This package also provides escaping functionality for data passed to the view file(s).

This package can easily be used by framework developers to implement the View layer of an MVC (Model-View-Controller) framework. 
It can also be easily incorporated into existing frameworks.

Users of this package are still responsible for making sure that they validate or sanitize data coming into their application(s) via user input 
(eg. via html forms) with tools like  [Respect\Validation](https://github.com/Respect/Validation), [Valitron](https://github.com/vlucas/valitron),
[Upload](https://github.com/brandonsavage/Upload), [Volan](https://github.com/serkin/Volan), [Sirius Validation](https://github.com/siriusphp/validation), 
[Filterus](https://github.com/ircmaxell/filterus), etc.

## Acknowledgement

The escaping functionality in this package is implemented using the [zend-escaper](https://github.com/zendframework/zend-escaper) package.

## Contribution

Since the goal of this package is to be lean and flexible, pull requests for significant 
new features will not be accepted. Users are encouraged to extend the package with new
feature(s) in their own projects. However, bug fix and documentation enhancement 
related pull requests are greatly welcomed.

## Requirements

* PHP 5.3.23+

## Installation
`composer require rotexsoft/file-renderer`

## Usage

### Basic Usage

Your main php script may look like below (let's call it `test.php` and assume it's located at the root directory of your project's folder):

`/some/path/my-project/test.php`

```php
<?php
    include './vendor/autoload.php';

    //To render a php file named `view.php` located in the `views` sub-directory 
    //within the directory containing this php script, use the code below:
    
    $file_paths = [ './views' ]; //you can also use absolute paths
    $view_data = [ 'paragraph_data_from_file_renderer' => 'This is a Paragraph!!' ];

    //you must include the file extension in the file name (in this case `.php`)
    $renderer = new \Rotexsoft\FileRenderer\Renderer('view.php', $view_data, $file_paths);
    
    //you could alternately create the Renderer object like below:
    //$renderer = new \Rotexsoft\FileRenderer\Renderer('./views/view.php', $view_data);

    $renderer->renderToScreen(); //Render the file immediately to the screen

    // The two lines below are equivalent to $renderer->renderToScreen()
    $output = $renderer->renderToString(); //First capture the output of rendering 
                                           //the file in a string variable.
    echo $output;

    //Both render*() methods will inject the elements of the data array into the 
    //view file first and then execute the view file.
    
    //You can also pass the file name and data parameters to the render*() methods.
    //You will have to include the path in the file name if you did not supply an
    //array of file paths when your Renderer object was created.
    $renderer2 = new \Rotexsoft\FileRenderer\Renderer();
    
    $renderer2->renderToScreen('./views/view.php', $view_data);
    
    //OR 
    $output = $renderer2->renderToString('./views/view.php', $view_data);
    echo $output;
?>
```

`/some/path/my-project/views/view.php`

```php
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <p><?php echo $paragraph_data_from_file_renderer; ?></p>
    </body>
</html>
```

**NOTE:**&nbsp;` the file name, if any, supplied to the **render*()** methods will be 
considered first for rendering if the file exists. The file name supplied to the 
constructor during object creation will be considered last for rendering if the 
file name supplied to the **render*()** method can't be found.`

### Getting, Setting and Unsetting View Data


#### Setting View Data

View data can be supplied when the Renderer object is created / instantiated
```php
<?php
    //data to supply when the Renderer object is created / instantiated
    $view_data = [ 'paragraph_data_from_file_renderer' => 'This is a Paragraph!!' ];

    //pass $view_data to the constructor to set view data during object creation
    $renderer = new \Rotexsoft\FileRenderer\Renderer('./views/view.php', $view_data);

    //NOTE: elements of the view data array supplied during construction time 
    //      can be updated or deleted after object creation.

    //NOTE: if no view data array is supplied during object creation, the view 
    //      data for the created object will have a default value of an empty
    //      array.

?>
```

View data can also be set or updated after the Renderer object has been created / instantiated
```php
<?php
    $renderer = new \Rotexsoft\FileRenderer\Renderer();
    
    //Set data using object assignment syntax.
    //Since view data was not supplied during object creation in this 
    //example the value below is being set for the first time for 
    //`paragraph_data_from_file_renderer` inside the internal view
    //data array.
    $renderer->paragraph_data_from_file_renderer = 'This is a Paragraph!!';
    
    //OR set data using the setVar() method
    // $renderer->setVar('paragraph_data_from_file_renderer', 'This is a Paragraph!!');

    //This will update the value of `paragraph_data_from_file_renderer` in the
    //view data array.
    $renderer->paragraph_data_from_file_renderer = 'This is a new Paragraph!!';
?>
```

#### Getting View Data

View data values can be accessed after the Renderer object is created / instantiated
```php
<?php
    $view_data = [ 'paragraph_data_from_file_renderer' => 'This is a Paragraph!!' ];
    $renderer = new \Rotexsoft\FileRenderer\Renderer('./views/view.php', $view_data);
    
    //You can access the value of `paragraph_data_from_file_renderer` like this:
    $renderer->paragraph_data_from_file_renderer;

    //OR like this:
    $renderer->getVar('paragraph_data_from_file_renderer');
?>
```

#### Unsetting View Data

View data values can be deleted after the Renderer object is created / instantiated
```php
<?php
    $view_data = [ 'paragraph_data_from_file_renderer' => 'This is a Paragraph!!' ];
    $renderer = new \Rotexsoft\FileRenderer\Renderer('./views/view.php', $view_data);
    
    //You can completely remove the `paragraph_data_from_file_renderer` entry
    //inside the internal view data array after the Renderer object creation
    //like this:
    unset($renderer->paragraph_data_from_file_renderer);
?>
```

### File paths

These are paths that will be searched for the file to be rendered via the __**render*()**__ methods.

If a path is prepended to the name of the file to be rendered (which can be supplied either during 
the creation of the renderer object or during a call to any of the __**render*()**__ methods) and
the file with the prepnded path exists, that file will be rendered and the renderer will not
bother searching the file paths supplied during construction or via call(s) to __**appendPath($path)**__
and / or __**prependPath($path)**__.

For example, assuming `view.php` exists in `./views`, `./views/controller1` and 
`./views/base-controller` the code below will lead to `./views/view.php` being 
rendered without even trying to search `./views/controller1` or 
`./views/base-controller` for `view.php`:

```php
<?php
    $file_paths = [ './views/controller1', './views/base-controller'  ];
    $view_data = [ 'paragraph_data_from_file_renderer' => 'This is a Paragraph!!' ];

    $renderer = new \Rotexsoft\FileRenderer\Renderer('./views/view.php', $view_data, $file_paths);
    
    //$renderer->renderToScreen() OR $renderer->renderToScreen('./views/view.php');
    //will both lead to the rendering of './views/view.php'
?>
```

If a path is not prepended to the name of the file to be rendered, then the search for a file to 
be rendered starts from the first element (i.e file path value) inside the registered array of 
file paths to the last element inside the array. It is up to the user of this package to register
file paths in a way that seems sensible to their use-case.

Given the following file paths:
```php
<?php
    $file_paths = [ './views/controller1', './views/base-controller'  ];
    $view_data = [ 'paragraph_data_from_file_renderer' => 'This is a Paragraph!!' ];

    $renderer = new \Rotexsoft\FileRenderer\Renderer('view.php', $view_data, $file_paths);
?>
```

If `view.php` exists in both `./views/controller1` and `./views/base-controller`, then the
search will lead to `./views/controller1/view.php` being selected and rendered when any of 
the **render*()** methods is called. This is because `./views/controller1` comes before
`./views/base-controller` in the file paths array.

If you want to give `./views/base-controller` a higher precedence in the file paths
array, you can do the following:

```php
<?php
    $renderer->removeFirstNPaths(1); //will remove './views/controller1' from the file paths array
    
    //$renderer->getFilePaths() at this point will return [ './views/base-controller' ]
    
    $renderer->appendPath('./views/controller1'); // will add './views/controller1' to the end of the 
                                                  // file paths array
    // $renderer->getFilePaths() at this point will return 
    //      [ './views/base-controller', './views/controller1' ]
?>
```

You can also accomplish the same thing with the following:

```php
<?php
    $renderer->removeLastNPaths(1); //will remove './views/base-controller' from the file paths array
    
    //$renderer->getFilePaths() at this point will return [ './views/controller1' ]
    
    $renderer->prependPath('./views/base-controller'); // will add './views/base-controller' to the 
                                                       // front of the file paths array
    // $renderer->getFilePaths() at this point will return 
    //      [ './views/base-controller', './views/controller1' ]
?>
```

### Escaping Data to be Passed to Views

Only string values in the data array and its sub-arrays (if any) will be escaped. Documentation on escaping coming soon!

### Advanced Usage

#### Implementing a Two-Step View Templating Architecture

Documentation coming soon!