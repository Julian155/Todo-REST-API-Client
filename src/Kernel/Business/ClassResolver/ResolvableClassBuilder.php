<?php
declare(strict_types=1);

namespace App\Kernel\Business\ClassResolver;

class ResolvableClassBuilder
{
    /**
     * @var string
     */
    private string $rootNameSpace;

    /**
     * @var string
     */
    private string $moduleName = '';

    /**
     * @param string $rootNameSpace
     */
    public function __construct(string $rootNameSpace)
    {
        $this->rootNameSpace = $rootNameSpace;
    }

    /**
     * @param object|string $callerClass
     *
     * @return void
     */
    public function extractResolvableClassModule(object|string $callerClass): void
    {
        if (is_object($callerClass)) {
            $className = get_class($callerClass);

            $classNameParts = explode('\\', $className);

            $this->moduleName = $classNameParts[1];

            return;
        }

        $this->moduleName = $callerClass;
    }

    /**
     * @return string
     */
    public function getRootNameSpace(): string
    {
        return $this->rootNameSpace;
    }

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return $this->moduleName;
    }
}
