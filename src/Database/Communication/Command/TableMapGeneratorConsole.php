<?php
declare(strict_types=1);

namespace App\Database\Communication\Command;

use App\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \App\Database\Business\DatabaseFacadeInterface getFacade()
 */
class TableMapGeneratorConsole extends Console
{
    public const COMMAND_NAME = 'database:generate:table-maps';
    public const DESCRIPTION = 'Creates table map class files for the database schema';

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
        $this->getFacade()->generateTableMaps();

        $output->writeln('Output was successful');

        return static::CODE_SUCCESS;
    }
}
