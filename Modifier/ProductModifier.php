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
use ONGR\ConnectionsBundle\Pipeline\ItemSkipException;
use ONGR\MagentoConnectorBundle\Document\CategoryObject;
use ONGR\MagentoConnectorBundle\Document\PriceObject;
use ONGR\MagentoConnectorBundle\Document\ProductDocument;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar;

/**
 * Modifies entities to match ongr product mapping.
 */
class ProductModifier extends AbstractImportModifyEventListener
{
    const ENTITY_TYPE_PRODUCT = 4;
    const PRODUCT_NAME = 71;
    const PRODUCT_IS_ACTIVE = 96;
    const PRODUCT_DESCRIPTION = 72;
    const PRODUCT_SHORT_DESCRIPTION = 73;
    const PRODUCT_META_TITLE = 82;
    const PRODUCT_META_KEYWORD = 83;
    const PRODUCT_META_DESCRIPTION = 84;
    const PRODUCT_IMAGE = 85;
    const PRODUCT_SMALL_IMAGE = 86;
    const PRODUCT_URL_PATH = 98;

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
     *
     * @throws ItemSkipException
     */
    protected function transform(ProductDocument $document, CatalogProductEntity $entity)
    {
        if ($this->isProductActive($entity)) {
            $document->setId($entity->getId());
            $document->setUrls([]);
            $document->setExpiredUrls([]);
            $document->setSku($entity->getSku());

            $this->addPrice($entity, $document);
            $this->addTextAttributes($entity, $document);
            $this->addVarcharAttributes($entity, $document);
            $this->addCategories($entity, $document);
        } else {
            throw new ItemSkipException('Product ' . $entity->getId() . ' is not active, so it wont be imported.');
        }
    }

    /**
     * Checks if product is active (check only if product is set as enabled disabled in magento).
     *
     * @param CatalogProductEntity $entity
     *
     * @return bool
     */
    public function isProductActive(CatalogProductEntity $entity)
    {
        $integerAttributes = $entity->getIntegerAttributes();

        foreach ($integerAttributes as $attribute) {
            if ($attribute->getAttributeId() === self::PRODUCT_IS_ACTIVE) {
                if ($attribute->getValue() !== 1) {
                    return false;
                } else {
                    return true;
                }
            }
        }

        return true;
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
                    $document->setDescription($attribute->getValue());
                    break;
                case self::PRODUCT_SHORT_DESCRIPTION:
                    $document->setShortDescription($attribute->getValue());
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
                case self::PRODUCT_NAME:
                    $document->setTitle($attribute->getValue());
                    break;
                case self::PRODUCT_URL_PATH:
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
                    case CategoryModifier::CATEGORY_NAME:
                        $categoryObject->setTitle($attribute->getValue());
                        break;
                    case CategoryModifier::CATEGORY_URL_PATH:
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
