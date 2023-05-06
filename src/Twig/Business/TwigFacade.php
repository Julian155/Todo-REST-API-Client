<?php
declare(strict_types=1);

namespace App\Twig\Business;

use App\Kernel\Business\AbstractFacade;

/**
 * @method \App\Twig\Business\TwigBusinessFactory getFactory()
 */
class TwigFacade extends AbstractFacade implements TwigFacadeInterface
{
    /**
     * @param string $routeTransferDirectory
     * @param array $templateVariables
     * @param string $templateFile
     * @param string $templatePath
     *
     * @return array
     */
    public function parseClassData(string $routeTransferDirectory, array $templateVariables, string $templateFile, string $templatePath): array
    {
        return $this->getFactory()
            ->createClassParser($templatePath)
            ->parseClassData($routeTransferDirectory, $templateVariables, $templateFile);
    }

    /**
     * @param string $folderName
     *
     * @return void
     */
    public function cleanGeneratedDirectory(string $folderName): void
    {
        $this->getFactory()->createDirectoryCleaner()->cleanGeneratedDirectory($folderName);
    }
}
