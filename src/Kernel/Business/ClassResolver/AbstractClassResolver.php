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
            'layerName' => 'Communication\\',
            'classType' => 'CommunicationFactory',
        ],
        'facade' => [
            'layerName' => 'Business\\',
            'classType' => 'Facade',
        ],
        'queryContainer' => [
            'layerName' => 'Persistence\\',
            'classType' => 'QueryContainer',
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
     * @var \App\Kernel\Business\ClassResolver\ResolvableClassBuilder|null
     */
    protected static ?ResolvableClassBuilder $resolvableClassBuilder = null;

    /**
     * @param object|string $callerClass
     *
     * @return object
     */
    public function resolveClassName(object|string $callerClass): object
    {
        $this->getResolvableClassBuilder()->extractResolvableClassModule($callerClass);

        $layerName = self::CLASS_NAME_MAP[$this->getClassName()]['layerName'];
        $classType = self::CLASS_NAME_MAP[$this->getClassName()]['classType'];

        $resolvedClassPath = sprintf(
            '\%s\%s\%s%s%s',
            $this->getResolvableClassBuilder()->getRootNameSpace(),
            $this->getResolvableClassBuilder()->getModuleName(),
            $layerName,
            $this->getResolvableClassBuilder()->getModuleName(),
            $classType,
        );

        return new $resolvedClassPath;
    }

    /**
     * @return \App\Kernel\Business\ClassResolver\ResolvableClassBuilder
     */
    protected function getResolvableClassBuilder(): ResolvableClassBuilder
    {
        if (!static::$resolvableClassBuilder) {
            $rootNamespace = strtok(__NAMESPACE__, '\\');

            static::$resolvableClassBuilder = new ResolvableClassBuilder($rootNamespace);
        }

        return static::$resolvableClassBuilder;
    }
    /**
     * @return string
     */
    protected abstract function getClassName(): string;
}
