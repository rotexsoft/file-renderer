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

### Main Features
* No new templating language or syntax to learn, just good old PHP is required to compose view files to be rendered.
    * View file(s) in existing projects can easily be adapted for rendering via this package with very little effort.
* This package can be easily used to implement a Two-Step-View system where all your site's pages share a common layout file and the content for each page gets injected into the layout file.
* Data (variables) can be injected into the files to be rendered via an associative array whose keys will be converted to variables when rendering occurs.
    * Escaping is performed on the values in the data array based on specified escape rules.
* Auto-Escaping is possible on a per instance basis of the **Renderer** class (escaping rules must be specified when instantiating a **Renderer** object for this feature to work).

## Acknowledgement

The escaping functionality in this package is implemented using the [zend-escaper](https://github.com/zendframework/zend-escaper) package.

## Contribution

Since the goal of this package is to be lean and flexible, pull requests for significant 
new features will not be accepted. Users are encouraged to extend the package with new
feature(s) in their own projects. However, bug fix and documentation enhancement 
related pull requests are greatly welcomed.

### Running Tests

  ` ./vendor/bin/phpunit --coverage-text`

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

    // The keys in this data array will be converted to variables when rendering
    // a view file. For example, a variable named `$paragraph_data_from_file_renderer`
    // with the value `'This is a Paragraph!!'` will be available to the view during
    // rendering.
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

**NOTE:** the file name, if any, supplied to the **render*()** methods will be 
considered first for rendering if the file exists. The file name supplied to the 
constructor during object creation will be considered last for rendering if the 
file name supplied to the **render*()** method can't be found.

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

Escaping functionality is provided via the zend-escaper package. It is recommended that you read this 
[article](https://github.com/rotexdegba/zend-escaper/blob/master/doc/book/zend.escaper.theory-of-operation.md) 
to understand the principles behind properly escaping data.

Escaping is possible in four contexts: 
* **Html Body:** this type of escaping should be used for view data variables which may contain html markup. 
For example:

`./views/view-with-escapable-html.php`
```php
<!DOCTYPE html>
<html>
    <head>
        <title>Encodings set correctly!</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div>
            What framework are you using?
            <?php echo $var_that_should_be_html_escaped; ?>
        </div>
    </body>
</html>
```

If `$var_that_should_be_html_escaped` has an initial value of `'<script>alert("zf2");</script>'`
it will be transformed to `'&lt;script&gt;alert(&quot;zf2&quot;);&lt;/script&gt;'` after **html**
escaping is applied to it.

* **Html Attribute:** this type of escaping should be used for view data variables which are meant to be 
rendered as attribute values within html elements in the view. For example:

`./views/view-with-escapable-html-attrs.php`
```php
<!DOCTYPE html>
<html>
    <head>
        <title>Encodings set correctly!</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div>
            <span title="<?php echo $var_that_should_be_html_attr_escaped; ?>" >
                What framework are you using?
            </span>
        </div>
    </body>
</html>
```

If `$var_that_should_be_html_attr_escaped` has an initial value of `'faketitle" onmouseover="alert(/ZF2!/);'`
it will be transformed to `'faketitle&quot;&#x20;onmouseover&#x3D;&quot;alert&#x28;&#x2F;ZF2&#x21;&#x2F;&#x29;&#x3B;'` 
after **html attribute** escaping is applied to it.

* **Css:** this type of escaping should be used for view data variables which are meant to be rendered
within `<style>` tags or inside the `style` attribute of any html tag. For example:

`./views/view-with-escapable-css.php`
```php
<!DOCTYPE html>
<html>
    <head>
        <title>Escaped CSS</title>
        <meta charset="UTF-8"/>
        <style>
            <?php echo $var_that_should_be_css_escaped; ?>
        </style>
    </head>
    <body>
        <p style="<?php echo $another_var_that_should_be_css_escaped; ?>">
            User controlled CSS needs to be properly escaped!
        </p>
    </body>
</html>
```

If `$var_that_should_be_css_escaped` has an initial value of 
`"body { background-image: url('http://example.com/foo.jpg?'); }</style><script>alert('You\\'ve been XSSed!')</script><style>"`
it will be transformed to `"body\20 \7B \20 background\2D image\3A \20 url\28 \27 http\3A \2F \2F example\2E com\2F foo\2E jpg\3F \27 \29 \3B \20 \7D \3C \2F style\3E \3C script\3E alert\28 \27 You\5C \27 ve\20 been\20 XSSed\21 \27 \29 \3C \2F script\3E \3C style\3E"` 
after **css** escaping is applied to it.

If `$another_var_that_should_be_css_escaped` has an initial value of 
`' display: block; " onclick="alert(\'You\\\'ve been XSSed!\'); '`
it will be transformed to `'\20 display\3A \20 block\3B \20 \22 \20 onclick\3D \22 alert\28 \27 You\5C \27 ve\20 been\20 XSSed\21 \27 \29 \3B \20 '` 
after **css** escaping is applied to it.

* **Javascript:** this type of escaping can be safely used for view data variables which are meant to be 
rendered as string literals or digits within Javascript code inside the view to be rendered. Other 
Javascript code that would be injected from view data variables can also be Javascript escaped, 
but it is possible that escaping them may lead to Javascript syntax error(s) when the view is 
rendered in a browser. For example:

`./views/view-with-escapable-js.php`
```php
<!DOCTYPE html>
<html>
    <head>
        <title>Escaped Entities</title>
        <meta charset="UTF-8"/>
        <script type="text/javascript">
            var some_string = '<?php echo $var_that_can_be_safely_js_escaped; ?>';
            alert(some_string);
        </script>
    </head>
    <body>
        <p onclick="var a_number = <?php echo $another_var_that_can_be_safely_js_escaped; ?>; alert(a_number);">
            Javascript escaping the variable in this paragraph's onclick attribute should
            be safe if the variable contains basic alphanumeric characters. It will definitely
            prevent XSS attacks.
        </p>

        <p onclick="<?php echo $another_var_that_cannot_be_guaranteed_to_be_safely_js_escaped; ?>">
            Javascript escaping the variable in this paragraph's onclick attribute may lead
            to Javascript syntax error(s) but will prevent XSS attacks.
        </p>
    </body>
</html>
```

If `$var_that_can_be_safely_js_escaped` has an initial value of `"javascript's cool"`
it will be transformed to `'javascript\x27s\x20cool'` after **Javascript** escaping 
is applied to it.

If `$another_var_that_can_be_safely_js_escaped` has an initial value of 
`'563'` it will be left unchanged with the same value of `'563'` 
after **Javascript** escaping is applied to it.

If `$another_var_that_cannot_be_guaranteed_to_be_safely_js_escaped` has an initial value of 
`' var x = \'Yo!\'; alert(x); '` it will be transformed to 
`'\x20var\x20x\x20\x3D\x20\x27Yo\x21\x27\x3B\x20alert\x28x\x29\x3B\x20'` 
after **Javascript** escaping is applied to it.

You can enable escaping either during the creation of the Renderer object and / or during a 
call to any of the **render*()** methods.

* To enable escaping during the creation of a Renderer object:

```php
<?php
    $file_paths = [];
    
    $bad_css_with_xss = 
        "body { background-image: url('http://example.com/foo.jpg?'); }</style><script>alert('You\\'ve been XSSed!')</script><style>";
    
    $bad_css_with_xss2 = ' display: block; " onclick="alert(\'You\\\'ve been XSSed!\'); ';
    
    $view_data = [
        'var_that_should_be_html_escaped'                               => '<script>alert("zf2");</script>',
        'var_that_should_be_html_attr_escaped'                          => 'faketitle" onmouseover="alert(/ZF2!/);',
        'var_that_should_be_css_escaped'                                => $bad_css_with_xss,
        'another_var_that_should_be_css_escaped'                        => $bad_css_with_xss2,
        'var_that_can_be_safely_js_escaped'                             => "javascript's cool",
        'another_var_that_can_be_safely_js_escaped'                     => '563',
        'another_var_that_cannot_be_guaranteed_to_be_safely_js_escaped' => ' var x = \'Yo!\'; alert(x); ',
    ];

    //an array of key(s) in the data array whose value(s) should each be html escaped
    $data_vars_2_be_html_escaped = ['var_that_should_be_html_escaped'];
    
    //an array of key(s) in the data array whose value(s) should each be html attr escaped
    $data_vars_2_be_html_attr_escaped = ['var_that_should_be_html_attr_escaped'];
    
    //an array of key(s) in the data array whose value(s) should each be css escaped
    $data_vars_2_be_css_escaped = [
        'var_that_should_be_css_escaped', 
        'another_var_that_should_be_css_escaped'
    ];
    
    //an array of key(s) in the data array whose value(s) should each be js escaped
    $data_vars_2_be_js_escaped = [
        'var_that_can_be_safely_js_escaped', 
        'another_var_that_can_be_safely_js_escaped',
        'another_var_that_cannot_be_guaranteed_to_be_safely_js_escaped'
    ];
    
    $escape_encoding = 'utf-8'; // should be the same encoding in which the document is served 
                                // to the browser (ie. the encoding defined in your html document).
    
    //Escaping functionality is being enabled in the call to the constructor
    //below because we are passing the $data_vars_2_be_*_escaped arrays to the
    //constructor. By default, if these escape parameters are not supplied to
    //the constructor, they will each internally be assigned an empty array 
    //value (meaning that escaping is disabled).
    $renderer = new \Rotexsoft\FileRenderer\Renderer(
                    '', //file name can be blank, but should be supplied when any render*() method is called
                    $view_data, 
                    $file_paths,
                    $escape_encoding,
                    $data_vars_2_be_html_escaped,
                    $data_vars_2_be_html_attr_escaped,
                    $data_vars_2_be_css_escaped,
                    $data_vars_2_be_js_escaped
                );

    $renderer->renderToScreen('./views/view-with-escapable-html.php'); //The escaping of the view data 
                                                                       //occurs only once during this 
                                                                       //first call to renderToScreen 
                                                                       //in order to prevent escaping 
                                                                       //the same data more than once.
                                                                            
    $renderer->renderToScreen('./views/view-with-escapable-html-attrs.php'); //Already escaped data
                                                                             //will be bound to this
                                                                             //view.
    
    $rendered_view = $renderer->renderToString('./views/view-with-escapable-css.php'); //Already 
                                                                                       //escaped data 
                                                                                       //will be bound 
                                                                                       //to this view.
    
    $renderer->renderToScreen('./views/view-with-escapable-js.php');  //Already escaped data will be
                                                                      //bound to this view.  
?>
```

* To enable escaping during a call to any of the **render*()** methods:

```php
<?php
    $bad_css_with_xss = 
        "body { background-image: url('http://example.com/foo.jpg?'); }</style><script>alert('You\\'ve been XSSed!')</script><style>";
    
    $bad_css_with_xss2 = ' display: block; " onclick="alert(\'You\\\'ve been XSSed!\'); ';
    
    $view_data = [
        'var_that_should_be_html_escaped'                               => '<script>alert("zf2");</script>',
        'var_that_should_be_html_attr_escaped'                          => 'faketitle" onmouseover="alert(/ZF2!/);',
        'var_that_should_be_css_escaped'                                => $bad_css_with_xss,
        'another_var_that_should_be_css_escaped'                        => $bad_css_with_xss2,
        'var_that_can_be_safely_js_escaped'                             => "javascript's cool",
        'another_var_that_can_be_safely_js_escaped'                     => '563',
        'another_var_that_cannot_be_guaranteed_to_be_safely_js_escaped' => ' var x = \'Yo!\'; alert(x); ',
    ];

    //an array of key(s) in the data array whose value(s) should each be html escaped
    $data_vars_2_be_html_escaped = ['var_that_should_be_html_escaped'];
    
    //an array of key(s) in the data array whose value(s) should each be html attr escaped
    $data_vars_2_be_html_attr_escaped = ['var_that_should_be_html_attr_escaped'];
    
    //an array of key(s) in the data array whose value(s) should each be css escaped
    $data_vars_2_be_css_escaped = [
        'var_that_should_be_css_escaped', 
        'another_var_that_should_be_css_escaped'
    ];
    
    //an array of key(s) in the data array whose value(s) should each be js escaped
    $data_vars_2_be_js_escaped = [
        'var_that_can_be_safely_js_escaped', 
        'another_var_that_can_be_safely_js_escaped',
        'another_var_that_cannot_be_guaranteed_to_be_safely_js_escaped'
    ];
    
    $escape_encoding = 'utf-8'; // should be the same encoding in which the document is served 
                                // to the browser (ie. the encoding defined in your html document).
    
    //create a renderer
    $renderer = new \Rotexsoft\FileRenderer\Renderer();

    //Escaping functionality is being enabled in the call to renderToScreen
    //below because we are passing the $data_vars_2_be_*_escaped arrays to it.
    //By default, if these escape parameters are not supplied, they will each 
    //internally be assigned an empty array value and merged with their 
    //corresponding internal \Rotexsoft\FileRenderer\Renderer property 
    //values for $renderer->data_vars_2_html_escape, $renderer->data_vars_2_css_escape
    //$renderer->data_vars_2_html_attr_escape and $renderer->data_vars_2_js_escape.
    //Note that these properties are protected and not externally accessible.
    $renderer->renderToScreen(
                    './views/view-with-escapable-html.php',
                    $view_data,                             //The escaping of the view data
                    $escape_encoding,                       //occurs only once during this
                    $data_vars_2_be_html_escaped,           //first call to renderToScreen
                    $data_vars_2_be_html_attr_escaped,      //in order to prevent escaping
                    $data_vars_2_be_css_escaped,            //the same data more than once.
                    $data_vars_2_be_js_escaped
                );                                                      
                                                
    $renderer->renderToScreen(
                    './views/view-with-escapable-html-attrs.php',   
                    $view_data,                                     //Already escaped data in the
                    $escape_encoding,                               //first call to renderToScreen
                    $data_vars_2_be_html_escaped,                   //will be bound to this view
                    $data_vars_2_be_html_attr_escaped,              //because the $view_data and 
                    $data_vars_2_be_css_escaped,                    //other parameters are the same
                    $data_vars_2_be_js_escaped                      //and we are rendering using the
                );                                                  //same instance of the Renderer class.
                          
    $rendered_view = $renderer->renderToString(
                    './views/view-with-escapable-css.php',
                    $view_data,                             //Already escaped data in the
                    $escape_encoding,                       //first call to renderToScreen 
                    $data_vars_2_be_html_escaped,           //will be bound to this view
                    $data_vars_2_be_html_attr_escaped,      //because the $view_data and 
                    $data_vars_2_be_css_escaped,            //other parameters are the same
                    $data_vars_2_be_js_escaped              //and we are rendering using the
                );                                          //same instance of the Renderer class.
    
    $renderer->renderToScreen(
                    './views/view-with-escapable-js.php',
                    $view_data,                             //Already escaped data in the
                    $escape_encoding,                       //first call to renderToScreen 
                    $data_vars_2_be_html_escaped,           //will be bound to this view
                    $data_vars_2_be_html_attr_escaped,      //because the $view_data and 
                    $data_vars_2_be_css_escaped,            //other parameters are the same
                    $data_vars_2_be_js_escaped              //and we are rendering using the
                );                                          //same instance of the Renderer class.
?>
```

>Enabling escaping via the constructor, is a neat way to enforce escaping of specified
view data variables in subsequent calls to the **render*()** methods without having to
pass the escape paremeters each subsequent time any of the **render*()** methods is called.
This is kind of a way to enable **auto-escaping** on an instance of the Renderer class. You
just have to make sure that the escaping parameters are set in a way that makes the most 
sense for the view(s) you are trying to render.

Only string values in the data array and its sub-arrays (if any) will be escaped if escaping is enabled.

More on escaping from the zend-escaper website:

>HTML escaping is accomplished via Zend\Escaper\Escaper's escapeHtml method. Internally it uses PHP's htmlspecialchars, 
and additionally correctly sets the flags and encoding. One thing a developer needs to pay special attention too, is the 
encoding in which the document is served to the client; **it must be the same** as the encoding used for escaping!
Go [here](https://github.com/rotexdegba/zend-escaper/blob/master/doc/book/zend.escaper.escaping-html.md) for more details.

>HTML Attribute escaping is accomplished via Zend\Escaper\Escaper's escapeHtmlAttr method. Internally it will convert the data to UTF-8, 
check for it's validity, and use an extended set of characters to escape that are not covered by htmlspecialchars to cover the cases 
where an attribute might be unquoted or quoted illegally.
Go [here](https://github.com/rotexdegba/zend-escaper/blob/master/doc/book/zend.escaper.escaping-html-attributes.md) for more details.

>CSS escaping is accomplished via Zend\Escaper\Escaper's escapeCss method. CSS escaping excludes only basic alphanumeric characters 
and escapes all other characters into valid CSS hexadecimal escapes.
Go [here](https://github.com/rotexdegba/zend-escaper/blob/master/doc/book/zend.escaper.escaping-css.md) for more details.

>Javascript escaping is accomplished via Zend\Escaper\Escaper's escapeJs method.
Javascript string literals in HTML are subject to significant restrictions particularly due to the potential for unquoted attributes 
and any uncertainty as to whether Javascript will be viewed as being CDATA or PCDATA by the browser. To eliminate any possible XSS 
vulnerabilities, Javascript escaping for HTML extends the escaping rules of both ECMAScript and JSON to include any potentially 
dangerous character. Very similar to HTML attribute value escaping, this means escaping everything except basic alphanumeric 
characters and the comma, period and underscore characters as hexadecimal or unicode escapes.
Javascript escaping applies to all literal strings and digits. It is not possible to safely escape other Javascript markup.
An extended set of characters are escaped beyond ECMAScript's rules for Javascript literal string escaping in order to prevent 
misinterpretation of Javascript as HTML leading to the injection of special characters and entities.
Go [here](https://github.com/rotexdegba/zend-escaper/blob/master/doc/book/zend.escaper.escaping-javascript.md) for more details.

### Advanced Usage

#### Implementing a Two-Step View Templating Architecture

Documentation coming soon!