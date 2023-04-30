<?php
declare(strict_types=1);

namespace App\Database\Business;

use App\Database\Business\ImportParser\ImportYamlParser;
use App\Database\Business\Loader\DatabaseLoader;
use App\Kernel\Business\AbstractBusinessFactory;

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
}
