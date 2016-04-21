# PHP File Renderer

![Build Status](https://travis-ci.org/rotexsoft/file-renderer.svg?branch=master&style=flat-square) &nbsp; https://travis-ci.org/rotexsoft/file-renderer 

## Introduction

This is a simple, elegant and flexible tool that can be used to render php files. It is designed to be un-obtrusive; your view files can easily be used 
with a different rendering or templating library. You do not need to learn any new syntax (or markup / templating language) in order to compose your view; 
simply write your views in plain old php. This package also provides escaping functionality for data passed to the view file(s).

This package can easily be used by framework developers to implement the View layer of an MVC (Model-View-Controller) framework.

Users of this package are still responsible for making sure that they validate or sanitize data coming into their application(s) via user input 
(eg. via html forms) with tools like  [Respect\Validation](https://github.com/Respect/Validation), [Valitron](https://github.com/vlucas/valitron),
[Upload](https://github.com/brandonsavage/Upload), [Volan](https://github.com/serkin/Volan), [Sirius Validation](https://github.com/siriusphp/validation), 
[Filterus](https://github.com/ircmaxell/filterus), etc.
