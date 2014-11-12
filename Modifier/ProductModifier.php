<?php

namespace ONGR\MagentoConnectorBundle\Modifier;

use Doctrine\ORM\EntityNotFoundException;
use ONGR\ConnectionsBundle\DataCollector\DataCollectorInterface;
use ONGR\ConnectionsBundle\DataCollector\Exception\DocumentSyncCancelException;
use ONGR\ConnectionsBundle\Doctrine\Modifier\ModifierInterface;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\MagentoConnectorBundle\Entity\CatalogCategoryEntityVarchar;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntity;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityText;
use ONGR\MagentoConnectorBundle\Entity\CatalogProductEntityVarchar;
use ONGR\MagentoConnectorBundle\Modifier\Helpers\AttributeTypes;

/**
 * Modifies entities to match ongr product mapping.
 */
class ProductModifier implements ModifierInterface
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
    public function modify(DocumentInterface $document, $entity, $type = DataCollectorInterface::TYPE_FULL)
    {
        $document->id = $entity->getId();
        $document->url = [];
        $document->expired_url = [];
        $document->sku = $entity->getSku();
        $document->origin = new \stdClass();
        $document->origin->country = '';
        $document->origin->location = '';
        $document->location = new \stdClass();
        $document->location->lon = 0;
        $document->location->lat = 0;

        $this->addPrice($entity, $document);
        $this->addTextAttributes($entity, $document);
        $this->addVarcharAttributes($entity, $document);
        $this->addCategory($entity, $document);
    }

    /**
     * Adds price field to DocumentInterface $document.
     *
     * @param CatalogProductEntity  $entity
     * @param DocumentInterface     $document
     *
     * @throws DocumentSyncCancelException
     */
    public function addPrice($entity, DocumentInterface $document)
    {
        try {
            $document->price = $entity->getPrice()->getPrice();
        } catch (EntityNotFoundException $exception) {
            // Do nothing, product has no price.
        }

        if (!($document->price)) {
            throw new DocumentSyncCancelException;
        }
    }

    /**
     * Adds longDescription and Description fields to DocumentInterface $document.
     *
     * @param CatalogProductEntity  $entity
     * @param DocumentInterface     $document
     *
     * @throws DocumentSyncCancelException
     */
    public function addTextAttributes($entity, DocumentInterface $document)
    {
        $textAttributes = $entity->getTextAttributes();
        if (count($textAttributes) === 0) {
            throw new DocumentSyncCancelException;
        }
        /** @var CatalogProductEntityText $attribute */
        foreach ($textAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore()) {
                continue;
            }
            switch ($attribute->getAttributeId()) {
                case AttributeTypes::PRODUCT_DESCRIPTION:
                    $document->longDescription = $attribute->getValue();
                    break;
                case AttributeTypes::PRODUCT_SHORT_DESCRIPTION:
                    $document->description = $attribute->getValue();
                    break;
                default:
                    // Do nothing.
                    break;
            }
        }
    }

    /**
     * Adds title, url, image and thumb fields to DocumentInterface $document.
     *
     * @param CatalogProductEntity  $entity
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
        /** @var CatalogProductEntityVarchar $attribute */
        foreach ($varcharAttributes as $attribute) {
            if ($this->storeId !== $attribute->getStore()) {
                continue;
            }
            switch ($attribute->getAttributeId()) {
                case AttributeTypes::PRODUCT_META_TITLE:
                    $document->title = $attribute->getValue();
                    break;
                case AttributeTypes::PRODUCT_LINKS_TITLE:
                    $document->url[] = $attribute->getValue();
                    break;
                case AttributeTypes::PRODUCT_IMAGE:
                    $document->image = $attribute->getValue();
                    break;
                case AttributeTypes::PRODUCT_SMALL_IMAGE:
                    $document->thumb = $attribute->getValue();
                    break;
                default:
                    // Do nothing.
                    break;
            }
        }
    }

    /**
     * Adds categories field to DocumentInterface $document.
     *
     * @param CatalogProductEntity  $entity
     * @param DocumentInterface     $document
     */
    public function addCategory($entity, DocumentInterface $document)
    {
        $category = $entity->getCategory();
        try {
            $path = $category->getCategory()->getPath();

            // Trim first two categories from path.
            $path = substr($path, strpos($path, '/') + 1);
            $path = substr($path, strpos($path, '/') + 1);
            $categories = explode('/', $path);

            $document->category = [$path];
            $document->category_id = $categories;

            $document->mainCategory = $category->getCategory()->getId();
            foreach ($category->getCategory()->getVarcharAttributes() as $attribute) {
                /** @var CatalogCategoryEntityVarchar $attribute */
                switch ($attribute->getAttributeId()) {
                    case AttributeTypes::CATEGORY_TITLE:
                        $document->category_title = [$attribute->getValue()];
                        break;
                    case AttributeTypes::CATEGORY_LINKS_TITLE:
                        $document->category_url = [$attribute->getValue()];
                        break;
                    default:
                        // Do nothing.
                        break;
                }
            }
        } catch (EntityNotFoundException $exception) {
            // Do nothing.
        }
    }
}
