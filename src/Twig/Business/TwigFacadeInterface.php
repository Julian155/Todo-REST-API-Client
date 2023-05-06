<?php
declare(strict_types=1);

namespace App\Twig\Business;

interface TwigFacadeInterface
{
    /**
     * @param string $routeTransferDirectory
     * @param array $templateVariables
     * @param string $templateFile
     * @param string $templatePath
     *
     * @return array
     */
    public function parseClassData(string $routeTransferDirectory, array $templateVariables, string $templateFile, string $templatePath): array;

    /**
     * @param string $folderName
     *
     * @return void
     */
    public function cleanGeneratedDirectory(string $folderName): void;
}
