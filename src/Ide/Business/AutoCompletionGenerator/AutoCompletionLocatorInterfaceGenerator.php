<?php
declare(strict_types=1);

namespace App\Ide\Business\AutoCompletionGenerator;

use App\Ide\Business\ModuleServicesCollector\ModuleServicesCollectorInterface;
use App\Ide\IdeConfig;
use App\Shared\Kernel\KernelConstants;
use Twig\Environment;

class AutoCompletionLocatorInterfaceGenerator implements AutoCompletionLocatorInterfaceGeneratorInterface
{
    private const FOLDER_NAME = 'Ide';
    private const TWIG_TRANSFER_TEMPLATE_FILE = 'AutoCompleteServiceSchema.twig';
    private const TWIG_TRANSFER_TEMPLATES_PATH = 'src/Ide/Templates';
    private const TWIG_TRANSFER_TEMPLATES_NAMESPACE = 'App\src\Ide\Templates';

    /**
     * @var array
     */
    private array $serviceClasses = [];

    /**
     * @var string
     */
    private string $routeIdeDirectory = '';

    /**
     * @var array
     */
    private array $templateVariables = [];

    /**
     * @var \App\Ide\Business\ModuleServicesCollector\ModuleServicesCollectorInterface
     */
    private ModuleServicesCollectorInterface $moduleServicesCollector;

    /**
     * @var \App\Ide\IdeConfig
     */
    private IdeConfig $config;

    /**
     * @var \Twig\Environment
     */
    private Environment $twigService;

    /**
     * @param \App\Ide\Business\ModuleServicesCollector\ModuleServicesCollectorInterface $moduleServicesCollector
     * @param \App\Ide\IdeConfig $config
     * @param \Twig\Environment $twigService
     */
    public function __construct(ModuleServicesCollectorInterface $moduleServicesCollector, IdeConfig $config, Environment $twigService)
    {
        $this->moduleServicesCollector = $moduleServicesCollector;
        $this->config = $config;
        $this->twigService = $twigService;
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
     * @return void
     */
    public function generateAutoCompletionLocatorInterfaces(): void
    {
        $this->routeIdeDirectory = sprintf(
            '%s/%s/%s',
            $this->config->getApplicationRootDirectory(),
            KernelConstants::GENERATED_PATH,
            self::FOLDER_NAME
        );

        $this->templateVariables = [
            'namespace' => self::TWIG_TRANSFER_TEMPLATES_NAMESPACE,
        ];

        $this->createIdeDirectory();

        $this->writeServiceAutoCompleteFiles();
        $this->writeAutoCompleteFile();
    }

    /**
     * @return void
     */
    protected function writeServiceAutoCompleteFiles(): void
    {
        $moduleServices = $this->moduleServicesCollector->collectModuleServices();

        foreach ($moduleServices as $moduleName => $services) {
            $className = $moduleName.'Interface';

            $this->setTemplateVariables($className, $services);

            [$filePath, $fileContent] = $this->parseAutoCompleteServiceClassData();

            $this->writeIdeFile($filePath, $fileContent);

            $this->addAutoCompleteServiceClass($className, $moduleName);
        }
    }

    /**
     * @return void
     */
    protected function createIdeDirectory(): void
    {
        if (!file_exists($this->routeIdeDirectory)) {
            mkdir($this->routeIdeDirectory, 0777, true);
        }
    }

    /**
     * @return void
     */
    protected function writeAutoCompleteFile(): void
    {
        $this->setTemplateVariables('AutoCompleteInterface', $this->serviceClasses);

        [$filePath, $fileContent] = $this->parseAutoCompleteServiceClassData();

        $this->writeIdeFile($filePath, $fileContent);
    }

    /**
     * @param string $filePath
     * @param string $fileContent
     *
     * @return void
     */
    protected function writeIdeFile(string $filePath, string $fileContent): void
    {
        file_put_contents($filePath, $fileContent);
    }

    /**
     * @param string $className
     * @param string $moduleName
     *
     * @return void
     */
    protected function addAutoCompleteServiceClass(string $className, string $moduleName): void
    {
        $autoCompleteClassPath = sprintf(
            '%s\%s\%s',
            KernelConstants::GENERATED_NAMESPACE,
            self::FOLDER_NAME,
            $className
        );

        $this->serviceClasses[lcfirst($moduleName)] = $autoCompleteClassPath;
    }

    /**
     * @param string $className
     * @param array $services
     *
     * @return void
     */
    protected function setTemplateVariables(string $className, array $services): void
    {
        $this->templateVariables['interfaceName'] = $className;
        $this->templateVariables['services'] = $services;
    }

    /**
     * @return array
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function parseAutoCompleteServiceClassData(): array
    {
        $fileContent = $this->twigService->render(self::TWIG_TRANSFER_TEMPLATE_FILE, $this->templateVariables);

        $filePath = sprintf(
            '%s/%s.php',
            $this->routeIdeDirectory,
            $this->templateVariables['interfaceName'],
        );

        return [$filePath, $fileContent];
    }
}
