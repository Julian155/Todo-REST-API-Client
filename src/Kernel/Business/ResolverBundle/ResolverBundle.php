<?php
declare(strict_types=1);

namespace App\Kernel\Business\ResolverBundle;

class ResolverBundle implements ResolverBundleInterface
{
    /**
     * @var array
     */
    protected static array $resolvedClassCache = [];

    /**
     * @var array
     */
    private array $resolvers;

    /**
     * @var string
     */
    private string $moduleName = '';

    public function __construct(array $resolvers)
    {
        $this->resolvers = $resolvers;
    }

    /**
     * @param string $moduleName
     *
     * @return $this
     */
    public function setModuleName(string $moduleName): self
    {
        $this->moduleName = $moduleName;

        return $this;
    }

    /**
     * @param string $serviceName
     * @param array $arguments
     *
     * @return object
     */
    public function __call(string $serviceName, array $arguments): object
    {
        if (isset(static::$resolvedClassCache[$this->moduleName][$serviceName])) {
            return new static::$resolvedClassCache[$this->moduleName][$serviceName];
        }

        $resolver = $this->getResolver($serviceName);

        $resolvedClass = $resolver->resolveClass(ucfirst($this->moduleName));

        static::$resolvedClassCache[$this->moduleName][$serviceName] = $resolvedClass;

        return $resolvedClass;
    }

    /**
     * @param string $serviceName
     *
     * @return \App\Kernel\Business\ResolverBundle\ServiceResolverInterface
     */
    protected function getResolver(string $serviceName): ServiceResolverInterface
    {
        return $this->resolvers[$serviceName];
    }
}
