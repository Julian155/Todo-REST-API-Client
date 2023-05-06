<?php
declare(strict_types=1);

namespace App\Twig;

use App\Kernel\AbstractDependencyProvider;
use App\Kernel\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigDependencyProvider extends AbstractDependencyProvider
{
    public const SERVICE_TWIG = 'TWIG_SERVICE';

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addTwigEnvironment($container);

        return $container;
    }

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addTwigEnvironment(Container $container): Container
    {
        $container->set(static::SERVICE_TWIG, $this->createTwigEnvironment());

        return $container;
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
