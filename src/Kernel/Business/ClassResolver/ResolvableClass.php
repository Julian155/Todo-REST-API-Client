<?php
declare(strict_types=1);

namespace App\Kernel\Business\ClassResolver;

class ResolvableClass
{
    /**
     * @var string
     */
    private string $projectName = '';

    /**
     * @var string
     */
    private string $moduleName = '';

    /**
     * @var string
     */
    private string $layerName = '';

    /**
     * @param object $callerClass
     */
    public function __construct(object $callerClass)
    {
        $this->initResolvableClass($callerClass);
    }

    /**
     * @param object $callerClass
     *
     * @return void
     */
    protected function initResolvableClass(object $callerClass): void
    {
        $className = get_class($callerClass);

        $classNameParts = explode('\\', $className);

        $this->projectName = $classNameParts[0];
        $this->moduleName = $classNameParts[1];
        $this->layerName = $classNameParts[2];
    }

    /**
     * @return string
     */
    public function getProjectName(): string
    {
        return $this->projectName;
    }

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return $this->moduleName;
    }

    /**
     * @return string
     */
    public function getLayerName(): string
    {
        return $this->layerName;
    }
}
