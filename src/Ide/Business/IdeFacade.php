<?php
declare(strict_types=1);

namespace App\Ide\Business;

use App\Kernel\Business\AbstractFacade;

/**
 * @method \App\Ide\Business\IdeBusinessFactory getFactory()
 */
class IdeFacade extends AbstractFacade implements IdeFacadeInterface
{
    /**
     * @return void
     */
    public function generateAutoCompletionLocatorInterfaces(): void
    {
        $this->getFactory()->createAutoCompletionLocatorInterfaceGenerator()->generateAutoCompletionLocatorInterfaces();
    }
}
