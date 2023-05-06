<?php
declare(strict_types=1);

namespace App\Twig\Business\ClassParser;

use Twig\Environment;

class ClassParser implements ClassParserInterface
{
    private Environment $twigService;

    /**
     * @param \Twig\Environment $twigService
     * @param string $templatePath
     */
    public function __construct(Environment $twigService, string $templatePath)
    {
        $this->twigService = $twigService;
        $this->initLoader($templatePath);
    }

    /**
     * @param string $templatePath
     *
     * @return void
     */
    protected function initLoader(string $templatePath): void
    {
        /**
         * @var \Twig\Loader\FilesystemLoader $loader
         */
        $loader = $this->twigService->getLoader();

        $loader->setPaths($templatePath);
    }

    /**
     * @param string $routeTransferDirectory
     * @param array $templateVariables
     * @param string $templateFile
     *
     * @return array
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function parseClassData(string $routeTransferDirectory, array $templateVariables, string $templateFile): array
    {
        $transferFileContent = $this->twigService->render($templateFile, $templateVariables);

        $filePath = sprintf(
            '%s/%s.php',
            $routeTransferDirectory,
            $templateVariables['className'],
        );

        return [$filePath, $transferFileContent];
    }
}
