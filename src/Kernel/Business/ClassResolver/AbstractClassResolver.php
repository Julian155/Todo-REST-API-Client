<?php
declare(strict_types=1);

namespace App\Kernel\Business\ClassResolver;

abstract class AbstractClassResolver
{
    private const CLASS_NAME_MAP = [
        'businessFactory' => [
            'layerName' => 'Business\\',
            'classType' => 'BusinessFactory',
        ],
        'communicationFactory' => [
            'layerName' => 'Business\\',
            'classType' => 'CommunicationFactory',
        ],
        'facade' => [
            'layerName' => 'Business\\',
            'classType' => 'Facade',
        ],
        'config' => [
            'layerName' => '',
            'classType' => 'Config',
        ],
        'dependencyProvider' => [
            'layerName' => '',
            'classType' => 'DependencyProvider',
        ],
    ];

    /**
     * @param object $callerClass
     *
     * @return object
     */
    public function resolveClassName(object $callerClass): object
    {
        $resolvableClass = new ResolvableClass($callerClass);

        $layerName = self::CLASS_NAME_MAP[$this->getClassName()]['layerName'];
        $classType = self::CLASS_NAME_MAP[$this->getClassName()]['classType'];

        $resolvedFacadeClassName = sprintf(
            '\%s\%s\%s%s%s',
            $resolvableClass->getProjectName(),
            $resolvableClass->getModuleName(),
            $layerName,
            $resolvableClass->getModuleName(),
            $classType,
        );

        return new $resolvedFacadeClassName;
    }

    /**
     * @return string
     */
    protected abstract function getClassName(): string;
}
