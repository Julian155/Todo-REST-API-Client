<?php
declare(strict_types=1);

namespace App\Transfer\Business\XmlCollector;

use App\Transfer\TransferConfig;
use DirectoryIterator;

class XmlCollector implements XmlCollectorInterface
{
    private const ENTRY_DIRECTORY = '/src/Shared';
    private const TRANSFER_DIRECTORY = '/Transfer';

    /**
     * @var \App\Transfer\TransferConfig
     */
    private TransferConfig $config;

    /**
     * @param \App\Transfer\TransferConfig $config
     */
    public function __construct(TransferConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return string[]
     */
    public function collectXmlTransferFiles(): array
    {
        return $this->iterateDirectories(
            $this->createDirectoryIterator(sprintf(
                '%s%s',
                $this->config->getApplicationRootDirectory(),
                self::ENTRY_DIRECTORY
            ))
        );
    }

    /**
     * @param \DirectoryIterator $directoryIterator
     *
     * @return string[][]
     */
    protected function iterateDirectories(DirectoryIterator $directoryIterator): array
    {
        $xmlTransferFilePathCollection = [];

        while ($directoryIterator->valid()) {
            $directoryIterator->next();

            if ($directoryIterator->isDot()) {
                continue;
            }

            if ($directoryIterator->isDir()) {
                $transferModuleDirectoryPath = sprintf(
                    '%s%s',
                    $directoryIterator->getPathname(),
                    self::TRANSFER_DIRECTORY
                );

                if (is_dir($transferModuleDirectoryPath)) {
                    $xmlTransferFilePathCollection[] = $this->iterateModuleTransferDirectory(
                        $transferModuleDirectoryPath
                    );
                }
            }
        }

        return $xmlTransferFilePathCollection;
    }

    /**
     * @param string $transferModuleDirectoryPath
     *
     * @return array
     */
    protected function iterateModuleTransferDirectory(string $transferModuleDirectoryPath): array
    {
        $moduleTransferDirectoryIterator = $this->createDirectoryIterator($transferModuleDirectoryPath);

        $xmlTransferFilePathCollection = [];

        while ($moduleTransferDirectoryIterator->valid()) {
            if ($moduleTransferDirectoryIterator->isDot()) {
                $moduleTransferDirectoryIterator->next();

                continue;
            }

            if (!$moduleTransferDirectoryIterator->isDir() && $moduleTransferDirectoryIterator->getExtension() === 'xml') {
                $xmlTransferFilePathCollection[] = $moduleTransferDirectoryIterator->getPathname();
            }

            $moduleTransferDirectoryIterator->next();
        }

        return $xmlTransferFilePathCollection;
    }

    /**
     * @param string $directoryPath
     *
     * @return \DirectoryIterator
     */
    protected function createDirectoryIterator(string $directoryPath): DirectoryIterator
    {
        return new DirectoryIterator($directoryPath);
    }
}
