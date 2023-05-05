<?php
declare(strict_types=1);

namespace App\Transfer\Business\TransferFileWriter;

use App\Shared\Transfer\TransferConstants;
use App\Transfer\TransferConfig;
use Twig\Environment;

class TransferFileWriter implements TransferFileWriterInterface
{
    private const TWIG_TRANSFER_TEMPLATE_FILE = 'transferSchema.twig';
    private const TWIG_TRANSFER_TEMPLATES_PATH = 'src/Transfer/Templates';
    private const TWIG_TRANSFER_TEMPLATES_NAMESPACE = 'App\src\Transfer\Templates';

    /**
     * @var \Twig\Environment
     */
    private Environment $twigService;

    /**
     * @var \App\Transfer\TransferConfig
     */
    private TransferConfig $config;

    /**
     * @param \Twig\Environment $twigService
     * @param \App\Transfer\TransferConfig $config
     */
    public function __construct(Environment $twigService, TransferConfig $config)
    {
        $this->twigService = $twigService;
        $this->config = $config;
        $this->initLoader();
    }

    /**
     * @return void
     */
    protected function initLoader(): void
    {
        /**
         * @var \Twig\Loader\FilesystemLoader $loader
         */
        $loader = $this->twigService->getLoader();

        $loader->setPaths(self::TWIG_TRANSFER_TEMPLATES_PATH);
    }

    /**
     * @param \ArrayObject $mappedXmlTransferObjectCollection
     *
     * @return void
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function writeTransferClassDataToFiles(\ArrayObject $mappedXmlTransferObjectCollection): void
    {
        $routeTransferDirectory = sprintf(
            '%s/%s',
            $this->config->getApplicationRootDirectory(),
            TransferConstants::GENERATED_PATH,
        );

        $templateVariables = [
            'namespace' => self::TWIG_TRANSFER_TEMPLATES_NAMESPACE,
        ];

        foreach ($mappedXmlTransferObjectCollection as $mappedXmlTransferObject) {
            foreach ($mappedXmlTransferObject as $className => $properties) {
                $templateVariables['className'] = $className;
                $templateVariables['properties'] = $properties;

                [$filePath, $transferFileContent] = $this->parseTransferClassData($routeTransferDirectory, $templateVariables);

                file_put_contents($filePath, $transferFileContent);
            }
        }
    }

    /**
     * @param string $routeTransferDirectory
     * @param array $templateVariables
     *
     * @return array
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function parseTransferClassData(string $routeTransferDirectory, array $templateVariables): array
    {
        $transferFileContent = $this->twigService->render(self::TWIG_TRANSFER_TEMPLATE_FILE, $templateVariables);

        $filePath = sprintf(
            '%s/%s.php',
            $routeTransferDirectory,
            $templateVariables['className'],
        );

        return [$filePath, $transferFileContent];
    }
}
