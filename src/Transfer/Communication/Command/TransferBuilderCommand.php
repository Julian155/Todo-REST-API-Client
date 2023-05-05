<?php
declare(strict_types=1);

namespace App\Transfer\Communication\Command;

use App\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \App\Transfer\Business\TransferFacadeInterface getFacade()
 */
class TransferBuilderCommand extends Console
{
    public const COMMAND_NAME = 'transfer:generate';
    public const DESCRIPTION = 'Generates Transfer classes from xml files';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription(self::DESCRIPTION);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getFacade()->clearGeneratedDirectory();

        $mappedXmlTransfers = $this->getFacade()->getMappedXmlTransfers();

        $this->getFacade()->createTransfers($mappedXmlTransfers);

        return static::CODE_SUCCESS;
    }
}
