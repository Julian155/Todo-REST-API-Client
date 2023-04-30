<?php
declare(strict_types=1);

namespace App\Kernel\Communication\Controller;

use App\Kernel\Business\AbstractFacade;
use App\Kernel\Business\FacadeResolver;
use App\Kernel\Communication\AbstractCommunicationFactory;
use App\Kernel\Communication\CommunicationFactoryResolver;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;

class AbstractController extends SymfonyAbstractController
{
    /**
     * @var \App\Kernel\Communication\AbstractCommunicationFactory|null
     */
    public static ?AbstractCommunicationFactory $factory = null;

    /**
     * @var \App\Kernel\Business\AbstractFacade|null
     */
    protected static ?AbstractFacade $facade = null;

    /**
     * @return \App\Kernel\Communication\AbstractCommunicationFactory
     */
    public function getFactory(): AbstractCommunicationFactory
    {
        if (!static::$factory) {
            static::$factory = $this->getFactoryResolver()->resolveFactory($this);
        }

        return static::$factory;
    }

    /**
     * @return \App\Kernel\Communication\CommunicationFactoryResolver
     */
    protected function getFactoryResolver(): CommunicationFactoryResolver
    {
        return new CommunicationFactoryResolver();
    }

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
