<?php

namespace ONGR\MagentoConnectorBundle\Modifier;

use ONGR\ConnectionsBundle\DataCollector\DataCollectorInterface;
use ONGR\ConnectionsBundle\DataCollector\Exception\DocumentSyncCancelException;
use ONGR\ConnectionsBundle\Doctrine\Modifier\ModifierInterface;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;
use ONGR\MagentoConnectorBundle\Modifier\Helpers\AttributeTypes;

/**
 * Modifies entities to match ongr category mapping.
 */
class CategoryModifier implements ModifierInterface
{
    /**
     * @var int
     */
    protected $storeId;

    /**
     * @param int $storeId
     */
    public function __construct($storeId)
    {
        $this->storeId = $storeId;
    }

    /**
     * {@inheritdoc}
     */
    public function modify(DocumentInterface $document, $entity, $type = DataCollectorInterface::TYPE_FULL)
    {
        /** @var CatalogCategoryEntity $entity */
        $document->id = $entity->getId();
        $document->parentid = $entity->getParentId();
        $document->expired_url = [];

        if ($entity->getLevel() == 2) {
            // Root categories.
            $document->parentid = 'oxrootid';
        } elseif ($entity->getLevel() < 2) {
            throw new DocumentSyncCancelException;
        }

        // Trim first two categories (RootCatalog and DefaultCatalog) from path.
        $document->path = preg_replace('/^([^\/]*\/){2}/', '/', $entity->getPath(), -1, $replacements);

        if ($replacements == 0) {
            $document->path = '';
        }

        $document->sort = $entity->getSort();
        $document->url = [];

        $this->addVarcharAttributes($entity, $document);
        $this->addIntegerAttributes($entity, $document);
    }

    /**
     * @param CatalogCategoryEntity $entity
     * @param DocumentInterface     $document
     *
     * @throws DocumentSyncCancelException
     */
    public function addVarcharAttributes($entity, DocumentInterface $document)
    {
        $varcharAttributes = $entity->getVarcharAttributes();
        if (count($varcharAttributes) === 0) {
            throw new DocumentSyncCancelException;
        }
        foreach ($varcharAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore()) {
                continue;
            }
            /** @var CatalogCategoryEntityVarchar $attribute */
            switch ($attribute->getAttributeId()) {
                case AttributeTypes::CATEGORY_TITLE:
                    $document->title = $attribute->getValue();
                    break;
                case AttributeTypes::CATEGORY_LINKS_TITLE:
                    $document->url[] = $attribute->getValue();
                    break;
                default:
                    // Do nothing.
                    break;
            }
        }
    }

    /**
     * @param CatalogCategoryEntity $entity
     * @param DocumentInterface     $document
     *
     * @throws DocumentSyncCancelException
     */
    public function addIntegerAttributes($entity, DocumentInterface $document)
    {
        $integerAttributes = $entity->getIntegerAttributes();
        if (count($integerAttributes) === 0) {
            throw new DocumentSyncCancelException;
        }
        foreach ($integerAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore()) {
                continue;
            }
            /** @var CatalogCategoryEntityInt $attribute */
            switch ($attribute->getAttributeId()) {
                case AttributeTypes::CATEGORY_IS_ACTIVE:
                    $document->active = ((bool)$attribute->getValue()) ? 'true' : 'false';
                    break;
                default:
                    // Do nothing.
                    break;
            }
        }
    }
}
