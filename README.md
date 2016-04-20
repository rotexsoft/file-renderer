##### A tool for rendering PHP files that are meant to generate output. Easy to use as a view component in an MVC framework. 

![Build Status](https://travis-ci.org/rotexsoft/file-renderer.svg?branch=master&style=flat-square) &nbsp; https://travis-ci.org/rotexsoft/file-renderer 

This is a simple, elegant and flexible tool that can be used to render php files.

It provides escaping functionality.

It is designed to be un-obtrusive, your view files can easily be used with a different rendering or templating library.
You do not need to learn any new syntax (or markup / templating language) in order to compose your view. Just write your views in plain old php.

Users of this package are still responsible for making sure that they validate or sanitize data coming into their application(s) via user input 
(eg. via html forms) with tools like  [Respect\Validation](https://github.com/Respect/Validation), [Valitron](https://github.com/vlucas/valitron),
[Upload](https://github.com/brandonsavage/Upload), [Volan](https://github.com/serkin/Volan), [Sirius Validation](https://github.com/siriusphp/validation), 
[Filterus](https://github.com/ircmaxell/filterus), etc.
