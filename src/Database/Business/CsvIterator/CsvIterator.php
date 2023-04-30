<?php
declare(strict_types=1);

namespace App\Database\Business\CsvIterator;

use App\Database\DatabaseConfig;
use Iterator;
use SplFileObject;
use Countable;

class CsvIterator implements Iterator, Countable
{
    /**
     * @var \SplFileObject|null
     */
    protected ?SplFileObject $csvFileObject = null;

    /**
     * @var array
     */
    protected array $csvHeader;

    /**
     * @var array
     */
    protected array $csvConfig;

    /**
     * @var \App\Database\DatabaseConfig
     */
    protected DatabaseConfig $config;

    /**
     * @param array $csvConfig
     * @param \App\Database\DatabaseConfig $config
     */
    public function __construct(array $csvConfig, DatabaseConfig $config)
    {
        $this->csvConfig = $csvConfig;
        $this->config = $config;
        $this->initCsvIterator();
    }

    /**
     * @return void
     */
    protected function initCsvIterator(): void
    {
        $this->createCsvFileObject();
        $this->setCsvFileControl();
        $this->setCsvFlags();
        $this->setCsvHeader();
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->csvFileObject->current();
    }

    /**
     * @return void
     */
    public function next(): void
    {
        $this->csvFileObject->next();
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->csvFileObject->key();
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return $this->csvFileObject->valid();
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        if ($this->csvHeader) {
            return;
        }

        $this->csvFileObject->rewind();
    }

    /**
     * @return string
     */
    public function getCsvFilePath(): string
    {
        return sprintf(
            '%s/%s',
            $this->config->getApplicationRootDirectory(),
            $this->csvConfig['source']
        );
    }

    /**
     * @return void
     */
    protected function createCsvFileObject(): void
    {
        $this->csvFileObject = new SplFileObject($this->getCsvFilePath());
    }

    /**
     * @return void
     */
    protected function setCsvFileControl(): void
    {
        $this->csvFileObject->setCsvControl(",", "\n", "\\");
    }

    /**
     * @return void
     */
    protected function setCsvHeader(): void
    {
        $this->csvHeader = $this->csvFileObject->current();
        $this->csvFileObject->next();
    }

    /**
     * @return void
     */
    protected function setCsvFlags(): void
    {
        $this->csvFileObject->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->csvHeader);
    }
}
