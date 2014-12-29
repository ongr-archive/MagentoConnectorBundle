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
use ONGR\MagentoConnectorBundle\Documents\CategoryObject;
use ONGR\MagentoConnectorBundle\Documents\PriceObject;
use ONGR\MagentoConnectorBundle\Documents\ProductDocument;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar;

/**
 * Modifies entities to match ongr product mapping.
 */
class ProductModifier extends AbstractImportModifyEventListener
{
    const PRODUCT_DESCRIPTION = 72;
    const PRODUCT_SHORT_DESCRIPTION = 73;
    const PRODUCT_META_TITLE = 71;
    const PRODUCT_IMAGE = 85;
    const PRODUCT_SMALL_IMAGE = 86;
    const PRODUCT_LINKS_TITLE = 98;
    const ENTITY_TYPE_PRODUCT = 4;

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
        /** @var ProductDocument $document */
        $document = $eventItem->getDocument();
        /** @var CatalogProductEntity $entity */
        $entity = $eventItem->getEntity();

        $this->transform($document, $entity);
    }

    /**
     * Assigns data to given document.
     *
     * @param ProductDocument      $document
     * @param CatalogProductEntity $entity
     */
    protected function transform(ProductDocument $document, CatalogProductEntity $entity)
    {
        $document->setId($entity->getId());
        $document->setUrls([]);
        $document->setExpiredUrls([]);
        $document->setSku($entity->getSku());

        $this->addPrice($entity, $document);
        $this->addTextAttributes($entity, $document);
        $this->addVarcharAttributes($entity, $document);
        $this->addCategories($entity, $document);
    }

    /**
     * Adds prices to document.
     *
     * @param CatalogProductEntity $entity
     * @param ProductDocument      $document
     */
    public function addPrice($entity, ProductDocument $document)
    {
        $prices = $entity->getPrices();

        foreach ($prices as $price) {
            $document->addPrice(new PriceObject($price->getPrice()));
        }
    }

    /**
     * Adds longDescription and Description fields to document.
     *
     * @param CatalogProductEntity $entity
     * @param ProductDocument      $document
     */
    public function addTextAttributes($entity, ProductDocument $document)
    {
        $textAttributes = $entity->getTextAttributes();

        /** @var CatalogProductEntityText $attribute */
        foreach ($textAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore()) {
                continue;
            }
            switch ($attribute->getAttributeId()) {
                case self::PRODUCT_DESCRIPTION:
                    $document->setLongDescription($attribute->getValue());
                    break;
                case self::PRODUCT_SHORT_DESCRIPTION:
                    $document->setDescription($attribute->getValue());
                    break;
                default:
                    // Do nothing.
                    break;
            }
        }
    }

    /**
     * Adds title, url, image and thumb fields to document.
     *
     * @param CatalogProductEntity $entity
     * @param ProductDocument      $document
     */
    public function addVarcharAttributes($entity, ProductDocument $document)
    {
        $varcharAttributes = $entity->getVarcharAttributes();

        /** @var CatalogProductEntityVarchar $attribute */
        foreach ($varcharAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore()) {
                continue;
            }
            switch ($attribute->getAttributeId()) {
                case self::PRODUCT_META_TITLE:
                    $document->setTitle($attribute->getValue());
                    break;
                case self::PRODUCT_LINKS_TITLE:
                    $document->addUrl($attribute->getValue());
                    break;
                case self::PRODUCT_IMAGE:
                    $document->addImageUrl($attribute->getValue());
                    break;
                case self::PRODUCT_SMALL_IMAGE:
                    $document->addSmallImageUrl($attribute->getValue());
                    break;
                default:
                    // Do nothing.
                    break;
            }
        }
    }

    /**
     * Adds categories field to document.
     *
     * @param CatalogProductEntity $entity
     * @param ProductDocument      $document
     */
    public function addCategories($entity, ProductDocument $document)
    {
        $categories = $entity->getCategories();
        $documentCategories = [];

        foreach ($categories as $categoryProduct) {
            $categoryObject = new CategoryObject();
            $path = $categoryProduct->getCategory()->getPath();

            // Trim first two categories (RootCatalog and DefaultCatalog) from path.
            $path = preg_replace('/^([^\/]*\/){2}/', '', $path);
            $paths = explode('/', $path);

            $categoryObject->setPath($path);
            $categoryObject->setCategories($paths);
            $categoryObject->setId($categoryProduct->getCategory()->getId());

            foreach ($categoryProduct->getCategory()->getVarcharAttributes() as $attribute) {
                /** @var CatalogCategoryEntityVarchar $attribute */
                switch ($attribute->getAttributeId()) {
                    case CategoryModifier::CATEGORY_TITLE:
                        $categoryObject->setTitle($attribute->getValue());
                        break;
                    case CategoryModifier::CATEGORY_LINKS_TITLE:
                        $categoryObject->setUrlString($attribute->getValue());
                        break;
                    default:
                        // Do nothing.
                        break;
                }
            }

            $documentCategories[] = $categoryObject;
        }

        $document->setCategories($documentCategories);
    }
}
