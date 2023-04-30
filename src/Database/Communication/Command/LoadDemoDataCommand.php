<?php
declare(strict_types=1);

namespace App\Database\Communication\Command;

use App\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \App\Database\Business\DatabaseFacadeInterface getFacade()
 */
class LoadDemoDataCommand extends Console
{
    public const COMMAND_NAME = 'database:load:data';
    public const DESCRIPTION = 'Load demo data into the database';

    protected const PATH_ARGUMENT = 'path';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->addArgument(
            static::PATH_ARGUMENT,
            InputArgument::REQUIRED,
            'Sets the path for the yaml import file [Required]'
        );

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
        $importPath = $input->getArgument(static::PATH_ARGUMENT);

        $this->getFacade()->loadDemoData($importPath);

        $output->writeln('Output was successful');

        return static::CODE_SUCCESS;
    }
}
