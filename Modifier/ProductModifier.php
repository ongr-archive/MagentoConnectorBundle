<?php

namespace ONGR\MagentoConnectorBundle\Modifier;

use Doctrine\ORM\EntityNotFoundException;
use Exception;
use ONGR\ConnectionsBundle\EventListener\AbstractImportModifyEventListener;
use ONGR\ConnectionsBundle\Import\Item\AbstractImportItem;
use ONGR\MagentoConnectorBundle\Documents\ProductDocument;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar;
use ONGR\MagentoConnectorBundle\Modifier\Helpers\AttributeTypes;

/**
 * Modifies entities to match ongr product mapping.
 */
class ProductModifier extends AbstractImportModifyEventListener
{
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

        $document->setId($entity->getId());
        $document->setUrl([]);
        $document->setExpiredUrl([]);
        $document->setSku($entity->getSku());

        $this->addPrice($entity, $document);
        $this->addTextAttributes($entity, $document);
        $this->addVarcharAttributes($entity, $document);
        $this->addCategory($entity, $document);
    }

    /**
     * Adds price field to document.
     *
     * @param CatalogProductEntity $entity
     * @param ProductDocument      $document
     *
     * @throws Exception
     */
    public function addPrice($entity, ProductDocument $document)
    {
        try {
            $document->setPrice($entity->getPrice()->getPrice());
        } catch (EntityNotFoundException $exception) {
            // Do nothing, product has no price.
        }

        if (!($document->getPrice())) {
            throw new Exception; // todo: before was 'DocumentSyncCancelException'
        }
    }

    /**
     * Adds longDescription and Description fields to document.
     *
     * @param CatalogProductEntity $entity
     * @param ProductDocument      $document
     *
     * @throws Exception
     */
    public function addTextAttributes($entity, ProductDocument $document)
    {
        $textAttributes = $entity->getTextAttributes();
        if (count($textAttributes) === 0) {
            throw new Exception; // todo: before was 'DocumentSyncCancelException'
        }
        /** @var CatalogProductEntityText $attribute */
        foreach ($textAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore()) {
                continue;
            }
            switch ($attribute->getAttributeId()) {
                case AttributeTypes::PRODUCT_DESCRIPTION:
                    $document->setLongDescription($attribute->getValue());
                    break;
                case AttributeTypes::PRODUCT_SHORT_DESCRIPTION:
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
     *
     * @throws Exception
     */
    public function addVarcharAttributes($entity, ProductDocument $document)
    {
        $varcharAttributes = $entity->getVarcharAttributes();
        if (count($varcharAttributes) === 0) {
            throw new Exception; // todo: before was 'DocumentSyncCancelException'
        }
        /** @var CatalogProductEntityVarchar $attribute */
        foreach ($varcharAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore()) {
                continue;
            }
            switch ($attribute->getAttributeId()) {
                case AttributeTypes::PRODUCT_META_TITLE:
                    $document->setTitle($attribute->getValue());
                    break;
                case AttributeTypes::PRODUCT_LINKS_TITLE:
                    $document->addUrl($attribute->getValue());
                    break;
                case AttributeTypes::PRODUCT_IMAGE:
                    $document->addImageUrl($attribute->getValue());
                    break;
                case AttributeTypes::PRODUCT_SMALL_IMAGE:
                    $document->thumb = $attribute->getValue(); // todo
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
    public function addCategory($entity, ProductDocument $document)
    {
        $category = $entity->getCategory();
        try {
            $path = $category->getCategory()->getPath();

            // Trim first two categories (RootCatalog and DefaultCatalog) from path.
            $path = preg_replace('/^([^\/]*\/){2}/', '', $path);
            $categories = explode('/', $path);

            $document->category = [$path]; // todo
            $document->category_id = $categories; // todo

            $document->mainCategory = $category->getCategory()->getId();
            foreach ($category->getCategory()->getVarcharAttributes() as $attribute) {
                /** @var CatalogCategoryEntityVarchar $attribute */
                switch ($attribute->getAttributeId()) {
                    case AttributeTypes::CATEGORY_TITLE:
                        $document->category_title = [$attribute->getValue()]; // todo
                        break;
                    case AttributeTypes::CATEGORY_LINKS_TITLE:
                        $document->category_url = [$attribute->getValue()]; // todo
                        break;
                    default:
                        // Do nothing.
                        break;
                }
            }
        } catch (EntityNotFoundException $exception) {
            // Do nothing. // todo
        }
    }
}
