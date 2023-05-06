<?php
declare(strict_types=1);

namespace App\Twig\Business\ClassParser;

interface ClassParserInterface
{
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
    public function parseClassData(string $routeTransferDirectory, array $templateVariables, string $templateFile): array;
}
