<?php
declare(strict_types=1);

namespace App\Ide\Business\ModuleServicesCollector;

use App\Ide\IdeConfig;
use DirectoryIterator;

class ModuleServicesCollector implements ModuleServicesCollectorInterface
{
    private const PROJECT_DIRECTORY = '/src';
    private const MODULE_NAMESPACE = '\App\\';

    private const SERVICES = [
        'Config' => '',
        'Facade' => 'Business\\'
    ];

    private const EXCLUDED_MODULES = [
        'Generated',
        'Console'
    ];

    /**
     * @var \App\Ide\IdeConfig
     */
    private IdeConfig $config;

    /**
     * @param \App\Ide\IdeConfig $config
     */
    public function __construct(IdeConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return string[][]
     */
    public function collectModuleServices(): array
    {
        return $this->iterateDirectories(
            $this->createDirectoryIterator(sprintf(
                '%s%s',
                $this->config->getApplicationRootDirectory(),
                self::PROJECT_DIRECTORY
            ))
        );
    }

    /**
     * @param \DirectoryIterator $directoryIterator
     *
     * @return string[][]
     */
    protected function iterateDirectories(DirectoryIterator $directoryIterator): array
    {
        $moduleServicesCollection = [];

        while ($directoryIterator->valid()) {
            if ($directoryIterator->isDot() || in_array($directoryIterator->getBasename(), self::EXCLUDED_MODULES)) {
                $directoryIterator->next();

                continue;
            }

            if ($directoryIterator->isDir()) {
                $moduleName = $directoryIterator->getBasename();

                $moduleServices = [];
                foreach (self::SERVICES as $serviceName => $layer) {
                    $fileName = $moduleName.$serviceName;

                    $servicePath = sprintf(
                        '%s%s\%s%s',
                        self::MODULE_NAMESPACE,
                        $moduleName,
                        $layer,
                        $fileName
                    );

                    if ($this->doesServiceExist($servicePath)) {
                        if ($layer) {
                            $servicePath = $servicePath.'Interface';
                        }

                        $moduleServices[lcfirst($serviceName)] = $servicePath;
                    }
                }

                $moduleServicesCollection += [$moduleName => $moduleServices];
            }

            $directoryIterator->next();
        }

        return $moduleServicesCollection;
    }

    /**
     * @param string $filePath
     *
     * @return bool
     */
    protected function doesServiceExist(string $filePath): bool
    {
        return class_exists($filePath);
    }

    /**
     * @param string $directoryPath
     *
     * @return \DirectoryIterator
     */
    protected function createDirectoryIterator(string $directoryPath): DirectoryIterator
    {
        return new DirectoryIterator($directoryPath);
    }
}
