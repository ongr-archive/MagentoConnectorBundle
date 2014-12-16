<?php

namespace ONGR\MagentoConnectorBundle\Modifier;

use ONGR\ConnectionsBundle\Event\AbstractInitialSyncModifyEvent;
use ONGR\ConnectionsBundle\Event\ImportItem;
use ONGR\MagentoConnectorBundle\Documents\CategoryDocument;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;
use ONGR\MagentoConnectorBundle\Modifier\Helpers\AttributeTypes;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Modifies entities to match ongr category mapping.
 */
class CategoryModifier extends AbstractInitialSyncModifyEvent
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
    protected function modify(ImportItem $eventItem)
    {
        /** @var CategoryDocument $document */
        $document = $eventItem->getDocument();
        /** @var CatalogCategoryEntity $entity */
        $entity = $eventItem->getEntity();

        $document->setId($entity->getId());
        $document->setParentId($entity->getParentId());
        $document->setExpiredUrl([]);

        if ($entity->getLevel() == 2) {
            // Root categories.
            $document->setParentId('oxrootid');
        } elseif ($entity->getLevel() < 2) {
            throw new Exception; // todo: before was 'DocumentSyncCancelException'
        }

        // Trim first two categories (RootCatalog and DefaultCatalog) from path.
        $document->setPath(preg_replace('/^([^\/]*\/){2}/', '/', $entity->getPath(), -1, $replacements));

        if ($replacements == 0) {
            $document->setPath('');
        }

        $document->setSort($entity->getSort());
        $document->setUrl([]);

        $this->addVarcharAttributes($entity, $document);
        $this->addIntegerAttributes($entity, $document);
    }

    /**
     * @param CatalogCategoryEntity $entity
     * @param CategoryDocument      $document
     *
     * @throws Exception
     */
    public function addVarcharAttributes($entity, CategoryDocument $document)
    {
        $varcharAttributes = $entity->getVarcharAttributes();
        if (count($varcharAttributes) === 0) {
            throw new Exception; // todo: before was 'DocumentSyncCancelException'
        }
        foreach ($varcharAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore()) {
                continue;
            }
            /** @var CatalogCategoryEntityVarchar $attribute */
            switch ($attribute->getAttributeId()) {
                case AttributeTypes::CATEGORY_TITLE:
                    $document->setTitle($attribute->getValue());
                    break;
                case AttributeTypes::CATEGORY_LINKS_TITLE:
                    $document->addUrlString($attribute->getValue());
                    break;
                default:
                    // Do nothing.
                    break;
            }
        }
    }

    /**
     * @param CatalogCategoryEntity $entity
     * @param CategoryDocument      $document
     *
     * @throws Exception
     */
    public function addIntegerAttributes($entity, CategoryDocument $document)
    {
        $integerAttributes = $entity->getIntegerAttributes();
        if (count($integerAttributes) === 0) {
            throw new Exception; // todo: before was 'DocumentSyncCancelException'
        }
        foreach ($integerAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore()) {
                continue;
            }
            /** @var CatalogCategoryEntityInt $attribute */
            switch ($attribute->getAttributeId()) {
                case AttributeTypes::CATEGORY_IS_ACTIVE:
                    $document->setActive((bool)$attribute->getValue());
                    break;
                default:
                    // Do nothing.
                    break;
            }
        }
    }
}
