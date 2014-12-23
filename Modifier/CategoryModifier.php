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
use ONGR\MagentoConnectorBundle\Documents\CategoryDocument;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityInt;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;

/**
 * Modifies entities to match ongr category mapping.
 */
class CategoryModifier extends AbstractImportModifyEventListener
{
    const CATEGORY_TITLE = 41;
    const CATEGORY_IS_ACTIVE = 42;
    const CATEGORY_LINKS_TITLE = 57;

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
    protected function modify(AbstractImportItem $eventItem)
    {
        /** @var CategoryDocument $document */
        $document = $eventItem->getDocument();
        /** @var CatalogCategoryEntity $entity */
        $entity = $eventItem->getEntity();

        $this->transform($document, $entity);
    }

    /**
     * Assigns data to given document.
     *
     * @param CategoryDocument      $document
     * @param CatalogCategoryEntity $entity
     *
     * @throws \Exception
     */
    protected function transform(CategoryDocument $document, CatalogCategoryEntity $entity)
    {
        $document->setId($entity->getId());
        $document->setParentId($entity->getParentId());
        $document->setExpiredUrl([]);

        if ($entity->getLevel() == 2) {
            // Root categories.
            $document->setParentId('oxrootid');
        } elseif ($entity->getLevel() < 2) {
            throw new \Exception('Wrong category level. Got level=' . $entity->getLevel());
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
     */
    public function addVarcharAttributes($entity, CategoryDocument $document)
    {
        $varcharAttributes = $entity->getVarcharAttributes();

        foreach ($varcharAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore()) {
                continue;
            }
            /** @var CatalogCategoryEntityVarchar $attribute */
            switch ($attribute->getAttributeId()) {
                case self::CATEGORY_TITLE:
                    $document->setTitle($attribute->getValue());
                    break;
                case self::CATEGORY_LINKS_TITLE:
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
     */
    public function addIntegerAttributes($entity, CategoryDocument $document)
    {
        $integerAttributes = $entity->getIntegerAttributes();

        foreach ($integerAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore()) {
                continue;
            }
            /** @var CatalogCategoryEntityInt $attribute */
            switch ($attribute->getAttributeId()) {
                case self::CATEGORY_IS_ACTIVE:
                    $document->setActive((bool)$attribute->getValue());
                    break;
                default:
                    // Do nothing.
                    break;
            }
        }
    }
}
