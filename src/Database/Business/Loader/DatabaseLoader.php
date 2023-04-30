<?php
declare(strict_types=1);

namespace App\Database\Business\Loader;

use App\Database\Business\CsvIterator\CsvIterator;
use App\Database\Business\ImportParser\ImportYamlParser;
use App\Database\ConnectionTrait;
use App\Database\DatabaseConfig;

class DatabaseLoader
{
    use ConnectionTrait;

    /**
     * @var \App\Database\Business\ImportParser\ImportYamlParser
     */
    protected ImportYamlParser $yamlParser;

    /**
     * @var \App\Database\DatabaseConfig $config
     */
    protected DatabaseConfig $config;

    /**
     * @param \App\Database\Business\ImportParser\ImportYamlParser $yamlParser
     * @param \App\Database\DatabaseConfig $config
     */
    public function __construct(ImportYamlParser $yamlParser, DatabaseConfig $config)
    {
        $this->yamlParser = $yamlParser;
        $this->config = $config;
    }

    /**
     * @param string $importFilePath
     *
     * @return void
     */
    public function loadDemoData(string $importFilePath): void
    {
        $this->truncateTables();

        $csvFilesMetaData = $this->yamlParser->parseImportPath($importFilePath);

        foreach ($csvFilesMetaData as $csvFileMetaData) {
            $csvIterator = $this->createCsvIterator($csvFileMetaData);

            $tableName = $csvFileMetaData['table-name'];

            $numberOfValues = str_repeat('?,', $csvIterator->count());
            $numberOfValues = rtrim($numberOfValues, ',');

            $this->getConnection()->beginTransaction();
            foreach ($csvIterator as $csvRow) {
                $sql = sprintf(
                    "INSERT INTO %s VALUES (%s);",
                    $tableName,
                    $numberOfValues,
                );

                $statement = $this->getConnection()->prepare($sql);

                $statement->execute($csvRow);
            }
            $this->getConnection()->commit();
        }
    }

    /**
     * @return void
     */
    protected function truncateTables(): void
    {
        $tables = $this->getConnection()->prepare('SHOW TABLES');
        $tables->execute();

        $this->getConnection()->query('SET foreign_key_checks = 0');

        try {
            foreach($tables->fetchAll(\PDO::FETCH_COLUMN) as $table) {
                $this->getConnection()->query('TRUNCATE TABLE `' . $table . '`')->execute();
            }
        } catch (\Exception $exception) {
            $this->getConnection()->query('SET foreign_key_checks = 1');
        }

        $this->getConnection()->query('SET foreign_key_checks = 1');
    }

    /**
     * @param array $csvConfig
     *
     * @return \App\Database\Business\CsvIterator\CsvIterator
     */
    protected function createCsvIterator(array $csvConfig): CsvIterator
    {
        return new CsvIterator($csvConfig, $this->config);
    }
}
