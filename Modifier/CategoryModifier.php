<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Modifier;

use ONGR\ConnectionsBundle\EventListener\AbstractImportModifyEventListener;
use ONGR\ConnectionsBundle\Pipeline\Item\AbstractImportItem;
use ONGR\ConnectionsBundle\Pipeline\ItemSkipper;
use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\MagentoConnectorBundle\Document\CategoryDocument;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;

/**
 * Modifies entities to match ongr category mapping.
 */
class CategoryModifier extends AbstractImportModifyEventListener
{
    const CATEGORY_NAME = 41;
    const CATEGORY_IS_ACTIVE = 42;
    const CATEGORY_DESCRIPTION = 44;
    const CATEGORY_IMAGE = 45;
    const CATEGORY_META_TITLE = 46;
    const CATEGORY_META_KEYWORDS = 47;
    const CATEGORY_META_DESCRIPTION = 48;
    const CATEGORY_PATH = 52;
    const CATEGORY_URL_PATH = 57;

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
    protected function modify(AbstractImportItem $eventItem, ItemPipelineEvent $event)
    {
        /** @var CategoryDocument $document */
        $document = $eventItem->getDocument();
        /** @var CatalogCategoryEntity $entity */
        $entity = $eventItem->getEntity();

        $this->transform($document, $entity, $event);
    }

    /**
     * Assigns data to given document.
     *
     * @param CategoryDocument      $document
     * @param CatalogCategoryEntity $entity
     * @param ItemPipelineEvent     $event
     */
    protected function transform(CategoryDocument $document, CatalogCategoryEntity $entity, ItemPipelineEvent $event)
    {
        $document->setId($entity->getId());
        $document->setParentId($entity->getParentId());
        $document->setExpiredUrls([]);
        $document->setHidden(false);

        if ($entity->getLevel() == 2) {
            // Root categories.
            $document->setParentId(CategoryDocument::ROOT_ID);
        } elseif ($entity->getLevel() < 2) {
            ItemSkipper::skip($event, 'Wrong category level. Got level=' . $entity->getLevel());

            return;
        }

        // Trim first two categories (RootCatalog and DefaultCatalog) from path.
        $document->setPath(preg_replace('/^([^\/]*\/){2}/', '/', $entity->getPath(), -1, $replacements));

        if ($replacements == 0) {
            $document->setPath('');
        }

        $document->setSort($entity->getSort());
        $document->setUrls([]);

        $this->addVarcharAttributes($entity, $document);
        $this->addIntegerAttributes($entity, $document);
    }

    /**
     * @param CatalogCategoryEntity $entity
     * @param CategoryDocument      $document
     */
    public function addVarcharAttributes($entity, CategoryDocument $document)
    {
        $varcharAttributes = $entity->getVarcharAttributes();

        foreach ($varcharAttributes as $attribute) {
            // Skip if this item is not for this store or default store.
            if ($this->storeId !== $attribute->getStore() && $attribute->getStore() !== 0) {
                continue;
            }
            /** @var CatalogCategoryEntityVarchar $attribute */
            switch ($attribute->getAttributeId()) {
                case self::CATEGORY_NAME:
                    $document->setTitle($attribute->getValue());
                    break;
                case self::CATEGORY_URL_PATH:
                    $document->setUrlString($attribute->getValue());
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
     */
    public function addIntegerAttributes($entity, CategoryDocument $document)
    {
        $integerAttributes = $entity->getIntegerAttributes();

        foreach ($integerAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore() && $attribute->getStore() !== 0) {
                continue;
            }
            /** @var CatalogCategoryEntityInt $attribute */
            if ($attribute->getAttributeId() == self::CATEGORY_IS_ACTIVE) {
                $document->setActive((bool)$attribute->getValue());
            }
        }
    }
}
