<?php
declare(strict_types=1);

namespace App\Ide\Business\AutoCompletionGenerator;

interface AutoCompletionLocatorInterfaceGeneratorInterface
{
    /**
     * @return void
     */
    public function generateAutoCompletionLocatorInterfaces(): void;
}
