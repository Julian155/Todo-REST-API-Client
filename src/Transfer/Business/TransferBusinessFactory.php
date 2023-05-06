<?php
declare(strict_types=1);

namespace App\Transfer\Business;

use App\Transfer\Business\DirectoryFileCleaner\DirectoryFileCleaner;
use App\Transfer\Business\TransferMapper\TransferMapper;
use App\Transfer\Business\TransferMapper\TransferMapperInterface;
use App\Transfer\Business\TransferFileWriter\TransferFileWriter;
use App\Transfer\Business\TransferFileWriter\TransferFileWriterInterface;
use App\Transfer\Business\XmlCollector\XmlCollectorInterface;
use App\Transfer\Business\XmlLoader\XmlLoader;
use App\Transfer\TransferDependencyProvider;
use App\Kernel\Business\AbstractBusinessFactory;
use App\Transfer\Business\XmlCollector\XmlCollector;
use Twig\Environment;

/**
 * @method \App\Transfer\TransferConfig getConfig()
 */
class TransferBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \App\Transfer\Business\XmlLoader\XmlLoader
     */
    public function createXmlLoader(): XmlLoader
    {
        return new XmlLoader(
            $this->createXmlCollector(),
            $this->createTransferMapper(),
            $this->getConfig(),
        );
    }

    /**
     * @return \App\Transfer\Business\XmlCollector\XmlCollectorInterface
     */
    public function createXmlCollector(): XmlCollectorInterface
    {
        return new XmlCollector(
            $this->getConfig()
        );
    }

    /**
     * @return \App\Transfer\Business\TransferMapper\TransferMapperInterface
     */
    public function createTransferMapper(): TransferMapperInterface
    {
        return new TransferMapper();
    }

    /**
     * @return \App\Transfer\Business\TransferFileWriter\TransferFileWriterInterface
     */
    public function createTransferFileWriter(): TransferFileWriterInterface
    {
        return new TransferFileWriter(
            $this->getTwigService(),
            $this->getConfig(),
        );
    }

    /**
     * @return \App\Transfer\Business\DirectoryFileCleaner\DirectoryFileCleaner
     */
    public function createDirectoryFileCleaner(): DirectoryFileCleaner
    {
        return new DirectoryFileCleaner(
            $this->getConfig(),
        );
    }

    /**
     * @return \Twig\Environment
     */
    public function getTwigService(): Environment
    {
        return $this->getDependency(TransferDependencyProvider::SERVICE_TWIG);
    }
}