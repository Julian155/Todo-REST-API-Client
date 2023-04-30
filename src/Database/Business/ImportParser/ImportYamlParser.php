<?php
declare(strict_types=1);

namespace App\Database\Business\ImportParser;

use App\Database\DatabaseConfig;
use Symfony\Component\Yaml\Yaml;

class ImportYamlParser
{
    /**
     * @var \App\Database\DatabaseConfig $config
     */
    protected DatabaseConfig $config;

    /**
     * @param \App\Database\DatabaseConfig $config
     */
    public function __construct(DatabaseConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $importPath
     *
     * @return array
     */
    public function parseImportPath(string $importPath): array
    {
        return Yaml::parseFile(sprintf(
            '%s/%s',
            $this->config->getApplicationRootDirectory(),
            $importPath
        ))['actions'];
    }
}
