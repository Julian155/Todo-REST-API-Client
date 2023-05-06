<?php
declare(strict_types=1);

namespace App\Ide\Business;

use App\Ide\Business\AutoCompletionGenerator\AutoCompletionLocatorInterfaceGenerator;
use App\Ide\Business\AutoCompletionGenerator\AutoCompletionLocatorInterfaceGeneratorInterface;
use App\Ide\Business\ModuleServicesCollector\ModuleServicesCollector;
use App\Ide\Business\ModuleServicesCollector\ModuleServicesCollectorInterface;
use App\Kernel\Business\AbstractBusinessFactory;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * @method \App\Ide\IdeConfig getConfig()
 */
class IdeBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \App\Ide\Business\AutoCompletionGenerator\AutoCompletionLocatorInterfaceGeneratorInterface
     */
    public function createAutoCompletionLocatorInterfaceGenerator(): AutoCompletionLocatorInterfaceGeneratorInterface
    {
        return new AutoCompletionLocatorInterfaceGenerator(
            $this->createModuleServicesCollector(),
            $this->getConfig(),
            $this->createTwigEnvironment()
        );
    }

    /**
     * @return \App\Ide\Business\ModuleServicesCollector\ModuleServicesCollectorInterface
     */
    public function createModuleServicesCollector(): ModuleServicesCollectorInterface
    {
        return new ModuleServicesCollector(
            $this->getConfig()
        );
    }

    /**
     * @return \Twig\Environment
     */
    protected function createTwigEnvironment(): Environment
    {
        return new Environment(
            $this->createTwigFileSystemLoader()
        );
    }

    /**
     * @return \Twig\Loader\FilesystemLoader
     */
    protected function createTwigFileSystemLoader(): FilesystemLoader
    {
        return new FilesystemLoader();
    }
}
