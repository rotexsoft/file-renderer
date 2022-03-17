<?php
namespace{
    \error_reporting(E_ALL | E_STRICT);

    require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'vendor/autoload.php';
}

namespace Rotexsoft\FileRenderer {

    function hash_algos(): array {

        $algos = ['sha512', 'sha384', 'sha256', 'sha1'];

        return [ $algos[\RendererTest::$hash_algo_index] ];
    }
} 
// this is the replacement version of \hash_algos() 
// that will be called when running phpunit tests

