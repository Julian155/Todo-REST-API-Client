<?php
declare(strict_types=1);

namespace App\Database\Business\TableMapGenerator;

use App\Database\ConnectionTrait;
use App\Database\DatabaseConfig;
use App\Shared\Kernel\KernelConstants;
use App\Twig\Business\TwigFacadeInterface;

class TableMapGenerator implements TableMapGeneratorInterface
{
    use ConnectionTrait;

    private const FOLDER_NAME = 'TableMap';
    private const TWIG_TRANSFER_TEMPLATE_FILE = 'TableMapFileSchema.twig';
    private const TWIG_TRANSFER_TEMPLATES_PATH = 'src/Database/Templates';
    private const TWIG_TRANSFER_TEMPLATES_NAMESPACE = 'App\src\Database\Templates';

    /**
     * @var \App\Twig\Business\TwigFacadeInterface
     */
    private TwigFacadeInterface $twigFacade;

    /**
     * @var \App\Database\DatabaseConfig
     */
    private DatabaseConfig $config;

    private string $routeTableMapDirectory = '';

    /**
     * @param \App\Twig\Business\TwigFacadeInterface $twigFacade
     * @param \App\Database\DatabaseConfig $config
     */
    public function __construct(TwigFacadeInterface $twigFacade, DatabaseConfig $config)
    {
        $this->twigFacade = $twigFacade;
        $this->config = $config;
    }

    public function generateTableMaps(): void
    {
        $this->twigFacade->cleanGeneratedDirectory(self::FOLDER_NAME);

        $this->routeTableMapDirectory = sprintf(
            '%s/%s/%s',
            $this->config->getApplicationRootDirectory(),
            KernelConstants::GENERATED_PATH,
            self::FOLDER_NAME
        );

        $this->createTableMapDirectory();

        $templateVariables = [
            'namespace' => self::TWIG_TRANSFER_TEMPLATES_NAMESPACE,
        ];

        foreach ($this->getTableData() as $tableName => $columns) {
            $templateVariables['className'] = str_replace("_", "", ucwords($tableName, " /_")).self::FOLDER_NAME;
            $templateVariables['tableName'] = $tableName;
            $templateVariables['columns'] = $columns;

            [$filePath, $transferFileContent] = $this->twigFacade->parseClassData(
                $this->routeTableMapDirectory,
                $templateVariables,
                self::TWIG_TRANSFER_TEMPLATE_FILE,
                self::TWIG_TRANSFER_TEMPLATES_PATH
            );

            file_put_contents($filePath, $transferFileContent);
        }
    }

    /**
     * @return void
     */
    protected function createTableMapDirectory(): void
    {
        if (!file_exists($this->routeTableMapDirectory)) {
            mkdir($this->routeTableMapDirectory, 0777, true);
        }
    }

    /**
     * @return string[]
     */
    protected function getTableData(): array
    {
        $tableData = [];

        $query = $this->getConnection()->query('SHOW TABLES');
        $tables = $query->fetchAll(\PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            $query = $this->getConnection()->query('SHOW COLUMNS IN '.$table);
            $columns = $query->fetchAll(\PDO::FETCH_COLUMN);

            $tableData[$table] = $columns;
        }

        return $tableData;
    }
}
