<?php
declare(strict_types=1);

namespace App\Transfer\Business\BaseTransfer;

use Serializable;

abstract class AbstractTransfer implements Serializable
{
    public function serialize()
    {
        return json_encode($this->toArray());
    }

    public function unserialize($data)
    {
        $arrayData = json_decode($data);

        $this->fromArray($arrayData);
    }

    /**
     * @return array
     */
    public abstract function toArray(): array;

    /**
     * @param array $transferData
     *
     * @return void
     */
    public abstract function fromArray(array $transferData): void;
}
