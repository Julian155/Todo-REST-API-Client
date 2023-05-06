<?php
declare(strict_types=1);

namespace App\Database\Business;

use App\Database\Business\ImportParser\ImportYamlParser;
use App\Database\Business\Loader\DatabaseLoader;
use App\Database\Business\TableMapGenerator\TableMapGenerator;
use App\Database\Business\TableMapGenerator\TableMapGeneratorInterface;
use App\Database\DatabaseDependencyProvider;
use App\Kernel\Business\AbstractBusinessFactory;
use App\Twig\Business\TwigFacadeInterface;
use Twig\Environment;

/**
 * @method \App\Database\DatabaseConfig getConfig()
 */
class DatabaseBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \App\Database\Business\Loader\DatabaseLoader
     */
    public function createDatabaseLoader(): DatabaseLoader
    {
        return new DatabaseLoader(
            $this->createImportYamlParser(),
            $this->getConfig()
        );
    }

    /**
     * @return \App\Database\Business\ImportParser\ImportYamlParser
     */
    public function createImportYamlParser(): ImportYamlParser
    {
        return new ImportYamlParser(
            $this->getConfig()
        );
    }

    /**
     * @return \App\Database\Business\TableMapGenerator\TableMapGeneratorInterface
     */
    public function createTableMapGenerator(): TableMapGeneratorInterface
    {
        return new TableMapGenerator(
            $this->getTwigFacade(),
            $this->getConfig()
        );
    }

    /**
     * @return \App\Twig\Business\TwigFacadeInterface
     */
    public function getTwigFacade(): TwigFacadeInterface
    {
        return $this->getDependency(DatabaseDependencyProvider::TWIG_FACADE);
    }
}
