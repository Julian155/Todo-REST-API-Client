<?php
declare(strict_types=1);

namespace App\Twig\Business;

use App\Kernel\Business\AbstractBusinessFactory;
use App\Twig\Business\ClassParser\ClassParser;
use App\Twig\Business\ClassParser\ClassParserInterface;
use App\Twig\Business\DirectoryFileCleaner\DirectoryFileCleaner;
use App\Twig\Business\DirectoryFileCleaner\DirectoryFileCleanerInterface;
use App\Twig\TwigDependencyProvider;
use Twig\Environment;

/**
 * @method \App\Twig\TwigConfig getConfig()
 */
class TwigBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @param string $templatePath
     *
     * @return \App\Twig\Business\ClassParser\ClassParserInterface
     */
    public function createClassParser(string $templatePath): ClassParserInterface
    {
        return new ClassParser(
            $this->getTwigService(),
            $templatePath
        );
    }

    /**
     * @return \App\Twig\Business\DirectoryFileCleaner\DirectoryFileCleanerInterface
     */
    public function createDirectoryCleaner(): DirectoryFileCleanerInterface
    {
        return new DirectoryFileCleaner(
            $this->getConfig()
        );
    }

    /**
     * @return \Twig\Environment
     */
    public function getTwigService(): Environment
    {
        return $this->getDependency(TwigDependencyProvider::SERVICE_TWIG);
    }
}
