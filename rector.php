<?php
declare(strict_types=1);

use Rector\Set\ValueObject\SetList;
use Rector\Config\RectorConfig;


return static function (RectorConfig $containerConfigurator): void {

    // Define what rule sets will be applied
    $containerConfigurator->import(SetList::PHP_52);
    $containerConfigurator->import(SetList::PHP_53);
    $containerConfigurator->import(SetList::PHP_54);
    $containerConfigurator->import(SetList::PHP_55);
    $containerConfigurator->import(SetList::PHP_56);
    $containerConfigurator->import(SetList::PHP_70);
    $containerConfigurator->import(SetList::PHP_71);
    $containerConfigurator->import(SetList::PHP_72);
    $containerConfigurator->import(SetList::PHP_73);
    $containerConfigurator->import(SetList::PHP_74);
    //$containerConfigurator->import(SetList::PHP_80);
    //$containerConfigurator->import(SetList::PHP_81);
    
    $containerConfigurator->import(SetList::PSR_4);
    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::TYPE_DECLARATION);
    
    $containerConfigurator->skip([
        \Rector\Php71\Rector\FuncCall\CountOnNullRector::class,
    ]);
    
    // get parameters
    //$parameters = $containerConfigurator->parameters();

    // register a single rule
    //$services = $containerConfigurator->services();
    //$services->set(TypedPropertyRector::class);
    
    // get services (needed for register a single rule)
    $services = $containerConfigurator->services();
    
    //TODO:PHP8 comment once PHP 8 becomes minimum version
    $services->remove(Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector::class);
};
