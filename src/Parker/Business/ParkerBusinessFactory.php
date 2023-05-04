<?php
declare(strict_types=1);

namespace App\Parker\Business;
use App\Kernel\Business\AbstractBusinessFactory;
use App\Parker\Business\Writer\ParkerWriter;


class ParkerBusinessFactory extends AbstractBusinessFactory
{
    public function createParkerWriter(): ParkerWriter
    {
        return new ParkerWriter();
    }
}
