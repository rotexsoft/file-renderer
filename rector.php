<?php
declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;


return static function (ContainerConfigurator $containerConfigurator): void {
    
    // get parameters
    $parameters = $containerConfigurator->parameters();

    // Define what rule sets will be applied
    $parameters->set(Option::SETS, [
        SetList::PHP_52,
        SetList::PHP_53,
        SetList::PHP_54,
        SetList::PHP_55,
        SetList::PHP_56,
        SetList::PHP_70,
        SetList::PHP_71,
        SetList::PHP_72,
        SetList::DEAD_CODE,
        SetList::PHP_73,
        SetList::PHP_74,
        //SetList::PHP_80,
        SetList::DEAD_CODE,
        SetList::PSR_4,
        SetList::TYPE_DECLARATION,
        SetList::TYPE_DECLARATION_STRICT,
    ]);

    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();
};
