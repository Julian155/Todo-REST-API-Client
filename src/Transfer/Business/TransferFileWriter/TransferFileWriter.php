<?php
declare(strict_types=1);

namespace App\Transfer\Business\TransferFileWriter;

use App\Shared\Transfer\TransferConstants;
use App\Transfer\TransferConfig;
use App\Twig\Business\TwigFacade;
use Twig\Environment;

class TransferFileWriter implements TransferFileWriterInterface
{
    private const FOLDER_NAME = 'Transfer';
    private const TWIG_TRANSFER_TEMPLATE_FILE = 'transferSchema.twig';
    private const TWIG_TRANSFER_TEMPLATES_PATH = 'src/Transfer/Templates';
    private const TWIG_TRANSFER_TEMPLATES_NAMESPACE = 'App\src\Transfer\Templates';

    /**
     * @var \App\Twig\Business\TwigFacade
     */
    private TwigFacade $twigFacade;

    /**
     * @var \App\Transfer\TransferConfig
     */
    private TransferConfig $config;

    /**
     * @var string
     */
    private string $routeTransferDirectory = '';

    /**
     * @param \App\Twig\Business\TwigFacade  $twigFacade
     * @param \App\Transfer\TransferConfig $config
     */
    public function __construct(TwigFacade $twigFacade, TransferConfig $config)
    {
        $this->twigFacade = $twigFacade;
        $this->config = $config;
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
        $this->routeTransferDirectory = sprintf(
            '%s/%s/%s',
            $this->config->getApplicationRootDirectory(),
            TransferConstants::GENERATED_PATH,
            self::FOLDER_NAME
        );

        $this->twigFacade->cleanGeneratedDirectory(self::FOLDER_NAME);

        $this->createTransferDirectory();

        $templateVariables = [
            'namespace' => self::TWIG_TRANSFER_TEMPLATES_NAMESPACE,
        ];

        foreach ($mappedXmlTransferObjectCollection as $mappedXmlTransferObject) {
            foreach ($mappedXmlTransferObject as $className => $properties) {
                $templateVariables['className'] = $className.'Transfer';
                $templateVariables['properties'] = $properties;

                [$filePath, $transferFileContent] = $this->twigFacade->parseClassData(
                    $this->routeTransferDirectory,
                    $templateVariables,
                    self::TWIG_TRANSFER_TEMPLATE_FILE,
                    self::TWIG_TRANSFER_TEMPLATES_PATH
                );

                file_put_contents($filePath, $transferFileContent);
            }
        }
    }

    /**
     * @return void
     */
    protected function createTransferDirectory(): void
    {
        if (!file_exists($this->routeTransferDirectory)) {
            mkdir($this->routeTransferDirectory, 0777, true);
        }
    }
}
