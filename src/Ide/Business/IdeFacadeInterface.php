<?php
declare(strict_types=1);

namespace App\Ide\Business;

interface IdeFacadeInterface
{
    /**
     * @return void
     */
    public function generateAutoCompletionLocatorInterfaces(): void;
}
