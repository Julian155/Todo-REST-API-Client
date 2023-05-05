<?php
declare(strict_types=1);

namespace App\Transfer\Business\TransferMapper;

use App\Shared\Transfer\TransferTypeEnum;
use DOMDocument;
use DOMElement;
use DOMNodeList;

class TransferMapper implements TransferMapperInterface
{
    private const TRANSFER_NAMESPACE = 'App\Generated\\';
    private const PROPERTY_NAME = 'name';
    private const PROPERTY_TYPE = 'type';
    private const PROPERTY_TYPE_HINT = 'typeHint';
    private const PROPERTY_USE_NAME = 'useName';

    /**
     * @param \DOMDocument $xmlTransferDocument
     *
     * @return array
     */
    public function mapXmlDocumentToArray(DOMDocument $xmlTransferDocument): array
    {
        return $this->mapTransferNodesToArray($xmlTransferDocument->childNodes);
    }

    /**
     * @param \DOMNodeList $transferNodes
     *
     * @return array
     */
    protected function mapTransferNodesToArray(DOMNodeList $transferNodes): array
    {
        $mappedTransfers = [];

        /**
         * @var \DOMElement $transferNode
         */
        foreach ($transferNodes as $transferNode) {
            if ($transferNode->nodeName === 'transfer') {
                $className = $transferNode->attributes->getNamedItem(self::PROPERTY_NAME)->nodeValue;

                $mappedTransfers[$className] = $this->mapTransferNodeToArray($transferNode->getElementsByTagName('property'));
            }

            if ($transferNode->childNodes->length) {
                $mappedTransfers += $this->mapTransferNodesToArray($transferNode->childNodes);

            }

        }

        return $mappedTransfers;
    }

    /**
     * @param \DOMNodeList $transferNode
     *
     * @return array
     */
    protected function mapTransferNodeToArray(DOMNodeList $transferNode): array
    {
        $mappedTransfer = [];

        /**
         * @var \DOMElement $propertyNode
         */
        foreach ($transferNode as $propertyNode) {
            $mappedTransfer += $this->mapNodePropertyToArray($propertyNode);
        }

        return $mappedTransfer;
    }

    /**
     * @param \DOMElement $transferNode
     *
     * @return array[]
     */
    protected function mapNodePropertyToArray(DOMElement $transferNode): array
    {
        $type = $transferNode->attributes->getNamedItem(self::PROPERTY_TYPE)->nodeValue;
        $name = $transferNode->attributes->getNamedItem(self::PROPERTY_NAME)->nodeValue;

        $propertyTypeData = $this->createTypeArrayForProperty($type);

        return [
            $name => $propertyTypeData
        ];
    }

    /**
     * @param string $type
     *
     * @return array
     */
    protected function createTypeArrayForProperty(string $type): array
    {
        $newType = $type;
        $typeHint = $type;
        $useName = null;

        if ($this->isArrayType($newType)) {
            $newType = 'array';
        }

        if ($this->isClassType($this->normalizeType($type))) {
            $typeHint = sprintf(
                '\%s%s',
                self::TRANSFER_NAMESPACE,
                $type,
            );

            $useName = $typeHint;
        }

        return [
            self::PROPERTY_TYPE => $newType,
            self::PROPERTY_TYPE_HINT => $typeHint,
            self::PROPERTY_USE_NAME => $useName,
        ];
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    protected function isArrayType(string $type): bool
    {
        return str_ends_with($type, '[]');
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    protected function isClassType(string $type): bool
    {
        return !in_array($type, TransferTypeEnum::TRANSFER_PROPERTY_TYPES);
    }

    /**
     * @param string $type
     *
     * @return string
     */
    protected function normalizeType(string $type): string
    {
        return rtrim($type, '[]');
    }
}
