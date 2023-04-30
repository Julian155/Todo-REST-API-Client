<?php
declare(strict_types=1);

namespace App\Console;

use App\Kernel\Business\AbstractFacade;
use App\Kernel\Business\FacadeResolver;
use Symfony\Component\Console\Command\Command;

class Console extends Command
{
    protected const CODE_SUCCESS = 1;
    protected const CODE_FAILURE = 0;

    /**
     * @var \App\Kernel\Business\AbstractFacade|null
     */
    protected static ?AbstractFacade $facade = null;

    /**
     * @return \App\Kernel\Business\AbstractFacade
     */
    public function getFacade(): AbstractFacade
    {
        if (!static::$facade) {
            static::$facade = $this->getFacadeResolver()->resolveFacade($this);
        }

        return static::$facade;
    }

    /**
     * @return \App\Kernel\Business\FacadeResolver
     */
    protected function getFacadeResolver(): FacadeResolver
    {
        return new FacadeResolver();
    }
}
