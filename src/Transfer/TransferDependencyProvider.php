<?php
declare(strict_types=1);

namespace App\Transfer;

use App\Kernel\AbstractDependencyProvider;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TransferDependencyProvider extends AbstractDependencyProvider
{
    public const SERVICE_TWIG = 'TWIG_SERVICE';

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function addBusinessLayerDependencies(ContainerInterface $container): ContainerInterface
    {
        $container = $this->addTwigEnvironment($container);

        return $container;
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function addTwigEnvironment(ContainerInterface $container): ContainerInterface
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
