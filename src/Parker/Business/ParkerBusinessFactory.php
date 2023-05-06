<?php
declare(strict_types=1);

namespace App\Parker\Business;

use App\Kernel\Business\AbstractBusinessFactory;
use App\Parker\Business\ParkerWriter\ParkerWriter;
use App\Parker\Business\ParkerWriter\ParkerWriterInterface;

/**
 * @method \App\Parker\Persistence\ParkerEntityManagerInterface getEntityManager()
 */
class ParkerBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \App\Parker\Business\ParkerWriter\ParkerWriterInterface
     */
    public function createParkerWriter(): ParkerWriterInterface
    {
        return new ParkerWriter(
            $this->getEntityManager()
        );
    }
}
