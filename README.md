# PHP File Renderer

[![PHP Tests and Code Quality Tools](https://github.com/rotexsoft/file-renderer/workflows/Run%20PHP%20Tests%20and%20Code%20Quality%20Tools/badge.svg)](https://github.com/rotexsoft/file-renderer/actions?query=workflow%3A%22Run+PHP+Tests+and+Code+Quality+Tools%22) &nbsp;
![GitHub release (latest SemVer)](https://img.shields.io/github/v/release/rotexsoft/file-renderer) &nbsp; 
![GitHub](https://img.shields.io/github/license/rotexsoft/file-renderer) &nbsp; 
[![Coverage Status](https://coveralls.io/repos/github/rotexsoft/file-renderer/badge.svg?branch=master)](https://coveralls.io/github/rotexsoft/file-renderer?branch=master) &nbsp; 
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/rotexsoft/file-renderer) &nbsp;
![Packagist Downloads](https://img.shields.io/packagist/dt/rotexsoft/file-renderer) &nbsp;
![GitHub top language](https://img.shields.io/github/languages/top/rotexsoft/file-renderer) &nbsp; 
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/rotexsoft/file-renderer) &nbsp; 
![GitHub commits since latest release (by date)](https://img.shields.io/github/commits-since/rotexsoft/file-renderer/latest) &nbsp; 
![GitHub last commit](https://img.shields.io/github/last-commit/rotexsoft/file-renderer) &nbsp; 
![GitHub Release Date](https://img.shields.io/github/release-date/rotexsoft/file-renderer) &nbsp; 
<a href="https://libraries.io/packagist/rotexsoft%2Ffile-renderer">
    <img alt="Libraries.io dependency status for GitHub repo" src="https://img.shields.io/librariesio/github/rotexsoft/file-renderer">
</a>

- [PHP File Renderer](#php-file-renderer)
    - [Introduction](#introduction)
        - [Main Features](#main-features)
	- [Acknowledgement](#acknowledgement)
    - [Changelog](#changelog)
	- [Contribution](#contribution)
		- [Running Tests](#running-tests)
	- [Requirements](#requirements)
	- [Installation](#installation)
	- [Usage](#usage)
		- [Basic Usage](#basic-usage)
		- [Getting, Setting and Unsetting View Data](#getting-setting-and-unsetting-view-data)
			- [Setting View Data](#setting-view-data)
			- [Getting View Data](#getting-view-data)
			- [Unsetting View Data](#unsetting-view-data)
		- [File paths](#file-paths)
		- [Escaping Data to be Passed to Views](#escaping-data-to-be-passed-to-views)
			- [Using Wild Cards in Escape Specification](#using-wild-cards-in-escape-specification)
		- [Advanced Usage](#advanced-usage)
			- [Implementing a Two-Step View Templating System](#implementing-a-two-step-view-templating-system)
				- [Sharing Data between Layout and Page Content Views](#sharing-data-between-layout-and-page-content-views)
			- [Nesting Renderers](#nesting-renderers)

## Introduction

This is a simple, elegant and flexible tool that can be used to render php files (also referred to as `Views` within this documentation)
that emit valid html output to a web-browser. It is designed to be unobtrusive; your view files can easily be used with a different
rendering or templating library. You do not need to learn any new syntax (or markup / templating language) in order to compose your
views; simply write your views in plain old php. This package also provides escaping functionality for data passed to the view file(s).

This package can easily be used by framework developers to implement the View layer of an MVC (Model-View-Controller) framework.
It can also be easily incorporated into existing frameworks.

100% Unit Test Coverage.

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

The escaping functionality in this package is implemented using the [laminas-escaper](https://docs.laminas.dev/laminas-escaper/) package.

## Changelog

[Here](https://github.com/rotexsoft/file-renderer/releases).

## Contribution

Since the goal of this package is to be lean and flexible, pull requests for significant
new features will not be accepted. Users are encouraged to extend the package with new
feature(s) in their own projects. However, bug fix and documentation enhancement
related pull requests are greatly welcomed.

### Running Tests

  ` ./vendor/bin/phpunit --coverage-text`

### Branching

These are the branches in this repository:

- **master:** contains code for the latest major version of this package
- **1.X:** contains code for the **1.x** version of this package
- **2.X:** contains code for the **2.x** version of this package
- **5.x:** contains code for the **5.x** version of this package

## Requirements

* PHP 8.1+
* Not currently certified for use with HHVM (unit tests failing when run in an HHVM environment).

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

    $bad_css_with_xss = <<<INPUT
body { background-image: url('http://example.com/foo.jpg?'); }</style>
<script>alert('You\\'ve been XSSed!')</script><style>
INPUT;

    $bad_css_with_xss2 = ' display: block; " onclick="alert(\'You\\\'ve been XSSed!\'); ';

    $bad_url_segment_with_xss = ' " onmouseover="alert(\'zf2\')';

    $view_data = [
        'paragraph_data_from_file_renderer'                     => 'This is a Paragraph!!',
        'var_that_should_be_html_escaped'                       => '<script>alert("zf2");</script>',
        'var_that_should_be_html_attr_escaped'                  => 'faketitle" onmouseover="alert(/ZF2!/);',
        'var_that_should_be_css_escaped'                        => $bad_css_with_xss,
        'another_var_that_should_be_css_escaped'                => $bad_css_with_xss2,
        'var_that_can_be_safely_js_escaped'                     => "javascript's cool",
        'a_var_that_can_be_safely_js_escaped'                   => '563',
        'a_var_that_cant_be_guaranteed_to_be_safely_js_escaped' => ' var x = \'Yo!\'; alert(x); ',
        'var_that_should_be_url_escaped'                        => $bad_url_segment_with_xss,
    ];

    //You MUST include the file extension in the file name (in this case `.php`)
    //NOTE: that the fourth argument represents the encoding that will be used
    //      by the escaping functions in the renderer. This value should be the
    //      same as the encoding specified in the view file being rendered
    //      (eg. the charset value of the http-equiv meta tag in your view).
    $renderer = new \Rotexsoft\FileRenderer\Renderer('view.php', $view_data, $file_paths, 'utf-8');

    //You could alternately create the Renderer object like below:
    //$renderer = new \Rotexsoft\FileRenderer\Renderer('./views/view.php', $view_data);

    $renderer->renderToScreen(); //Render the file immediately to the screen

    // The two lines below are equivalent to $renderer->renderToScreen()
    $output = $renderer->renderToString(); //First capture the output of rendering
                                           //the file in a string variable.
    echo $output;

    //The render*() methods will extract the elements of the data array into
    //variables (array keys will be used as variable names) that will be
    //available to the view file to be rendered before rendering the view.

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
        <title>Escaped Entities</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <style>
           <?php // CSS escaping is being applied to the variable below ?>
            <?php echo $this->escapeCss($var_that_should_be_css_escaped); ?>
        </style>

        <script type="text/javascript">
            // Javascript escaping is being applied to the variable below
            var some_string = '<?php echo $this->escapeJs($var_that_can_be_safely_js_escaped); ?>';
            alert(some_string);
        </script>
    </head>
    <body>
        <!-- An unescaped variable -->
        <p><?php echo $paragraph_data_from_file_renderer; ?></p>

        <div>
            <!-- Html Attribute escaping is being applied to the variable below -->
            <span title="<?php echo $this->escapeHtmlAttr($var_that_should_be_html_attr_escaped); ?>" >
                What framework are you using?
                <!-- Html escaping is being applied to the variable below -->
                <?php echo $this->escapeHtml($var_that_should_be_html_escaped); ?>
            </span>
        </div>

        <!-- CSS escaping is being applied to the variable below -->
        <p style="<?php echo $this->escapeCss($another_var_that_should_be_css_escaped); ?>">
            User controlled CSS needs to be properly escaped!

            <!-- Url escaping is being applied to the variable below -->
            <a href="http://example.com/?name=<?php echo $this->escapeUrl($var_that_should_be_url_escaped); ?>">Click here!</a>
        </p>

        <!-- Javascript escaping is being applied to the variable below -->
        <p onclick="var a_number = <?php echo $this->escapeJs($a_var_that_can_be_safely_js_escaped); ?>; alert(a_number);">
            Javascript escaping the variable in this paragraph's onclick attribute should
            be safe if the variable contains basic alphanumeric characters. It will definitely
            prevent XSS attacks.
        </p>

        <!-- Javascript escaping is being applied to the variable below -->
        <p onclick="<?php echo $this->escapeJs($a_var_that_cant_be_guaranteed_to_be_safely_js_escaped); ?>">
            Javascript escaping the variable in this paragraph's onclick attribute may lead
            to Javascript syntax error(s) but will prevent XSS attacks.
        </p>
    </body>
</html>

```

**NOTE:** the file name, if any, supplied to the **render*()** methods will be
considered first for rendering if the file exists. The file name supplied to the
constructor during object creation will be considered last for rendering if the
file name supplied to the **render*()** method can't be found.

**NOTE:** you can access the Renderer object inside your view via the **`$this`** variable.
There are five escape methods you can use within your view:
* **`$this->escapeHtml(string $some_string_variable):`** an alias for PHP's htmlspecialchars() for escaping data which may contain html markup.
* **`$this->escapeHtmlAttr(string $some_string_variable):`** for escaping data which is meant to be rendered as an attribute value within an html element in a view.
* **`$this->escapeCss(string $some_string_variable):`** for escaping data which is meant to be rendered within `<style>` tags or inside the style attribute of any html element.
* **`$this->escapeJs(string $some_string_variable):`** for escaping data which is meant to be rendered as string literals or digits within Javascript code in a view.
* **`$this->escapeUrl(string $some_string_variable):`** an alias for PHP's rawurlencode() for escaping data being inserted into a URL and not to the whole URL itself.

See the [Escaping Data to be Passed to Views](#escaping-data-to-be-passed-to-views) section for more info about escaping.


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
    //internal view data array (ie. the protected `data` property in \Rotexsoft\FileRenderer\Renderer).
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

Escaping functionality is provided via the laminas-escaper package. It is **STRONGLY RECOMMENDED** that you read this
[article](https://docs.laminas.dev/laminas-escaper/theory-of-operation/)
to understand the principles behind properly escaping data.

Escaping is possible in four contexts:
* **Html:** this type of escaping should be used for view data variables which may contain html markup.
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

Given `$var_that_should_be_html_escaped` with an initial value of:
> `'<script>alert("zf2");</script>'`

it will be transformed to
> `'&lt;script&gt;alert(&quot;zf2&quot;);&lt;/script&gt;'`

after **html** escaping is applied to it.

* **Html Attribute:** this type of escaping should be used for view data variables which are meant to be
rendered as attribute values within html elements in a view. For example:

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

Given `$var_that_should_be_html_attr_escaped` has an initial value of:
>`'faketitle" onmouseover="alert(/ZF2!/);'`

it will be transformed to
>`'faketitle&quot;&#x20;onmouseover&#x3D;&quot;alert&#x28;&#x2F;ZF2&#x21;&#x2F;&#x29;&#x3B;'`

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

Given `$var_that_should_be_css_escaped` has an initial value of:
>`"body { background-image: url('http://example.com/foo.jpg?'); }</style><script>alert('You\\'ve been XSSed!')</script><style>"`

it will be transformed to
>`"body\20 \7B \20 background\2D image\3A \20 url\28 \27 http\3A \2F \2F example\2E com\2F foo\2E jpg\3F \27 \29 \3B \20 \7D \3C \2F style\3E \3C script\3E alert\28 \27 You\5C \27 ve\20 been\20 XSSed\21 \27 \29 \3C \2F script\3E \3C style\3E"`

after **css** escaping is applied to it.

Given `$another_var_that_should_be_css_escaped` has an initial value of:
>`' display: block; " onclick="alert(\'You\\\'ve been XSSed!\'); '`

it will be transformed to
>`'\20 display\3A \20 block\3B \20 \22 \20 onclick\3D \22 alert\28 \27 You\5C \27 ve\20 been\20 XSSed\21 \27 \29 \3B \20 '`

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
        <p onclick="var a_number = <?php echo $a_var_that_can_be_safely_js_escaped; ?>; alert(a_number);">
            Javascript escaping the variable in this paragraph's onclick attribute should
            be safe if the variable contains basic alphanumeric characters. It will definitely
            prevent XSS attacks.
        </p>

        <p onclick="<?php echo $a_var_that_cant_be_guaranteed_to_be_safely_js_escaped; ?>">
            Javascript escaping the variable in this paragraph's onclick attribute may lead
            to Javascript syntax error(s) but will prevent XSS attacks.
        </p>
    </body>
</html>
```

Given `$var_that_can_be_safely_js_escaped` has an initial value of:
>`"javascript's cool"`

it will be transformed to
>`'javascript\x27s\x20cool'`

after **Javascript** escaping is applied to it.

Given `$a_var_that_can_be_safely_js_escaped` has an initial value of:
>`'563'`

it will be left unchanged with the same value of
>`'563'`

after **Javascript** escaping is applied to it.

Given `$a_var_that_cant_be_guaranteed_to_be_safely_js_escaped` has an initial value of:
>`' var x = \'Yo!\'; alert(x); '`

it will be transformed to
>`'\x20var\x20x\x20\x3D\x20\x27Yo\x21\x27\x3B\x20alert\x28x\x29\x3B\x20'`

after **Javascript** escaping is applied to it.

You can enable escaping

1. during the creation of the Renderer object.

2. during a call to any of the **render*()** methods.

3. manually within your view file by calling any of the public escape methods available in Renderer Class:
    - `$this->escapeHtml(string $some_string_variable)`
    - `$this->escapeHtmlAttr(string $some_string_variable)`
    - `$this->escapeCss(string $some_string_variable)`
    - `$this->escapeJs(string $some_string_variable)`
    - `$this->escapeUrl(string $some_string_variable)`


* To enable escaping during the creation of a Renderer object:

```php
<?php
    $file_paths = [];

    $bad_css_with_xss = <<<INPUT
body { background-image: url('http://example.com/foo.jpg?'); }</style>
<script>alert('You\\'ve been XSSed!')</script><style>
INPUT;
    $bad_css_with_xss2 = ' display: block; " onclick="alert(\'You\\\'ve been XSSed!\'); ';

    $view_data = [
        'var_that_should_be_html_escaped'                       => '<script>alert("zf2");</script>',
        'var_that_should_be_html_attr_escaped'                  => 'faketitle" onmouseover="alert(/ZF2!/);',
        'var_that_should_be_css_escaped'                        => $bad_css_with_xss,
        'another_var_that_should_be_css_escaped'                => $bad_css_with_xss2,
        'var_that_can_be_safely_js_escaped'                     => "javascript's cool",
        'a_var_that_can_be_safely_js_escaped'                   => '563',
        'a_var_that_cant_be_guaranteed_to_be_safely_js_escaped' => ' var x = \'Yo!\'; alert(x); ',
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
        'a_var_that_can_be_safely_js_escaped',
        'a_var_that_cant_be_guaranteed_to_be_safely_js_escaped'
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

>#### Using Wild Cards in Escape Specification

>To specify that all fields in the data array be **HTML escaped**, set the `$data_vars_2_be_html_escaped`
array in the example above with a value of `['*']`

>To specify that all fields in the data array be **HTML attribute escaped**, set the `$data_vars_2_be_html_attr_escaped`
array in the example above with a value of `['*']`

>To specify that all fields in the data array be **CSS escaped**, set the `$data_vars_2_be_css_escaped`
array in the example above with a value of `['*']`

>To specify that all fields in the data array be **Javascript escaped**, set the `$data_vars_2_be_js_escaped`
array in the example above with a value of `['*']`

* To enable escaping during a call to any of the **render*()** methods:

```php
<?php
    $bad_css_with_xss = <<<INPUT
body { background-image: url('http://example.com/foo.jpg?'); }</style>
<script>alert('You\\'ve been XSSed!')</script><style>
INPUT;

    $bad_css_with_xss2 = ' display: block; " onclick="alert(\'You\\\'ve been XSSed!\'); ';

    $view_data = [
        'var_that_should_be_html_escaped'                       => '<script>alert("zf2");</script>',
        'var_that_should_be_html_attr_escaped'                  => 'faketitle" onmouseover="alert(/ZF2!/);',
        'var_that_should_be_css_escaped'                        => $bad_css_with_xss,
        'another_var_that_should_be_css_escaped'                => $bad_css_with_xss2,
        'var_that_can_be_safely_js_escaped'                     => "javascript's cool",
        'a_var_that_can_be_safely_js_escaped'                   => '563',
        'a_var_that_cant_be_guaranteed_to_be_safely_js_escaped' => ' var x = \'Yo!\'; alert(x); ',
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
        'a_var_that_can_be_safely_js_escaped',
        'a_var_that_cant_be_guaranteed_to_be_safely_js_escaped'
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
This is how to enable **auto-escaping** on an instance of the Renderer class. You
just have to make sure that the escaping parameters are set in a way that makes the most
sense for the view(s) you are trying to render.

Only string values in the data array and its sub-arrays (if any) will be escaped if escaping is enabled.

More on escaping from the laminas-escaper website:

>HTML escaping is accomplished via Laminas\Escaper\Escaper's escapeHtml method. Internally it uses PHP's htmlspecialchars,
and additionally correctly sets the flags and encoding. One thing a developer needs to pay special attention too, is the
encoding in which the document is served to the client; **it must be the same** as the encoding used for escaping!
Go [here](https://docs.laminas.dev/laminas-escaper/escaping-html/) for more details.

>HTML Attribute escaping is accomplished via Laminas\Escaper\Escaper's escapeHtmlAttr method. Internally it will convert the data to UTF-8,
check for it's validity, and use an extended set of characters to escape that are not covered by htmlspecialchars to cover the cases
where an attribute might be unquoted or quoted illegally.
Go [here](https://docs.laminas.dev/laminas-escaper/escaping-html-attributes/) for more details.

>CSS escaping is accomplished via Laminas\Escaper\Escaper's escapeCss method. CSS escaping excludes only basic alphanumeric characters
and escapes all other characters into valid CSS hexadecimal escapes.
Go [here](https://docs.laminas.dev/laminas-escaper/escaping-css/) for more details.

>Javascript escaping is accomplished via Laminas\Escaper\Escaper's escapeJs method.
Javascript string literals in HTML are subject to significant restrictions particularly due to the potential for unquoted attributes
and any uncertainty as to whether Javascript will be viewed as being CDATA or PCDATA by the browser. To eliminate any possible XSS
vulnerabilities, Javascript escaping for HTML extends the escaping rules of both ECMAScript and JSON to include any potentially
dangerous character. Very similar to HTML attribute value escaping, this means escaping everything except basic alphanumeric
characters and the comma, period and underscore characters as hexadecimal or unicode escapes.
Javascript escaping applies to all literal strings and digits. It is not possible to safely escape other Javascript markup.
An extended set of characters are escaped beyond ECMAScript's rules for Javascript literal string escaping in order to prevent
misinterpretation of Javascript as HTML leading to the injection of special characters and entities.
Go [here](https://docs.laminas.dev/laminas-escaper/escaping-javascript/) for more details.

### Advanced Usage

#### Implementing a Two-Step View Templating System

The simplest way to implement a **Two-Step View Templating System** is to create two instances of the **Renderer**
class. One instance will be used to render the layout view file and the other will be used to render the page content
that will be passed as a data field to the first renderer (ie. the layout renderer). A single instance of the **Renderer**
class could also be used to accomplish the same result. It's up to you to decide how data should be passed to the views.

**Implementation:** Assuming `layout.php`, `sample-content-page.php`,
`two-step-view-implemetation-two-renderers.php` and `two-step-view-implemetation-one-renderer.php`
are all in the same folder.

`layout.php`

```php
<!DOCTYPE html>
<html>
    <head>
        <title>Two Step View Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div>
            <?php echo $page_content; ?>
        </div>
    </body>
</html>
```

`sample-content-page.php`

```html
<p>This is a sample page to be injected into <strong>layout.php</strong>.</p>
```

`two-step-view-implemetation-two-renderers.php`

```php
<?php
    $layout_data = [];
    $layout_renderer = new \Rotexsoft\FileRenderer\Renderer();
    $layout_page_content_renderer = new \Rotexsoft\FileRenderer\Renderer();

    //Render the page content and store it in the data array to be passed to the layout.
    $layout_data['page_content'] =
             $layout_page_content_renderer->renderToString('./sample-content-page.php');

    //Render the layout
    $layout_renderer->renderToScreen('./layout.php', $layout_data);
?>
```

`two-step-view-implemetation-one-renderer.php`

```php
<?php
    $layout_data = [];
    $renderer = new \Rotexsoft\FileRenderer\Renderer();

    //Render the page content and store it in the data array to be passed to the layout.
    $layout_data['page_content'] = $renderer->renderToString('./sample-content-page.php');

    //Render the layout
    $renderer->renderToScreen('./layout.php', $layout_data);
?>
```

Running `two-step-view-implemetation-two-renderers.php` or `two-step-view-implemetation-one-renderer.php`
will lead to the output below:

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Two Step View Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div>
            <p>This is a sample page to be injected into <strong>view.php</strong>.</p>
        </div>
    </body>
</html>
```

##### Sharing Data between Layout and Page Content Views

`two-step-view-implemetation-one-renderer-share-data.php`

```php
<?php
    $layout_data = []; //pass this data array to renderToScreen or renderToString
                       //when rendering layout.php. This is additional data that
                       //will only be available to layout.php.

    //The 'page_content' entry in the array below will be available to all
    //views rendered using $renderer. Passing a data array with a 'page_content'
    //entry to renderToString or renderToScreen will cause the intial value of
    //the 'page_content' entry (in this case 'Default Page Content!') to be
    //ignored when rendering (the value of the 'page_content' entry in the data
    //array passed to renderToString or renderToScreen will be used instead).
    $shared_data = ['page_content' => 'Default Page Content!'];
    $renderer = new \Rotexsoft\FileRenderer\Renderer('', $shared_data);

    //Render the page content and store it in the data array to be passed to the layout.
    $layout_data['page_content'] = $renderer->renderToString('./sample-content-page.php');

    //Render the layout
    $renderer->renderToScreen('./layout.php', $layout_data); // will cause
                                                             // $layout_data['page_content']
                                                             // to be used as $page_content
                                                             // in layout.php instead of the
                                                             // value of $shared_data['page_content'].

    $renderer->renderToScreen('./layout.php'); // This will cause
                                               // $shared_data['page_content']
                                               // to be used as $page_content
                                               // in layout.php because we are
                                               // not passing any data array to
                                               // renderToScreen so it looks for
                                               // data in the $shared_data passed
                                               // to the constructor. Note that
                                               // the values in $shared_data are
                                               // stored in a protected property
                                               // of $renderer (ie. $renderer->data
                                               // whose value is publicly accessible
                                               // via $renderer->getData()).
?>
```

The example above can be extended for use-cases where more than one renderer is being used.


#### Nesting Renderers

You can actually pass instances of **\Rotexsoft\FileRenderer\Renderer** to php functions and statements that accept string arguments like **echo**, **sprintf** & the likes. 

The instance of **\Rotexsoft\FileRenderer\Renderer** passed to such a function or statement will be automatically converted to a string by php automatically calling the **\Rotexsoft\FileRenderer\Renderer::__toString()** method of the instance. 

**\Rotexsoft\FileRenderer\Renderer::__toString()** tries to render the file associated with the instance and passes the string result returned from rendering the file back to the function or statement that expects a string argument. 

This behavior can be taken advantage of when a renderer has one or more renderers added to it as data via any of the following methods:

- an array containing one or more renderers is passed as the second argument passed to **\Rotexsoft\FileRenderer\Renderer::__construct(...)**
- calling **\Rotexsoft\FileRenderer\Renderer::setVar($key, $value)** with a second argument that is a renderer or an array of renderers
- object property assignment via the magic setter **\Rotexsoft\FileRenderer\Renderer::__set($key, $value)** builtin php mechanism

Now let's see how we can leverage this automatic conversion of renderer objects to strings in an application.

Assume you have the four php files below in your application:

`layout.php`

```php
<!DOCTYPE html>
<html>
    <head>
        <title>Nesting Renderers Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div>
            <?php echo $layout_content; ?>
        </div>
    </body>
</html>
```

`layout_content.php`

```php
            <p>This is a sample page to be injected into <strong>layout.php</strong>.</p>
            <?= $layout_content_1; ?>
```

`layout_content_1.php`

```php
            <p>This is a sample page to be injected into <strong>layout_content.php</strong>.</p>
            <?= $layout_content_2; ?>
```

`layout_content_2.php`

```php
            <p>This is a sample page to be injected into <strong>layout_content_1.php</strong>.</p>
```

We can render them via nesting like so in a file that is in the same folder with the four php files above 
(they could be in any folder, just make sure the correct path is prepended to the file name passed as 
the first argument to the constructor of the renderer class):

`nesting_tester.php`

```php
$layout_renderer = new \Rotexsoft\FileRenderer\Renderer('./layout.php');
$page_renderer = new \Rotexsoft\FileRenderer\Renderer('./layout_content.php');
$page_renderer2 = new \Rotexsoft\FileRenderer\Renderer('./layout_content_1.php');
$page_renderer3 = new \Rotexsoft\FileRenderer\Renderer('./layout_content_2.php');

$layout_renderer->layout_content= $page_renderer;
$page_renderer->layout_content_1= $page_renderer2;
$page_renderer2->layout_content_2= $page_renderer3;

echo $layout_renderer; 
```

Which results in the output below:

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Nesting Renderers Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div>
                        <p>This is a sample page to be injected into <strong>layout.php</strong>.</p>
                        <p>This is a sample page to be injected into <strong>layout_content.php</strong>.</p>
                        <p>This is a sample page to be injected into <strong>layout_content_1.php</strong>.</p>
        </div>
    </body>
</html>
```

Now let's walk through what just happened.

We created four renderer objects assigned to **$layout_renderer**, **$page_renderer**,
**$page_renderer2** and **$page_renderer3** to render **layout.php**, **layout_content.php**, 
**layout_content_1.php** and **layout_content_2.php** respectively.

```php
$layout_renderer = new \Rotexsoft\FileRenderer\Renderer('./layout.php');
$page_renderer = new \Rotexsoft\FileRenderer\Renderer('./layout_content.php');
$page_renderer2 = new \Rotexsoft\FileRenderer\Renderer('./layout_content_1.php');
$page_renderer3 = new \Rotexsoft\FileRenderer\Renderer('./layout_content_2.php');
```

We then did the following assignments:

* The renderer **$page_renderer** is assigned to the renderer **$layout_renderer** as a property named **layout_content** which will be accessible via the variable **$layout_content** inside the **layout.php** file to be rendered by **$layout_renderer**

```php
$layout_renderer->layout_content= $page_renderer;
```

* The renderer **$page_renderer2** is assigned to the renderer **$page_renderer** as a property named **layout_content_1** which will be accessible via the variable **$layout_content_1** inside the **layout_content.php** file to be rendered by **$page_renderer**

```php
$page_renderer->layout_content_1= $page_renderer2;
```

* The renderer **$page_renderer3** is assigned to the renderer **$page_renderer2** as a property named **layout_content_2** which will be accessible via the variable **$layout_content_2** inside the **layout_content_1.php** file to be rendered by **$page_renderer2**

```php
$page_renderer2->layout_content_2= $page_renderer3;
```

We finally execute the **echo** statement with **$layout_renderer** as its argument:

```php
echo $layout_renderer; 
```

This leads to php automatically executing **$layout_renderer->__toString()**, which leads to the 
rendering of **layout.php** which has the echo statement below inside it

```php
<?php echo $layout_content; ?> 
```

**$layout_content** in **layout.php** shown in the echo statement snippet above is actually referencing the renderer assigned to 
**$page_renderer** in **nesting_tester.php** earlier above. 

This echo statement in **layout.php** leads to php automatically executing **$layout_content->__toString()**, 
which leads to the rendering of **layout_content.php** which has the echo statement below inside it

```php
<?= $layout_content_1; ?>
```

**$layout_content_1** in **layout_content.php** shown in the echo statement snippet above is actually referencing the renderer assigned to 
**$page_renderer2** in **nesting_tester.php** earlier above. 

This echo statement in **layout_content.php** leads to php automatically executing **$layout_content_1->__toString()**, 
which leads to the rendering of **layout_content_1.php** which has the echo statement below inside it

```php
<?= $layout_content_2; ?>
```
**$layout_content_2** in **layout_content_1.php** shown in the echo statement snippet above is actually referencing the renderer assigned to 
**$page_renderer3** in **nesting_tester.php** earlier above. 

This echo statement in **layout_content_1.php** leads to php automatically executing **$layout_content_2->__toString()**, 
which leads to the rendering of **layout_content_2.php** which has just html and no php in it and is the last file rendered in this chain of renderers. Below is the content of **layout_content_2.php** again.

```php
            <p>This is a sample page to be injected into <strong>layout_content_1.php</strong>.</p>
```

This all leads to 
1. the output of rendering **layout_content_2.php** being returned back to the echo statement in **layout_content_1.php**,
2. the output of rendering **layout_content_1.php** is in turn returned back to the echo statement in **layout_content.php**, 
3. the output of rendering **layout_content.php** is in turn returned back to the echo statement in **layout.php** 
4. and finally all these outputs  get combined inside in **layout.php** and  printed out to the screen as the output below (earlier shown above):

```php
<!DOCTYPE html>
<html>
    <head>
        <title>Nesting Renderers Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div>
                        <p>This is a sample page to be injected into <strong>layout.php</strong>.</p>
                        <p>This is a sample page to be injected into <strong>layout_content.php</strong>.</p>
                        <p>This is a sample page to be injected into <strong>layout_content_1.php</strong>.</p>
        </div>
    </body>
</html>
```
That's how you nest renderers and render their combined output. 

> Note: with nesting, you have to supply all the information needed to render each file to the constructor of the 
renderer class when creating each renderer object. See **\Rotexsoft\FileRenderer\Renderer::__construct(...)** for
more details.
