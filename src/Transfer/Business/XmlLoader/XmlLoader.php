<?php
declare(strict_types=1);

namespace App\Transfer\Business\XmlLoader;

use App\Transfer\Business\TransferMapper\TransferMapperInterface;
use App\Transfer\Business\XmlCollector\XmlCollectorInterface;
use App\Transfer\TransferConfig;
use ArrayObject;
use DOMDocument;
use Symfony\Component\Config\Util\XmlUtils;

class XmlLoader implements XmlLoaderInterface
{
    /**
     * @var \ArrayObject
     */
    private ArrayObject $mappedXmlTransfers;

    /**
     * @var \App\Transfer\Business\XmlCollector\XmlCollectorInterface
     */
    private XmlCollectorInterface $xmlCollector;

    /**
     * @var \App\Transfer\Business\TransferMapper\TransferMapperInterface
     */
    private TransferMapperInterface $transferMapper;

    /**
     * @var \App\Transfer\TransferConfig
     */
    private TransferConfig $config;

    /**
     * @param \App\Transfer\Business\XmlCollector\XmlCollectorInterface $xmlCollector
     * @param \App\Transfer\Business\TransferMapper\TransferMapperInterface $transferMapper
     * @param \App\Transfer\TransferConfig $config
     */
    public function __construct(XmlCollectorInterface $xmlCollector, TransferMapperInterface $transferMapper, TransferConfig $config)
    {
        $this->xmlCollector = $xmlCollector;
        $this->transferMapper = $transferMapper;
        $this->config = $config;
        $this->mappedXmlTransfers = new ArrayObject();
    }

    /**
     * @return ArrayObject
     */
    public function loadXmlTransferFiles(): ArrayObject
    {
        $xmlTransferModules = $this->xmlCollector->collectXmlTransferFiles();

        foreach ($xmlTransferModules as $xmlTransferModule) {
            foreach ($xmlTransferModule as $xmlTransferFilePath) {
                $xmlDocument = $this->loadTransfer($xmlTransferFilePath);
                $mappedTransfer = $this->transferMapper->mapXmlDocumentToArray($xmlDocument);

                $this->mappedXmlTransfers->append($mappedTransfer);
            }
        }

        return $this->mappedXmlTransfers;
    }

    /**
     * @param string $xmlDtoPath
     *
     * @return \DOMDocument
     */
    protected function loadTransfer(string $xmlDtoPath): DOMDocument
    {
        return XmlUtils::loadFile($xmlDtoPath, sprintf(
            '%s%s',
            $this->config->getApplicationRootDirectory(),
            $this->config->getXsdSchemaPath()
        ));
    }
}
