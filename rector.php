<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;


return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    
    $parameters->set(Option::EXCLUDE_PATHS, [
        // single file
        //__DIR__ . '/src/ComplicatedFile.php',
        // or directory
        //__DIR__ . '/src/views/*/*',
    ]);
    
    $parameters->set(Option::EXCLUDE_RECTORS, [
        
        \Rector\CodeQuality\Rector\If_\MoveOutMethodCallInsideIfConditionRector::class,
        \Rector\CodeQuality\Rector\Ternary\SimplifyTautologyTernaryRector::class,
        \Rector\CodeQuality\Rector\FunctionLike\RemoveAlwaysTrueConditionSetInConstructorRector::class,
        \Rector\CodeQuality\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector::class,
        \Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector::class,
        \Rector\CodeQuality\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector::class,
        \Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector::class,
        \Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector::class,
        \Rector\CodeQuality\Rector\Array_\ArrayThisCallToThisMethodCallRector::class,
        \Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector::class,
        \Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector::class,
        
        \Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector::class,
        \Rector\CodingStyle\Rector\Include_\FollowRequireByDirRector::class,
        \Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class,
        \Rector\CodingStyle\Rector\Assign\ManualJsonStringToJsonEncodeArrayRector::class,
        \Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector::class,
        \Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector::class,
        \Rector\CodingStyle\Rector\Function_\CamelCaseFunctionNamingToUnderscoreRector::class,
        \Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector::class,
        
        \Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector::class,
        
        \Rector\DeadCode\Rector\ClassConst\RemoveUnusedClassConstantRector::class,
        \Rector\DeadCode\Rector\Array_\RemoveDuplicatedArrayKeyRector::class,
        \Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector::class,
        \Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector::class,
        \Rector\DeadCode\Rector\ClassMethod\RemoveUnusedParameterRector::class,
        \Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateConstantRector::class,
        \Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector::class,
        \Rector\DeadCode\Rector\ClassMethod\RemoveDeadConstructorRector::class,
        \Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector::class,
        \Rector\DeadCode\Rector\MethodCall\RemoveDefaultArgumentValueRector::class,
        \Rector\DeadCode\Rector\Property\RemoveSetterOnlyPropertyAndMethodCallRector::class,
        \Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector::class,
        \Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector::class,
        \Rector\DeadCode\Rector\Function_\RemoveUnusedFunctionRector::class,
        \Rector\DeadCode\Rector\ClassMethod\RemoveDeadRecursiveClassMethodRector::class,
        \Rector\DeadCode\Rector\MethodCall\RemoveEmptyMethodCallRector::class,
        
        \Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class,
        \Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::class,
        \Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector::class,
        \Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class,
        \Rector\Naming\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector::class,
        \Rector\Naming\Rector\ClassMethod\MakeIsserClassMethodNameStartWithIsRector::class,
        \Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class,
        \Rector\Naming\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector::class,
        
        \Rector\Php70\Rector\Assign\ListSwapArrayOrderRector::class,
        
        \Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector::class,
        
        \Rector\Php72\Rector\ConstFetch\BarewordStringRector::class,
        
        \Rector\Php74\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector::class,
        
        \Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector::class,
        
        \Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector::class,
    ]);

    // Define what rule sets will be applied
    $parameters->set(Option::SETS, [
        SetList::DEAD_CODE,
            // No Rector
            //  \Rector\DeadCode\Rector\ClassConst\RemoveUnusedClassConstantRector::class,
            //  \Rector\DeadCode\Rector\Array_\RemoveDuplicatedArrayKeyRector::class,
            //  \Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector::class
            //  \Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector::class,
            //  \Rector\DeadCode\Rector\ClassMethod\RemoveUnusedParameterRector::class,
            //  \Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateConstantRector::class,
            //  \Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector::class,
            //  \Rector\DeadCode\Rector\ClassMethod\RemoveDeadConstructorRector::class,
            //  \Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector::class,
            //  \Rector\DeadCode\Rector\MethodCall\RemoveDefaultArgumentValueRector::class,
            //  \Rector\DeadCode\Rector\Property\RemoveSetterOnlyPropertyAndMethodCallRector::class,
            //  \Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector::class,
            //  \Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector::class,
            //  \Rector\DeadCode\Rector\Function_\RemoveUnusedFunctionRector::class,
            //  \Rector\DeadCode\Rector\ClassMethod\RemoveDeadRecursiveClassMethodRector::class,
            //  \Rector\DeadCode\Rector\MethodCall\RemoveEmptyMethodCallRector::class,
        SetList::PERFORMANCE,
        SetList::CODE_QUALITY,
            // No Rector:
            //        \Rector\CodeQuality\Rector\Ternary\SimplifyTautologyTernaryRector::class,
            //        \Rector\CodeQuality\Rector\FunctionLike\RemoveAlwaysTrueConditionSetInConstructorRector::class,
            //        \Rector\CodeQuality\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector::class,
            //        \Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector::class,
            //        \Rector\CodeQuality\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector::class,
            //        \Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector::class,
            //        \Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector::class,
            //        \Rector\CodeQuality\Rector\Array_\ArrayThisCallToThisMethodCallRector::class,
            //        \Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector::class,
            //        \Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector::class,
        SetList::CODE_QUALITY_STRICT,
                // No Rector:
                //  \Rector\CodeQuality\Rector\If_\MoveOutMethodCallInsideIfConditionRector::class,
        SetList::CODING_STYLE,
            // No Rector:
            //        \Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector::class,
            //        \Rector\CodingStyle\Rector\Include_\FollowRequireByDirRector::class,
            //        \Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class,
            //        \Rector\CodingStyle\Rector\Assign\ManualJsonStringToJsonEncodeArrayRector::class,
            //        \Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector::class,
            //        \Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector::class,
            //        \Rector\CodingStyle\Rector\Function_\CamelCaseFunctionNamingToUnderscoreRector::class,
            //        \Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector::class,   //only use in projects where you really wanna do this
        SetList::CODING_STYLE_ADVANCED,
            // No Rector:
            //  \Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector::class,
        //SetList::LARAVEL_STATIC_TO_INJECTION, // only in laravel projects
        //SetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL, // only in laravel projects
        SetList::MYSQL_TO_MYSQLI, // only use in web-apps with db access and db / orm packages
        SetList::NAMING,
            // No Rector:
            //        \Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class,
            //        \Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::class,
            //        \Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector::class,
            //        \Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class,
            //        \Rector\Naming\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector::class,
            //        \Rector\Naming\Rector\ClassMethod\MakeIsserClassMethodNameStartWithIsRector::class,
            //        \Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class,
            //        \Rector\Naming\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector::class,
        SetList::PERFORMANCE,
        SetList::PHPEXCEL_TO_PHPSPREADSHEET, // only use in projects that use phpexcel
        SetList::PHP_52,
        SetList::PHP_53,
        SetList::PHP_54,
        SetList::PHP_55,
        SetList::PHP_56,
        SetList::PHP_70,
            // No Rector
            //  \Rector\Php70\Rector\Assign\ListSwapArrayOrderRector::class,
        SetList::PHP_71,
            // No Rector
            //  \Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector::class,
        SetList::PHP_72,
            // No Rector
            //  \Rector\Php72\Rector\ConstFetch\BarewordStringRector::class,
        SetList::PHP_73,
        SetList::PHP_74,
            // No Rector
            //  \Rector\Php74\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector::class,
        //SetList::PHP_80
            // No Rector
            //  \Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector::class,
        //SetList::PSR_4,
        SetList::TYPE_DECLARATION,
            // No Rector
            //  \Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector::class,
    ]);

    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();
};
